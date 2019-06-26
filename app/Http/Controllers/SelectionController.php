<?php

namespace App\Http\Controllers;

use App\Course;
use App\SubjectList;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        $courses = Course::where('parent_id', null)->get();
        foreach ($courses as $course) {
            $allExams = [];
            foreach ($course->children as $child) {
                $exams = [];
                foreach ($child->subjects as $subject)
                    if (!$subject->subjectsList->internal) {
                        $exams[] = $subject->subjectsList->name;
                    }
                $child->exams = $exams;
                $allExams = array_unique(array_merge($allExams, $exams));
            }
            $course->exams = $allExams;
        }
        $subjects = SubjectList::where('internal', false)->get();
        return view('pages.selection')->with('courses', $courses)->with('subjects', $subjects);
    }
}
