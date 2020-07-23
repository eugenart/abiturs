<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\DateUpdate;
use App\Faculty;
use App\Freeseats_basesForeigner;
use App\Freeseats_basesMasterForeigner;
use App\PlanCompetitionForeigner;
use App\PlanCompetitionMasterForeigner;
use App\PlanForeigner;
use App\PlanMasterForeigner;
use App\PreparationLevel;
use App\Speciality;
use App\Specialization;
use App\StatisticForeigner;
use App\StatisticMaster;
use App\StatisticMasterForeigner;
use App\Student;
use App\StudentMasterForeigner;
use App\StudyForm;
use App\Traits\XlsMakerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticMasterForeignerController extends Controller
{
    use XlsMakerTrait;
    function sortByPredefinedOrder($leftItem, $rightItem){
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
            "Заочная форма, полное возмещение затрат"
        );

        $flipped = array_flip($order);

        $leftItem = stristr($leftItem, '.', true);
        $rightItem = stristr($rightItem, '.', true);

        $leftPos = $flipped[$leftItem];
        $rightPos = $flipped[$rightItem];

        return $leftPos >= $rightPos;
    }

    public function index(Request $request)
    {
        $locale = $request->session()->get('locale');
        //return $request;
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
            $studyForms = $this->search($search_fio, $search_faculties, $search_specialities, $search_studyForms, $notification, $locale);
        }

        //получим все названия файлов xls
        $files_xls = array();
        $notification_files = "";
        if ($dir = scandir(storage_path('app/public/files-xls-stat/masterf'))) {
            $files_xls = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $files_xls[] = $file;
            }
//            arsort($files_xls);
            usort($files_xls, array($this, 'sortByPredefinedOrder'));
        } else {
            if($locale == 'ru' || is_null($locale)) {
                $notification_files = "Не удалось открыть директорию с файлами";
            }
            if($locale == 'en'){
                $notification_files = "Couldn't open the directory with the files";
            }
        }


        $date_update = DateUpdate::where('name_file', '=', 'stat_master')->first();
        $faculties = $this->fetchFaculties();
        $studyFormsForInputs = DB::table('study_forms')->join('statistic_master_foreigners', 'study_forms.id', '=', 'statistic_master_foreigners.id_studyForm')
            ->groupBy('study_forms.id')->select('study_forms.*')->get();;

