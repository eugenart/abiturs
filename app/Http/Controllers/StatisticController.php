<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Speciality;
use App\Statistic;
use App\Student;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        //$statistics = Statistic::all();
        $faculties = Faculty::all();
        foreach ($faculties as $fac) {
            $statFac = Statistic::where('id_faculty', '=', $fac->id)->get();
            //$fac->statFac = Statistic::where('id_faculty', '=', $fac->id)->get();
            $specialities = [];
            foreach ($statFac as $item) {
                $specialities[] = $item->id_speciality;
            }
            $fac->specialities = array_values(array_unique($specialities));
            $statSpec = [];
            $preparationLevel = [];
            foreach ($fac->specialities as $spec) {
                $statSpec[] = Statistic::where('id_speciality', '=', $spec)->get();
            }
            foreach ($statSpec as $stsp) {
                $preparationLevel[] = $stsp->preparationLevel;
            }
            $fac->statSpec = $statSpec;

        }

        return json_encode($faculties, JSON_UNESCAPED_UNICODE);

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
