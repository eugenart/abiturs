<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\FacultyArea;
use App\PreparationLevel;
use App\Score;
use App\Speciality;
use App\Specialization;
use App\Statistic;
use App\StatisticsExtra;
use App\StatisticsIntra;
use App\StatisticsPart;
use App\Student;
use App\StudyForm;
use App\Subject;
use App\TrainingArea;
use App\TrainingAreasSubject;
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
        StudyForm::truncate();
        AdmissionBasis::truncate();
        PreparationLevel::truncate();
        Category::truncate();
        $studentsStat = array();
        $studyForms = array();
        $prepLevels = array();
        $admissionBases = array();
        $categories = array();

        foreach ($json_data as $k => $st) {

            $stdForm = array(
                'name' => $st['studyForm']
            );
            $studyForms[] = $stdForm;

            $prepLevel = array(
                'name' => $st['preparationLevel']
            );
            $prepLevels[] = $prepLevel;

            $admissionBasis = array(
                'name' => $st['admissionBasis']
            );
            $admissionBases[] = $admissionBasis;

            $category = array(
                'name' => $st['category']
            );
            $categories[] = $category;

        }

        $studyForms = array_unique($studyForms, SORT_REGULAR);
        StudyForm::insert($studyForms);
        $prepLevels = array_unique($prepLevels, SORT_REGULAR);
        PreparationLevel::insert($prepLevels);
        $admissionBases = array_unique($admissionBases, SORT_REGULAR);
        AdmissionBasis::insert($admissionBases);
        $categories = array_unique($categories, SORT_REGULAR);
        Category::insert($categories);

        StatisticsIntra::truncate();
        StatisticsPart::truncate();
        StatisticsExtra::truncate();

        foreach ($json_data as $k => $st) {

            $idStudent = Student::where('studentId', '=', $st['studentId'])->first();
            $idFaculty = Faculty::where('facultyId', '=', $st['facultyId'])->first();
            $idSpecialization = Specialization::where('specializationId', '=', $st['specialization'])->first();
            $idSpeciality = Speciality::where('specialityId', '=', $st['speciality'])->first();
            $idStudyForm = StudyForm::where('name', '=', $st['studyForm'])->first();
            $idPreparationLevel = PreparationLevel::where('name', '=', $st['preparationLevel'])->first();
            $idAdmissionBasis = AdmissionBasis::where('name', '=', $st['admissionBasis'])->first();
            $idCategory = Category::where('name', '=', $st['category'])->first();

            // print_r($idFaculty);
            $stat = array(
                'id_student' => intval($idStudent->id),
                'id_faculty' => intval($idFaculty->id),
                'id_speciality' => intval($idSpeciality->id),
                'id_specialization' => $idSpecialization ? intval($idSpecialization->id) : null,
                'id_preparationLevel' => intval($idPreparationLevel->id),
                'id_admissionBasis' => intval($idAdmissionBasis->id),
                'id_studyForm' => intval($idStudyForm->id),
                'id_category' => intval($idCategory->id),
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

        $studentsStatIntras = array();
        $studentsStatParts = array();
        $studentsStatExtras = array();

        foreach ($studentsStat as $value) {
            if ($value['id_studyForm'] === StudyForm::where('name', '=', 'Очная')->first()->id) {
                $studentsStatIntras[] = $value;
            } elseif ($value['id_studyForm'] === StudyForm::where('name', '=', 'Очно-заочная')->first()->id) {
                $studentsStatParts[] = $value;
            } else {
                $studentsStatExtras[] = $value;
            }
        }

        $chunks = array_chunk($studentsStatIntras, 3000);
        foreach ($chunks as $chunk) {
            StatisticsIntra::insert($chunk);
        }

        $chunks = array_chunk($studentsStatParts, 3000);
        foreach ($chunks as $chunk) {
            StatisticsPart::insert($chunk);
        }

        $chunks = array_chunk($studentsStatExtras, 3000);
        foreach ($chunks as $chunk) {
            StatisticsExtra::insert($chunk);
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


    public function parseAreas()
    {
        $filejson = file_get_contents(storage_path('app/public/files/test2.json'));
        $json_arr = json_decode($filejson, true);
        $json_data = $json_arr['data'];

        TrainingArea::truncate();
        TrainingAreasSubject::truncate();
        FacultyArea::truncate();

        $areas = array();
        $areas_subjects = array();
        $areas_faculties = array();
        $count_areas = 0;

        foreach ($json_data as $k => $facultyItem) {
            $id_faculty = Faculty::where('facultyId', '=', $facultyItem['facultyId'])->first();

            foreach ($facultyItem['trainingAreas'] as $areaItem) {

                $id_speciality = Speciality::where('specialityId', '=', $areaItem['trainingAreasId'])->first();

                $area = array(
                    'id_speciality' => intval($id_speciality->id),
                    'trainingForm' => $areaItem['trainingForm'],
                    'freeSeatsNumber' => intval($areaItem['freeSeatsNumber']),
                    'years' => intval($areaItem['years']),
                    'price' => intval($areaItem['price'])
                );

                $areas[] = $area;
                $count_areas++;

                $faculty = array(
                    'id_faculty' => intval($id_faculty->id),
                    'id_area' => $count_areas,
                );
                $areas_faculties[] = $faculty;

                foreach ($areaItem['subjects'] as $subjectItem) {
                    $id_subject = Subject::where('subjectId', '=', $subjectItem['subjectId'])->first();

                    $subject = array(
                        'id_area' => $count_areas,
                        'id_subject' => intval($id_subject->id),
                        'minScore' => $subjectItem['minScore']
                    );
                    $areas_subjects[] = $subject;
                }
            }
        }


        TrainingArea::insert($areas);
        FacultyArea::insert($areas_faculties);
        TrainingAreasSubject::insert($areas_subjects);

        return json_encode('Выгрузка данных о ценах на обучение успешно завершена!');
    }

    public function parseFromJson(Request $request)
    {
        set_time_limit(1200);

        //$this->parseStudents();
        $this->parseStat();
        // $this->parseScore();
        //$this->parseAreas();

        return json_encode('Информация об абитуриентах успешно выгружена!');
    }
}
