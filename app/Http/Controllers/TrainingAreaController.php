<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;

class TrainingAreaController extends Controller
{
    public function index(Request $request)
    {
        $faculties = Faculty::all();

        foreach ($faculties as $faculty) {
            $faculty->tArea = $faculty->areas()->get();
        }

        foreach ($faculties as $faculty) {
            foreach ($faculty->tArea as $item){
                $item->area = $item->area()->first();
                $item->area->sp_name = $item->area->speciality()->first();
                $item->area->scores = $item->area->minScores()->get();
                foreach ($item->area->scores as $value) {
                    $value->subject = $value->subject()->first();
                }
            }
        }

        if ($request->ajax()) {
            return response()->json($faculties, 200);
        }

        return view('structure.minscore', compact('faculties'));
    }

    public function price(Request $request)
    {
        $faculties = Faculty::all();

        foreach ($faculties as $faculty) {
            $faculty->tArea = $faculty->areas()->get();
        }

        foreach ($faculties as $faculty) {
            foreach ($faculty->tArea as $item){
                $item->area = $item->area()->first();
                $item->area->sp_name = $item->area->speciality()->first();
                $item->area->scores = $item->area->minScores()->get();
                foreach ($item->area->scores as $value) {
                    $value->subject = $value->subject()->first();
                }
            }
        }

        if ($request->ajax()) {
            return response()->json($faculties, 200);
        }

        return view('structure.price', compact('faculties'));
    }
}
