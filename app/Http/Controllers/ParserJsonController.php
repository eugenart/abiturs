<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\Faculty;
use App\Freeseats_bases;
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
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ParserJsonController extends Controller
{

    //парсинг статистики
    public function parseStudents()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/test3.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Student::truncate();
        $students = array();

        foreach ($json_data as $k => $st) {
            $student = array(
                'studentId' => $st['studentId'],
                'fio' => $st['fio'],
            );
            $students[] = $student;
        }
        $students = array_unique($students, SORT_REGULAR);
        Student::insert($students);
//        foreach ($students as $student) {
//            Student::insert($student);
//        }
    }

    public function parseStat()
    {
        $filejson = file_get_contents(storage_path('app/public/files/test3.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Statistic::truncate();
        StudyForm::truncate();
//        AdmissionBasis::truncate();
        PreparationLevel::truncate();
        Category::truncate();
        $studentsStat = array();
        $studyForms = array();
        $prepLevels = array();
       // $admissionBases = array();
        $categories = array();

        foreach ($json_data as $k => $st) {

            $stdForm = array(
                'name' => $st['studyForm']
            );
            $studyForms[] = $stdForm;

            $prepLevel = array(
                'name' => $st['preparationLevel']
            );
            $prepLevels[] = $prepLevel;

//            $admissionBasis = array(
//                'name' => $st['admissionBasis']
//            );
//            $admissionBases[] = $admissionBasis;

            $category = array(
                'name' => $st['category']
            );
            $categories[] = $category;

        }

        $studyForms = array_unique($studyForms, SORT_REGULAR);
        StudyForm::insert($studyForms);
        $prepLevels = array_unique($prepLevels, SORT_REGULAR);
        PreparationLevel::insert($prepLevels);
//        $admissionBases = array_unique($admissionBases, SORT_REGULAR);
//        AdmissionBasis::insert($admissionBases);
        $categories = array_unique($categories, SORT_REGULAR);
        Category::insert($categories);

//        StatisticsIntra::truncate();
//        StatisticsPart::truncate();
//        StatisticsExtra::truncate();
        Statistic::truncate();

        foreach ($json_data as $k => $st) {

            $idStudent = Student::where('studentId', '=', $st['studentId'])->first();
            $idFaculty = Faculty::where('facultyId', '=', $st['facultyId'])->first();
            $idSpecialization = Specialization::where('specializationId', '=', $st['specialization'])->first();
            $idSpeciality = Speciality::where('specialityId', '=', $st['speciality'])->first();
            $idStudyForm = StudyForm::where('name', '=', $st['studyForm'])->first();
            $idPreparationLevel = PreparationLevel::where('name', '=', $st['preparationLevel'])->first();
            $idAdmissionBasis = AdmissionBasis::where('name', '=', $st['admissionBasis'])->first();
            $idCategory = Category::where('name', '=', $st['category'])->first();

            // print_r($idFaculty);
            $stat = array(
                'id_student' => intval($idStudent->id),
                'id_faculty' => intval($idFaculty->id),
                'id_speciality' => intval($idSpeciality->id),
                'id_specialization' => $idSpecialization ? intval($idSpecialization->id) : null,
                'id_preparationLevel' => intval($idPreparationLevel->id),
                'id_admissionBasis' => intval($idAdmissionBasis->id),
                'id_studyForm' => intval($idStudyForm->id),
                'id_category' => intval($idCategory->id),
                'accept' => $st['accept'],
                'original' => $st['original'],
                'summ' => $st['summ'],
                'indAchievement' => $st['indAchievement'],
                'summContest' => $st['summContest'],
                'needHostel' => $st['needHostel'],
                'notice1' => $st['notice1'],
                'notice2' => $st['notice2'],
                'is_chosen' => false
            );
            $studentsStat[] = $stat;
        }

        $chunks = array_chunk($studentsStat, 3000);
        foreach ($chunks as $chunk) {
            Statistic::insert($chunk);
        }

//        $studentsStatIntras = array();
//        $studentsStatParts = array();
//        $studentsStatExtras = array();
//
//        foreach ($studentsStat as $value) {
//            if ($value['id_studyForm'] === StudyForm::where('name', '=', 'Очная')->first()->id) {
//                $studentsStatIntras[] = $value;
//            } elseif ($value['id_studyForm'] === StudyForm::where('name', '=', 'Очно-заочная')->first()->id) {
//                $studentsStatParts[] = $value;
//            } else {
//                $studentsStatExtras[] = $value;
//            }
//        }
//
//        $chunks = array_chunk($studentsStatIntras, 3000);
//        foreach ($chunks as $chunk) {
//            StatisticsIntra::insert($chunk);
//        }
//
//        $chunks = array_chunk($studentsStatParts, 3000);
//        foreach ($chunks as $chunk) {
//            StatisticsPart::insert($chunk);
//        }
//
//        $chunks = array_chunk($studentsStatExtras, 3000);
//        foreach ($chunks as $chunk) {
//            StatisticsExtra::insert($chunk);
//        }


    }

    public function parseScore()
    {
        $filejson = file_get_contents(storage_path('app/public/files/test3.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Score::truncate();
        $scores = array();

        foreach ($json_data as $k => $st) {
            foreach ($st['score'] as $item) {
                $idSubject = Subject::where('subjectId', '=', $item['subjectId'])->first();

                $score = array(
                    'id_statistic' => $k + 1,
                    'id_subject' => intval($idSubject->id),
                    'score' => $item['subjectScore']
                );

                $scores[] = $score;
            }
        }

        $chunks = array_chunk($scores, 3000);

        foreach ($chunks as $chunk) {
            Score::insert($chunk);
        }


    }

    //парсинг минимальных баллов
//    public function parseAreas()
//    {
//        set_time_limit(0);
//        $filejson = file_get_contents(storage_path('app/public/files/test2.json'));
//        $json_arr = json_decode($filejson, true);
//        $json_data = $json_arr['data'];
//
//        TrainingArea::truncate();
//        TrainingAreasSubject::truncate();
//        FacultyArea::truncate();
//
//        $areas = array();
//        $areas_subjects = array();
//        $areas_faculties = array();
//        $count_areas = 0;
//
//        foreach ($json_data as $k => $facultyItem) {
//            $id_faculty = Faculty::where('facultyId', '=', $facultyItem['facultyId'])->first();
//
//            foreach ($facultyItem['trainingAreas'] as $areaItem) {
//
//                $id_speciality = Speciality::where('specialityId', '=', $areaItem['trainingAreasId'])->first();
//                $id_studyForm = StudyForm::where('name', '=', $areaItem['trainingForm'])->first();
//
//                $area = array(
//                    'id_speciality' => intval($id_speciality->id),
//                    'id_studyForm' => intval($id_studyForm->id),
//                    'freeSeatsNumber' => intval($areaItem['freeSeatsNumber']),
//                    'years' => intval($areaItem['years']),
//                    'price' => intval($areaItem['price'])
//                );
//
//                $areas[] = $area;
//                $count_areas++;
//
//                $faculty = array(
//                    'id_faculty' => intval($id_faculty->id),
//                    'id_area' => $count_areas,
//                );
//                $areas_faculties[] = $faculty;
//
//                foreach ($areaItem['subjects'] as $subjectItem) {
//                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
//
//                    $subject = array(
//                        'id_area' => $count_areas,
//                        'id_subject' => intval($id_subject->id),
//                        'minScore' => $subjectItem['minScore']
//                    );
//                    $areas_subjects[] = $subject;
//                }
//            }
//        }
//
//
//        TrainingArea::insert($areas);
//        FacultyArea::insert($areas_faculties);
//        TrainingAreasSubject::insert($areas_subjects);
//
//        return json_encode('Выгрузка данных о ценах на обучение успешно завершена!');
//    }

    //парсинг минимальных баллов 2
    public function parseAreasSarBach()
    {
        set_time_limit(0);
        $filejson = file_get_contents(storage_path('app/public/files/Саранск (бакалавры, спец-ты) 2019.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Plan::truncate();
        Competition::truncate();
        PlanCompetition::truncate();
        PlanCompScore::truncate();

        $arr_plan = array();
        $arr_competition = array();
        $arr_plan_comp = array();
        $arr_plan_comp_score = array();
        $arr_prices = array();
        $arr_freeseats = array();
        $count_plan = 0;


        foreach ($json_data as $k => $element) {
            if(!$element['Competition']['foreigner']) {
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

        return json_encode('12345!');
    }

    public function parseFromJson(Request $request)
    {
        set_time_limit(1200);
        $this->parseStudents();
        $this->parseStat();
        $this->parseScore();


        return json_encode('Информация об абитуриентах успешно выгружена!');
    }
}
