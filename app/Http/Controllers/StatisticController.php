<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Competition;
use App\CompetitionAsp;
use App\DateUpdate;
use App\Faculty;
use App\Freeseats_bases;
use App\Infoblock;
use App\Plan;
use App\PlanCompetition;
use App\PreparationLevel;
use App\Score;
use App\Section;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\StatisticAsp;
use App\Student;
use App\StudyForm;
use App\TrainingArea;
use App\Traits\XlsMakerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;

class StatisticController extends Controller
{
    use XlsMakerTrait;

    function sortByPredefinedOrder($leftItem, $rightItem)
    {
        $order = array(
            "Очная форма, особое право",
            "Очная форма, целевое обучение",
            "Очная форма, бюджет",
            "Очная форма, полное возмещение затрат",

            "Очно-заочная форма, особое право",
            "Очно-заочная форма, целевое обучение",
            "Очно-заочная форма, бюджет",
            "Очно-заочная форма, полное возмещение затрат",

            "Заочная форма, особое право",
            "Заочная форма, целевое обучение",
            "Заочная форма, бюджет",
            "Заочная форма, полное возмещение затрат",

            "Очная форма, особое право, аспирантура",
            "Очная форма, целевое обучение, аспирантура",
            "Очная форма, бюджет, аспирантура",
            "Очная форма, полное возмещение затрат, аспирантура",

            "Очно-заочная форма, особое право, аспирантура",
            "Очно-заочная форма, целевое обучение, аспирантура",
            "Очно-заочная форма, бюджет, аспирантура",
            "Очно-заочная форма, полное возмещение затрат, аспирантура",

            "Заочная форма, особое право, аспирантура",
            "Заочная форма, целевое обучение, аспирантура",
            "Заочная форма, бюджет, аспирантура",
            "Заочная форма, полное возмещение затрат, аспирантура",

            "Очная форма, особое право, ординатура",
            "Очная форма, целевое обучение, ординатура",
            "Очная форма, бюджет, ординатура",
            "Очная форма, полное возмещение затрат, ординатура",

            "Очно-заочная форма, особое право, ординатура",
            "Очно-заочная форма, целевое обучение, ординатура",
            "Очно-заочная форма, бюджет, ординатура",
            "Очно-заочная форма, полное возмещение затрат, ординатура",

            "Заочная форма, особое право, ординатура",
            "Заочная форма, целевое обучение, ординатура",
            "Заочная форма, бюджет, ординатура",
            "Заочная форма, полное возмещение затрат, ординатура",
        );

        $flipped_order = array_flip($order);

        $leftItem = stristr($leftItem, '.', true);
        $rightItem = stristr($rightItem, '.', true);

        $leftPos = $flipped_order[$leftItem];
        $rightPos = $flipped_order[$rightItem];

        return $leftPos >= $rightPos;
    }

