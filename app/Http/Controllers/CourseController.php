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

//        return view('structure.section', compact('infoblocks'));
        return;
    }

    function store(Request $request) {
        $courses = Course::all();
        foreach ($courses as $course) {
            $course->courses = $course->children;
        }

        if ($request->ajax()) {
            return response()->json($courses, 200);
        }
        return;
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
