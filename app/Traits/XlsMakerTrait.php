<?php

namespace App\Traits;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\Freeseats_bases;
use App\Plan;
use App\PlanCompetition;
use App\PreparationLevel;
use App\Speciality;
use App\Statistic;
use App\StudyForm;
use PHPExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Writer_Excel5;

trait XlsMakerTrait
{
    public function createXls($studyForms)
    {
        if (isset($studyForms)) {


            require_once '..\app\Http\Controllers\Classes\PHPExcel.php';
            require_once('..\app\Http\Controllers\Classes\PHPExcel\Writer\Excel5.php');

            // Создаем объект класса PHPExcel
            $xls = new PHPExcel();
// Устанавливаем индекс активного листа
            $xls->setActiveSheetIndex(0);
// Получаем активный лист
            $sheet = $xls->getActiveSheet();
// Подписываем лист
            $sheet->setTitle('Списки');

// Вставляем текст в ячейку A1
            $sheet->setCellValue("A1", 'Полный пофамильный перечень лиц, успешно прошедших вступительные испытания и допущенных к участию в конкурсе на зачисление по каждому направлению подготовки (специальности) очной формы обучения на места в рамках контрольных цифр приема с указанием суммы конкурсных баллов по всем вступительным испытаниям ');
            $sheet->getStyle('A1')->getFill()->setFillType(
                PHPExcel_Style_Fill::FILL_SOLID);
//        $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');

// Объединяем ячейки
            $sheet->mergeCells('A1:M3');

// Выравнивание текста
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(
                PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            foreach ($studyForms as $studyForm) {
                if (isset($studyForm->stat)) {
                    foreach ($studyForm->stat as $category) {
                        if (isset($category->admissionBases)) {
                            foreach ($category->admissionBases as $admissionBasis) {
                                if (isset($admissionBasis->preparationLevels)) {
                                    foreach ($admissionBasis->preparationLevels as $preparationLevel) {
                                        if (isset($preparationLevel->faculties)) {
                                            foreach ($preparationLevel->faculties as $faculty) {
                                                if (isset($faculty->specialities)) {
                                                    foreach ($faculty->specialities as $speciality=>$k0) {
                                                        $sheet->setCellValue("A4", "Факультет / институт:	");
                                                        $sheet->setCellValue("A5", "Направление подготовки / специальность:");
                                                        $sheet->setCellValue("A6", "Уровень подготовки:");
                                                        $sheet->setCellValue("B4", $faculty->name);
                                                        $sheet->setCellValue("B5", $speciality->name);
                                                        $sheet->setCellValue("B6", $preparationLevel->name);


                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            $objWriter = new PHPExcel_Writer_Excel5($xls);
            $objWriter->save('E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files-xls\file.xls');
        }
    }
}