    public function makeModelsNames($modelName)
    {
        $names_arr = array();
        if ($modelName == 'Statistic') {
            $names_arr['Statistic'] = 'App\Statistic';
            $names_arr['Student'] = 'App\Student';
            $names_arr['Competition'] = 'App\Competition';
            $names_arr['PlanCompetition'] = 'App\PlanCompetition';
            $names_arr['PlanCompScore'] = 'App\PlanCompScore';
            $names_arr['Plan'] = 'App\Plan';
            $names_arr['Score'] = 'App\Score';
            $names_arr['Freeseats'] = 'App\Freeseats_bases';
            $names_arr['folder'] = 'bach';
            $names_arr['date'] = 'stat_bach';
            $names_arr['name_table'] = 'statistics';
            $names_arr['page'] = 'pages.stat';

        }
        if ($modelName == 'StatisticMaster') {
            $names_arr['Statistic'] = 'App\StatisticMaster';
            $names_arr['Student'] = 'App\StudentMaster';
            $names_arr['Competition'] = 'App\CompetitionMaster';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionMaster';
            $names_arr['PlanCompScore'] = 'App\PlanCompScoreMaster';
            $names_arr['Plan'] = 'App\PlanMaster';
            $names_arr['Score'] = 'App\ScoreMaster';
            $names_arr['Freeseats'] = 'App\Freeseats_basesMaster';
            $names_arr['folder'] = 'master';
            $names_arr['date'] = 'stat_master';
            $names_arr['name_table'] = 'statistic_masters';
            $names_arr['page'] = 'pages.statmaster';
        }
        if ($modelName == 'StatisticAsp') {
            $names_arr['Statistic'] = 'App\StatisticAsp';
            $names_arr['Student'] = 'App\StudentAsp';
            $names_arr['Competition'] = 'App\CompetitionAsp';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionAsp';
            $names_arr['PlanCompScore'] = 'App\PlanCompScoreAsp';
            $names_arr['Plan'] = 'App\PlanAsp';
            $names_arr['Score'] = 'App\ScoreAsp';
            $names_arr['Freeseats'] = 'App\Freeseats_basesAsp';
            $names_arr['folder'] = 'asp';
            $names_arr['date'] = 'stat_asp';
            $names_arr['name_table'] = 'statistic_asps';
            $names_arr['page'] = 'pages.statasp';
        }
        if ($modelName == 'StatisticSpo') {
            $names_arr['Statistic'] = 'App\StatisticSpo';
            $names_arr['Student'] = 'App\StudentSpo';
            $names_arr['Competition'] = 'App\CompetitionSpo';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionSpo';
            $names_arr['PlanCompScore'] = 'App\PlanCompScoreSpo';
            $names_arr['Plan'] = 'App\PlanSpo';
            $names_arr['Score'] = 'App\ScoreSpo';
            $names_arr['Freeseats'] = 'App\Freeseats_basesSpo';
            $names_arr['folder'] = 'spo';
            $names_arr['date'] = 'stat_spo';
            $names_arr['name_table'] = 'statistic_spos';
            $names_arr['page'] = 'pages.statspo';
        }

        if ($modelName == 'StatisticForeigner') {
            $names_arr['Statistic'] = 'App\StatisticForeigner';
            $names_arr['Student'] = 'App\StudentForeigner';
            $names_arr['Competition'] = 'App\CompetitionForeigner';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionForeigner';
            $names_arr['PlanCompScore'] = 'App\PlanCompScoreForeigner';
            $names_arr['Plan'] = 'App\PlanForeigner';
            $names_arr['Score'] = 'App\ScoreForeigner';
            $names_arr['Freeseats'] = 'App\Freeseats_basesForeigner';
            $names_arr['folder'] = 'bachf';
            $names_arr['date'] = 'stat_bach';
            $names_arr['name_table'] = 'statistic_foreigners';
            $names_arr['page'] = 'pages.statforeigner';
        }
        if ($modelName == 'StatisticMasterForeigner') {
            $names_arr['Statistic'] = 'App\StatisticMasterForeigner';
            $names_arr['Student'] = 'App\StudentMasterForeigner';
            $names_arr['Competition'] = 'App\CompetitionMasterForeigner';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionMasterForeigner';
            $names_arr['Plan'] = 'App\PlanMasterForeigner';
            $names_arr['PlanCompScore'] = 'App\PlanCompScoreMasterForeigner';
            $names_arr['Score'] = 'App\ScoreMasterForeigner';
            $names_arr['Freeseats'] = 'App\Freeseats_basesMasterForeigner';
            $names_arr['folder'] = 'masterf';
            $names_arr['date'] = 'stat_master';
            $names_arr['name_table'] = 'statistic_master_foreigners';
            $names_arr['page'] = 'pages.statmasterforeigner';
        }
        if ($modelName == 'StatisticAspForeigner') {
            $names_arr['Statistic'] = 'App\StatisticAspForeigner';
            $names_arr['Student'] = 'App\StudentAspForeigner';
            $names_arr['Competition'] = 'App\CompetitionAspForeigner';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionAspForeigner';
            $names_arr['PlanCompScore'] = 'App\PlanCompScoreAspForeigner';
            $names_arr['Plan'] = 'App\PlanAspForeigner';
            $names_arr['Score'] = 'App\ScoreAspForeigner';
            $names_arr['Freeseats'] = 'App\Freeseats_basesAspForeigner';
            $names_arr['folder'] = 'aspf';
            $names_arr['date'] = 'stat_asp';
            $names_arr['name_table'] = 'statistic_asp_foreigners';
            $names_arr['page'] = 'pages.stataspforeigner';
        }
//        var_export($names_arr);
        return $names_arr;
    }


    public function bachelor(Request $request)
    {
        $names_arr = $this->makeModelsNames('Statistic');
        return $this->query($request, $names_arr);
    }

    public function master(Request $request)
    {
        $names_arr = $this->makeModelsNames('StatisticMaster');
        return $this->query($request, $names_arr);
    }

    public function asp(Request $request)
    {
        $names_arr = $this->makeModelsNames('StatisticAsp');
        return $this->query($request, $names_arr);
    }

    public function spo(Request $request)
    {
        $names_arr = $this->makeModelsNames('StatisticSpo');
        return $this->query($request, $names_arr);
    }

    public function bachf(Request $request)
    {
        $names_arr = $this->makeModelsNames('StatisticForeigner');
        return $this->query($request, $names_arr);
    }

    public function masterf(Request $request)
    {
        $names_arr = $this->makeModelsNames('StatisticMasterForeigner');
        return $this->query($request, $names_arr);
    }

    public function aspf(Request $request)
    {
        $names_arr = $this->makeModelsNames('StatisticAspForeigner');
        return $this->query($request, $names_arr);
    }


    public function query(Request $request, $names_arr)
    {

        $search_fio = null;
        $search_faculties = [];
        $search_specialities = [];
        $search_studyForms = [];
        if (isset($request->fio)) {
            $search_fio = $request->fio;
        }
        if (isset($request->faculties)) {
            $search_faculties = $request->faculties;
        }
        if (isset($request->specialities)) {
            $search_specialities = $request->specialities;
        }
        if (isset($request->studyforms)) {
            $search_studyForms = $request->studyforms;
        }

        if (isset($search_fio) || !empty($search_faculties)) {
            $studyForms = $this->search($search_fio, $search_faculties, $search_specialities, $search_studyForms, $notification, $names_arr);
        }

        //получим все названия файлов xls
        $files_xls = array();
        $notification_files = "";

        if ($dir = scandir(storage_path('app/public/files-xls-stat/' . $names_arr['folder']))) {
            $files_xls = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $files_xls[] = $file;
            }
            usort($files_xls, array($this, 'sortByPredefinedOrder'));
        } else {
            $notification_files = "Не удалось открыть директорию с файлами";
        }


