<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\PreparationLevel;
use App\Speciality;
use App\Statistic;
use App\StatisticsExtra;
use App\StatisticsIntra;
use App\StatisticsPart;
use App\Student;
use App\StudyForm;
use App\TrainingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $faculties = $this->fetchFaculties();
        $studyFormsForInputs = StudyForm::all();
        return view('pages.stat', compact('faculties'), compact('studyFormsForInputs'));

    }

    public function search(Request $request)
    {

        $fio = $request->fio;
        //студенты все по имени
        $students = Student::where('fio', 'LIKE', '%' . $fio . '%')->get();
        $id_stud_arr = array();

        foreach ($students as $student) {
            $id_stud_arr[] = $student->id;
        }

        $studyForms = StudyForm::all();

        foreach ($studyForms as $k5 => $studyForm) {
            $categories = Category::all();
            foreach ($categories as $k4 => $category) {
                $admissionBases = AdmissionBasis::all();
                foreach ($admissionBases as $k3 => $admissionBasis) {
                    $preparationLevels = PreparationLevel::all();
                    foreach ($preparationLevels as $k2 => $preparationLevel) {
                        $faculties = Faculty::all();
                        foreach ($faculties as $k1 => $faculty) {
                            $specialities_id = DB::table('statistics')
                                ->where('id_faculty', '=', $faculty->id)
                                ->select('statistics.id_speciality')
                                ->distinct()
                                ->get();
                            $id_spec_arr = array();
                            foreach ($specialities_id as $item) {
                                $id_spec_arr[] = $item->id_speciality;
                            }
                            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

                            foreach ($specialities as $k0 => $speciality) {
                                $id_spec = Statistic::where('id_studyForm', '=', $studyForm->id)
                                    ->where('id_preparationLevel', '=', $preparationLevel->id)
                                    ->where('id_admissionBasis', '=', $admissionBasis->id)
                                    ->where('id_category', '=', $category->id)
                                    ->where('id_faculty', '=', $faculty->id)
                                    ->where('id_speciality', '=', $speciality->id)
                                    ->whereIn('id_student', $id_stud_arr)
                                    ->select('id_speciality')
                                    ->first();
                                $temp = collect(new Statistic);
                                if (isset($id_spec) && $id_spec->id_speciality == $speciality->id) {
                                    $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                        ->where('id_preparationLevel', '=', $preparationLevel->id)
                                        ->where('id_admissionBasis', '=', $admissionBasis->id)
                                        ->where('id_category', '=', $category->id)
                                        ->where('id_faculty', '=', $faculty->id)
                                        ->where('id_speciality', '=', $speciality->id)
                                        ->get();

                                }

                                $freeSeatsNumber = TrainingArea::where('id_speciality', '=', $speciality->id)
                                    ->where('id_studyForm', '=', $studyForm->id)
                                    ->first();

//                                $temp->search('id_student',$id_stud_arr);
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
                                        $speciality->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->freeSeatsNumber, 2);
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
        $studyFormsForInputs = StudyForm::all();
        $faculties = $this->fetchFaculties();
        //return $studyForms;
        return view('pages.stat', ['studyForms' => $studyForms, 'faculties' => $faculties, 'studyFormsForInputs' => $studyFormsForInputs]);
    }

    public function fetchFaculties()
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
        return view('pages.stat');
    }

}
