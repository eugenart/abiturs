<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\Faculty;
use App\Freeseats_bases;
use App\PastContests;
use App\Plan;
use App\PlanCompetition;
use App\PlanCompScore;
use App\PreparationLevel;
use App\Price;
use App\Score;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\Student;
use App\StudyForm;
use App\Subject;
use Illuminate\Http\Request;
use Mockery\Exception;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Throwable;

class ParserJsonController extends Controller
{

//------------------------НАЧАЛО парсинг статистики--------------------------------
    public function parseCatalogs()
    {
        ini_set('memory_limit', '1024M');
//        $filejson = file_get_contents(storage_path('app/public/files/test3_oo.json'));
        $filejson = file_get_contents(storage_path('app/public/files/statistics/БакСпец.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        StudyForm::truncate();
        PreparationLevel::truncate();
        Category::truncate();

        $studyForms = array();
        $prepLevels = array();
        $categories = array();

        //Заполняем справочную информацию собирая все из статистики
        foreach ($json_data as $k => $fac_stat) {
            $stdForm = array(
                'name' => $fac_stat['trainingForm']
            );
            $studyForms[] = $stdForm;

            foreach ($fac_stat['List'] as $stud_element) {
//                try {
//                    $stud_element['fio'];
//                } catch (Throwable $t) {
//                    var_dump($stud_element);
//                }
                // var_dump($stud_element['preparationLevel']);

                $prepLevel = array(
                    'name' => $stud_element['preparationLevel']
                );
                $prepLevels[] = $prepLevel;


                $category = array(
                    'name' => $stud_element['category']
                );
                $categories[] = $category;
//
            }
        }

        //делаем массивы уникальными и записываем в БД
        $studyForms = array_unique($studyForms, SORT_REGULAR);
        StudyForm::insert($studyForms);
        $prepLevels = array_unique($prepLevels, SORT_REGULAR);
        PreparationLevel::insert($prepLevels);
        $categories = array_unique($categories, SORT_REGULAR);
        Category::insert($categories);

    }

    public function parseStat2()
    {
        ini_set('memory_limit', '1024M');
//        $filejson = file_get_contents(storage_path('app/public/files/test3_oo.json'));
        $filejson = file_get_contents(storage_path('app/public/files/statistics/БакСпец.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Student::truncate();
        Statistic::truncate();
        Score::truncate();

        $scores = array();
        $students = array();
        $studentsStat = array();
        $count_idStudent = 0;
        foreach ($json_data as $k => $fac_stat) {
            $students = array(); //чистим массив студетов
            //выбираем из базы нужные айдишники
            $idPlan = Plan::where('planId', '=', $fac_stat['planId'])->first();
            $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
            $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
            $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
            $idCompetition = Competition::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
            $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
            $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

            //если все данные нашлись в бд

            foreach ($fac_stat['List'] as $student) {
                //находим id студента в предыдущих специальностях
                $idStudent = Student::where('studentId', '=', $student['studentId'])->first();
                if (empty($idStudent)) { //студента в базе нет - записываем
                    $stud = array(
                        'studentId' => $student['studentId'],
                        'fio' => $student['fio'],
                    );
                    $students[] = $stud;
                    $count_idStudent++;
                    $id_stud = $count_idStudent; //id студента равен счетчику записи в базу
                } else { //студент в БД есть  - не записываем, берем его id из БД
                    $id_stud = intval($idStudent->id); //id студента равен найденному в БД значению
                }
                //выбираем из БД остальные айдишники
                $idCategory = Category::where('name', '=', $student['category'])->first();
                $idPreparationLevel = PreparationLevel::where('name', '=', $student['preparationLevel'])->first();



                if (!empty($idPlan) && !empty($idFaculty) && !empty($idSpeciality) && !empty($idCompetition)
                    && !empty($idAdmissionBasis) && !empty($idStudyForm) && !empty($idCategory) && !empty($idPreparationLevel)) {
                    //создаем запись в массиве статистики
                    $stat = array(
                        'id_student' => $id_stud,
                        'id_faculty' => intval($idFaculty->id),
                        'id_speciality' => intval($idSpeciality->id),
                        'id_specialization' => $idSpecialization ? intval($idSpecialization->id) : null,
                        'id_preparationLevel' => intval($idPreparationLevel->id),
                        'id_admissionBasis' => intval($idAdmissionBasis->id),
                        'id_studyForm' => intval($idStudyForm->id),
                        'id_category' => intval($idCategory->id),
                        'accept' => $student['accept'],
                        'original' => $student['original'],
                        'summ' => $student['summ'],
                        'indAchievement' => $student['indAchievement'],
                        'summContest' => $student['summContest'],
                        'needHostel' => $student['needHostel'],
                        'notice1' => $student['notice1'],
                        'notice2' => $student['notice2'],
                        'is_chosen' => false,
                        'id_plan' => intval($idPlan->id),
                        'id_competition' => intval($idCompetition->id),
                        'foreigner' => $fac_stat['foreigner'],
                        'yellowline' => isset($student['yelloyline']) ? true : false
                        );
                    $studentsStat[] = $stat;
                }

                //теперь оценки
                foreach ($student['score'] as $score_item) {
                    $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                    $score = array(
                        'id_statistic' => count($studentsStat),
                        'id_subject' => intval($idSubject->id),
                        'score' => $score_item['subjectScore'],
                        'priority' => $score_item['Priority']
                    );
                    $scores[] = $score;
                }
            }

            //Записываем в БД студентов для этой специализации
            $students = array_unique($students, SORT_REGULAR);
            Student::insert($students);
        }

        $chunks = array_chunk($studentsStat, 3000);
        foreach ($chunks as $chunk) {
            Statistic::insert($chunk);
        }

        $chunks = array_chunk($scores, 3000);
        foreach ($chunks as $chunk) {
            Score::insert($chunk);
        }

    }
//------------------------КОНЕЦ парсинг статистики--------------------------------

//------------------------НАЧАЛО парсинг планов Бакалавров--------------------------------
    //парсинг планов, цен, мест, баллов БакалавриатСпец
    public function parsePlansBachSpecSar()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/Саранск (бакалавры, спец-ты) 2019.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Plan::truncate();
        Competition::truncate();
        PlanCompetition::truncate();
        PlanCompScore::truncate();
        Price::truncate();
        Freeseats_bases::truncate();

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();
        $count_plan = 0;


        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        Plan::insert($arr_plan);
        Competition::insert($arr_competition);
        PlanCompetition::insert($arr_plan_comp);
        PlanCompScore::insert($arr_plan_comp_score);
        Price::insert($arr_prices);
        Freeseats_bases::insert($arr_freeseats);

        return $count_plan;
        //return json_encode('Bachelors Saransk success!');
    }

    //парсинг планов, цен, мест, баллов БакалавриатСпец Рузаевка
    public function parsePlansBachSpecRuz()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/plans/РИМ  (бакалавры, спец-ты) 2019.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();

        $count_plan_db = Plan::count();
        $count_plan = intval($count_plan_db);

        foreach ($json_data as $k => $element) {
            if (!$element['Competition']['foreigner']) {
                $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();

                //заполним массив планов
                $plan = array(
                    'planId' => $element['Plan']['planId'],
                    'id_faculty' => intval($id_faculty->id),
                    'id_studyForm' => intval($id_studyForm->id),
                    'id_speciality' => intval($id_speciality->id),
                    'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                    'years' => intval($element['Plan']['years'])

                );
                //заполним массив испытаний
                $competition = array(
                    'competitionId' => $element['Competition']['CompetitionId'],
                    'competitionName' => $element['Competition']['CompetitionName']
                );


                $arr_plan[] = $plan;
                $arr_competition[] = $competition;
                $count_plan++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                //массив связей плана и испытания
                $plan_comp = array(
                    'id_plan' => $count_plan,
                    'id_competition' => $count_plan,
                    'freeSeatsNumber' => $element['freeSeatsNumber']
                );

                $arr_plan_comp[] = $plan_comp;

                //связь предметов-оценок с объедением плана-исптания
                foreach ($element['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $arr_plan_comp_score[] = $subject;
                }

                foreach ($element['Prices'] as $priceItem) {
                    $price = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'price' => $priceItem['Price'],
                        'info' => $priceItem['info']
                    );
                    $arr_prices[] = $price;
                }

                foreach ($element['admissionBasis'] as $basisItem) {
                    $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();

                    $freeseat = array(
                        'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                        'id_admissionBasis' => intval($id_admissionBasis->id),
                        'value' => $basisItem['value']
                    );
                    $arr_freeseats[] = $freeseat;
                }
            }
        }

        Plan::insert($arr_plan);
        Competition::insert($arr_competition);
        PlanCompetition::insert($arr_plan_comp);
        PlanCompScore::insert($arr_plan_comp_score);
        Price::insert($arr_prices);
        Freeseats_bases::insert($arr_freeseats);

    }

    public function parsePlansBach(Request $request)
    {
        set_time_limit(1200);

        $this->parsePlansBachSpecSar();
        $this->parsePlansBachSpecRuz(); //отдельно запускать нельзя, только в такой последовательности

        return json_encode('Bachelors Saransk and Ruzaevka success!');
    }
//------------------------КОНЕЦ парсинг планов Бакалавров--------------------------------

    //парсинг баллов за прошлые года
    public function parsePastContests()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/конкурсы.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        PastContests::truncate();

        $arr_contests = array();

        foreach ($json_data as $k => $element) {
            $id_studyForm = StudyForm::where('name', '=', $element['trainingForm'])->first();
            $id_admissionBasis = AdmissionBasis::where('baseId', '=', $element['IdBasis'])->first();
            $id_speciality = Speciality::where('specialityId', '=', $element['trainingAreasId'])->first();


            $contest = array(
                'id_studyForm' => intval($id_studyForm->id),
                'id_admissionBasis' => intval($id_admissionBasis->id),
                'id_speciality' => intval($id_speciality->id),
                'year' => $element['year'],
                'minScore' => $element['value']
            );

            $arr_contests[] = $contest;
        }

        PastContests::insert($arr_contests);

        return json_encode('ok!');

    }

    public function parseFromJson(Request $request)
    {
        set_time_limit(1200);

        $this->parseCatalogs();
        $this->parseStat2();


        return json_encode('Информация об абитуриентах успешно выгружена!');
    }
}
