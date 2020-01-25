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
        $categories = Category::all();
        $studyForms = StudyForm::all();
        $admissionBases = AdmissionBasis::all();
        $preparationLevels = PreparationLevel::all();
        $faculties = Faculty::all();
        $allInfo = array();

        foreach ($studyForms as $studyForm) {
            $tempForms = array();
            foreach ($categories as $category) {
                $tempstats = array();
                foreach ($admissionBases as $admissionBasis) {
                    $temppreps = array();
                    foreach ($preparationLevels as $preparationLevel) {
                        $tempfacs = array();
                        foreach ($faculties as $faculty) {
                            $tempspec = array();
                            $specialities = DB::table('statistics')
                                ->where('id_faculty', '=', $faculty->id)
                                ->select('statistics.id_speciality')
                                ->distinct()
                                ->get();
                            foreach ($specialities as $speciality) {
                                $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                    ->where('id_preparationLevel', '=', $preparationLevel->id)
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
                    count($temppreps) ? $tempstats[] = $temppreps : null;
                }
                $tempForms[] = $tempstats;
            }
            $studyForm->stat = $tempForms;
        }

        return json_encode($studyForms, JSON_UNESCAPED_UNICODE);
        //return view('pages.stat', compact('studyForms'));
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
