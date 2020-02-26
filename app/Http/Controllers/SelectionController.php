<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Plan;
use App\PlanCompetition;
use App\StudyForm;
use App\Subject;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
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
            $spec_com = "";
            $spez_com = "";
            foreach ($faculty->plan as $k => $plan) {

                if (($spec_com == $plan->id_speciality) && ($spez_com == $plan->id_specialization)) {
                    unset($faculty->plan[$k]);
                } else {
                    $spec_com = $plan->id_speciality;
                    $spez_com = $plan->id_specialization;

                    $plan->speciality = $plan->speciality()->first();
                    $plan->specialization = $plan->specialization()->first();

                    //выбираем формы обучения для одной специальности и спецз
                    $SpecForms = Plan::where('id_speciality', '=', $plan->id_speciality)
                        ->where('id_specialization', '=', $plan->id_specialization)
                        ->select('id_studyForm', 'id')->get();
                    $arr_studyForm = array();

                    foreach ($SpecForms as $form) {
                        $form_temp= StudyForm::where('id', '=', $form->id_studyForm)->select('name')->first();
                        $plan_comp_form = PlanCompetition::where('id_plan', '=', $form->id)->first();
                        $form_temp->freeseats = $plan_comp_form->freeseats()->get();
                        foreach ($form_temp->freeseats as $value) {
                            $value->admissionBasis = $value->admissionBasis()->first();
                        }
                        $form_temp->prices = $plan_comp_form->prices()->get();

                        $arr_studyForm[] = $form_temp;
                    }
                    $plan->studyForm = $arr_studyForm;


                    $plan->plan_comp = $plan->plan_comps()->first(); //связь с компетишн
                    $plan->scores = $plan->plan_comp->scores()->get();
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

       //return $faculties;
        return view('pages.selection')->with('subjects', $subjects)->with('faculties', $faculties);

    }
}