        $date_update = DateUpdate::where('name_file', '=', $names_arr['date'])->first();

        $faculties = $this->fetchFaculties($names_arr);

        $studyFormsForInputs = DB::table('study_forms')->join($names_arr['name_table'], 'study_forms.id', '=', $names_arr['name_table'] . '.id_studyForm')
            ->groupBy('study_forms.id')->select('study_forms.*')->get();

        //получение бегущей строки.
        //Magistratura Srednee-professionalinoe-obrazovanie
        $news = array();
        if($names_arr['folder'] == 'bach'){
            $infoblock = Infoblock::where('url', 'Bakalavriat-i-spetsialitet')->first();
            $news = $infoblock->news;
        }



        if (isset($studyForms)) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if ($studyForms->count() != 0) {
//успешный вывод
//                                return $studyForms;
                return view($names_arr['page'], ['studyForms' => $studyForms, 'faculties' => $faculties,
                    'studyFormsForInputs' => $studyFormsForInputs, 'actual_link' => $actual_link, 'date_update' => $date_update,
                    'files_xls' => $files_xls, 'notification_files' => $notification_files, 'news' => $news]);

            } else {
                if (isset($faculties) && isset($studyFormsForInputs)) {
                    if (($faculties->count() != 0) && ($studyFormsForInputs->count() != 0)) {
                        $notification = trans('statforeigner.notification_not_found');

                        return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs, 'notification' => $notification, 'news' => $news]);
                    } else {
                        $faculties = collect(new Faculty);
                        $studyFormsForInputs = collect(new StudyForm);

//на время пока аспирантуры нет
                        if($names_arr['page'] == 'pages.statasp' || $names_arr['page'] == 'pages.stataspforeigner'){
                            $notification = trans('statforeigner.notification_green_asp');
                        }else{
                            $notification = trans('statforeigner.notification_green');
                        }
                        return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                            'notification_green' => $notification, 'news' => $news]);
                    }
                } else {
                    $faculties = collect(new Faculty);
                    $studyFormsForInputs = collect(new StudyForm);

//на время пока аспирантуры нет
                    if($names_arr['page'] == 'pages.statasp' || $names_arr['page'] == 'pages.stataspforeigner'){
                        $notification = trans('statforeigner.notification_green_asp');
                    }else{
                        $notification = trans('statforeigner.notification_green');
                    }
                    return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                        'notification_green' => $notification, 'news' => $news]);
                }

            }
        } else {
            if (isset($faculties) && isset($studyFormsForInputs)) {
                if (($faculties->count() != 0) && ($studyFormsForInputs->count() != 0)) {
//CHANGE
                    if (isset($notification)) {
                        return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs, 'notification' => $notification, 'news' => $news]);
                    } else {
//                        return view($names_arr['page'], compact('faculties'), compact('studyFormsForInputs'));
                        return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,'news' => $news]);
                    }
                } else {
                    $faculties = collect(new Faculty);
                    $studyFormsForInputs = collect(new StudyForm);
                    if($names_arr['page'] == 'pages.statasp' || $names_arr['page'] == 'pages.stataspforeigner'){
                        $notification = trans('statforeigner.notification_green_asp');
                    }else{
                        $notification = trans('statforeigner.notification_green');
                    }
//CHANGE
                    return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                        'notification_green' => $notification, 'news' => $news]);
                }
            } else {
                $faculties = collect(new Faculty);
                $studyFormsForInputs = collect(new StudyForm);
                if($names_arr['page'] == 'pages.statasp' || $names_arr['page'] == 'pages.stataspforeigner'){
                    $notification = trans('statforeigner.notification_green_asp');
                }else{
                    $notification = trans('statforeigner.notification_green');
                }
//CHANGE
                return view($names_arr['page'], ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                    'notification_green' => $notification, 'news' => $news]);
            }
        }


    }

    public function search($search_fio, $search_faculties, $search_specialities, $search_studyForms, &$notification, $names_arr)
    {
//----------------поиск по категориям-------------------
        $search_specialities_arr = array();
        if (!empty($search_specialities)) {
            foreach ($search_specialities as $i => $s_spec) {
                $search_specialities_arr[] = explode(";", $s_spec)[1];
            }
        }
        $search_faculties = array_map('intval', $search_faculties);
        $search_studyForms = array_map('intval', $search_studyForms);
        $search_specialities_arr = array_map('intval', $search_specialities_arr);


        //если запросили по факультетам или спец
        if (!empty($search_faculties)) {
//CHANGE
            $info_faculties = $names_arr['Statistic']::whereIn('id_faculty', $search_faculties)
                ->select('id_studyForm', 'id_category', 'id_admissionBasis', 'id_preparationLevel', 'id_speciality', 'id_competition')
                ->distinct()
                ->get();

            $id_forms_arr = array();
            $id_cat_arr = array();
            $id_adm_arr = array();
            $id_prep_arr = array();
            $id_spec_arr = array();
            $id_comp_arr = array();
            foreach ($info_faculties as $stat) {
                $id_forms_arr[] = $stat->id_studyForm;
                $id_cat_arr[] = $stat->id_category;
                $id_adm_arr[] = $stat->id_admissionBasis;
                $id_prep_arr[] = $stat->id_preparationLevel;
                $id_spec_arr[] = $stat->id_speciality;
                $id_comp_arr[] = $stat->id_competition;
            }
            $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
            $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
            $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
            $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);
            $id_comp_arr = array_unique($id_comp_arr, SORT_REGULAR);

            if (!empty($search_specialities_arr)) {
                $id_spec_arr = array_intersect($id_spec_arr, $search_specialities_arr);
            }
            $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);

