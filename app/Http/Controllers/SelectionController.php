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
                $child->facultyName = $course->name;
                $child->exams = $exams;
                $child->intramural = $child->studyForms->where('name', 'Очная')->first();
                $child->partTime = $child->studyForms->where('name', 'Очно-заочная')->first();
                $child->correspondence = $child->studyForms->where('name', 'Заочная')->first();
                $allExams = array_unique(array_merge($allExams, $exams));
            }
            $course->exams = $allExams;
        }
        $subjects = SubjectList::where('internal', false)->get();
//        return view('pages.selection')->with('courses', $courses)->with('subjects', $subjects);
        return view('priem.index')->with('courses', $courses)->with('subjects', $subjects);
    }
}
