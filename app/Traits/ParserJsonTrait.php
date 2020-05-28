<?php

namespace App\Traits;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\CompetitionAsp;
use App\CompetitionMaster;
use App\CompetitionSpo;
use App\Faculty;
use App\Freeseats_bases;
use App\Freeseats_basesAsp;
use App\Freeseats_basesMaster;
use App\Freeseats_basesSpo;
use App\PastContests;
use App\Plan;
use App\PlanAsp;
use App\PlanCompetition;
use App\PlanCompetitionAsp;
use App\PlanCompetitionMaster;
use App\PlanCompetitionSpo;
use App\PlanCompScore;
use App\PlanCompScoreAsp;
use App\PlanCompScoreMaster;
use App\PlanCompScoreSpo;
use App\PlanMaster;
use App\PlanSpo;
use App\PreparationLevel;
use App\Price;
use App\PriceAsp;
use App\PriceMaster;
use App\PriceSpo;
use App\Score;
use App\ScoreAsp;
use App\ScoreMaster;
use App\ScoreSpo;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\StatisticAsp;
use App\StatisticMaster;
use App\StatisticSpo;
use App\Student;
use App\StudentAsp;
use App\StudentMaster;
use App\StudentSpo;
use App\StudyForm;
use App\Subject;
use ErrorException;
use Exception;

