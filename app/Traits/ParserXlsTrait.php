<?php
namespace App\Traits;

use App\AdmissionBasis;
use App\Faculty;
use App\Speciality;
use App\Specialization;
use App\Subject;
use Illuminate\Http\Request;
use PHPExcel_IOFactory;
use Psy\Exception\ErrorException;

trait ParserXlsTrait {

    public function parseSpecialities()
    {
        require_once (__DIR__.'/../Http/Controllers/Classes/PHPExcel.php');

        //Парсим Специальности
        try {
            $xlsSpec = PHPExcel_IOFactory::load(storage_path('app/public/files/catalogs/specialities.xls'));
        }
        catch (ErrorException $e){
            return $e;
        }
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
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/catalogs/specializations.xls'));
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

//        return json_encode('Специальности и специализации успешно выгружены!');
        return 'Специальности и специализации успешно выгружены!';

    }

    public function parseSubjects()
    {
        require_once (__DIR__.'/../Http/Controllers/Classes/PHPExcel.php');

        //Удаляем записи из таблиц
        Subject::truncate();
        // Парсим Специализации
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/catalogs/subjects.xls'));
        // Первый лист
        $xlsSpz->setActiveSheetIndex(0);
        $sheetSpz = $xlsSpz->getActiveSheet();
        $sheetSpz = $sheetSpz->toArray();


        //return count($sheetSpz);
        for ($i = 3; $i < count($sheetSpz); $i++) {

            //Добавляем записи Специализаций
            Subject::insert(array(
                'subjectId' => $sheetSpz[$i][0],
                'name' => $sheetSpz[$i][1]
            ));
        }
        return 'Дисциплины успешно выгружены!';
    }

    public function parseFaculties(){

        require_once (__DIR__.'/../Http/Controllers/Classes/PHPExcel.php');

        //Удаляем записи из таблиц
        Faculty::truncate();
        // Парсим Специализации
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/catalogs/faculties.xls'));
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

        return 'Факультеты успешно выгружены!';
    }

    public  function parseSubFac(){
        $this->parseSubjects();
        $this->parseFaculties();
        return 'Факультеты и дисциплины успешно выгружены!';
    }
    public function parseAdmissionBases()
    {
        require_once (__DIR__.'/../Http/Controllers/Classes/PHPExcel.php');

        //Удаляем записи из таблиц
        AdmissionBasis::truncate();
        // Парсим Специализации
        $xlsSpz = PHPExcel_IOFactory::load(storage_path('app/public/files/catalogs/admission_bases.xls'));
        // Первый лист
        $xlsSpz->setActiveSheetIndex(0);
        $sheetSpz = $xlsSpz->getActiveSheet();
        $sheetSpz = $sheetSpz->toArray();

        for($i=1; $i<count($sheetSpz); $i++){

            //Добавляем записи основ
            AdmissionBasis::insert(array(
                'baseId'  => $sheetSpz[$i][1],
                'name'   => $sheetSpz[$i][0],
                'short_name'   => $sheetSpz[$i][2]
            ));
        }

        return 'Основания для поступления успешно выгружены!';
    }

}
