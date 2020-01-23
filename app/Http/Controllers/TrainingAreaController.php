<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\TrainingArea;
use Illuminate\Http\Request;

class TrainingAreaController extends Controller
{
    public function index(Request $request)
    {
        $faculties = Faculty::all();

            foreach ($faculties as $faculty){
                $faculty->tArea = $faculty->areas()->get();
            }

        foreach ($faculties as $faculty) {
            foreach ($faculty->tArea as $item){
                $item->sp_name = $item->speciality()->get();
                $item->scores = $item->minScores()->get();
            }
        }

        if ($request->ajax()) {
            return response()->json($specialities, 200);
        }

        return view('structure.speciality',  compact('specialities'));

    }
}
