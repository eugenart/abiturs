<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\PastContests;
use App\Plan;
use App\PlanCompetition;
use App\PlanCompetitionForeigner;
use App\PlanForeigner;
use App\StudyForm;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectionForeignerController extends Controller
{
    public function index()
    {
        $subjects = DB::table('subjects')->join('plan_comp_score_foreigners', 'subjects.id', '=', 'plan_comp_score_foreigners.id_subject')
            ->groupBy('subjects.id')->select('subjects.*')->orderBy('name', 'asc')->get();
        foreach ($subjects as $k => $subject) {
            if (strpos($subject->name, 'испытание') or strpos($subject->name, 'достижение')) {
                unset($subjects[$k]);
            }
        }

        $faculties = Faculty::orderBy('name')->get();

        foreach ($faculties as $faculty) {
//            $faculty->plan = DB::table('plans')
//                ->join('specialities', 'plans.id_speciality', '=', 'specialities.id')
//                ->where('id_faculty', '=', $faculty->id)
//                ->orderBy('specialities.name')
//                ->select('specialities.name')
//                ->get();

            $faculty->plan = $faculty->plans_foreigner()->get();

        }
        foreach ($faculties as $faculty) {
            $spec_com = array();
            $spez_com = array();
            foreach ($faculty->plan as $k => $plan) {

                if (in_array($plan->id_speciality, $spec_com) && in_array($plan->id_specialization, $spez_com)) {
                    unset($faculty->plan[$k]);
                } else {
                    $spec_com[] = $plan->id_speciality;
                    $spez_com[] = $plan->id_specialization;

                    $plan->speciality = $plan->speciality()->select('code', 'name', 'en_name')->first();
                    $plan->sort_name = $plan->speciality()->select('name')->first();
                    $plan->specialization = $plan->specialization()->select('name', 'id_speciality', 'en_name')->first();
                    $plan->faculty_name = $plan->faculty()->select('name', 'en_name')->first();

//                    $plan->speciality = Speciality::where('id', '=', $plan->id_speciality)->select('code', 'name')->first();
//                    $plan->specialization = Specialization::where('id', '=', $plan->id_specialization)->select('name', 'id_speciality')->first();

                    //выбираем формы обучения для одной специальности и спецз
                    $SpecForms = PlanForeigner::where('id_speciality', '=', $plan->id_speciality)
                        ->where('id_specialization', '=', $plan->id_specialization)
                        ->select('id_studyForm', 'id', 'years')->get();
                    $arr_studyForm = array();

                    $plan->years = null;
                    foreach ($SpecForms as $form) {

                        $form_temp = StudyForm::where('id', '=', $form->id_studyForm)->select('name', 'en_name')->first();
                        $form_temp->years = $form->years;
                        $plan_comp_form = PlanCompetitionForeigner::where('id_plan', '=', $form->id)->first();
                        $form_temp->freeseats = $plan_comp_form->freeseats()->get();
                        foreach ($form_temp->freeseats as $value) {
                            $value->admissionBasis = $value->admissionBasis()->first();

//                            $past_contests = PastContests::where('id_speciality', '=', $plan->id_speciality)
//                                ->where('id_studyForm', '=', $form->id_studyForm)
//                                ->where('id_admissionBasis', '=', 3)
//                                ->select('year', 'minScore')
//                                ->get();
//                            $value->pastContests = $past_contests;
                        }
                        $form_temp->prices = $plan_comp_form->prices()->get();
                        $arr_studyForm[] = $form_temp;
                    }
                    //сорировка форм обучения
                    $temp_item_o = null;
                    $temp_item_z = null;
                    $temp_item_oz = null;
                    foreach ($arr_studyForm as $st) {
                        if ($st->name == "Очная") {
                            $temp_item_o = $st;
                        }
                        if ($st->name == "Заочная") {
                            $temp_item_z = $st;
                        }
                        if ($st->name == "Очно-заочная ") {
                            $temp_item_oz = $st;
                        }
                    }
                    $arr_studyForm_sort = array();
                    if (!is_null($temp_item_o)) {
                        $arr_studyForm_sort[] = $temp_item_o;
                    }
                    if (!is_null($temp_item_oz)) {
                        $arr_studyForm_sort[] = $temp_item_oz;
                    }
                    if (!is_null($temp_item_z)) {
                        $arr_studyForm_sort[] = $temp_item_z;
                    }

                    $plan->studyForm = $arr_studyForm_sort;

                    $plan->plan_comp = $plan->plan_comps()->first(); //связь с компетишн
//                    $plan->plan_comp = PlanCompetition::where('id_plan', '=', $plan->id)->first();
                    $id_ind = Subject::where('name', 'LIKE', '%Индивидуальное достижение%')->get();
                    $arr_id_ind = array();
                    foreach ($id_ind as $id_ind_item) {
                        $arr_id_ind[] = $id_ind_item['id'];
                    }
                    $plan->scores = $plan->plan_comp->scores()->whereNotIn('id_subject', $arr_id_ind)->get();
                    $changeable_subs = array();
                    foreach ($plan->scores as $value) {
                        $value->subject = $value->subject()->first();
                        if($value->changeable){
                            $changeable_subs[]= $value;
                        }
                    }
                    $plan->changeable_subs = $changeable_subs;
                }
            }
        }

        //  return $faculties;

        foreach ($faculties as $faculty) {
            $faculty->plan = $faculty->plan->sortBy('sort_name');
            $fsubjs = array();
            foreach ($faculty->plan as $plan) {
                $subjs = array();
                $plan->faculty = $faculty->name;
                foreach ($plan->scores as $value) {
                    if (!strpos($value->subject->name, 'достижение') and !strpos($value->subject->name, 'испытание')) {
                        $subjs[] = $value->subject->name;
                        $fsubjs[] = $value->subject->name;
                    }
                }
                $plan->subjects = $subjs;
            }
            $fsubjs = array_unique($fsubjs);
            $fsubjs = array_values($fsubjs);
            $faculty->subjects = $fsubjs;
        }


//
//         return $faculties;
        return view('pages.selectionforeigner')->with('subjects', $subjects)->with('faculties', $faculties);

    }
}
