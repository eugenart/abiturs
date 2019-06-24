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

        return view('structure.faculties', compact('courses'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $subject = Subject::create([
                'name' => $request->name,
            ]);
            return response()->json($subject, 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $subject = Subject::find($id);
            $subject->update([
                'name' => $request->name,
            ]);
            return response()->json($subject, 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $subject = Course::findOrFail($id);
            $subject->delete();
            return response()->json(['message' => 'Subject was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
