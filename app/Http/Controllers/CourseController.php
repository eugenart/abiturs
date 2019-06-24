<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    function index(Request $request) {
        $courses = Course::all();
        foreach ($courses as $course) {
            $course->courses = $course->children;
        }

        if ($request->ajax()) {
            return response()->json($courses, 200);
        }

        return view('structure.faculties', compact('courses'));
    }

    function store(Request $request) {
        if ($request->ajax()) {
            $course = Course::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
            ]);
            return response()->json($course, 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id) {
        if ($request->ajax()) {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json(['message' => 'Course was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
