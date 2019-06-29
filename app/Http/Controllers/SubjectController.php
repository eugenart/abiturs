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

        return view('structure.subject', compact('subjects'));
    }

    public function subjectList(Request $request)
    {
        $subjects = SubjectList::all();
        if ($request->ajax()) {
            return response()->json($subjects, 200);
        }

        return view('structure.egeSelect', compact('subjects'));
    }

    public function addToSubjectList(Request $request)
    {
        if ($request->ajax()) {
            $subjects = SubjectList::create([
                'name' => $request->name,
                'internal' => $request->internal
            ]);
            return response()->json($subjects, 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function deleteFromSubjectList(Request $request, $id)
    {
        $subjects = SubjectList::find($id);
        if ($request->ajax()) {
            $subjects->delete();
            return response()->json(['message' => 'Subject was deleted'], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $subject_list = [];
            foreach ($request->exams as $exam) {
                if (isset($exam['subject_id'])) {
                    $subject_list[] = $exam['id'];
                    Subject::find($exam['id'])->update(['score' => $exam['score']]);
                } else {
                    $newSubject = Subject::create([
                        'course_id' => $request->chosenCourse,
                        'subject_id' => $exam['id'],
                        'score' => $exam['score'],
                    ]);
                    $subject_list[] = $newSubject->id;
                }
            }
            $course = Course::find($request->chosenCourse);
            $subjects = $course->subjects->whereNotIn('id', $subject_list);
            foreach ($subjects as $subject) {
                $subject->delete();
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
