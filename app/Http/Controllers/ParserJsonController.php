<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Score;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ParserJsonController extends Controller
{

    public function parseStudents()
    {
        $filejson = file_get_contents(storage_path('app/public/files/test3.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Student::truncate();
        $students = array();

        foreach ($json_data as $k => $st) {
            $student = array(
                'studentId' => $st['studentId'],
                'fio' => $st['fio'],
            );
            $students[] = $student;
        }
        $students = array_unique($students, SORT_REGULAR);
        Student::insert($students);
//        foreach ($students as $student) {
//            Student::insert($student);
//        }
    }

    public function parseStat()
    {
        $filejson = file_get_contents(storage_path('app/public/files/test3.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Statistic::truncate();
        $studentsStat = array();

        foreach ($json_data as $k => $st) {
            $idStudent = Student::where('studentId', '=', $st['studentId'])->first();
            $idFaculty = Faculty::where('facultyId', '=', $st['facultyId'])->first();
            $idSpecialization = Specialization::where('specializationId', '=', $st['specialization'])->first();
            $idSpeciality = Speciality::where('specialityId', '=', $st['speciality'])->first();


            // print_r($idFaculty);
            $stat = array(
                'id_student' => intval($idStudent->id),
                'id_faculty' => intval($idFaculty->id),
                'id_speciality' => intval($idSpeciality->id),
                'id_specialization' => $idSpecialization ? intval($idSpecialization->id) : null,
                'preparationLevel' => $st['preparationLevel'],
                'admissionBasis' => $st['admissionBasis'],
                'studyForm' => $st['studyForm'],
                'category' => $st['category'],
                'accept' => $st['accept'],
                'original' => $st['original'],
                'summ' => $st['summ'],
                'indAchievement' => $st['indAchievement'],
                'summContest' => $st['summContest'],
                'needHostel' => $st['needHostel'],
                'notice1' => $st['notice1'],
                'notice2' => $st['notice2']
            );

            $studentsStat[] = $stat;
        }

        $chunks = array_chunk($studentsStat, 3000);

        foreach ($chunks as $chunk) {
            Statistic::insert($chunk);
        }
    }


    public function parseScore()
    {
        $filejson = file_get_contents(storage_path('app/public/files/test3.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        Score::truncate();
        $scores = array();

        foreach ($json_data as $k => $st) {
            foreach ($st['score'] as $item) {
                $idSubject = Subject::where('subjectId', '=', $item['subjectId'])->first();

                $score = array(
                    'id_statistic' => $k + 1,
                    'id_subject' => intval($idSubject->id),
                    'score' => $item['subjectScore']
                );

                $scores[] = $score;
            }
        }

        $chunks = array_chunk($scores, 3000);

        foreach ($chunks as $chunk) {
            Score::insert($chunk);
        }


    }


    public function parseFromJson(Request $request)
    {
        set_time_limit(600);

        $this->parseStudents();
        $this->parseStat();
        $this->parseScore();

        return view('pages.parser');
    }
}