trait ParserJsonTrait
{
    use XlsMakerTrait;
//------------------------НАЧАЛО парсинг статистики Бакалавры--------------------------------
    public function parseCatalogs($file)
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/' . $file));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

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
            StudyForm::truncate();
            StudyForm::insert($studyForms);
            $prepLevels = array_unique($prepLevels, SORT_REGULAR);
            PreparationLevel::truncate();
            PreparationLevel::insert($prepLevels);
            $categories = array_unique($categories, SORT_REGULAR);
            Category::truncate();
            Category::insert($categories);

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }

        return 'Формы обучения, категории, уровни подготовки успешно выгружены!';


    }

    public function parseStatBach()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_bach.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];
            Student::truncate(); //надо бы перенести его, но я пока не хочу ломать код
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
                            'yellowline' => isset($student['yelloyline']) ? true : false,
                            'acceptCount' => $student['acceptСount']
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

            $chunks = array_chunk($studentsStat, 2000);
            Statistic::truncate();
            foreach ($chunks as $chunk) {
                Statistic::insert($chunk);
            }

            $chunks = array_chunk($scores, 2000);
            Score::truncate();
            foreach ($chunks as $chunk) {
                Score::insert($chunk);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parseStatBachAll()
    {
        set_time_limit(1200);
        $this->parseCatalogs("stat_bach.json");
        $this->parseStatBach();
//        $this->XlsBach();

        return 'Информация об абитуриентах (бакалавриат,специалитет) успешно выгружена!';
    }
//------------------------КОНЕЦ парсинг статистики Бакалавры--------------------------------

//------------------------НАЧАЛО парсинг статистики Магистры--------------------------------
    public function parseCatalogsMaster()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_master.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $prepLevels = array();
            $categories = array();

            //Заполняем справочную информацию собирая все из статистики
            foreach ($json_data as $k => $fac_stat) {

                foreach ($fac_stat['List'] as $stud_element) {


                    $prepLevel_db = PreparationLevel::where('name', '=', $stud_element['preparationLevel'])->first();
                    if (empty($prepLevel_db)) {
                        $prepLevel = array(
                            'name' => $stud_element['preparationLevel']
                        );
                        $prepLevels[] = $prepLevel;
                    }

                    $category_db = Category::where('name', '=', $stud_element['category'])->first();
                    if (empty($category_db)) {
                        $category = array(
                            'name' => $stud_element['category']
                        );
                        $categories[] = $category;
                    }
                }
            }

            //делаем массивы уникальными и записываем в БД
            if (count($prepLevels)) {
                $prepLevels = array_unique($prepLevels, SORT_REGULAR);
                PreparationLevel::insert($prepLevels);
            }
            if (count($categories)) {
                $categories = array_unique($categories, SORT_REGULAR);
                Category::insert($categories);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parseStatMaster()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_master.json'));

            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            StudentMaster::truncate();

            $scores = array();
            $students = array();
            $studentsStat = array();
            $count_idStudent = 0;
            foreach ($json_data as $k => $fac_stat) {
                $students = array(); //чистим массив студетов
                //выбираем из базы нужные айдишники
                $idPlan = PlanMaster::where('planId', '=', $fac_stat['planId'])->first();
                $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                $idCompetition = CompetitionMaster::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                //если все данные нашлись в бд

                foreach ($fac_stat['List'] as $student) {
                    //находим id студента в предыдущих специальностях
                    $idStudent = StudentMaster::where('studentId', '=', $student['studentId'])->first();
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
                            'yellowline' => isset($student['yelloyline']) ? true : false,
                            'acceptCount' => $student['acceptСount']
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
                StudentMaster::insert($students);
            }


            $chunks = array_chunk($studentsStat, 2000);
            StatisticMaster::truncate();
            foreach ($chunks as $chunk) {
                StatisticMaster::insert($chunk);
            }

            $chunks = array_chunk($scores, 2000);
            ScoreMaster::truncate();
            foreach ($chunks as $chunk) {
                ScoreMaster::insert($chunk);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }

    }

    public function parseStatMasterAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsMaster();
        $this->parseStatMaster();
//        $this->XlsMaster();

        return 'Информация об абитуриентах (магистратура) успешно выгружена!';
    }
//------------------------КОНЕЦ парсинг статистики Магистры--------------------------------

//------------------------НАЧАЛО парсинг статистики Аспиранты--------------------------------
    public function parseCatalogsAsp()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_asp.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $prepLevels = array();
            $categories = array();

            //Заполняем справочную информацию собирая все из статистики
            foreach ($json_data as $k => $fac_stat) {

                foreach ($fac_stat['List'] as $stud_element) {

                    $prepLevel_db = PreparationLevel::where('name', '=', $stud_element['preparationLevel'])->first();
                    if (empty($prepLevel_db)) {
                        $prepLevel = array(
                            'name' => $stud_element['preparationLevel']
                        );
                        $prepLevels[] = $prepLevel;
                    }

                    $category_db = Category::where('name', '=', $stud_element['category'])->first();
                    if (empty($category_db)) {
                        $category = array(
                            'name' => $stud_element['category']
                        );
                        $categories[] = $category;
                    }
                }
            }

            //делаем массивы уникальными и записываем в БД
            if (count($prepLevels)) {
                $prepLevels = array_unique($prepLevels, SORT_REGULAR);
                PreparationLevel::insert($prepLevels);
            }
            if (count($categories)) {
                $categories = array_unique($categories, SORT_REGULAR);
                Category::insert($categories);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parseStatAsp()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_asp.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            StudentAsp::truncate();


            $scores = array();
            $students = array();
            $studentsStat = array();
            $count_idStudent = 0;
            foreach ($json_data as $k => $fac_stat) {
                $students = array(); //чистим массив студетов
                //выбираем из базы нужные айдишники
                $idPlan = PlanAsp::where('planId', '=', $fac_stat['planId'])->first();
                $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                $idCompetition = CompetitionAsp::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                //если все данные нашлись в бд

                foreach ($fac_stat['List'] as $student) {
                    //находим id студента в предыдущих специальностях
                    $idStudent = StudentAsp::where('studentId', '=', $student['studentId'])->first();
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
                            'yellowline' => isset($student['yelloyline']) ? true : false,
                            'acceptCount' => $student['acceptСount']
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
                StudentAsp::insert($students);
            }

            $chunks = array_chunk($studentsStat, 2000);
            StatisticAsp::truncate();

            foreach ($chunks as $chunk) {
                StatisticAsp::insert($chunk);
            }

            $chunks = array_chunk($scores, 2000);
            ScoreAsp::truncate();
            foreach ($chunks as $chunk) {
                ScoreAsp::insert($chunk);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parseStatAspAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsAsp();
        $this->parseStatAsp();

        return 'Информация об абитуриентах (аспирантура) успешно выгружена!';
    }
//------------------------КОНЕЦ парсинг статистики Аспиранты--------------------------------

//------------------------НАЧАЛО парсинг статистики СПО--------------------------------
    public function parseCatalogsSpo()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_spo.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $prepLevels = array();
            $categories = array();

            //Заполняем справочную информацию собирая все из статистики
            foreach ($json_data as $k => $fac_stat) {

                foreach ($fac_stat['List'] as $stud_element) {

                    $prepLevel_db = PreparationLevel::where('name', '=', $stud_element['preparationLevel'])->first();
                    if (empty($prepLevel_db)) {
                        $prepLevel = array(
                            'name' => $stud_element['preparationLevel']
                        );
                        $prepLevels[] = $prepLevel;
                    }

                    $category_db = Category::where('name', '=', $stud_element['category'])->first();
                    if (empty($category_db)) {
                        $category = array(
                            'name' => $stud_element['category']
                        );
                        $categories[] = $category;
                    }
                }
            }

            //делаем массивы уникальными и записываем в БД
            if (count($prepLevels)) {
                $prepLevels = array_unique($prepLevels, SORT_REGULAR);
                PreparationLevel::insert($prepLevels);
            }
            if (count($categories)) {
                $categories = array_unique($categories, SORT_REGULAR);
                Category::insert($categories);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parseStatSpo()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_spo.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            StudentSpo::truncate();

            $scores = array();
            $students = array();
            $studentsStat = array();
            $count_idStudent = 0;
            foreach ($json_data as $k => $fac_stat) {
                $students = array(); //чистим массив студетов
                //выбираем из базы нужные айдишники
                $idPlan = PlanSpo::where('planId', '=', $fac_stat['planId'])->first();
                $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                $idCompetition = CompetitionSpo::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                //если все данные нашлись в бд

                foreach ($fac_stat['List'] as $student) {
                    //находим id студента в предыдущих специальностях
                    $idStudent = StudentSpo::where('studentId', '=', $student['studentId'])->first();
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
                            'yellowline' => isset($student['yelloyline']) ? true : false,
                            'acceptCount' => $student['acceptСount']
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
                StudentSpo::insert($students);
            }

            $chunks = array_chunk($studentsStat, 2000);
            StatisticSpo::truncate();

            foreach ($chunks as $chunk) {
                StatisticSpo::insert($chunk);
            }

            $chunks = array_chunk($scores, 2000);
            ScoreSpo::truncate();
            foreach ($chunks as $chunk) {
                ScoreSpo::insert($chunk);
            }
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parseStatSpoAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsSpo();
        $this->parseStatSpo();

        return 'Информация об абитуриентах (СПО) успешно выгружена!';
    }
//------------------------КОНЕЦ парсинг статистики СПО--------------------------------

//------------------------НАЧАЛО парсинг планов Бакалавров--------------------------------
    //парсинг планов, цен, мест, баллов БакалавриатСпец
    public function parsePlansBachSpecSar()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_bach.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];


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
            Plan::truncate();
            Competition::truncate();
            PlanCompetition::truncate();
            PlanCompScore::truncate();
            Price::truncate();
            Freeseats_bases::truncate();
            Plan::insert($arr_plan);
            Competition::insert($arr_competition);
            PlanCompetition::insert($arr_plan_comp);
            PlanCompScore::insert($arr_plan_comp_score);
            Price::insert($arr_prices);
            Freeseats_bases::insert($arr_freeseats);
            return 1;
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }

    }

    //парсинг планов, цен, мест, баллов БакалавриатСпец Рузаевка
    public function parsePlansBachSpecRuz()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_rim/plans_rim_bach.json'));
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
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parsePlansBach()
    {
        set_time_limit(1200);

        if ($this->parsePlansBachSpecSar() === 1) {
            $this->parsePlansBachSpecRuz(); //отдельно запускать нельзя, только в такой последовательности
        }
        return 'Планы, цены за обучение и количество мест бакалавриата и специалитета успешно выгружены!';
    }
//------------------------КОНЕЦ парсинг планов Бакалавров--------------------------------

//------------------------НАЧАЛО парсинг планов Магистров--------------------------------
    //парсинг планов, цен, мест, баллов Магистры
    public function parsePlansMasterSar()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_master.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];


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

            PlanMaster::truncate();
            CompetitionMaster::truncate();
            PlanCompetitionMaster::truncate();
            PlanCompScoreMaster::truncate();
            PriceMaster::truncate();
            Freeseats_basesMaster::truncate();

            PlanMaster::insert($arr_plan);
            CompetitionMaster::insert($arr_competition);
            PlanCompetitionMaster::insert($arr_plan_comp);
            PlanCompScoreMaster::insert($arr_plan_comp_score);
            PriceMaster::insert($arr_prices);
            Freeseats_basesMaster::insert($arr_freeseats);

            return 1;
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    //парсинг планов, цен, мест, баллов БакалавриатСпец Рузаевка
    public function parsePlansMasterRuz()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_rim/plans_rim_master.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $arr_plan = array();
            $arr_competition = array();
            $arr_plan_comp = array();
            $arr_plan_comp_score = array();
            $arr_prices = array();
            $arr_freeseats = array();

            $count_plan_db = PlanMaster::count();
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

            PlanMaster::insert($arr_plan);
            CompetitionMaster::insert($arr_competition);
            PlanCompetitionMaster::insert($arr_plan_comp);
            PlanCompScoreMaster::insert($arr_plan_comp_score);
            PriceMaster::insert($arr_prices);
            Freeseats_basesMaster::insert($arr_freeseats);
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parsePlansMaster()
    {
        set_time_limit(1200);

        if ($this->parsePlansMasterSar() === 1) {
            $this->parsePlansMasterRuz(); //отдельно запускать нельзя, только в такой последовательности
        }
        return 'Планы, цены за обучение и количество мест магистратуры успешно выгружены!';
    }
