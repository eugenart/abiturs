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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {

        $studyForms = StudyForm::all();

        foreach ($studyForms as $studyForm) {
            $categories = Category::all();
            foreach ($categories as $category) {
                $admissionBases = AdmissionBasis::all();
                foreach ($admissionBases as $admissionBasis) {
                    $preparationLevels = PreparationLevel::all();
                    foreach ($preparationLevels as $preparationLevel) {
                        $faculties = Faculty::all();
                        foreach ($faculties as $faculty) {
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

                            foreach ($specialities as $speciality) {
                                $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                    ->where('id_preparationLevel', '=', $preparationLevel->id)
                                    ->where('id_admissionBasis', '=', $admissionBasis->id)
                                    ->where('id_category', '=', $category->id)
                                    ->where('id_faculty', '=', $faculty->id)
                                    ->where('id_speciality', '=', $speciality->id)
                                    ->get();
                                // $temp->count() ? $tempspec[] = $temp : null;
                                $speciality->abiturs = $temp;
                            }
                            //count($tempspec) ? $tempfacs[] = $tempspec : null;
                            $faculty->specialities = $specialities;
                        }
                        //count($tempfacs) ? $temppreps[] = $tempfacs : null;
                        $preparationLevel->faculties = $faculties;
                    }
                    //count($temppreps) ? $tempstats[] = $temppreps : null;
                    $admissionBasis->preparationLevels = $preparationLevels;
                }
                // $tempForms[] = $tempstats;
                $category->admissionBases = $admissionBases;
            }
            // $studyForm->stat = $tempForms;
            $studyForm->stat = $categories;
        }

        // return $studyForms;

        // return json_encode($studyForms, JSON_UNESCAPED_UNICODE);
        return view('pages.stat', compact('studyForms'));
//        return view('pages.stat', [ 'statistics' => $statistics
        //  'faculties' => Faculty::facultyJoinStat()//,
        // 'specialities' => Speciality::specJoinStat()
        // ]);
    }

    public function search(Request $request)
    {
        //dd($request->all());
//        $fio = $request->fio;
//        $students = Student::where('fio', 'LIKE', '%' . $fio . '%')->get(); //студенты все по имени
//        $id_stud_arr = array();
//
//
//        foreach ($students as $student) {
//            $id_stud_arr[] = $student->id;
//        }
//
//        //выбрать статистику по этим студентам
//        $stat = Statistic::whereIn('id_student', $id_stud_arr)->get();
//        //return $stat;
//        return view('pages.stat', ['statistics' => $stat]);

        $fio = $request->fio;
        $students = Student::where('fio', 'LIKE', '%' . $fio . '%')->get(); //студенты все по имени
        $id_stud_arr = array();


        foreach ($students as $student) {
            $id_stud_arr[] = $student->id;
        }


        $studyForms = StudyForm::all();

        foreach ($studyForms as $studyForm) {
            $categories = Category::all();
            foreach ($categories as $category) {
                $admissionBases = AdmissionBasis::all();
                foreach ($admissionBases as $admissionBasis) {
                    $preparationLevels = PreparationLevel::all();
                    foreach ($preparationLevels as $preparationLevel) {
                        $faculties = Faculty::all();
                        foreach ($faculties as $faculty) {
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

                            foreach ($specialities as $speciality) {
                                $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                    ->where('id_preparationLevel', '=', $preparationLevel->id)
                                    ->where('id_admissionBasis', '=', $admissionBasis->id)
                                    ->where('id_category', '=', $category->id)
                                    ->where('id_faculty', '=', $faculty->id)
                                    ->where('id_speciality', '=', $speciality->id)
                                    ->whereIn('id_student', $id_stud_arr)
                                    ->get();
                                // $temp->count() ? $tempspec[] = $temp : null;
                                $speciality->abiturs = $temp;
                            }
                            //count($tempspec) ? $tempfacs[] = $tempspec : null;
                            $faculty->specialities = $specialities;
                        }
                        //count($tempfacs) ? $temppreps[] = $tempfacs : null;
                        $preparationLevel->faculties = $faculties;
                    }
                    //count($temppreps) ? $tempstats[] = $temppreps : null;
                    $admissionBasis->preparationLevels = $preparationLevels;
                }
                // $tempForms[] = $tempstats;
                $category->admissionBases = $admissionBases;
            }
            // $studyForm->stat = $tempForms;
            $studyForm->stat = $categories;
        }
        return view('pages.stat',compact('studyForms'));
    }

}
