<?php

namespace App\Http\Controllers;

use App\Course;
use App\StudyForms;
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
                    $child->subjects;
                    $child->intramural = $child->studyForms->where('name', 'Очная')->first();
                    $child->partTime = $child->studyForms->where('name', 'Очно-заочная')->first();
                    $child->correspondence = $child->studyForms->where('name', 'Заочная')->first();

                    $studyFormNull = [
                        'name' => null,
                        'budget' => null,
                        'price' => null,
                        'year' => null,
                    ];

                    $child->intramural == null ? $child->intramural = $studyFormNull : null;
                    $child->partTime == null ? $child->partTime = $studyFormNull : null;
                    $child->correspondence == null ? $child->correspondence = $studyFormNull : null;

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
                'score' => $request->score,
            ]);
            if (isset($request->intramural['name'])) {
                StudyForms::create([
                    'name' => $request->intramural['name'],
                    'budget' => (isset($request->intramural['budget']) ? $request->intramural['budget'] : '-'),
                    'price' => (isset($request->intramural['price']) ? $request->intramural['price'] : '-'),
                    'year' => (isset($request->intramural['year']) ? $request->intramural['year'] : '-'),
                    'course_id' => $course->id,
                ]);
            }
            if (isset($request->partTime['name'])) {
                StudyForms::create([
                    'name' => $request->partTime['name'],
                    'budget' => (isset($request->partTime['budget']) ? $request->partTime['budget'] : '-'),
                    'price' => (isset($request->partTime['price']) ? $request->partTime['price'] : '-'),
                    'year' => (isset($request->partTime['year']) ? $request->partTime['year'] : '-'),
                    'course_id' => $course->id,
                ]);
            }
            if (isset($request->correspondence['name'])) {
                StudyForms::create([
                    'name' => $request->correspondence['name'],
                    'budget' => (isset($request->correspondence['budget']) ? $request->correspondence['budget'] : '-'),
                    'price' => (isset($request->correspondence['price']) ? $request->correspondence['price'] : '-'),
                    'year' => (isset($request->correspondence['year']) ? $request->correspondence['year'] : '-'),
                    'course_id' => $course->id,
                ]);
            }
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
                'score' => $request->score,
            ]);
            $course->intramural = $course->studyForms->where('name', 'Очная')->first();
            $course->partTime = $course->studyForms->where('name', 'Очно-заочная')->first();
            $course->correspondence = $course->studyForms->where('name', 'Заочная')->first();
            if (isset($request->intramural['name'])) {
                if ($course->intramural) {
                    $course->intramural->update([
                        'name' => $request->intramural['name'],
                        'budget' => (isset($request->intramural['budget']) ? $request->intramural['budget'] : '-'),
                        'price' => (isset($request->intramural['price']) ? $request->intramural['price'] : '-'),
                        'year' => (isset($request->intramural['year']) ? $request->intramural['year'] : '-'),
                        'course_id' => $course->id,
                    ]);
                } else {
                    StudyForms::create([
                        'name' => $request->intramural['name'],
                        'budget' => (isset($request->intramural['budget']) ? $request->intramural['budget'] : '-'),
                        'price' => (isset($request->intramural['price']) ? $request->intramural['price'] : '-'),
                        'year' => (isset($request->intramural['year']) ? $request->intramural['year'] : '-'),
                        'course_id' => $course->id,
                    ]);
                }
            }
            if (!isset($request->intramural) && $course->intramural !== null) {
                $course->intramural->delete();
            }

            if (isset($request->partTime['name'])) {
                if ($course->partTime) {
                    $course->partTime->update([
                        'name' => $request->partTime['name'],
                        'budget' => (isset($request->partTime['budget']) ? $request->partTime['budget'] : '-'),
                        'price' => (isset($request->partTime['price']) ? $request->partTime['price'] : '-'),
                        'year' => (isset($request->partTime['year']) ? $request->partTime['year'] : '-'),
                        'course_id' => $course->id,
                    ]);
                } else {
                    StudyForms::create([
                        'name' => $request->partTime['name'],
                        'budget' => (isset($request->partTime['budget']) ? $request->partTime['budget'] : '-'),
                        'price' => (isset($request->partTime['price']) ? $request->partTime['price'] : '-'),
                        'year' => (isset($request->partTime['year']) ? $request->partTime['year'] : '-'),
                        'course_id' => $course->id,
                    ]);
                }
            }
            if (!isset($request->partTime) && $course->partTime !== null) {
                $course->partTime->delete();
            }

            if (isset($request->correspondence['name'])) {
                if ($course->correspondence) {
                    $course->correspondence->update([
                        'name' => $request->correspondence['name'],
                        'budget' => (isset($request->correspondence['budget']) ? $request->correspondence['budget'] : '-'),
                        'price' => (isset($request->correspondence['price']) ? $request->correspondence['price'] : '-'),
                        'year' => (isset($request->correspondence['year']) ? $request->correspondence['year'] : '-'),
                        'course_id' => $course->id,
                    ]);
                } else {
                    StudyForms::create([
                        'name' => $request->correspondence['name'],
                        'budget' => (isset($request->correspondence['budget']) ? $request->correspondence['budget'] : '-'),
                        'price' => (isset($request->correspondence['price']) ? $request->correspondence['price'] : '-'),
                        'year' => (isset($request->correspondence['year']) ? $request->correspondence['year'] : '-'),
                        'course_id' => $course->id,
                    ]);
                }
            }
            if (!isset($request->correspondence) && $course->correspondence !== null) {
                $course->correspondence->delete();
            }

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
