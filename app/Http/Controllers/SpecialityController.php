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

        foreach ($specialities as $speciality) {
            $speciality->sp = $speciality->specialization()->get();
        }

        if ($request->ajax()) {
            return response()->json($specialities, 200);
        }

        return view('structure.speciality',  compact('specialities'));
    }
}
