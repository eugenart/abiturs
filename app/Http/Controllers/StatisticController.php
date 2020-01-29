<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\PreparationLevel;
use App\Speciality;
use App\Statistic;
use App\Student;
use App\StudyForm;
use App\TrainingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {

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
            $studyForms = $this->search($search_fio, $search_faculties, $search_specialities, $search_studyForms);
        }


        $faculties = $this->fetchFaculties();
        $studyFormsForInputs = StudyForm::all();
        if (isset($studyForms)) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            return view('pages.stat', ['studyForms' => $studyForms, 'faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs, 'actual_link' => $actual_link]);

        } else {
            return view('pages.stat', compact('faculties'), compact('studyFormsForInputs'));
            //return $studyForms;
        }


    }


    public function search($search_fio, $search_faculties, $search_specialities, $search_studyForms)
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
            if (!empty($search_studyForms)) {
                $studyForms = StudyForm::whereIn('id', $search_studyForms)->get();
            } else {
                $studyForms = StudyForm::all();
            }

            foreach ($studyForms as $k5 => $studyForm) {
                $categories = Category::all();
                foreach ($categories as $k4 => $category) {
                    $admissionBases = AdmissionBasis::all();
                    foreach ($admissionBases as $k3 => $admissionBasis) {
                        $preparationLevels = PreparationLevel::all();
                        foreach ($preparationLevels as $k2 => $preparationLevel) {
                            //находим нужные нам факультеты
                            $faculties = Faculty::whereIn('id', $search_faculties)->get();


                            foreach ($faculties as $k1 => $faculty) {
                                if (!empty($search_specialities_arr)) {
                                    $specialities_id = DB::table('statistics')
                                        ->where('id_faculty', '=', $faculty->id)
                                        ->whereIn('id_speciality', $search_specialities_arr)
                                        ->select('statistics.id_speciality')
                                        ->distinct()
                                        ->get();
                                    //return var_dump($specialities_id);
                                } else {
                                    $specialities_id = DB::table('statistics')
                                        ->where('id_faculty', '=', $faculty->id)
                                        ->select('statistics.id_speciality')
                                        ->distinct()
                                        ->get();
                                }
                                // return var_dump($specialities_id);
                                $id_spec_arr = array();
                                foreach ($specialities_id as $item) {
                                    $id_spec_arr[] = $item->id_speciality;
                                }

                                //для выбора названий специальностей
                                $specialities = Speciality::whereIn('id', $id_spec_arr)->get();
                                foreach ($specialities as $k0 => $speciality) {

                                    $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                        ->where('id_preparationLevel', '=', $preparationLevel->id)
                                        ->where('id_admissionBasis', '=', $admissionBasis->id)
                                        ->where('id_category', '=', $category->id)
                                        ->where('id_faculty', '=', $faculty->id)
                                        ->where('id_speciality', '=', $speciality->id)
                                        ->get();

                                    $freeSeatsNumber = TrainingArea::where('id_speciality', '=', $speciality->id)
                                        ->where('id_studyForm', '=', $studyForm->id)
                                        ->first();

                                    if ($temp->count()) {
                                        $speciality->abiturs = $temp; //добавляем запись

                                        $originalsCount = 0;
                                        foreach ($temp as $student) {
                                            if ($student->original == true) {
                                                $originalsCount += 1;
                                            }
                                        }
                                        if (!empty($freeSeatsNumber)) {
                                            $speciality->freeSeatsNumber = $freeSeatsNumber->freeSeatsNumber;
                                            if ($freeSeatsNumber->freeSeatsNumber != 0) {
                                                $speciality->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->freeSeatsNumber, 2);
                                            }
                                        } else {
                                            $speciality->originalsCount = null;
                                            $speciality->freeSeatsNumber = null;
                                        }
                                    } else {
                                        $speciality->abiturs = null;
                                    }
                                    if (empty($speciality->abiturs)) {
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
                        $preparationLevels->count() ? $admissionBasis->preparationLevels = $preparationLevels : null;
                        if (empty($admissionBasis->preparationLevels)) {
                            unset($admissionBases[$k3]);
                        }
                    }
                    $admissionBases->count() ? $category->admissionBases = $admissionBases : null;
                    if (empty($category->admissionBases)) {
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

            $id_students = Student::where('fio', 'LIKE', '%' . $search_fio . '%')->get();

            $id_stud_arr = array();
            foreach ($id_students as $student) {
                $id_stud_arr[] = $student->id;
            }
            //если таких человеков нет нужно как это сказать
            if (empty($id_students)) {
                return $studyForms;
            }
            $statistic_for_people = Statistic::whereIn('id_student', $id_stud_arr)->get();
            //записей максимум 5-6 если человек ввел фамилию и имя
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

            $studyForms = StudyForm::whereIn('id', $id_forms_arr)->get();
            foreach ($studyForms as $k5 => $studyForm) {
                $categories = Category::whereIn('id', $id_cat_arr)->get();
                foreach ($categories as $k4 => $category) {
                    $admissionBases = AdmissionBasis::whereIn('id', $id_adm_arr)->get();
                    foreach ($admissionBases as $k3 => $admissionBasis) {
                        $preparationLevels = PreparationLevel::whereIn('id', $id_prep_arr)->get();
                        foreach ($preparationLevels as $k2 => $preparationLevel) {
                            $faculties = Faculty::whereIn('id', $id_fac_arr)->get();
                            foreach ($faculties as $k1 => $faculty) {
                                //выбор специальности для этого факультета и и подходящего под людей(уменешели колво)
                                $specialities_id = DB::table('statistics')
                                    ->where('id_faculty', '=', $faculty->id)
                                    ->select('statistics.id_speciality')
                                    ->distinct()
                                    ->get();

                                $id_spec_arr = array();
                                foreach ($specialities_id as $item) {
                                    $id_spec_arr[] = $item->id_speciality;
                                }
                                //выберем имена и коды специальностей
                                $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

                                foreach ($specialities as $k0 => $speciality) {

                                    $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                        ->where('id_preparationLevel', '=', $preparationLevel->id)
                                        ->where('id_admissionBasis', '=', $admissionBasis->id)
                                        ->where('id_category', '=', $category->id)
                                        ->where('id_faculty', '=', $faculty->id)
                                        ->where('id_speciality', '=', $speciality->id)
                                        ->get();


                                    $freeSeatsNumber = TrainingArea::where('id_speciality', '=', $speciality->id)
                                        ->where('id_studyForm', '=', $studyForm->id)
                                        ->first();

                                    if ($temp->count()) {
                                        $speciality->abiturs = $temp;
                                        foreach ($id_stud_arr as $id) {
                                            foreach ($temp as $student) {
                                                if ($student->id_student === $id) {
                                                    $student->is_chosen = true;
                                                } else {
                                                    continue;
                                                }
                                            }
                                        }
                                        $originalsCount = 0;
                                        foreach ($temp as $student) {
                                            if ($student->original == true) {
                                                $originalsCount += 1;
                                            }
                                        }
                                        if (!empty($freeSeatsNumber)) {
                                            $speciality->freeSeatsNumber = $freeSeatsNumber->freeSeatsNumber;
                                            if ($freeSeatsNumber->freeSeatsNumber != 0) {
                                                $speciality->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->freeSeatsNumber, 2);
                                            }
                                        } else {
                                            $speciality->originalsCount = null;
                                            $speciality->freeSeatsNumber = null;
                                        }
                                    } else {
                                        $speciality->abiturs = null;
                                    }
                                    if (empty($speciality->abiturs)) {
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
                        $preparationLevels->count() ? $admissionBasis->preparationLevels = $preparationLevels : null;
                        if (empty($admissionBasis->preparationLevels)) {
                            unset($admissionBases[$k3]);
                        }
                    }
                    $admissionBases->count() ? $category->admissionBases = $admissionBases : null;
                    if (empty($category->admissionBases)) {
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
        $studyFormsForInputs = StudyForm::all();
        $faculties = $this->fetchFaculties();
        return $studyForms;

// return view('pages.stat', ['studyForms' => $studyForms, 'faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs]);
    }

    public
    function fetchFaculties()
    {
        $faculties = Faculty::all();
        foreach ($faculties as $faculty) {
            $id_specialities = Statistic::where('id_faculty', '=', $faculty->id)
                ->select('id_speciality')
                ->get();

            $id_spec_arr = array();
            foreach ($id_specialities as $item) {
                $id_spec_arr[] = $item->id_speciality;
            }
            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

            foreach ($specialities as $speciality) {
                $id_studyForms = TrainingArea::where('id_speciality', '=', $speciality->id)
                    ->select('id_studyForm')
                    ->get();

                $id_studyForms_arr = array();
                foreach ($id_studyForms as $item) {
                    $id_studyForms_arr[] = $item->id_studyForm;
                }
                $studyForms = StudyForm::whereIn('id', $id_studyForms_arr)->get();

                $studyForms->count() ? $speciality->studyForms = $studyForms : null;
            }
            $faculty->speciality = $specialities;
        }
        return $faculties;
        // return view('pages.stat');
    }

}
