<?php
namespace App\Traits;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\CompetitionAsp;
use App\CompetitionMaster;
use App\CompetitionSpo;
use App\Faculty;
use App\Plan;
use App\PlanAsp;
use App\PlanMaster;
use App\PlanSpo;
use App\PreparationLevel;
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
use Illuminate\Http\Request;

trait ParserJsonTrait{
//------------------------НАЧАЛО парсинг статистики Бакалавры--------------------------------
    public function parseCatalogs()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_bach.json'));
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
        return json_encode('Формы обучения, категории, уровни подготовки успешно выгружены!');

    }

    public function parseStatBach(){
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_bach.json'));
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

    public function parseStatBachAll(){
        set_time_limit(1200);
        $this->parseCatalogs();
        $this->parseStatBach();
        return json_encode('Информация об абитуриентах (бакалавриат,специалитет) успешно выгружена!');
    }
//------------------------КОНЕЦ парсинг статистики Бакалавры--------------------------------

//------------------------НАЧАЛО парсинг статистики Магистры--------------------------------
    public function parseCatalogsMaster()
    {
        ini_set('memory_limit', '1024M');

        $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_master.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];


//        PreparationLevel::truncate();
//        Category::truncate();


        $prepLevels = array();
        $categories = array();

        //Заполняем справочную информацию собирая все из статистики
        foreach ($json_data as $k => $fac_stat) {

            foreach ($fac_stat['List'] as $stud_element) {
//                try {
//                    $stud_element['fio'];
//                } catch (Throwable $t) {
//                    var_dump($stud_element);
//                }
                // var_dump($stud_element['preparationLevel']);

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
    }

    public function parseStatMaster()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_master.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        StudentMaster::truncate();
        StatisticMaster::truncate();
        ScoreMaster::truncate();

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
            StudentMaster::insert($students);
        }

        $chunks = array_chunk($studentsStat, 3000);
        foreach ($chunks as $chunk) {
            StatisticMaster::insert($chunk);
        }

        $chunks = array_chunk($scores, 3000);
        foreach ($chunks as $chunk) {
            ScoreMaster::insert($chunk);
        }

    }

    public function parseStatMasterAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsMaster();
        $this->parseStatMaster();

        return json_encode('Информация об абитуриентах (магистратура) успешно выгружена!');
    }
//------------------------КОНЕЦ парсинг статистики Магистры--------------------------------

//------------------------НАЧАЛО парсинг статистики Аспиранты--------------------------------
    public function parseCatalogsAsp()
    {
        ini_set('memory_limit', '1024M');

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
    }

    public function parseStatAsp()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_asp.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        StudentAsp::truncate();
        StatisticAsp::truncate();
        ScoreAsp::truncate();

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
            StudentAsp::insert($students);
        }

        $chunks = array_chunk($studentsStat, 3000);
        foreach ($chunks as $chunk) {
            StatisticAsp::insert($chunk);
        }

        $chunks = array_chunk($scores, 3000);
        foreach ($chunks as $chunk) {
            ScoreAsp::insert($chunk);
        }

    }

    public function parseStatAspAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsAsp();
        $this->parseStatAsp();

        return json_encode('Информация об абитуриентах (аспирантура) успешно выгружена!');
    }
//------------------------КОНЕЦ парсинг статистики Аспиранты--------------------------------

//------------------------НАЧАЛО парсинг статистики СПО--------------------------------
    public function parseCatalogsSpo()
    {
        ini_set('memory_limit', '1024M');

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
    }

    public function parseStatSpo()
    {
        ini_set('memory_limit', '1024M');
        $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_spo.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        StudentSpo::truncate();
        StatisticSpo::truncate();
        ScoreSpo::truncate();

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
            StudentSpo::insert($students);
        }

        $chunks = array_chunk($studentsStat, 3000);
        foreach ($chunks as $chunk) {
            StatisticSpo::insert($chunk);
        }

        $chunks = array_chunk($scores, 3000);
        foreach ($chunks as $chunk) {
            ScoreSpo::insert($chunk);
        }

    }

    public function parseStatSpoAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsSpo();
        $this->parseStatSpo();

        return json_encode('Информация об абитуриентах (СПО) успешно выгружена!');
    }
//------------------------КОНЕЦ парсинг статистики СПО--------------------------------



}
