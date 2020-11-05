<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Faculty;
use App\Freeseats_bases;
use App\PastContests;
use App\Plan;
use App\PlanCompetition;
use App\Price;
use App\Speciality;
use App\Specialization;
use App\StudyForm;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class SelectionController extends Controller
{
    public function index()
    {
        $subjects = DB::table('subjects')->join('plan_comp_scores', 'subjects.id', '=', 'plan_comp_scores.id_subject')
            ->groupBy('subjects.id')->select('subjects.*')->orderBy('name', 'asc')->get();
        foreach ($subjects as $k => $subject) {
            if (strpos($subject->name, 'испытание') or strpos($subject->name, 'достижение')) {
                unset($subjects[$k]);
            }
        }

        $faculties = Faculty::orderBy('name')->get();

        foreach ($faculties as $faculty) {
            $faculty->plan = $faculty->plans()->get();
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

                    $plan->speciality = $plan->speciality()->select('code', 'name')->first();
                    $plan->sort_name = $plan->speciality()->select('name')->first();
                    $plan->specialization = $plan->specialization()->select('name', 'id_speciality')->first();

                    //выбираем формы обучения для одной специальности и спецз
                    $SpecForms = Plan::where('id_speciality', '=', $plan->id_speciality)
                        ->where('id_specialization', '=', $plan->id_specialization)
                        ->select('id_studyForm', 'id', 'years', 'planId')->get();
                    $arr_studyForm = array();

                    $plan->years = null;
                    foreach ($SpecForms as $form) {

                        $form_temp = StudyForm::where('id', '=', $form->id_studyForm)->select('name')->first();
                        $form_temp->years = $form->years;

//                        $plan_comp_form = PlanCompetition::where('id_plan', '=', $form->id)->first();
//
//                        $form_temp->freeseats = $plan_comp_form->freeseats()->get();

//                        //competition
                        $p_c = Plan::where('planId', $form->planId)->select('id')->get();
                        $pc_arr = array();
                        foreach ($p_c as $pc_item){
                            $pc_arr[] = $pc_item->id;
                        }
                        $plan_comp_form = PlanCompetition::whereIn('id_plan', $pc_arr)->get();
                        $pcf_arr = array();
                        foreach ($plan_comp_form as $pc_item){
                            $pcf_arr[] = $pc_item->id;
                        }
                        $form_temp->freeseats = Freeseats_bases::whereIn('id_plan_comp', $pcf_arr)->get();

                        $id_plan_comp = $form_temp->freeseats->first()->id_plan_comp;
                        foreach ($form_temp->freeseats as $value) {
                            $value->admissionBasis = $value->admissionBasis()->first();

                                $past_contests = PastContests::where('id_speciality', '=', $plan->id_speciality)
                                    ->where('id_studyForm', '=', $form->id_studyForm)
                                    ->where('id_admissionBasis', '=', 3)
                                    ->select('year', 'minScore')
                                    ->get();
                                $value->pastContests = $past_contests;

                        }

                        $form_temp->prices = Price::whereIn('id_plan_comp', $pcf_arr)->get();
//                        return $form_temp->prices ;
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

                    //собираем готовый объект
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

//          return $faculties;

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

        $year = 2021;
//
//         return $faculties;

        return view('pages.selection', ['subjects' => $subjects, 'faculties' => $faculties, 'year'=>$year]);
    }
}