//------------------------КОНЕЦ парсинг планов Магистров--------------------------------

//------------------------НАЧАЛО парсинг планов Аспиранты--------------------------------
    //парсинг планов, цен, мест, баллов Аспиранты
    public function parsePlansAsp()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_asp.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];


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
            PlanAsp::truncate();
            CompetitionAsp::truncate();
            PlanCompetitionAsp::truncate();
            PlanCompScoreAsp::truncate();
            PriceAsp::truncate();
            Freeseats_basesAsp::truncate();

            PlanAsp::insert($arr_plan);
            CompetitionAsp::insert($arr_competition);
            PlanCompetitionAsp::insert($arr_plan_comp);
            PlanCompScoreAsp::insert($arr_plan_comp_score);
            PriceAsp::insert($arr_prices);
            Freeseats_basesAsp::insert($arr_freeseats);
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parsePlansAspMain()
    {
        set_time_limit(1200);

        $this->parsePlansAsp();

        return 'Планы, цены за обучение и количество мест аспирантуры успешно выгружены!';
    }
//------------------------КОНЕЦ парсинг планов Аспиранты--------------------------------

//------------------------НАЧАЛО парсинг планов СПО--------------------------------
    //парсинг планов, цен, мест, баллов СПО
    public function parsePlansSpoSar()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_spo.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];


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
            PlanSpo::truncate();
            CompetitionSpo::truncate();
            PlanCompetitionSpo::truncate();
            PlanCompScoreSpo::truncate();
            PriceSpo::truncate();
            Freeseats_basesSpo::truncate();

            PlanSpo::insert($arr_plan);
            CompetitionSpo::insert($arr_competition);
            PlanCompetitionSpo::insert($arr_plan_comp);
            PlanCompScoreSpo::insert($arr_plan_comp_score);
            PriceSpo::insert($arr_prices);
            Freeseats_basesSpo::insert($arr_freeseats);

            return 1;
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    //парсинг планов, цен, мест, баллов СПО Рузаевка
    public function parsePlansSpoRuz()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_rim/plans_rim_spo.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $arr_plan = array();
            $arr_competition = array();
            $arr_plan_comp = array();
            $arr_plan_comp_score = array();
            $arr_prices = array();
            $arr_freeseats = array();

            $count_plan_db = PlanSpo::count();
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

            PlanSpo::insert($arr_plan);
            CompetitionSpo::insert($arr_competition);
            PlanCompetitionSpo::insert($arr_plan_comp);
            PlanCompScoreSpo::insert($arr_plan_comp_score);
            PriceSpo::insert($arr_prices);
            Freeseats_basesSpo::insert($arr_freeseats);
            return 1;
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    //парсинг планов, цен, мест, баллов СПО Ковылкино
    public function parsePlansSpoKov()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_kov/plans_kov_spo.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $arr_plan = array();
            $arr_competition = array();
            $arr_plan_comp = array();
            $arr_plan_comp_score = array();
            $arr_prices = array();
            $arr_freeseats = array();

            $count_plan_db = PlanSpo::count();
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

            PlanSpo::insert($arr_plan);
            CompetitionSpo::insert($arr_competition);
            PlanCompetitionSpo::insert($arr_plan_comp);
            PlanCompScoreSpo::insert($arr_plan_comp_score);
            PriceSpo::insert($arr_prices);
            Freeseats_basesSpo::insert($arr_freeseats);

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }

    public function parsePlansSpo()
    {
        set_time_limit(1200);
        try {

            if ($this->parsePlansSpoSar() === 1) {
                if ($this->parsePlansSpoRuz() === 1) { //отдельно запускать нельзя, только в такой последовательности
                    $this->parsePlansSpoKov(); //отдельно запускать нельзя, только в такой последовательности
                }
            }
        } catch (Exception $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
        return 'Планы, цены за обучение и количество мест СПО успешно выгружены!';
    }
//------------------------КОНЕЦ парсинг планов СПО--------------------------------


    //парсинг баллов за прошлые года
    public function parsePastContests()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/pastContests/past_contests.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];


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
            PastContests::truncate();
            PastContests::insert($arr_contests);

            return 'Статистика предыдущих лет успешно выгружена!';

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            die();
        }
    }


}