//        return $studyForms;
        if (isset($studyForms)) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if ($studyForms->count() != 0) {
                return view('pages.statmasterforeigner', ['studyForms' => $studyForms, 'faculties' => $faculties,
                    'studyFormsForInputs' => $studyFormsForInputs, 'actual_link' => $actual_link, 'date_update' => $date_update,
                    'files_xls' => $files_xls, 'notification_files' => $notification_files]);
            } else {
                if (isset($faculties) && isset($studyFormsForInputs)) {
                    if (($faculties->count() != 0) && ($studyFormsForInputs->count() != 0)) {
                        if($locale == 'ru' || is_null($locale)) {
                            $notification = "По Вашему запросу ничего не найдено";
                        }
                        if($locale == 'en'){
                            $notification = "Nothing was found at your request";
                        }
                        return view('pages.statmasterforeigner', ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs, 'notification' => $notification]);
                    } else {
                        $faculties = collect(new Faculty);
                        $studyFormsForInputs = collect(new StudyForm);
                        if($locale == 'ru' || is_null($locale)) {
                            $notification = "Прием документов ведется в электронной форме";
                        }
                        if($locale == 'en'){
                            $notification = "Reception of documents is in electronic form";
                        }
                        return view('pages.statmasterforeigner', ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                            'notification_green' => $notification]);
                    }
                } else {
                    $faculties = collect(new Faculty);
                    $studyFormsForInputs = collect(new StudyForm);
                    if($locale == 'ru' || is_null($locale)) {
                        $notification = "Прием документов ведется в электронной форме";
                    }
                    if($locale == 'en'){
                        $notification = "Reception of documents is in electronic form";
                    }
                    return view('pages.statmasterforeigner', ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                        'notification_green' => $notification]);
                }

            }
        } else {
            if (isset($faculties) && isset($studyFormsForInputs)) {
                if (($faculties->count() != 0) && ($studyFormsForInputs->count() != 0)) {
                    if (isset($notification)) {
                        return view('pages.statmasterforeigner', ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs, 'notification' => $notification]);
                    } else {
                        return view('pages.statmasterforeigner', compact('faculties'), compact('studyFormsForInputs'));
                    }
                } else {
                    $faculties = collect(new Faculty);
                    $studyFormsForInputs = collect(new StudyForm);
                    if($locale == 'ru' || is_null($locale)) {
                        $notification = "Прием документов ведется в электронной форме";
                    }
                    if($locale == 'en'){
                        $notification = "Reception of documents is in electronic form";
                    }
                    return view('pages.statmasterforeigner', ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                        'notification_green' => $notification]);
                }
            } else {
                $faculties = collect(new Faculty);
                $studyFormsForInputs = collect(new StudyForm);
                if($locale == 'ru' || is_null($locale)) {
                    $notification = "Прием документов ведется в электронной форме";
                }
                if($locale == 'en'){
                    $notification = "Reception of documents is in electronic form";
                }
                return view('pages.statmasterforeigner', ['faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs,
                    'notification_green' => $notification]);
            }
        }


    }


    public function search($search_fio, $search_faculties, $search_specialities, $search_studyForms, &$notification, $locale)
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
            $info_faculties = StatisticMasterForeigner::whereIn('id_faculty', $search_faculties)
                ->select('id_studyForm', 'id_category', 'id_admissionBasis', 'id_preparationLevel', 'id_speciality')
                ->distinct()
                ->get();

            $id_forms_arr = array();
            $id_cat_arr = array();
            $id_adm_arr = array();
            $id_prep_arr = array();
            $id_spec_arr = array();
            foreach ($info_faculties as $stat) {
                $id_forms_arr[] = $stat->id_studyForm;
                $id_cat_arr[] = $stat->id_category;
                $id_adm_arr[] = $stat->id_admissionBasis;
                $id_prep_arr[] = $stat->id_preparationLevel;
                $id_spec_arr[] = $stat->id_speciality;
            }
            $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
            $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
            $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
            $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);

            if (!empty($search_specialities_arr)) {
                $id_spec_arr = array_intersect($id_spec_arr, $search_specialities_arr);
            }
            $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);
            //var_dump($id_spec_arr);

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
                                        $temp = StatisticMasterForeigner::where('id_studyForm', '=', $studyForm->id)
                                            ->where('id_speciality', '=', $speciality->id)
                                            ->where('id_specialization', '=', $spez_id)
                                            ->where('id_preparationLevel', '=', $preparationLevel->id)
                                            ->where('id_admissionBasis', '=', $admissionBasis->id)
                                            ->where('id_category', '=', $category->id)
                                            ->where('id_faculty', '=', $faculty->id)
                                            ->get();
                                        $idPlan = PlanMasterForeigner::where('id_speciality', '=', $speciality->id)
                                            ->where('id_studyForm', '=', $studyForm->id)
                                            ->where('id_specialization', '=', $spez_id)
                                            ->where('id_faculty', '=', $faculty->id)
                                            ->first();

                                        if (!empty($idPlan)) {
//                                        $freeSeatsNumber = PlanCompetition::where('id_plan', '=', intval($idPlan->id))->first();
                                            $id_plan_comps = PlanCompetitionMasterForeigner::where('id_plan', '=', intval($idPlan->id))->first();
                                            if (!empty($id_plan_comps)) {
                                                $freeSeatsNumber = Freeseats_basesMasterForeigner::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                                where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                            }
                                        }
                                        if ($temp->count()) {
                                            $admissionBasis->abiturs = $temp; //добавляем запись

                                            $originalsCount = 0;
                                            foreach ($temp as $student) {
                                                if ($student->original == true) {
                                                    $originalsCount += 1;
                                                }
                                            }
                                            if (!empty($freeSeatsNumber)) {
                                                $admissionBasis->freeSeatsNumber = $freeSeatsNumber->value;
                                                if ($freeSeatsNumber->value != 0) {
                                                    $admissionBasis->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->value, 2);
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
                                    $admissionBases->count() ? $specialization->admissionBases = $admissionBases : null;
                                    if (empty($specialization->admissionBases)) {
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
            $id_students = StudentMasterForeigner::where('fio', 'LIKE', '%' . $search_fio . '%')
                ->select('id', 'fio')
                ->get();

            if ($id_students->count() == 0) {
                $id_students = StudentMasterForeigner::where('fio_en', 'LIKE', '%' . $search_fio . '%')
                    ->select('id', 'fio')
                    ->get();
            }
            if ($id_students->count() > 9) {
                if($locale == 'ru'  || is_null($locale)) {
                    $notification = 'По вашему запросу найдено слишком много совпадений. Пожалуйста, уточните запрос.';
                }
                if($locale == 'en') {
                    $notification = 'There were too many hits on your request. Please elaborate on your request.';
                }
                return;
            }
            if ($id_students->count() == 0) {
                if($locale == 'ru' || is_null($locale)) {
                    $notification = 'По вашему запросу ничего не найдено.';
                }
                if($locale == 'en') {
                    $notification = 'Nothing was found at your request.';
                };
                return;
            }


            //делаем из этого массив id
            $id_stud_arr = array();
            foreach ($id_students as $student) {
                $id_stud_arr[] = $student->id;
            }
            $id_stud_arr = array_map('intval', $id_stud_arr);

            //выбираем всю статистику где id студентов как нам нужно
            $statistic_for_people = StatisticMasterForeigner::whereIn('id_student', $id_stud_arr)->get();
            //echo("<pre>" . $statistic_for_people . "</pre>");

            //записей максимум 5-6 если человек ввел фамилию и имя
            //создаем массивы по каждой категории
            $id_forms_arr = array();
            $id_cat_arr = array();
            $id_adm_arr = array();
            $id_prep_arr = array();
            $id_fac_arr = array();
            $id_spec_arr = array();
            foreach ($statistic_for_people as $stat) {
                $id_forms_arr[] = $stat->id_studyForm;
                $id_cat_arr[] = $stat->id_category;
                $id_adm_arr[] = $stat->id_admissionBasis;
                $id_prep_arr[] = $stat->id_preparationLevel;
                $id_fac_arr[] = $stat->id_faculty;
                $id_spec_arr[] = $stat->id_speciality;
            }
            $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
            $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
            $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
            $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);
            $id_fac_arr = array_unique($id_fac_arr, SORT_REGULAR);
            $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);

            // echo("<pre>" . $id_spec_arr . "</pre>");

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

                                        $temp = StatisticMasterForeigner::where('id_studyForm', '=', $studyForm->id)
                                            ->where('id_preparationLevel', '=', $preparationLevel->id)
                                            ->where('id_admissionBasis', '=', $admissionBasis->id)
                                            ->where('id_category', '=', $category->id)
                                            ->where('id_faculty', '=', $faculty->id)
                                            ->where('id_speciality', '=', $speciality->id)
                                            ->where('id_specialization', '=', $spez_id)
                                            ->get();
                                        $temp2 = $temp->intersect($statistic_for_people);
//                                    if(!$temp2->isEmpty()) {
//
//                                    }
                                        //нужно проверить содержит ли полученная коллекция нужных студентов
                                        //выбираем свободные места на этой специальности
                                        $idPlan = PlanMasterForeigner::where('id_speciality', '=', $speciality->id)
                                            ->where('id_studyForm', '=', $studyForm->id)
                                            ->where('id_specialization', '=', $spez_id)
                                            ->where('id_faculty', '=', $faculty->id)
                                            ->first();
                                        if (!empty($idPlan)) {
                                            $id_plan_comps = PlanCompetitionMasterForeigner::where('id_plan', '=', intval($idPlan->id))->first();
                                            if (!empty($id_plan_comps)) {
                                                $freeSeatsNumber = Freeseats_basesMasterForeigner::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                                where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                            }
                                        }
//                                    $freeSeatsNumber = TrainingArea::where('id_speciality', '=', $speciality->id)
//                                        ->where('id_studyForm', '=', $studyForm->id)
//                                        ->first();
                                        //обозначаем выбранного студента цветом
                                        if ($temp->count() && !$temp2->isEmpty()) {
                                            $admissionBasis->abiturs = $temp; //записываем статистику в специальность
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
                                                    $admissionBasis->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->value, 2);
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
                                    $admissionBases->count() ? $specialization->admissionBases = $admissionBases : null;
                                    if (empty($specialization->admissionBases)) {
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
        $studyFormsForInputs = DB::table('study_forms')->join('statistic_master_foreigners', 'study_forms.id', '=', 'statistic_master_foreigners.id_studyForm')
            ->groupBy('study_forms.id')->select('study_forms.*')->get();;
        $faculties = $this->fetchFaculties();


        $file_name = $this->createXls($studyForms);

        $studyForms->file_xls = $file_name;
        return $studyForms;


    }

    public function fetchFaculties()
    {
        $faculties = Faculty::orderBy('name')->get();
        foreach ($faculties as $k => $faculty) {
            $id_specialities = StatisticMasterForeigner::where('id_faculty', '=', $faculty->id)
                ->select('id_speciality')
                ->get();

            $id_spec_arr = array();
            foreach ($id_specialities as $item) {
                $id_spec_arr[] = $item->id_speciality;
            }

            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

            foreach ($specialities as $speciality) {
                $id_studyForms = PlanMasterForeigner::where('id_speciality', '=', $speciality->id)
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