//CHANGE
            $sdf = $names_arr['Statistic']::whereIn('id_competition', $id_comp_arr)
                ->whereIn('id_speciality', $id_spec_arr)
                ->whereIn('id_category', $id_cat_arr)
                ->whereIn('id_admissionBasis', $id_adm_arr)
                ->whereIn('id_preparationLevel', $id_prep_arr)
                ->select('id_competition')->get();

            $id_comp_arr = array();
            foreach ($sdf as $stat) {
                $id_comp_arr[] = $stat->id_competition;
            }
            $id_comp_arr = array_unique($id_comp_arr, SORT_REGULAR);

            if (!empty($search_studyForms)) {
                $studyForms = StudyForm::whereIn('id', $search_studyForms)
                    ->whereIn('id', $id_forms_arr)
                    ->get();

            } else {
                $studyForms = StudyForm::whereIn('id', $id_forms_arr)->get();
            }

            foreach ($studyForms as $k5 => $studyForm) {
                $categories = Category::whereIn('id', $id_cat_arr)->get();

                foreach ($categories as $k4 => $category) {

                    $preparationLevels = PreparationLevel::whereIn('id', $id_prep_arr)->get();
                    foreach ($preparationLevels as $k2 => $preparationLevel) {
                        //находим нужные нам факультеты их имена
                        $faculties = Faculty::whereIn('id', $search_faculties)->get();

                        foreach ($faculties as $k1 => $faculty) {
                            //для выбора названий специальностей
                            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

                            foreach ($specialities as $k0 => $speciality) {

                                $specializations = Specialization::where('id_speciality', '=', $speciality->id)->get();

                                if ($specializations->count() == 0) {
                                    $specializations = collect(new Specialization);
                                    //добавить в коллеекцию элемент

                                    $element = Specialization::where('id', '=', 1)->first();
                                    $element->id = 0;
                                    $element->specializationId = '0';
                                    $element->id_speciality = '0';
                                    $element->name = '';
                                    $element->en_name = '';

                                    $specializations->push($element);
//                                        return $specializations;
                                } else {

                                    $element = Specialization::where('id', '=', 1)->first();
                                    $element->id = 0;
                                    $element->specializationId = '0';
                                    $element->id_speciality = '0';
                                    $element->name = '';
                                    $element->en_name = '';

                                    $specializations->push($element);
//                                        return $specializations;
                                }

                                foreach ($specializations as $kend => $specialization) {
//CHANGE
                                    $competitions = $names_arr['Competition']::whereIn('id', $id_comp_arr)->get();
//
                                    foreach ($competitions as $k6 => $competition) {
                                        $admissionBases = AdmissionBasis::whereIn('id', $id_adm_arr)->get();
                                        //самая костыльная сортировка на свете
                                        $newadm = collect(new AdmissionBasis);
                                        foreach ($admissionBases as $k3 => $admissionBasis) {
                                            if ($admissionBasis->name == "Особое право") {
                                                $element0 = AdmissionBasis::where('name', '=', "Особое право")->first();
                                            }
                                            if ($admissionBasis->name == "Целевой прием") {
                                                $element1 = AdmissionBasis::where('name', '=', "Целевой прием")->first();
                                            }
                                            if ($admissionBasis->name == "Бюджетная основа") {
                                                $element2 = AdmissionBasis::where('name', '=', "Бюджетная основа")->first();
                                            }
                                            if ($admissionBasis->name == "Полное возмещение затрат") {
                                                $element3 = AdmissionBasis::where('name', '=', "Полное возмещение затрат")->first();
                                            }
                                        }

                                        if (isset($element0)) {
                                            $newadm->push($element0);
                                        }
                                        if (isset($element1)) {
                                            $newadm->push($element1);
                                        }
                                        if (isset($element2)) {
                                            $newadm->push($element2);
                                        }
                                        if (isset($element3)) {
                                            $newadm->push($element3);
                                        }

                                        $admissionBases = $newadm;

                                        foreach ($admissionBases as $k3 => $admissionBasis) {



                                            if ($specialization->id == 0) {
                                                $spez_id = null;
                                            } else {
                                                $spez_id = $specialization->id;
                                            }
//CHANGE
                                            $temp = $names_arr['Statistic']::where('id_studyForm', '=', $studyForm->id)
                                                ->where('id_speciality', '=', $speciality->id)
                                                ->where('id_specialization', '=', $spez_id)
                                                ->where('id_preparationLevel', '=', $preparationLevel->id)
                                                ->where('id_admissionBasis', '=', $admissionBasis->id)
                                                ->where('id_category', '=', $category->id)
                                                ->where('id_faculty', '=', $faculty->id)
                                                ->where('id_competition', '=', $competition->id)
                                                ->get();

//CHANGE
                                            $id_plan_c = $names_arr['PlanCompetition']::where('id_competition', '=', $competition->id)->first();

//CHANGE
                                            if (!empty($id_plan_c)) {
                                                $idPlan = $names_arr['Plan']::where('id_speciality', '=', $speciality->id)
                                                    ->where('id_studyForm', '=', $studyForm->id)
                                                    ->where('id_specialization', '=', $spez_id)
                                                    ->where('id_faculty', '=', $faculty->id)
                                                    ->where('id', $id_plan_c->id_plan)
                                                    ->first();
                                            }

//CHANGE

                                            if (empty($idPlan)) {
                                                if (!empty($id_plan_c)) {
                                                    $idPlan = $names_arr['Plan']::where('id_speciality', '=', $speciality->id)
                                                        ->where('id_studyForm', '=', $studyForm->id)
                                                        ->where('id_faculty', '=', $faculty->id)
                                                        ->where('id', $id_plan_c->id_plan)
                                                        ->first();
                                                }
                                            }

                                            if (isset($idPlan)) {
                                                if (!empty($idPlan)) {
                                                    $id_plan_comps = $names_arr['PlanCompetition']::where('id_competition', '=', intval($competition->id))->first();
                                                    if (!empty($id_plan_comps)) {
//CHANGE
                                                        $freeSeatsNumber = $names_arr['Freeseats']::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                                        where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                                    }
                                                }
                                            }
                                            if ($temp->count()) {
                                                $admissionBasis->abiturs = $temp; //добавляем запись
                                                $arr_subs = array();
                                                $arr_subs_en = array();
                                                $str = '';
                                                $str_en = '';
                                                $change = false;
                                                $subs = $names_arr['PlanCompScore']::where('id_plan_comp', '=', $id_plan_comps->id)->get();
                                                foreach ($subs as $key => $sub){
                                                    if($sub->changeable == 1 && !$change){
                                                        $change = true;
                                                        $str = $sub->subject->name . '/';
                                                        $str_en = $sub->subject->en_name . '/';
                                                    }
                                                    else if($sub->changeable == 1 && $change){
                                                        $str .= $sub->subject->name;
                                                        $str_en .= $sub->subject->en_name;
                                                        $arr_subs[] = $str;
                                                        $arr_subs_en[] = $str_en;
                                                    }
                                                    else if($sub->subject->subjectId != '000000015'){
                                                        $arr_subs[] = $sub->subject->name;
                                                        $arr_subs_en[] = $sub->subject->en_name;
                                                    }
                                                }
                                                $admissionBasis->subs = $arr_subs;
                                                $admissionBasis->subs_en = $arr_subs_en;



                                                $temp_stage = $temp->first();

                                                $stage = $temp_stage->stage;
                                                /*if ($stage[0] == '(') {
                                                    $stage = substr($stage, 1, -1);
                                                }*/
                                                $admissionBasis->stage = $stage;

                                                $stage_title = $temp_stage->stage_title;
                                                if ($stage_title[0] == '(') {
                                                    $stage_title = substr($stage_title, 1, -1);
                                                }
                                                $admissionBasis->stage_title = $stage_title;

                                                $dateUp = DateUpdate::where('id_plan',$idPlan->id)->where('id_competition', intval($competition->id))->where('id_admissionBasis', $admissionBasis->id)
                                                    ->where('id_studyForm', $studyForm->id)->first();
                                                if(isset($dateUp)) {
                                                    $admissionBasis->dateUp = $dateUp->date_update;
                                                }else{
                                                    $admissionBasis->dateUp = NULL;
                                                }

                                                $originalsCount = 0;
                                                foreach ($temp as $student) {
                                                    if ($student->original == true) {
                                                        $originalsCount += 1;
                                                    }
                                                }
                                                if (!empty($freeSeatsNumber)) {
                                                    $admissionBasis->freeSeatsNumber = $freeSeatsNumber->value;
                                                    if ($freeSeatsNumber->value != 0) {
                                                        $admissionBasis->originalsCount = round(floatval(count($temp)) / $freeSeatsNumber->value, 2);
                                                    }
                                                } else {
                                                    $admissionBasis->originalsCount = null;
                                                    $admissionBasis->freeSeatsNumber = null;
                                                }
                                            } else {
                                                $admissionBasis->abiturs = null;
                                            }
                                            if (empty($admissionBasis->abiturs)) {
                                                unset($admissionBases[$k3]);
                                            }
                                        }
                                        $admissionBases->count() ? $competition->admissionBases = $admissionBases : null;
                                        if (empty($competition->admissionBases)) {
                                            unset($competitions[$k6]);
                                        }
                                    }
                                    $competitions->count() ? $specialization->competitions = $competitions : null; //В любом случае не пустые
                                    if (empty($specialization->competitions)) {
                                        unset($specializations[$kend]);
                                    }
                                }

                                $specializations->count() ? $speciality->specializations = $specializations : null; //В любом случае не пустые
                                if (empty($speciality->specializations)) {
                                    unset($specialities[$k0]);
                                }
                            }
                            $specialities->count() ? $faculty->specialities = $specialities : null; //В любом случае не пустые
                            if (empty($faculty->specialities)) {
                                unset($faculties[$k1]);
                            }
                        }
                        $faculties->count() ? $preparationLevel->faculties = $faculties : null;
                        if (empty($preparationLevel->faculties)) {
                            unset($preparationLevels[$k2]);
                        }
                    }
                    $preparationLevels->count() ? $category->preparationLevels = $preparationLevels : null;
                    if (empty($category->preparationLevels)) {
                        unset($categories[$k4]);
                    }
                }

                $categories->count() ? $studyForm->stat = $categories : null;
                if (empty($studyForm->stat)) {
                    unset($studyForms[$k5]);
                }
            }
        }
