<?php

namespace App\Http\Controllers;

use App\AdmissionBasis;
use App\Faculty;
use App\Speciality;
use App\Specialization;
use App\Subject;
use Illuminate\Http\Request;
use PHPExcel_IOFactory;
use App\Traits\ParserXlsTrait;

class ParserController extends Controller
{
    use ParserXlsTrait;

    public function index(Request $request)
    {
        return view('structure.parse');
    }

    //данные функции лежат здесь для того чтобы можно было сделать через них роут к общедоступным методам Trait'а
    public function parseSpecialitiesLocal(Request $request)
    {
        $result =  $this->parseSpecialities();
        return $result;
    }

    public function parseSubjectsLocal(Request $request)
    {
        $result =  $this->parseSubjects();
        return $result;
    }

    public function parseFacultiesLocal(Request $request){
       $this->parseFaculties();
    }

    public function parseAdmissionBasesLocal(Request $request)
    {
        $this->parseAdmissionBases();
    }
}
