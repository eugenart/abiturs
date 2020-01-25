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
                $item->area->faculty = $faculty->name;
                foreach ($item->area->scores as $value) {
                    if (!strpos($value->subject->name, 'достижение') and !strpos($value->subject->name, 'испытание')) {
                        $subjs[] = $value->subject->name;
                        $fsubjs[] = $value->subject->name;
                    }
                }
                $item->subjects = $subjs;
                $item->area->subjects = $subjs;
            }
            $faculty->subjects = array_unique($fsubjs);
        }
        return view('pages.selection')->with('subjects', $subjects)->with('faculties', $faculties);
        //       return view('priem.index')->with('courses', $courses)->with('subjects', $subjects);
        //return view('pages.stat');
    }
}
