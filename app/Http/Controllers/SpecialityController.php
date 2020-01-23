<?php

namespace App\Http\Controllers;

use App\Speciality;
use App\Specialization;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index(Request $request)
    {
        $specialities = Speciality::all();


        if ($request->ajax()) {
            return response()->json($specialities, 200);
        }

        return view('structure.section',  compact('specialities'));
    }
}
