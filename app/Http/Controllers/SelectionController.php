<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Subject;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        foreach ($subjects as $k => $subject) {
            if (strpos($subject->name, 'испытание') or strpos($subject->name, 'достижение')) {
                unset($subjects[$k]);
            }
        }

        $faculties = Faculty::all();

        foreach ($faculties as $faculty) {
            $faculty->tArea = $faculty->areas()->get();
        }

        foreach ($faculties as $faculty) {
            foreach ($faculty->tArea as $item) {
                $item->area = $item->area()->first();
                $item->area->sp_name = $item->area->speciality()->first();
                $item->area->scores = $item->area->minScores()->get();
                foreach ($item->area->scores as $value) {
                    $value->subject = $value->subject()->first();
                }
            }
        }

        foreach ($faculties as $faculty) {
            $fsubjs = [];
            foreach ($faculty->tArea as $item) {
                $subjs = [];
                foreach ($item->area->scores as $value) {
                    if (!strpos($value->subject->name, 'достижение') and !strpos($value->subject->name, 'испытание')) {
                        $subjs[] = $value->subject->name;
                        $fsubjs[] = $value->subject->name;
                    }
                }
                $item->subjects = $subjs;
            }
            $faculty->subjects = array_unique($fsubjs);
        }

//        $courses = Course::where('parent_id', null)->get();
//        foreach ($courses as $course) {
//            $allExams = [];
//            foreach ($course->children as $child) {
//                $exams = [];
//                foreach ($child->subjects as $subject)
//                    if (!$subject->subjectsList->internal) {
//                        $exams[] = $subject->subjectsList->name;
//                    }
//                $child->facultyName = $course->name;
//                $child->exams = $exams;
//                $child->intramural = $child->studyForms->where('name', 'Очная')->first();
//                $child->partTime = $child->studyForms->where('name', 'Очно-заочная')->first();
//                $child->correspondence = $child->studyForms->where('name', 'Заочная')->first();
//                $allExams = array_unique(array_merge($allExams, $exams));
//            }
//            $course->exams = $allExams;
//        }
        //  $subjects = SubjectList::where('internal', false)->get();
        return view('pages.selection')->with('subjects', $subjects)->with('faculties', $faculties);
        //       return view('priem.index')->with('courses', $courses)->with('subjects', $subjects);
        //return view('pages.stat');
    }
}
