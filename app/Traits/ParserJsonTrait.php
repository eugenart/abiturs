<?php

namespace App\Traits;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\CompetitionAsp;
use App\CompetitionAspForeigner;
use App\CompetitionForeigner;
use App\CompetitionMaster;
use App\CompetitionMasterForeigner;
use App\CompetitionSpo;
use App\DateUpdate;
use App\Faculty;
use App\Freeseats_bases;
use App\Freeseats_basesAsp;
use App\Freeseats_basesAspForeigner;
use App\Freeseats_basesForeigner;
use App\Freeseats_basesMaster;
use App\Freeseats_basesMasterForeigner;
use App\Freeseats_basesSpo;
use App\PastContests;
use App\Plan;
use App\PlanAsp;
use App\PlanAspForeigner;
use App\PlanCompetition;
use App\PlanCompetitionAsp;
use App\PlanCompetitionAspForeigner;
use App\PlanCompetitionForeigner;
use App\PlanCompetitionMaster;
use App\PlanCompetitionMasterForeigner;
use App\PlanCompetitionSpo;
use App\PlanCompScore;
use App\PlanCompScoreAsp;
use App\PlanCompScoreAspForeigner;
use App\PlanCompScoreForeigner;
use App\PlanCompScoreMaster;
use App\PlanCompScoreMasterForeigner;
use App\PlanCompScoreSpo;
use App\PlanForeigner;
use App\PlanMaster;
use App\PlanMasterForeigner;
use App\PlanSpo;
use App\PreparationLevel;
use App\Price;
use App\PriceAsp;
use App\PriceAspForeigner;
use App\PriceForeigner;
use App\PriceMaster;
use App\PriceMasterForeigner;
use App\PriceSpo;
use App\Score;
use App\ScoreAsp;
use App\ScoreAspForeigner;
use App\ScoreForeigner;
use App\ScoreMaster;
use App\ScoreMasterForeigner;
use App\ScoreSpo;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\StatisticAsp;
use App\StatisticAspForeigner;
use App\StatisticForeigner;
use App\StatisticMaster;
use App\StatisticMasterForeigner;
use App\StatisticSpo;
use App\Student;
use App\StudentAsp;
use App\StudentAspForeigner;
use App\StudentForeigner;
use App\StudentMaster;
use App\StudentMasterForeigner;
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

            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, ' parseCatalogs()');

            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $studyForms = array();
            $prepLevels = array();
            $categories = array();

            //Заполняем справочную информацию собирая все из статистики
            foreach ($json_data as $k => $fac_stat) {
                $stdForm = array(
                    'name' => $fac_stat['trainingForm'],
                    'en_name' => $fac_stat['trainingForm_en']
                );
                $studyForms[] = $stdForm;

                foreach ($fac_stat['List'] as $stud_element) {

                    $prepLevel = array(
                        'name' => $stud_element['preparationLevel'],
                        'en_name' => $stud_element['preparationLevel_en']
                    );
                    $prepLevels[] = $prepLevel;


                    $category = array(
                        'name' => $stud_element['category'],
                        'en_name' => $stud_element['category_en']
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
            echo "Error: ";
            echo $e->getMessage();
            fwrite($logs, "Error: ");
            fwrite($logs, $e->getMessage());
            fclose($logs);
            return -1;
        }

        fwrite($logs, ' Формы обучения, категории, уровни подготовки успешно выгружены!');
        fclose($logs);
        return 'Формы обучения, категории, уровни подготовки успешно выгружены!';

    }

    public function parseStatBach()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_bach.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, 'function parseStatBach()');
            echo 'function parseStatBach(){' . PHP_EOL;

            //ПРОВЕРКА
            $mes = NULL;
            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $idPlan = Plan::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = Competition::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();


                    if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                        || empty($idAdmissionBasis) || empty($idStudyForm)) {
                        $mes .= ' Не найден параметр.';
                        if (empty($idPlan)) {
                            $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                        }
                        if (empty($idFaculty)) {
                            $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                        }
                        if (empty($idSpeciality)) {
                            $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                        }
                        if (empty($idCompetition)) {
                            $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                        }
                        if (empty($idAdmissionBasis)) {
                            $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                        }
                        if (empty($idStudyForm)) {
                            $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                        }

                    }

                    foreach ($fac_stat['List'] as $student) {
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (empty($idSubject)) {
                                $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                            }
                        }
                    }
                } else {
                    $idPlan = PlanForeigner::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionForeigner::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                        || empty($idAdmissionBasis) || empty($idStudyForm)) {
                        $mes .= ' Не найден параметр.';
                        if (empty($idPlan)) {
                            $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                        }
                        if (empty($idFaculty)) {
                            $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                        }
                        if (empty($idSpeciality)) {
                            $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                        }
                        if (empty($idCompetition)) {
                            $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                        }
                        if (empty($idAdmissionBasis)) {
                            $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                        }
                        if (empty($idStudyForm)) {
                            $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                        }

                    }
                    foreach ($fac_stat['List'] as $student) {
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (empty($idSubject)) {
                                $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                            }
                        }
                    }
                }


            }
            if ($mes != NULL) {
                throw new ErrorException($mes);
            }


            Student::truncate(); //надо бы перенести его, но я пока не хочу ломать код
            StudentForeigner::truncate(); //надо бы перенести его, но я пока не хочу ломать код
            fwrite($logs, ' Students tables truncated;');
            echo '  Students tables truncated' . PHP_EOL;
            $scores = array();

            $studentsStat = array();
            $count_idStudent = 0;

            $scores_f = array();
            $studentsStat_f = array();
            $count_idStudent_f = 0;

            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $students = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = Plan::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = Competition::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //дата обновления статистики по плану
                    if(isset($fac_stat['date'])) {
                        $date_last = DateUpdate::where('id_plan', intval($idPlan->id))->where('id_competition', intval($idCompetition->id))->where('id_admissionBasis',intval($idAdmissionBasis->id))
                            ->where('id_studyForm',intval($idStudyForm->id))->first();
                        if(!empty($date_last)){
                            $date_update = DateUpdate::find($date_last->id);
//                            $date_update->date_update = $fac_stat['date'];
//                            $date_update->save();
                        }else{
                            $dates[] = array(
                                'name_file' => '',
                                'username' => '',
                                'date_update' => $fac_stat['date'],
                                'id_admissionBasis' => intval($idAdmissionBasis->id),
                                'id_studyForm' => intval($idStudyForm->id),
                                'id_plan' => intval($idPlan->id),
                                'id_competition' => intval($idCompetition->id),
                                'id_category' => '',
                                'id_preparationLevel'=> '',
                            );
                        }
                    }

                    //если все данные нашлись в бд specializationName
                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента если он уже подал куда то еще
                        $idStudent = Student::where('studentId', '=', $student['studentId'])->first();


                        if (empty($idStudent)) { //студента в базе нет - записываем
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],
                            );

                            $students[] = $stud;
                            $count_idStudent++;
