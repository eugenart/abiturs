<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\PreparationLevel;
use App\Speciality;
use App\Statistic;
use App\StatisticsExtra;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::all();
        $admissionBases = AdmissionBasis::all();
        $preparationLevels = PreparationLevel::all();
        $faculties = Faculty::all();
//        $specialities = Speciality::all();

        foreach ($categories as $category) {
            $tempstats = array();
            foreach ($admissionBases as $admissionBasis) {
                $temppreps = array();
                foreach ($preparationLevels as $preparationLevel) {
                    $tempfacs = array();
                    foreach ($faculties as $faculty) {
                        $tempspec = array();
                        $specialities = DB::table('statistics_extras')
                            ->where('id_faculty', '=', $faculty->id)
                            ->select('statistics_extras.id_speciality')
                            ->distinct()
                            ->get();
                        foreach ($specialities as $speciality){
                            $temp = StatisticsExtra::where('id_preparationLevel', '=', $preparationLevel->id)
                                ->where('id_admissionBasis', '=', $admissionBasis->id)
                                ->where('id_category', '=', $category->id)
                                ->where('id_faculty', '=', $faculty->id)
                                ->where('id_speciality', '=', $speciality->id_speciality)
                                ->get();
                            $temp->count() ? $tempspec[] = $temp : null;
                        }
                        count($tempspec) ? $tempfacs[] = $tempspec : null;
                    }
                    count($tempfacs) ? $temppreps[] = $tempfacs : null;
                }
                count($temppreps) ?  $tempstats[] = $temppreps : null;
            }
            $category->statWithBasis = $tempstats;
        }
        $category->stat = [];
        return $categories;


        //$statistics = Statistic::all();
//        $faculties = Faculty::all();
//        foreach ($faculties as $fac) {
//            $statFac = Statistic::where('id_faculty', '=', $fac->id)->get();
//            //$fac->statFac = Statistic::where('id_faculty', '=', $fac->id)->get();
//            $specialities = [];
//            foreach ($statFac as $item) {
//                $specialities[] = $item->id_speciality;
//            }
//            $fac->specialities = array_values(array_unique($specialities));
//            $statSpec = [];
//            $preparationLevel = [];
//            foreach ($fac->specialities as $spec) {
//                $statSpec[] = Statistic::where('id_speciality', '=', $spec)->get();
//            }
//            foreach ($statSpec as $stsp) {
//                $preparationLevel[] = $stsp->preparationLevel;
//            }
//            $fac->statSpec = $statSpec;
//
//        }
//
//        return json_encode($faculties, JSON_UNESCAPED_UNICODE);

//        return view('pages.stat', compact('statistics', 'faculties', 'specialities'));
//        return view('pages.stat', [ 'statistics' => $statistics
        //  'faculties' => Faculty::facultyJoinStat()//,
        // 'specialities' => Speciality::specJoinStat()
        // ]);
    }

    public function search(Request $request)
    {
        //dd($request->all());
        $fio = $request->fio;
        $students = Student::where('fio', 'LIKE', '%' . $fio . '%')->get(); //студенты все по имени
        $id_stud_arr = array();


        foreach ($students as $student) {
            $id_stud_arr[] = $student->id;
        }

        //выбрать статистику по этим студентам
        $stat = Statistic::whereIn('id_student', $id_stud_arr)->get();
        //return $stat;
        return view('pages.stat', ['statistics' => $stat]);
    }

}
