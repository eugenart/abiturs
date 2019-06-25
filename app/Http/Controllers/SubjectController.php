<?php

namespace App\Http\Controllers;

use App\Course;
use App\Subject;
use App\SubjectList;
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

    public function subjectList(Request $request)
    {
        $subjects = SubjectList::all();
        if ($request->ajax()) {
            return response()->json($subjects, 200);
        }

        return view('structure.faculties', compact('courses'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            foreach ($request->exams as $exam) {
                $subject = Subject::create([
                    'course_id' => $request->chosenCourse,
                    'subject_id' => $exam['id'],
                    'score' => $exam['minScore'],
                ]);
            }
            return response()->json(['message' => 'OK'], 200);
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