//                            Student::insert($stud);
//                            $idStudent = Student::where('studentId', '=', $student['studentId'])->first();
//                            $id_stud = intval($idStudent->id);
                            $id_stud = $count_idStudent;//id студента равен счетчику записи в базу
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat[] = $stat;
                        } else {
                            $mes = 'Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }

                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score = array(
                                    'id_statistic' => count($studentsStat),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores[] = $score;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }
                    //Записываем в БД студентов для этой специализации
                    $students = array_unique($students, SORT_REGULAR);
                    //var_dump($students);
                     Student::insert($students);

                } else {
                    $students_f = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = PlanForeigner::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionForeigner::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //дата обновления статистики по плану
                    if(isset($fac_stat['date'])) {
                        $date_last = DateUpdate::where('id_plan', intval($idPlan->id))->where('id_competition', intval($idCompetition->id))->where('id_admissionBasis',intval($idAdmissionBasis->id))
                            ->where('id_studyForm',intval($idStudyForm->id))->first();
                        if(!empty($date_last)){
                            $date_update = DateUpdate::find($date_last->id);
//                            $date_update->date_update = $fac_stat['date'];
//                            $date_update->save();
                        }else{
                            $dates[] = array(
                                'name_file' => '',
                                'username' => '',
                                'date_update' => $fac_stat['date'],
                                'id_admissionBasis' => intval($idAdmissionBasis->id),
                                'id_studyForm' => intval($idStudyForm->id),
                                'id_plan' => intval($idPlan->id),
                                'id_competition' => intval($idCompetition->id),
                                'id_category' => '',
                                'id_preparationLevel'=> '',
                            );
                        }
                    }

                    //если все данные нашлись в бдspecializationName

                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента в предыдущих специальностях
                        $idStudent = StudentForeigner::where('studentId', '=', $student['studentId'])->first();
                        if (empty($idStudent)) { //студента в базе нет - записываем
                            $fio_en = null;
                            if (isset($student['fio_en'])) {
                                $fio_en = mb_convert_case(mb_strtolower($student['fio_en']), MB_CASE_TITLE);
                            }
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud_f = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'fio_en' => $fio_en,
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],

                            );
                            $students_f[] = $stud_f;
                            $count_idStudent_f++;
                            $id_stud_f = $count_idStudent_f; //id студента равен счетчику записи в базу
                        } else { //студент в БД есть  - не записываем, берем его id из БД
                            $id_stud_f = intval($idStudent->id); //id студента равен найденному в БД значению
                        }
                        //выбираем из БД остальные айдишники
                        $idCategory = Category::where('name', '=', $student['category'])->first();
                        $idPreparationLevel = PreparationLevel::where('name', '=', $student['preparationLevel'])->first();


                        if (!empty($idPlan) && !empty($idFaculty) && !empty($idSpeciality) && !empty($idCompetition)
                            && !empty($idAdmissionBasis) && !empty($idStudyForm) && !empty($idCategory) && !empty($idPreparationLevel)) {
                            //создаем запись в массиве статистики
                            $stat_f = array(
                                'id_student' => $id_stud_f,
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat_f[] = $stat_f;
                        } else {
                            $mes = 'Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }

                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score_f = array(
                                    'id_statistic' => count($studentsStat_f),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores_f[] = $score_f;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }
                    //Записываем в БД студентов для этой специализации
                    $students_f = array_unique($students_f, SORT_REGULAR);
                    StudentForeigner::insert($students_f);
                }
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

            $chunks = array_chunk($studentsStat_f, 2000);
            StatisticForeigner::truncate();
            foreach ($chunks as $chunk) {
                StatisticForeigner::insert($chunk);
            }

            $chunks = array_chunk($scores_f, 2000);
            ScoreForeigner::truncate();
            foreach ($chunks as $chunk) {
                ScoreForeigner::insert($chunk);
            }

            if(isset($dates)) {
                $chunks = array_chunk($dates, 2000);

                foreach ($chunks as $chunk) {
                    DateUpdate::insert($chunk);
                }
            }

        } catch (ErrorException $e) {
            echo "Error: ";
            echo $e->getMessage() . PHP_EOL;
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "Error: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
    }

    public function parseStatBachAll()
    {
        set_time_limit(1200);
        $result = $this->parseStatBach();
        if ($result != -1) {
            $this->XlsBach();
            $this->XlsBachForeigner();
        }

        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        if ($result != -1) {
            fwrite($logs, ' Информация об абитуриентах (бакалавриат,специалитет) успешно выгружена!');
            fclose($logs);
            echo '  Бакалавариат выгружен' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация об абитуриентах (бакалавриат,специалитет) успешно выгружена!' . PHP_EOL;
        } else {
            fwrite($logs, 'Информация не будет обновлена.');
            fclose($logs);
            echo '  Информация не будет обновлена.' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация не будет обновлена.';
        }

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
            echo 'function parseCatalogsMaster()' . PHP_EOL;
            $prepLevels = array();
            $categories = array();

            //Заполняем справочную информацию собирая все из статистики
            foreach ($json_data as $k => $fac_stat) {

                foreach ($fac_stat['List'] as $stud_element) {


                    $prepLevel_db = PreparationLevel::where('name', '=', $stud_element['preparationLevel'])->first();
                    if (empty($prepLevel_db)) {
                        $prepLevel = array(
                            'name' => $stud_element['preparationLevel'],
                            'en_name' => $stud_element['preparationLevel_en']
                        );
                        $prepLevels[] = $prepLevel;
                    }

                    $category_db = Category::where('name', '=', $stud_element['category'])->first();
                    if (empty($category_db)) {
                        $category = array(
                            'name' => $stud_element['category'],
                            'en_name' => $stud_element['category_en']
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
            echo "  Error: ";
            echo $e->getMessage() . PHP_EOL;

            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, " Error: ");
            fwrite($logs, $e->getMessage());
            fclose($logs);

            return -1;
        }
    }

    public function parseStatMaster()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_master.json'));

            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];
            echo 'function parseStatMaster(){' . PHP_EOL;

            //ПРОВЕРКА
            $mes = NULL;
            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $idPlan = PlanMaster::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionMaster::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();


                    if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                        || empty($idAdmissionBasis) || empty($idStudyForm)) {
                        $mes .= ' Не найден параметр.';
                        if (empty($idPlan)) {
                            $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                        }
                        if (empty($idFaculty)) {
                            $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                        }
                        if (empty($idSpeciality)) {
                            $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                        }
                        if (empty($idCompetition)) {
                            $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                        }
                        if (empty($idAdmissionBasis)) {
                            $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                        }
                        if (empty($idStudyForm)) {
                            $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                        }

                    }

                    foreach ($fac_stat['List'] as $student) {
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (empty($idSubject)) {
                                $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                            }
                        }
                    }
                } else {
                    $idPlan = PlanMasterForeigner::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionMasterForeigner::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                        || empty($idAdmissionBasis) || empty($idStudyForm)) {
                        $mes .= ' Не найден параметр.';
                        if (empty($idPlan)) {
                            $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                        }
                        if (empty($idFaculty)) {
                            $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                        }
                        if (empty($idSpeciality)) {
                            $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                        }
                        if (empty($idCompetition)) {
                            $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                        }
                        if (empty($idAdmissionBasis)) {
                            $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                        }
                        if (empty($idStudyForm)) {
                            $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                        }

                    }
                    foreach ($fac_stat['List'] as $student) {
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (empty($idSubject)) {
                                $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                            }
                        }
                    }
                }


            }
            if ($mes != NULL) {
                throw new ErrorException($mes);
            }


            StudentMaster::truncate();
            StudentMasterForeigner::truncate();

            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, ' Students tables truncated; ');
            echo '  Students tables truncated; ' . PHP_EOL;

            $scores = array();
            $students = array();
            $studentsStat = array();
            $count_idStudent = 0;

            $scores_f = array();
            $students_f = array();
            $studentsStat_f = array();
            $count_idStudent_f = 0;

            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $students = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = PlanMaster::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionMaster::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //если все данные нашлись в бд

                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента в предыдущих специальностях
                        $idStudent = StudentMaster::where('studentId', '=', $student['studentId'])->first();
                        if (empty($idStudent)) { //студента в базе нет - записываем
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat[] = $stat;
                        } else {
                            $mes = ' Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }

                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score = array(
                                    'id_statistic' => count($studentsStat),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores[] = $score;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }

                    //Записываем в БД студентов для этой специализации
                    $students = array_unique($students, SORT_REGULAR);
                    StudentMaster::insert($students);
                } else {
                    $students_f = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = PlanMasterForeigner::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionMasterForeigner::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //если все данные нашлись в бдspecializationName

                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента в предыдущих специальностях
                        $idStudent = StudentMasterForeigner::where('studentId', '=', $student['studentId'])->first();
                        if (empty($idStudent)) { //студента в базе нет - записываем
                            $fio_en = null;
                            if (isset($student['fio_en'])) {
                                $fio_en = mb_convert_case(mb_strtolower($student['fio_en']), MB_CASE_TITLE);
                            }
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud_f = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'fio_en' => $fio_en,
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],
                            );
                            $students_f[] = $stud_f;
                            $count_idStudent_f++;
                            $id_stud_f = $count_idStudent_f; //id студента равен счетчику записи в базу
                        } else { //студент в БД есть  - не записываем, берем его id из БД
                            $id_stud_f = intval($idStudent->id); //id студента равен найденному в БД значению
                        }
                        //выбираем из БД остальные айдишники
                        $idCategory = Category::where('name', '=', $student['category'])->first();
                        $idPreparationLevel = PreparationLevel::where('name', '=', $student['preparationLevel'])->first();


                        if (!empty($idPlan) && !empty($idFaculty) && !empty($idSpeciality) && !empty($idCompetition)
                            && !empty($idAdmissionBasis) && !empty($idStudyForm) && !empty($idCategory) && !empty($idPreparationLevel)) {
                            //создаем запись в массиве статистики
                            $stat_f = array(
                                'id_student' => $id_stud_f,
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat_f[] = $stat_f;
                        } else {
                            $mes = 'Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }

                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score_f = array(
                                    'id_statistic' => count($studentsStat_f),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores_f[] = $score_f;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }
                    //Записываем в БД студентов для этой специализации
                    $students_f = array_unique($students_f, SORT_REGULAR);
                    StudentMasterForeigner::insert($students_f);
                }
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

            $chunks = array_chunk($studentsStat_f, 2000);
            StatisticMasterForeigner::truncate();
            foreach ($chunks as $chunk) {
                StatisticMasterForeigner::insert($chunk);
            }

            $chunks = array_chunk($scores_f, 2000);
            ScoreMasterForeigner::truncate();
            foreach ($chunks as $chunk) {
                ScoreMasterForeigner::insert($chunk);
            }

        } catch (ErrorException $e) {
            echo "  Error: ";
            echo $e->getMessage() . PHP_EOL;
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, " Error: ");
            fwrite($logs, $e->getMessage());
            fclose($logs);
            return -1;
        }

    }

    public function parseStatMasterAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsMaster();
        $result = $this->parseStatMaster();
        if ($result != -1) {
            $this->XlsMaster();
            $this->XlsMasterForeigner();
        }

        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        if ($result != -1) {
            fwrite($logs, ' Информация об абитуриентах (магистратура) успешно выгружена!');
            fclose($logs);
            echo '  Магистратура выгружена' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация об абитуриентах (магистратура) успешно выгружена!';
        } else {
            fwrite($logs, 'Информация не будет обновлена.');
            fclose($logs);
            echo '  Информация не будет обновлена.' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация не будет обновлена.';
        }
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
            echo 'parseCatalogsAsp()' . PHP_EOL;
            $prepLevels = array();
            $categories = array();

            //Заполняем справочную информацию собирая все из статистики
            foreach ($json_data as $k => $fac_stat) {

                foreach ($fac_stat['List'] as $stud_element) {

                    $prepLevel_db = PreparationLevel::where('name', '=', $stud_element['preparationLevel'])->first();
                    if (empty($prepLevel_db)) {
                        $prepLevel = array(
                            'name' => $stud_element['preparationLevel'],
                            'en_name' => $stud_element['preparationLevel_en']
                        );
                        $prepLevels[] = $prepLevel;
                    }

                    $category_db = Category::where('name', '=', $stud_element['category'])->first();
                    if (empty($category_db)) {
                        $category = array(
                            'name' => $stud_element['category'],
                            'en_name' => $stud_element['category_en']
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
            echo "  Error: ";
            echo $e->getMessage() . PHP_EOL;
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, " Error: ");
            fwrite($logs, $e->getMessage());
            fclose($logs);
            return -1;
        }
    }

    public function parseStatAsp()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_asp.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];

            echo 'parseStatAsp(){' . PHP_EOL;

            //ПРОВЕРКА
            $mes = NULL;
            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $idPlan = PlanAsp::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionAsp::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();


                    if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                        || empty($idAdmissionBasis) || empty($idStudyForm)) {
                        $mes .= ' Не найден параметр.';
                        if (empty($idPlan)) {
                            $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                        }
                        if (empty($idFaculty)) {
                            $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                        }
                        if (empty($idSpeciality)) {
                            $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                        }
                        if (empty($idCompetition)) {
                            $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                        }
                        if (empty($idAdmissionBasis)) {
                            $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                        }
                        if (empty($idStudyForm)) {
                            $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                        }

                    }

                    foreach ($fac_stat['List'] as $student) {
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (empty($idSubject)) {
                                $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                            }
                        }
                    }
                } else {
                    $idPlan = PlanAspForeigner::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionAspForeigner::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                        || empty($idAdmissionBasis) || empty($idStudyForm)) {
                        $mes .= ' Не найден параметр.';
                        if (empty($idPlan)) {
                            $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                        }
                        if (empty($idFaculty)) {
                            $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                        }
                        if (empty($idSpeciality)) {
                            $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                        }
                        if (empty($idCompetition)) {
                            $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                        }
                        if (empty($idAdmissionBasis)) {
                            $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                        }
                        if (empty($idStudyForm)) {
                            $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                        }

                    }
                    foreach ($fac_stat['List'] as $student) {
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (empty($idSubject)) {
                                $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                            }
                        }
                    }
                }


            }
            if ($mes != NULL) {
                throw new ErrorException($mes);
            }

            StudentAsp::truncate();
            StudentAspForeigner::truncate();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, ' Students tables truncated; ');
            echo '  Students tables truncated;' . PHP_EOL;

            $scores = array();
            $students = array();
            $studentsStat = array();
            $count_idStudent = 0;

            $scores_f = array();
            $students_f = array();
            $studentsStat_f = array();
            $count_idStudent_f = 0;

            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $students = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = PlanAsp::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionAsp::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //если все данные нашлись в бд

                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента в предыдущих специальностях
                        $idStudent = StudentAsp::where('studentId', '=', $student['studentId'])->first();
                        if (empty($idStudent)) { //студента в базе нет - записываем
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat[] = $stat;
                        } else {
                            $mes = 'Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }

                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score = array(
                                    'id_statistic' => count($studentsStat),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores[] = $score;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }

                    //Записываем в БД студентов для этой специализации
                    $students = array_unique($students, SORT_REGULAR);
                    StudentAsp::insert($students);
                } else {
                    $students_f = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = PlanAspForeigner::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionAspForeigner::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //если все данные нашлись в бдspecializationName

                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента в предыдущих специальностях
                        $idStudent = StudentAspForeigner::where('studentId', '=', $student['studentId'])->first();
                        if (empty($idStudent)) { //студента в базе нет - записываем
                            $fio_en = null;
                            if (isset($student['fio_en'])) {
                                $fio_en = mb_convert_case(mb_strtolower($student['fio_en']), MB_CASE_TITLE);
                            }
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud_f = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'fio_en' => $fio_en,
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],
                            );
                            $students_f[] = $stud_f;
                            $count_idStudent_f++;
                            $id_stud_f = $count_idStudent_f; //id студента равен счетчику записи в базу
                        } else { //студент в БД есть  - не записываем, берем его id из БД
                            $id_stud_f = intval($idStudent->id); //id студента равен найденному в БД значению
                        }
                        //выбираем из БД остальные айдишники
                        $idCategory = Category::where('name', '=', $student['category'])->first();
                        $idPreparationLevel = PreparationLevel::where('name', '=', $student['preparationLevel'])->first();


                        if (!empty($idPlan) && !empty($idFaculty) && !empty($idSpeciality) && !empty($idCompetition)
                            && !empty($idAdmissionBasis) && !empty($idStudyForm) && !empty($idCategory) && !empty($idPreparationLevel)) {
                            //создаем запись в массиве статистики
                            $stat_f = array(
                                'id_student' => $id_stud_f,
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat_f[] = $stat_f;
                        } else {
                            $mes = 'Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }

                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score_f = array(
                                    'id_statistic' => count($studentsStat_f),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores_f[] = $score_f;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }
                    //Записываем в БД студентов для этой специализации
                    $students_f = array_unique($students_f, SORT_REGULAR);
                    StudentAspForeigner::insert($students_f);
                }
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

            $chunks = array_chunk($studentsStat_f, 2000);
            StatisticAspForeigner::truncate();

            foreach ($chunks as $chunk) {
                StatisticAspForeigner::insert($chunk);
            }

            $chunks = array_chunk($scores_f, 2000);
            ScoreAspForeigner::truncate();
            foreach ($chunks as $chunk) {
                ScoreAspForeigner::insert($chunk);
            }

        } catch (ErrorException $e) {
            echo "  Error: ";
            echo $e->getMessage() . PHP_EOL;
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, " Error: ");
            fwrite($logs, $e->getMessage());
            fclose($logs);
            return -1;
        }
    }


    public function parseStatAspAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsAsp();
        $result = $this->parseStatAsp();
        if ($result != -1) {
            $this->XlsAsp();
            $this->XlsAspForeigner();
        }

        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        if ($result != -1) {
            fwrite($logs, 'Информация об абитуриентах (аспирантура) успешно выгружена!');
            fclose($logs);
            echo '  Аспирантура выгружена' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация об абитуриентах (аспирантура) успешно выгружена!';
        } else {
            fwrite($logs, 'Информация не будет обновлена.');
            fclose($logs);
            echo '  Информация не будет обновлена.' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация не будет обновлена.';
        }
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
            echo 'function parseCatalogsSpo()' . PHP_EOL;
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
            echo "Error: ";
            echo $e->getMessage();

            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "Error: ");
            fwrite($logs, $e->getMessage() . '\n');
            fclose($logs);

            return -1;
        }
    }

    public function parseStatSpo()
    {
        ini_set('memory_limit', '1024M');
        try {
            $filejson = file_get_contents(storage_path('app/public/files/statistics/stat_spo.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];
            echo 'parseStatSpo(){' . PHP_EOL;

            //ПРОВЕРКА
            $mes = NULL;
            foreach ($json_data as $k => $fac_stat) {

                $idPlan = PlanSpo::where('planId', '=', $fac_stat['planId'])->first();
                $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                if (empty($idSpecialization)) {
                    $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                }
                $idCompetition = CompetitionSpo::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();


                if (empty($idPlan) || empty($idFaculty) || empty($idSpeciality) || empty($idCompetition)
                    || empty($idAdmissionBasis) || empty($idStudyForm)) {
                    $mes .= ' Не найден параметр.';
                    if (empty($idPlan)) {
                        $mes .= ' idPlan = ' . $fac_stat['planId'] . ',' . PHP_EOL;
                    }
                    if (empty($idFaculty)) {
                        $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',' . PHP_EOL;
                    }
                    if (empty($idSpeciality)) {
                        $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',' . PHP_EOL;
                    }
                    if (empty($idCompetition)) {
                        $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',' . PHP_EOL;
                    }
                    if (empty($idAdmissionBasis)) {
                        $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',' . PHP_EOL;
                    }
                    if (empty($idStudyForm)) {
                        $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',' . PHP_EOL;
                    }

                }

                foreach ($fac_stat['List'] as $student) {
                    foreach ($student['score'] as $score_item) {
                        $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                        if (empty($idSubject)) {
                            $mes .= 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'] . PHP_EOL;
                        }
                    }
                }


            }
            if ($mes != NULL) {
                throw new ErrorException($mes);
            }

            StudentSpo::truncate();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, 'Students tables truncated; ');
            echo 'Students tables truncated;' . PHP_EOL;

            $scores = array();
            $students = array();
            $studentsStat = array();
            $count_idStudent = 0;
            foreach ($json_data as $k => $fac_stat) {
                if (!$fac_stat['foreigner']) {
                    $students = array(); //чистим массив студетов
                    //выбираем из базы нужные айдишники
                    $idPlan = PlanSpo::where('planId', '=', $fac_stat['planId'])->first();
                    $idFaculty = Faculty::where('facultyId', '=', $fac_stat['facultyId'])->first();
                    $idSpeciality = Speciality::where('specialityId', '=', $fac_stat['trainingAreasId'])->first();
                    $idSpecialization = Specialization::where('specializationId', '=', $fac_stat['specializationID'])->first();
                    if (empty($idSpecialization)) {
                        $idSpecialization = Specialization::where('name', '=', $fac_stat['specializationName'])->first();
                    }
                    $idCompetition = CompetitionSpo::where('competitionId', '=', $fac_stat['CompetitionId'])->first();
                    $idAdmissionBasis = AdmissionBasis::where('baseId', '=', $fac_stat['IdBasis'])->first();
                    $idStudyForm = StudyForm::where('name', '=', $fac_stat['trainingForm'])->first();

                    //если все данные нашлись в бд

                    foreach ($fac_stat['List'] as $student) {
                        //находим id студента в предыдущих специальностях
                        $idStudent = StudentSpo::where('studentId', '=', $student['studentId'])->first();
                        if (empty($idStudent)) { //студента в базе нет - записываем
                            if(isset($student['snilsshow'])){
                                $snilsshow = $student['snilsshow'];
                            }else{
                                $snilsshow = false;
                            }
                            $stud = array(
                                'studentId' => $student['studentId'],
                                'fio' => mb_convert_case(mb_strtolower($student['fio']), MB_CASE_TITLE),
                                'snils' => preg_replace('/[^0-9]/', '', $student['snils']),
                                'snils2' => $student['snils2'],
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
                                'acceptCount' => $student['acceptСount'],
                                'stage' => isset($fac_stat['Stage']) ? $fac_stat['Stage'] : null,
                                'stage_title' => isset($fac_stat['StageTitle']) ? $fac_stat['StageTitle'] : null,
                                'snils_show' => $snilsshow,
                            );
                            $studentsStat[] = $stat;
                        } else {
                            $mes = 'Не найден параметр.';
                            if (empty($idPlan)) {
                                $mes .= ' idPlan = ' . $fac_stat['planId'] . ',';
                            }
                            if (empty($idFaculty)) {
                                $mes .= ' idFaculty = ' . $fac_stat['facultyId'] . ',';
                            }
                            if (empty($idSpeciality)) {
                                $mes .= ' $idSpeciality = ' . $fac_stat['trainingAreasId'] . ',';
                            }
                            if (empty($idCompetition)) {
                                $mes .= ' $idCompetition = ' . $fac_stat['CompetitionId'] . ',';
                            }
                            if (empty($idAdmissionBasis)) {
                                $mes .= ' $idAdmissionBasis = ' . $fac_stat['IdBasis'] . ',';
                            }
                            if (empty($idStudyForm)) {
                                $mes .= ' $idStudyForm = ' . $fac_stat['trainingForm'] . ',';
                            }
                            if (empty($idCategory)) {
                                $mes .= ' $idCategory = ' . $student['category'] . ',';
                            }
                            if (empty($idPreparationLevel)) {
                                $mes .= ' $idPreparationLevel = ' . $student['preparationLevel'] . ',';
                            }


                            throw new ErrorException($mes);
                        }

                        //теперь оценки
                        foreach ($student['score'] as $score_item) {
                            $idSubject = Subject::where('subjectId', '=', $score_item['subjectId'])->first();
                            if (!empty($idSubject)) {
                                $score = array(
                                    'id_statistic' => count($studentsStat),
                                    'id_subject' => intval($idSubject->id),
                                    'score' => $score_item['subjectScore'],
                                    'priority' => $score_item['Priority']
                                );
                                $scores[] = $score;
                            } else {
                                $mes = 'Не найден параметр. ' . ' idSubject = ' . $score_item['subjectId'];

                                throw new ErrorException($mes);
                            }
                        }
                    }

                    //Записываем в БД студентов для этой специализации
                    $students = array_unique($students, SORT_REGULAR);
                    StudentSpo::insert($students);
                }
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
            echo "  Error: ";
            echo $e->getMessage() . PHP_EOL;
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, " Error: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);

            fclose($logs);
            return -1;
        }
    }

    public function parseStatSpoAll()
    {
        set_time_limit(1200);

        $this->parseCatalogsSpo();
        $result = $this->parseStatSpo();
        if ($result != -1) {
            $this->XlsSpo();
        }

        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        if ($result != -1) {
            fwrite($logs, ' Информация об абитуриентах (СПО) успешно выгружена!');
            fclose($logs);
            echo '  СПО выгружена' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация об абитуриентах (СПО) успешно выгружена!';
        } else {
            fwrite($logs, 'Информация не будет обновлена.');
            fclose($logs);
            echo '  Информация не будет обновлена.' . PHP_EOL . '}' . PHP_EOL;
            return 'Информация не будет обновлена.';
        }
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

            $arr_plan_f = array();
            $arr_competition_f = array();
            $arr_plan_comp_f = array();
            $arr_plan_comp_score_f = array();
            $arr_prices_f = array();
            $arr_freeseats_f = array();
            $count_plan_f = 0;


            foreach ($json_data as $k => $element) {
                if (!$element['Competition']['foreigner']) {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = ' Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        $changable = false;
                        if (isset($subjectItem['change'])) {
                            $changable = $subjectItem['change'] == "True" ? 1 : 0;
                        }
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore'],
                                'changeable' => $changable
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = ' Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];

                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'organization' => $basisItem['Organization'],
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = ' Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];

                            throw new ErrorException($mes);
                        }
                    }
                } else {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan_f = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = ' Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
                    //заполним массив испытаний
                    $competition_f = array(
                        'competitionId' => $element['Competition']['CompetitionId'],
                        'competitionName' => $element['Competition']['CompetitionName']
                    );


                    $arr_plan_f[] = $plan_f;
                    $arr_competition_f[] = $competition_f;
                    $count_plan_f++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                    //массив связей плана и испытания
                    $plan_comp_f = array(
                        'id_plan' => $count_plan_f,
                        'id_competition' => $count_plan_f,
                        'freeSeatsNumber' => $element['freeSeatsNumber']
                    );

                    $arr_plan_comp_f[] = $plan_comp_f;

                    //связь предметов-оценок с объедением плана-исптания
                    foreach ($element['subjects'] as $subjectItem) {
                        $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
                        $changable = false;
                        if (isset($subjectItem['change'])) {
                            $changable = $subjectItem['change'] == "True" ? 1 : 0;
                        }
                        if (!empty($id_subject)) {
                            $subject_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore'],
                                'changeable' => $changable
                            );
                            $arr_plan_comp_score_f[] = $subject_f;
                        } else {
                            $mes = ' Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];

                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],
                                'info_en' => $priceItem['info_en'],
                            );
                            $arr_prices_f[] = $price_f;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'organization' => $basisItem['Organization'],
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats_f[] = $freeseat_f;
                        } else {
                            $mes = ' Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];

                            throw new ErrorException($mes);
                        }
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

            PlanForeigner::truncate();
            CompetitionForeigner::truncate();
            PlanCompetitionForeigner::truncate();
            PlanCompScoreForeigner::truncate();
            PriceForeigner::truncate();
            Freeseats_basesForeigner::truncate();
            PlanForeigner::insert($arr_plan_f);
            CompetitionForeigner::insert($arr_competition_f);
            PlanCompetitionForeigner::insert($arr_plan_comp_f);
            PlanCompScoreForeigner::insert($arr_plan_comp_score_f);
            PriceForeigner::insert($arr_prices_f);
            Freeseats_basesForeigner::insert($arr_freeseats_f);

            return 1;
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . '\n');
            fclose($logs);
            return -1;
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

            $arr_plan_f = array();
            $arr_competition_f = array();
            $arr_plan_comp_f = array();
            $arr_plan_comp_score_f = array();
            $arr_prices_f = array();
            $arr_freeseats_f = array();

            $count_plan_db_f = PlanForeigner::count();
            $count_plan_f = intval($count_plan_db_f);

            foreach ($json_data as $k => $element) {
                if (!$element['Competition']['foreigner']) {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {

                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        $changable = false;
                        if (isset($subjectItem['change'])) {
                            $changable = $subjectItem['change'] == "True" ? 1 : 0;
                        }
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore'],
                                'changeable' => $changable
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];

                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],

                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'organization' => $basisItem['Organization'],
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];

                            throw new ErrorException($mes);
                        }
                    }
                } else {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {

                        $plan_f = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
                    //заполним массив испытаний
                    $competition_f = array(
                        'competitionId' => $element['Competition']['CompetitionId'],
                        'competitionName' => $element['Competition']['CompetitionName']
                    );


                    $arr_plan_f[] = $plan_f;
                    $arr_competition_f[] = $competition_f;
                    $count_plan_f++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                    //массив связей плана и испытания
                    $plan_comp_f = array(
                        'id_plan' => $count_plan_f,
                        'id_competition' => $count_plan_f,
                        'freeSeatsNumber' => $element['freeSeatsNumber']
                    );

                    $arr_plan_comp_f[] = $plan_comp_f;

                    //связь предметов-оценок с объедением плана-исптания
                    foreach ($element['subjects'] as $subjectItem) {
                        $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
                        $changable = false;
                        if (isset($subjectItem['change'])) {
                            $changable = $subjectItem['change'] == "True" ? 1 : 0;
                        }
                        if (!empty($id_subject)) {
                            $subject_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore'],
                                'changeable' => $changable
                            );
                            $arr_plan_comp_score_f[] = $subject_f;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];

                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],
                                'info_en' => $priceItem['info_en'],
                            );
                            $arr_prices_f[] = $price_f;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'organization' => $basisItem['Organization'],
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats_f[] = $freeseat_f;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];

                            throw new ErrorException($mes);
                        }
                    }
                }
            }

            Plan::insert($arr_plan);
            Competition::insert($arr_competition);
            PlanCompetition::insert($arr_plan_comp);
            PlanCompScore::insert($arr_plan_comp_score);
            Price::insert($arr_prices);
            Freeseats_bases::insert($arr_freeseats);

            PlanForeigner::insert($arr_plan_f);
            CompetitionForeigner::insert($arr_competition_f);
            PlanCompetitionForeigner::insert($arr_plan_comp_f);
            PlanCompScoreForeigner::insert($arr_plan_comp_score_f);
            PriceForeigner::insert($arr_prices_f);
            Freeseats_basesForeigner::insert($arr_freeseats_f);
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, " С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
    }

    public function parsePlansBach()
    {
        set_time_limit(1200);

        if ($this->parsePlansBachSpecSar() === 1) {
            $this->parsePlansBachSpecRuz(); //отдельно запускать нельзя, только в такой последовательности
        }
        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');

        fwrite($logs, ' Планы, цены за обучение и количество мест бакалавриата и специалитета успешно выгружены!');

        fclose($logs);

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

            $arr_plan_f = array();
            $arr_competition_f = array();
            $arr_plan_comp_f = array();
            $arr_plan_comp_score_f = array();
            $arr_prices_f = array();
            $arr_freeseats_f = array();
            $count_plan_f = 0;

            foreach ($json_data as $k => $element) {
                if (!$element['Competition']['foreigner']) {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
                    }
                } else {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan_f = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
                    //заполним массив испытаний
                    $competition_f = array(
                        'competitionId' => $element['Competition']['CompetitionId'],
                        'competitionName' => $element['Competition']['CompetitionName']
                    );


                    $arr_plan_f[] = $plan_f;
                    $arr_competition_f[] = $competition_f;
                    $count_plan_f++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                    //массив связей плана и испытания
                    $plan_comp_f = array(
                        'id_plan' => $count_plan_f,
                        'id_competition' => $count_plan_f,
                        'freeSeatsNumber' => $element['freeSeatsNumber']
                    );

                    $arr_plan_comp_f[] = $plan_comp_f;

                    //связь предметов-оценок с объедением плана-исптания
                    foreach ($element['subjects'] as $subjectItem) {
                        $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
                        if (!empty($id_subject)) {
                            $subject_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score_f[] = $subject_f;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],
                                'info_en' => $priceItem['info_en'],
                            );
                            $arr_prices_f[] = $price_f;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats_f[] = $freeseat_f;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
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


            PlanMasterForeigner::truncate();
            CompetitionMasterForeigner::truncate();
            PlanCompetitionMasterForeigner::truncate();
            PlanCompScoreMasterForeigner::truncate();
            PriceMasterForeigner::truncate();
            Freeseats_basesMasterForeigner::truncate();

            PlanMasterForeigner::insert($arr_plan_f);
            CompetitionMasterForeigner::insert($arr_competition_f);
            PlanCompetitionMasterForeigner::insert($arr_plan_comp_f);
            PlanCompScoreMasterForeigner::insert($arr_plan_comp_score_f);
            PriceMasterForeigner::insert($arr_prices_f);
            Freeseats_basesMasterForeigner::insert($arr_freeseats_f);

            return 1;
        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
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

            $arr_plan_f = array();
            $arr_competition_f = array();
            $arr_plan_comp_f = array();
            $arr_plan_comp_score_f = array();
            $arr_prices_f = array();
            $arr_freeseats_f = array();

            $count_plan_db_f = PlanMasterForeigner::count();
            $count_plan_f = intval($count_plan_db_f);

            foreach ($json_data as $k => $element) {
                if (!$element['Competition']['foreigner']) {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
                    }
                } else {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {

                        $plan_f = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
                    //заполним массив испытаний
                    $competition_f = array(
                        'competitionId' => $element['Competition']['CompetitionId'],
                        'competitionName' => $element['Competition']['CompetitionName']
                    );


                    $arr_plan_f[] = $plan_f;
                    $arr_competition_f[] = $competition_f;
                    $count_plan_f++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                    //массив связей плана и испытания
                    $plan_comp_f = array(
                        'id_plan' => $count_plan_f,
                        'id_competition' => $count_plan_f,
                        'freeSeatsNumber' => $element['freeSeatsNumber']
                    );

                    $arr_plan_comp_f[] = $plan_comp_f;

                    //связь предметов-оценок с объедением плана-исптания
                    foreach ($element['subjects'] as $subjectItem) {
                        $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
                        if (!empty($id_subject)) {
                            $subject_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score_f[] = $subject_f;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],
                                'info_en' => $priceItem['info_en'],
                            );
                            $arr_prices_f[] = $price_f;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats_f[] = $freeseat_f;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
                    }
                }
            }

            PlanMaster::insert($arr_plan);
            CompetitionMaster::insert($arr_competition);
            PlanCompetitionMaster::insert($arr_plan_comp);
            PlanCompScoreMaster::insert($arr_plan_comp_score);
            PriceMaster::insert($arr_prices);
            Freeseats_basesMaster::insert($arr_freeseats);

            PlanMasterForeigner::insert($arr_plan_f);
            CompetitionMasterForeigner::insert($arr_competition_f);
            PlanCompetitionMasterForeigner::insert($arr_plan_comp_f);
            PlanCompScoreMasterForeigner::insert($arr_plan_comp_score_f);
            PriceMasterForeigner::insert($arr_prices_f);
            Freeseats_basesMasterForeigner::insert($arr_freeseats_f);

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
    }

    public function parsePlansMaster()
    {
        set_time_limit(1200);

        if ($this->parsePlansMasterSar() === 1) {
            $this->parsePlansMasterRuz(); //отдельно запускать нельзя, только в такой последовательности
        }
        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        fwrite($logs, ' Планы, цены за обучение и количество мест магистратуры успешно выгружены!');
        fclose($logs);
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

            $arr_plan_f = array();
            $arr_competition_f = array();
            $arr_plan_comp_f = array();
            $arr_plan_comp_score_f = array();
            $arr_prices_f = array();
            $arr_freeseats_f = array();
            $count_plan_f = 0;


            foreach ($json_data as $k => $element) {
                if (!$element['Competition']['foreigner']) {

                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }
                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
                    }
                } else {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan_f = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
                    //заполним массив испытаний
                    $competition_f = array(
                        'competitionId' => $element['Competition']['CompetitionId'],
                        'competitionName' => $element['Competition']['CompetitionName']
                    );


                    $arr_plan_f[] = $plan_f;
                    $arr_competition_f[] = $competition_f;
                    $count_plan_f++; //если не делать юник для планов которые повторяются то id плана и компетишина равны




                    //массив связей плана и испытания
                    $plan_comp_f = array(
                        'id_plan' => $count_plan_f,
                        'id_competition' => $count_plan_f,
                        'freeSeatsNumber' => $element['freeSeatsNumber']
                    );

                    $arr_plan_comp_f[] = $plan_comp_f;

                    //связь предметов-оценок с объедением плана-исптания
                    foreach ($element['subjects'] as $subjectItem) {
                        $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
                        if (!empty($id_subject)) {
                            $subject_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score_f[] = $subject_f;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],
                                'info_en' => $priceItem['info_en'],
                            );
                            $arr_prices_f[] = $price_f;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats_f[] = $freeseat_f;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
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

            PlanAspForeigner::truncate();
            CompetitionAspForeigner::truncate();
            PlanCompetitionAspForeigner::truncate();
            PlanCompScoreAspForeigner::truncate();
            PriceAspForeigner::truncate();
            Freeseats_basesAspForeigner::truncate();

            PlanAspForeigner::insert($arr_plan_f);
            CompetitionAspForeigner::insert($arr_competition_f);
            PlanCompetitionAspForeigner::insert($arr_plan_comp_f);
            PlanCompScoreAspForeigner::insert($arr_plan_comp_score_f);
            PriceAspForeigner::insert($arr_prices_f);
            Freeseats_basesAspForeigner::insert($arr_freeseats_f);

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
    }

    public function parsePlansOrd()
    {
        set_time_limit(0);
        try {
            $filejson = file_get_contents(storage_path('app/public/files/plans/plans_saransk/plans_sar_ord.json'));
            $json_arr = json_decode($filejson, true);
            $json_data = $json_arr['data'];


            $arr_plan = array();
            $arr_competition = array();
            $arr_plan_comp = array();
            $arr_plan_comp_score = array();
            $arr_prices = array();
            $arr_freeseats = array();
            $count_plan_db = PlanAsp::count();
            $count_plan = intval($count_plan_db);

            $arr_plan_f = array();
            $arr_competition_f = array();
            $arr_plan_comp_f = array();
            $arr_plan_comp_score_f = array();
            $arr_prices_f = array();
            $arr_freeseats_f = array();
            $count_plan_db_f = PlanAspForeigner::count();
            $count_plan_f = intval($count_plan_db_f);

            foreach ($json_data as $k => $element) {
                if (!$element['Competition']['foreigner']) {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }
                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
                    }
                } else {
                    $id_faculty = Faculty::where('facultyId', '=', $element['Plan']['facultyId'])->first();
                    $id_studyForm = StudyForm::where('name', '=', $element['Plan']['trainingForm'])->first();
                    $id_speciality = Speciality::where('specialityId', '=', $element['Plan']['trainingAreasId'])->first();
                    $id_specialization = Specialization::where('specializationId', '=', $element['Plan']['specializationID'])->first();
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan_f = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
                    //заполним массив испытаний
                    $competition_f = array(
                        'competitionId' => $element['Competition']['CompetitionId'],
                        'competitionName' => $element['Competition']['CompetitionName']
                    );


                    $arr_plan_f[] = $plan_f;
                    $arr_competition_f[] = $competition_f;
                    $count_plan_f++; //если не делать юник для планов которые повторяются то id плана и компетишина равны
                    //массив связей плана и испытания
                    $plan_comp_f = array(
                        'id_plan' => $count_plan_f,
                        'id_competition' => $count_plan_f,
                        'freeSeatsNumber' => $element['freeSeatsNumber']
                    );

                    $arr_plan_comp_f[] = $plan_comp_f;

                    //связь предметов-оценок с объедением плана-исптания
                    foreach ($element['subjects'] as $subjectItem) {
                        $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();
                        if (!empty($id_subject)) {
                            $subject_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score_f[] = $subject_f;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info'],
                                'info_en' => $priceItem['info_en'],
                            );
                            $arr_prices_f[] = $price_f;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat_f = array(
                                'id_plan_comp' => $count_plan_f, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats_f[] = $freeseat_f;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
                    }
                }
            }

            PlanAsp::insert($arr_plan);
            CompetitionAsp::insert($arr_competition);
            PlanCompetitionAsp::insert($arr_plan_comp);
            PlanCompScoreAsp::insert($arr_plan_comp_score);
            PriceAsp::insert($arr_prices);
            Freeseats_basesAsp::insert($arr_freeseats);

            PlanAspForeigner::insert($arr_plan_f);
            CompetitionAspForeigner::insert($arr_competition_f);
            PlanCompetitionAspForeigner::insert($arr_plan_comp_f);
            PlanCompScoreAspForeigner::insert($arr_plan_comp_score_f);
            PriceAspForeigner::insert($arr_prices_f);
            Freeseats_basesAspForeigner::insert($arr_freeseats_f);

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
    }

    public function parsePlansAspMain()
    {
        set_time_limit(1200);

        $this->parsePlansAsp();
        $this->parsePlansOrd();
        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        fwrite($logs, ' Планы, цены за обучение и количество мест аспирантуры успешно выгружены!');
        fclose($logs);
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
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
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
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
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
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {

                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
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
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
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
                    if (!isset($id_specialization)) {
                        $id_specialization = Specialization::where('name', '=', $element['Plan']['specializationName'])->first();
                    }

                    //заполним массив планов
                    if (!empty($id_faculty) && !empty($id_studyForm) && !empty($id_speciality)) {
                        $plan = array(
                            'planId' => $element['Plan']['planId'],
                            'id_faculty' => intval($id_faculty->id),
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_speciality' => intval($id_speciality->id),
                            'id_specialization' => $id_specialization ? intval($id_specialization->id) : null,
                            'years' => intval($element['Plan']['years'])

                        );
                    } else {
                        $mes = 'Не найден параметр.';
                        if (empty($id_faculty)) {
                            $mes .= ' id_faculty' . $element['Plan']['facultyId'] . ',';
                        }
                        if (empty($id_studyForm)) {
                            $mes .= ' $id_studyForm' . $element['Plan']['trainingForm'] . ',';
                        }
                        if (empty($id_speciality)) {
                            $mes .= ' $id_speciality = ' . $element['Plan']['trainingAreasId'] . ',';
                        }

                        throw new ErrorException($mes);
                    }
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
                        if (!empty($id_subject)) {
                            $subject = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_subject' => intval($id_subject->id),
                                'minScore' => $subjectItem['minScore']
                            );
                            $arr_plan_comp_score[] = $subject;
                        } else {
                            $mes = 'Не найден параметр.' . ' id_subject = ' . $subjectItem['subjectId'];
                            throw new ErrorException($mes);
                        }
                    }
                    if (isset($element['Prices'])) {
                        foreach ($element['Prices'] as $priceItem) {
                            $price = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'price' => $priceItem['Price'],
                                'info' => $priceItem['info']
                            );
                            $arr_prices[] = $price;
                        }
                    }

                    foreach ($element['admissionBasis'] as $basisItem) {
                        $id_admissionBasis = AdmissionBasis::where('baseId', '=', $basisItem['IdBasis'])->first();
                        if (!empty($id_admissionBasis)) {
                            $freeseat = array(
                                'id_plan_comp' => $count_plan, // так же если не делать уникальной таблицу планов
                                'id_admissionBasis' => intval($id_admissionBasis->id),
                                'value' => $basisItem['value']
                            );
                            $arr_freeseats[] = $freeseat;
                        } else {
                            $mes = 'Не найден параметр.' . 'id_admissionBasis = ' . $basisItem['IdBasis'];
                            throw new ErrorException($mes);
                        }
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
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
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
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        fwrite($logs, ' Планы, цены за обучение и количество мест СПО успешно выгружены!');
        fclose($logs);
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

                if (!empty($id_studyForm) && !empty($id_admissionBasis)) {
                    if (!empty($id_speciality)) {
                        $contest = array(
                            'id_studyForm' => intval($id_studyForm->id),
                            'id_admissionBasis' => intval($id_admissionBasis->id),
                            'id_speciality' => intval($id_speciality->id),
                            'year' => $element['year'],
                            'minScore' => $element['value']
                        );

                        $arr_contests[] = $contest;
                    }
                } else {
                    $mes = 'Не найден параметр.';
                    if (empty($id_admissionBasis)) {
                        $mes .= ' id_admissionBasis' . $element['IdBasis'] . ',';
                    }
                    if (empty($id_studyForm)) {
                        $mes .= ' $id_studyForm' . $element['trainingForm'] . ',';
                    }
                    if (empty($id_speciality)) {
                        $mes .= ' $id_speciality = ' . $element['trainingAreasId'] . ',';
                    }

                    throw new ErrorException($mes);
                }
            }
            PastContests::truncate();
            PastContests::insert($arr_contests);
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, ' Статистика предыдущих лет успешно выгружена!');
            fclose($logs);
            return 'Статистика предыдущих лет успешно выгружена!';

        } catch (ErrorException $e) {
            echo "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ";
            echo $e->getMessage();
            $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
            fwrite($logs, "С новым файлом что-то не так. Данные не будут обновленны. Ошибка: ");
            fwrite($logs, $e->getMessage() . PHP_EOL);
            fclose($logs);
            return -1;
        }
    }


}