// ----------------поиск по имени-------------------
        if (isset($search_fio)) {
            //выбираем всех студентов подходящих по фио

            //узнаем снилс ищут или фио
            $search_snils = preg_replace('/[^0-9]/', '', $search_fio);//удаляем все кроме цифр
            if($search_snils == ""){
                //ищут фио
                $id_students = $names_arr['Student']::where('fio', 'LIKE', '%' . $search_fio . '%')
                    ->select('id', 'fio', 'snils2') //показываем форматированный
                    ->get();
            }else{
                //ищут снилс
                $id_students = $names_arr['Student']::where('snils', 'LIKE', '%' . $search_snils . '%') //ищем по полю без тире
                ->select('id', 'fio', 'snils2') //показываем форматированный
                ->get();
            }

            if ($id_students->count() > 9) {
                $notification =  trans('statforeigner.notification_specify');
                return;
            }

            if ($id_students->count() == 0) {
                $notification = trans('statforeigner.notification_not_found');
                return;
            }


//делаем из этого массив id
            $id_stud_arr = array();
            foreach ($id_students as $student) {
                $id_stud_arr[] = $student->id;
            }
            $id_stud_arr = array_map('intval', $id_stud_arr);

//выбираем всю статистику где id студентов как нам нужно
            if($search_snils == ""){
                $statistic_for_people = $names_arr['Statistic']::whereIn('id_student', $id_stud_arr)->where('snils_show', false)->get();
            }else{
                $statistic_for_people = $names_arr['Statistic']::whereIn('id_student', $id_stud_arr)->where('snils_show', true)->get();
            }

//echo("<pre>" . $statistic_for_people . "</pre>");

//записей максимум 5-6 если человек ввел фамилию и имя
//создаем массивы по каждой категории
            $id_forms_arr = array();
            $id_cat_arr = array();
            $id_adm_arr = array();
            $id_prep_arr = array();
            $id_fac_arr = array();
            $id_spec_arr = array();
            $id_comp_arr = array();
            foreach ($statistic_for_people as $stat) {
                $id_forms_arr[] = $stat->id_studyForm;
                $id_cat_arr[] = $stat->id_category;
                $id_adm_arr[] = $stat->id_admissionBasis;
                $id_prep_arr[] = $stat->id_preparationLevel;
                $id_fac_arr[] = $stat->id_faculty;
                $id_spec_arr[] = $stat->id_speciality;
                $id_comp_arr[] = $stat->id_competition;
            }
            $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
            $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
            $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
            $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);
            $id_fac_arr = array_unique($id_fac_arr, SORT_REGULAR);
            $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);
            $id_comp_arr = array_unique($id_comp_arr, SORT_REGULAR);

