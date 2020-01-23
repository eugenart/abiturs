<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function index(Request $request)
    {
        $subjects = Subject::all();
        if ($request->ajax()) {
            return response()->json($subjects, 200);
        }

        return view('structure.subject', compact('subjects'));
    }
}
