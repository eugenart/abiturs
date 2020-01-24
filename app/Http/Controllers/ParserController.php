<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Speciality;
use App\Specialization;
use App\Subject;
use Illuminate\Http\Request;
use PHPExcel_IOFactory;

class ParserController extends Controller
{
    public function index(Request $request)
    {
        // $subjs = Subject::all();
        return view('structure.parse'/*, compact('sheet')*/);
    }

    public function parseFromXls(Request $request)
    {
        require_once 'Classes/PHPExcel.php';

        //Парсим Специальности
        $xlsSpec = PHPExcel_IOFactory::load(storage_path('app/public/files/Специальности.xls'));
        // Первый лист
        $xlsSpec->setActiveSheetIndex(0);
        $sheetSpec = $xlsSpec->getActiveSheet();
        $sheetSpec = $sheetSpec->toArray();

        //Удаляем записи из обоих таблиц
        Specialization::truncate();
        Speciality::truncate();


        //Добавляем записи Специальностей
        for($i=1; $i<count($sheetSpec); $i++){
           Speciality::insert(array(
            'specialityId'  => $sheetSpec[$i][2],
            'code' => $sheetSpec[$i][0],
            'name'   => $sheetSpec[$i][1]
        ));
        }


        // Парсим Специализации
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/Специализации.xls'));
        // Первый лист
        $xlsSpz->setActiveSheetIndex(0);
        $sheetSpz = $xlsSpz->getActiveSheet();
        $sheetSpz = $sheetSpz->toArray();


        for($i=1; $i<count($sheetSpz); $i++){

            //получим id специальности для привязки по имени и коду
            $speciality = Speciality::where('name', '=', $sheetSpz[$i][2])
                ->where('code', '=', $sheetSpz[$i][3])
                ->first();
            $id_speciality = $speciality->id;

            //Добавляем записи Специализаций
            Specialization::insert(array(
                'specializationId'  => $sheetSpz[$i][4],
                'name'   => $sheetSpz[$i][0],
                'id_speciality'   => $id_speciality

            ));
        }

        return json_encode('Специальности и специализации успешно выгружены!');
    }

    public function parseFromXlsSub(Request $request)
    {
        require_once 'Classes/PHPExcel.php';

        //Удаляем записи из таблиц
        Subject::truncate();
        // Парсим Специализации
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/Дисциплины.xls'));
        // Первый лист
        $xlsSpz->setActiveSheetIndex(0);
        $sheetSpz = $xlsSpz->getActiveSheet();
        $sheetSpz = $sheetSpz->toArray();

        for($i=3; $i<count($sheetSpz); $i++){

            //Добавляем записи Специализаций
            Subject::insert(array(
                'subjectId'  => $sheetSpz[$i][0],
                'name'   => $sheetSpz[$i][1]
            ));
        }

        //Удаляем записи из таблиц
        Faculty::truncate();
        // Парсим Специализации
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/Факультеты.xls'));
        // Первый лист
        $xlsSpz->setActiveSheetIndex(0);
        $sheetSpz = $xlsSpz->getActiveSheet();
        $sheetSpz = $sheetSpz->toArray();

        for($i=1; $i<count($sheetSpz); $i++){

            //Добавляем записи Специализаций
            Faculty::insert(array(
                'facultyId'  => $sheetSpz[$i][0],
                'name'   => $sheetSpz[$i][1]
            ));
        }

        return json_encode('Факультеты и дисциплины успешно выгружены!');
    }


}