// echo("<pre>" . $id_spec_arr . "</pre>");
            $sdf = $names_arr['Statistic']::whereIn('id_competition', $id_comp_arr)
                ->whereIn('id_speciality', $id_spec_arr)
                ->whereIn('id_category', $id_cat_arr)
                ->whereIn('id_admissionBasis', $id_adm_arr)
                ->whereIn('id_preparationLevel', $id_prep_arr)
                ->select('id_competition')->get();

            $id_comp_arr = array();
            foreach ($sdf as $stat) {
                $id_comp_arr[] = $stat->id_competition;
            }
            $id_comp_arr = array_unique($id_comp_arr, SORT_REGULAR);
//проходим по каждой категории и ищем нужные нам записи статистики чтобы привести их в правильную структуру для вывода
            $studyForms = StudyForm::whereIn('id', $id_forms_arr)->get();
            foreach ($studyForms as $k5 => $studyForm) {
                $categories = Category::whereIn('id', $id_cat_arr)->get();
                foreach ($categories as $k4 => $category) {

                    $preparationLevels = PreparationLevel::whereIn('id', $id_prep_arr)->get();
                    foreach ($preparationLevels as $k2 => $preparationLevel) {
                        $faculties = Faculty::whereIn('id', $id_fac_arr)->get();
                        foreach ($faculties as $k1 => $faculty) {
                            //выберем имена и коды специальностей
                            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();
                            foreach ($specialities as $k0 => $speciality) {

                                $specializations = Specialization::where('id_speciality', '=', $speciality->id)->get();

                                if ($specializations->count() == 0) {
                                    $specializations = collect(new Specialization);
                                    //добавить в коллеекцию элемент

                                    $element = Specialization::where('id', '=', 1)->first();
                                    $element->id = 0;
                                    $element->specializationId = '0';
                                    $element->id_speciality = '0';
                                    $element->name = '';
                                    $element->en_name = '';

                                    $specializations->push($element);
//                                        return $specializations;
                                } else {

                                    $element = Specialization::where('id', '=', 1)->first();
                                    $element->id = 0;
                                    $element->specializationId = '0';
                                    $element->id_speciality = '0';
                                    $element->name = '';
                                    $element->en_name = '';

                                    $specializations->push($element);
//                                        return $specializations;
                                }

                                foreach ($specializations as $kend => $specialization) {
                                    $competitions = $names_arr['Competition']::whereIn('id', $id_comp_arr)->get();
//
                                    foreach ($competitions as $k6 => $competition) {
                                        $admissionBases = AdmissionBasis::whereIn('id', $id_adm_arr)->get();
                                        //самая костыльная сортировка на свете
                                        $newadm = collect(new AdmissionBasis);
                                        foreach ($admissionBases as $k3 => $admissionBasis) {
                                            if ($admissionBasis->name == "Особое право") {
                                                $element0 = AdmissionBasis::where('name', '=', "Особое право")->first();
                                            }
                                            if ($admissionBasis->name == "Целевой прием") {
                                                $element1 = AdmissionBasis::where('name', '=', "Целевой прием")->first();
                                            }
                                            if ($admissionBasis->name == "Бюджетная основа") {
                                                $element2 = AdmissionBasis::where('name', '=', "Бюджетная основа")->first();
                                            }
                                            if ($admissionBasis->name == "Полное возмещение затрат") {
                                                $element3 = AdmissionBasis::where('name', '=', "Полное возмещение затрат")->first();
                                            }
                                        }

                                        if (isset($element0)) {
                                            $newadm->push($element0);
                                        }
                                        if (isset($element1)) {
                                            $newadm->push($element1);
                                        }
                                        if (isset($element2)) {
                                            $newadm->push($element2);
                                        }
                                        if (isset($element3)) {
                                            $newadm->push($element3);
                                        }

                                        $admissionBases = $newadm;
                                        foreach ($admissionBases as $k3 => $admissionBasis) {

                                            if ($specialization->id == 0) {
                                                $spez_id = null;
                                            } else {
                                                $spez_id = $specialization->id;
                                            }

                                            $temp = $names_arr['Statistic']::where('id_studyForm', '=', $studyForm->id)
                                                ->where('id_preparationLevel', '=', $preparationLevel->id)
                                                ->where('id_admissionBasis', '=', $admissionBasis->id)
                                                ->where('id_category', '=', $category->id)
                                                ->where('id_faculty', '=', $faculty->id)
                                                ->where('id_speciality', '=', $speciality->id)
                                                ->where('id_specialization', '=', $spez_id)
                                                ->where('id_competition', '=', $competition->id)
                                                ->get();
                                            $temp2 = $temp->intersect($statistic_for_people);
//                                    if(!$temp2->isEmpty()) {
//
//                                    }
                                            $id_plan_c = $names_arr['PlanCompetition']::where('id_competition', '=', $competition->id)->first();

                                            //нужно проверить содержит ли полученная коллекция нужных студентов
                                            //выбираем свободные места на этой специальности
                                            $idPlan = $names_arr['Plan']::where('id_speciality', '=', $speciality->id)
                                                ->where('id_studyForm', '=', $studyForm->id)
                                                ->where('id_specialization', '=', $spez_id)
                                                ->where('id_faculty', '=', $faculty->id)
                                                ->where('id', $id_plan_c->id_plan)
                                                ->first();

                                            if (empty($idPlan)) {
                                                $idPlan = $names_arr['Plan']::where('id_speciality', '=', $speciality->id)
                                                    ->where('id_studyForm', '=', $studyForm->id)
//                                                ->where('id_specialization', '=', $spez_id)
                                                    ->where('id_faculty', '=', $faculty->id)
                                                    ->where('id', $id_plan_c->id_plan)
                                                    ->first();
                                            }

                                            if (!empty($idPlan)) {
                                                $id_plan_comps = $names_arr['PlanCompetition']::where('id_competition', '=', intval($competition->id))->first();
                                                if (!empty($id_plan_comps)) {
                                                    $freeSeatsNumber = $names_arr['Freeseats']::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                                    where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                                }
                                            }
//                                    $freeSeatsNumber = TrainingArea::where('id_speciality', '=', $speciality->id)
//                                        ->where('id_studyForm', '=', $studyForm->id)
//                                        ->first();
                                            //обозначаем выбранного студента цветом
                                            if ($temp->count() && !$temp2->isEmpty()) {
                                                $admissionBasis->abiturs = $temp; //записываем статистику в специальность
                                                $arr_subs = array();
                                                $arr_subs_en = array();
                                                $str = '';
                                                $str_en = '';
                                                $change = false;
                                                $subs = $names_arr['PlanCompScore']::where('id_plan_comp', '=', $id_plan_comps->id)->get();
                                                foreach ($subs as $key => $sub){
                                                    if($sub->changeable == 1 && !$change){
                                                        $change = true;
                                                        $str = $sub->subject->name . '/';
                                                        $str_en = $sub->subject->en_name . '/';
                                                    }
                                                    else if($sub->changeable == 1 && $change){
                                                        $str .= $sub->subject->name;
                                                        $str_en .= $sub->subject->en_name;
                                                        $arr_subs[] = $str;
                                                        $arr_subs_en[] = $str_en;
                                                    }
                                                    else if($sub->subject->subjectId != '000000015'){
                                                        $arr_subs[] = $sub->subject->name;
                                                        $arr_subs_en[] = $sub->subject->en_name;
                                                    }
                                                }
                                                $admissionBasis->subs = $arr_subs;
                                                $admissionBasis->subs_en = $arr_subs_en;

                                                $temp_stage = $temp->first();
                                                $stage = $temp_stage->stage;
                                                $stage_title = $temp_stage->stage_title;
                                                if ($stage[0] == '(') {
                                                    $stage = substr($stage, 1, -1);
                                                }
                                                $admissionBasis->stage = $stage;
                                                if ($stage_title[0] == '(') {
                                                    $stage_title = substr($stage_title, 1, -1);
                                                }
                                                $admissionBasis->stage_title = $stage_title;

                                                $chosenStudents = collect(new Student);
                                                foreach ($id_stud_arr as $id) {
                                                    $serialNumSpec = 0;
                                                    foreach ($temp as $student) {
                                                        $serialNumSpec++;
                                                        if ($student->id_student === $id) {
                                                            $student->is_chosen = true;
                                                            $chosenStudents->push($student->student);
                                                            $chosenStudent_last = $chosenStudents->last();
                                                            $chosenStudent_last->serialNum = $serialNumSpec;
                                                        } else {
                                                            continue;
                                                        }
                                                    }
                                                }
                                                $chosenStudents = $chosenStudents->sortBy('serialNum');
                                                //запишем выбранных студентов в специальность
                                                $admissionBasis->chosenStudents = $chosenStudents;
                                                //считаем оригиналы
                                                $originalsCount = 0;
                                                foreach ($temp as $student) {
                                                    if ($student->original == true) {
                                                        $originalsCount += 1;
                                                    }
                                                }
                                                //считаем колво человек на место
                                                if (!empty($freeSeatsNumber)) {
                                                    $admissionBasis->freeSeatsNumber = $freeSeatsNumber->value;
                                                    if ($freeSeatsNumber->value != 0) {
                                                        $admissionBasis->originalsCount = round(floatval(count($temp)) / $freeSeatsNumber->value, 2);
                                                    }
                                                } else {
                                                    $admissionBasis->originalsCount = null;
                                                    $admissionBasis->freeSeatsNumber = null;
                                                }
                                            } else {
                                                $admissionBasis->abiturs = null; //если статистики для специальности нет то не записываем
                                            }
                                            if (empty($admissionBasis->abiturs)) { //если не записали, удаляем специальность из списка
                                                unset($admissionBases[$k3]);
                                            }
                                        }
                                        $admissionBases->count() ? $competition->admissionBases = $admissionBases : null;
                                        if (empty($competition->admissionBases)) {
                                            unset($competitions[$k6]);
                                        }
                                    }
                                    $competitions->count() ? $specialization->competitions = $competitions : null; //В любом случае не пустые
                                    if (empty($specialization->competitions)) {
                                        unset($specializations[$kend]);
                                    }
                                }
                                $specializations->count() ? $speciality->specializations = $specializations : null; //В любом случае не пустые
                                if (empty($speciality->specializations)) {
                                    unset($specialities[$k0]);
                                }
                            }
                            $specialities->count() ? $faculty->specialities = $specialities : null;
                            if (empty($faculty->specialities)) {
                                unset($faculties[$k1]);
                            }
                        }
                        $faculties->count() ? $preparationLevel->faculties = $faculties : null;
                        if (empty($preparationLevel->faculties)) {
                            unset($preparationLevels[$k2]);
                        }
                    }
                    $preparationLevels->count() ? $category->preparationLevels = $preparationLevels : null;
                    if (empty($category->preparationLevels)) {
                        unset($categories[$k4]);
                    }
                }
                $categories->count() ? $studyForm->stat = $categories : null;
                if (empty($studyForm->stat)) {
                    unset($studyForms[$k5]);
                }
            }
        }

