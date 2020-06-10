<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\PastContests;
use App\Plan;
use App\PlanCompetition;
use App\StudyForm;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectionController extends Controller
{
    public function index()
    {
        //$subjects = Subject::all();
        $subjects = DB::table('subjects')->join('plan_comp_scores', 'subjects.id', '=', 'plan_comp_scores.id_subject')
            ->groupBy('subjects.id')->select('subjects.*')->get();
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
                    $plan->specialization = $plan->specialization()->select('name', 'id_speciality')->first();

                    //выбираем формы обучения для одной специальности и спецз
                    $SpecForms = Plan::where('id_speciality', '=', $plan->id_speciality)
                        ->where('id_specialization', '=', $plan->id_specialization)
                        ->select('id_studyForm', 'id', 'years')->get();
                    $arr_studyForm = array();

                    $plan->years = null;
                    foreach ($SpecForms as $form) {

                        $form_temp = StudyForm::where('id', '=', $form->id_studyForm)->select('name')->first();
                        $form_temp->years = $form->years;
                        $plan_comp_form = PlanCompetition::where('id_plan', '=', $form->id)->first();
                        $form_temp->freeseats = $plan_comp_form->freeseats()->get();
                        foreach ($form_temp->freeseats as $value) {
                            $value->admissionBasis = $value->admissionBasis()->first();

                            $past_contests = PastContests::where('id_speciality', '=', $plan->id_speciality)
                                ->where('id_studyForm', '=', $form->id_studyForm)
                                ->where('id_admissionBasis', '=', $value->id_admissionBasis)
                                ->select('year', 'minScore')
                                ->get();


                            $value->pastContests = $past_contests;

                        }
                        $form_temp->prices = $plan_comp_form->prices()->get();


                        $arr_studyForm[] = $form_temp;
                    }
                    $plan->studyForm = $arr_studyForm;

                    $plan->plan_comp = $plan->plan_comps()->first(); //связь с компетишн
                    $id_ind = Subject::where('name', 'LIKE', '%Индивидуальное достижение%')->get();
                    $arr_id_ind = array();
                    foreach ($id_ind as $id_ind_item){
                        $arr_id_ind[] = $id_ind_item['id'];
                    }
                    $plan->scores = $plan->plan_comp->scores()->whereNotIn('id_subject', $arr_id_ind)->get();
                    foreach ($plan->scores as $value) {
                        $value->subject = $value->subject()->first();
                    }

//                    $freeseats_temp = $plan->plan_comp->freeseats()->get();
//                    foreach ($freeseats_temp as $value) {
//                        $value->admissionBasis = $value->admissionBasis()->first();
//                    }
//
//                    $prices_temp = $plan->plan_comp->prices()->get();


                }
            }
        }

        //  return $faculties;


        foreach ($faculties as $faculty) {
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
                //$plan->area->subjects = $subjs;
            }
            $fsubjs = array_unique($fsubjs);
            $fsubjs = array_values($fsubjs);
            $faculty->subjects = $fsubjs;
        }
//
//         return $faculties;
        return view('pages.selection')->with('subjects', $subjects)->with('faculties', $faculties);

    }
}
