<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        $data = [];
        foreach ($courses as $course) {
            if ($course->parent_id == null) {
                $course->courses = $course->children;
                foreach ($course->courses as $child) {
                    $child->isEdit = false;
//                    $subjects_list = [];
                    foreach ($child->subjects as $subject) {
                        $subject->name = $subject->subjectsList->name;
//                        $subject->subject_id = $subject->subjectsList->id;
//                        $subjects_list[] = $subject;
                    }
//                    $child->subject_list = $subjects_list;
                    $child->subjects = $child->subjects;
                }
                $course->isEdit = false;
                $data[] = $course;
            }
        }

        if ($request->ajax()) {
            return response()->json($data, 200);
        }

        return view('structure.faculties', compact('courses'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $course = Course::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'studyForm' => $request->studyForm,
                'score' => $request->score,
            ]);
            return response()->json($course, 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $course = Course::find($id);
            $course->update([
                'name' => $request->name,
                'studyForm' => $request->studyForm,
                'score' => $request->score,
            ]);
            return response()->json($course, 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json(['message' => 'Course was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