//Выборка для инпутов
        $studyFormsForInputs = DB::table('study_forms')->join($names_arr['name_table'], 'study_forms.id', '=', $names_arr['name_table'] . '.id_studyForm')
            ->groupBy('study_forms.id')->select('study_forms.*')->get();;
        $faculties = $this->fetchFaculties($names_arr);


        return $studyForms;




    }

    public
    function createFileXls(Request $request)
    {

        $studyForms = $request->all();
        $studyForms = $studyForms[0];
        $studyForms = (array)json_decode($studyForms);
        $collection = StudyForm::hydrate($studyForms);
        $file_name = $this->createXlsDynamic($collection);
        //var_dump($file_name);
        return json_encode($file_name);

    }

    public
    function fetchFaculties($names_arr)
    {
        $faculties = Faculty::orderBy('name')->get();
        foreach ($faculties as $k => $faculty) {
            $id_specialities = $names_arr['Statistic']::where('id_faculty', '=', $faculty->id)
                ->select('id_speciality')
                ->get();

            $id_spec_arr = array();
            foreach ($id_specialities as $item) {
                $id_spec_arr[] = $item->id_speciality;
            }

            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

            foreach ($specialities as $speciality) {
                $id_studyForms = $names_arr['Plan']::where('id_speciality', '=', $speciality->id)
                    ->select('id_studyForm')
                    ->get();

//                $id_studyForms = TrainingArea::where('id_speciality', '=', $speciality->id)
//                    ->select('id_studyForm')
//                    ->get();
//
                $id_studyForms_arr = array();
                foreach ($id_studyForms as $item) {
                    $id_studyForms_arr[] = $item->id_studyForm;
                }
                $studyForms = StudyForm::whereIn('id', $id_studyForms_arr)->get();
//
                $studyForms->count() ? $speciality->studyForms = $studyForms : null;
            }
            $faculty->speciality = $specialities;
        }
        return $faculties;
        // return view('pages.stat');
    }
}
