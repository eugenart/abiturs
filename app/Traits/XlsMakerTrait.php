<?php

namespace App\Traits;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\PreparationLevel;
use App\Speciality;
use App\Specialization;
use App\StatisticAsp;
use App\StudyForm;
use ErrorException;
use PHPExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Writer_Excel5;

trait XlsMakerTrait
{
    public function makeModelsNames($modelName)
    {
        $names_arr = array();
        if ($modelName == 'Statistic') {
            $names_arr['Statistic'] = 'App\Statistic';
            $names_arr['Competition'] = 'App\Competition';
            $names_arr['PlanCompetition'] = 'App\PlanCompetition';
            $names_arr['Plan'] = 'App\Plan';
            $names_arr['Freeseats'] = 'App\Freeseats_bases';
            $names_arr['folder'] = 'bach';
        }
        if ($modelName == 'StatisticMaster') {
            $names_arr['Statistic'] = 'App\StatisticMaster';
            $names_arr['Competition'] = 'App\CompetitionMaster';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionMaster';
            $names_arr['Plan'] = 'App\PlanMaster';
            $names_arr['Freeseats'] = 'App\Freeseats_basesMaster';
            $names_arr['folder'] = 'master';
        }
        if ($modelName == 'StatisticAsp') {
            $names_arr['Statistic'] = 'App\StatisticAsp';
            $names_arr['Competition'] = 'App\CompetitionAsp';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionAsp';
            $names_arr['Plan'] = 'App\PlanAsp';
            $names_arr['Freeseats'] = 'App\Freeseats_basesAsp';
            $names_arr['folder'] = 'asp';
        }
        if ($modelName == 'StatisticSpo') {
            $names_arr['Statistic'] = 'App\StatisticSpo';
            $names_arr['Competition'] = 'App\CompetitionSpo';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionSpo';
            $names_arr['Plan'] = 'App\PlanSpo';
            $names_arr['Freeseats'] = 'App\Freeseats_basesSpo';
            $names_arr['folder'] = 'spo';
        }

        if ($modelName == 'StatisticForeigner') {
            $names_arr['Statistic'] = 'App\StatisticForeigner';
            $names_arr['Competition'] = 'App\CompetitionForeigner';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionForeigner';
            $names_arr['Plan'] = 'App\PlanForeigner';
            $names_arr['Freeseats'] = 'App\Freeseats_basesForeigner';
            $names_arr['folder'] = 'bachf';
        }
        if ($modelName == 'StatisticMasterForeigner') {
            $names_arr['Statistic'] = 'App\StatisticMasterForeigner';
            $names_arr['Competition'] = 'App\CompetitionMasterForeigner';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionMasterForeigner';
            $names_arr['Plan'] = 'App\PlanMasterForeigner';
            $names_arr['Freeseats'] = 'App\Freeseats_basesMasterForeigner';
            $names_arr['folder'] = 'masterf';
        }
        if ($modelName == 'StatisticAspForeigner') {
            $names_arr['Statistic'] = 'App\StatisticAspForeigner';
            $names_arr['Competition'] = 'App\CompetitionAspForeigner';
            $names_arr['PlanCompetition'] = 'App\PlanCompetitionAspForeigner';
            $names_arr['Plan'] = 'App\PlanAspForeigner';
            $names_arr['Freeseats'] = 'App\Freeseats_basesAspForeigner';
            $names_arr['folder'] = 'aspf';
        }
//        var_export($names_arr);
        return $names_arr;
    }

    public function createXls($studyForms, $stat = false, $file_name_stat = "", $directory = "")
    {
        if (isset($studyForms)) {


            require_once(__DIR__ . '/../Http/Controllers/Classes/PHPExcel.php');
            require_once(__DIR__ . '/../Http/Controllers/Classes/PHPExcel/Writer/Excel5.php');

            // Создаем объект класса PHPExcel
            $xls = new PHPExcel();
// Устанавливаем индекс активного листа
            $xls->setActiveSheetIndex(0);
// Получаем активный лист
            $sheet = $xls->getActiveSheet();
// Подписываем лист
            $sheet->setTitle('Списки');

// Вставляем текст в ячейку A1
            $sheet->setCellValue("A1", '');
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1')->getFont()->setSize(14);
            $sheet->getRowDimension("1")->setRowHeight(80);
            $sheet->getStyle("A1")->getAlignment()->setWrapText(true);

// Объединяем ячейки
            $sheet->mergeCells('A1:M1');

// Выравнивание текста
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);;
            $c = 5;
            //ширина столбцов
            $sheet->getColumnDimension("A")->setWidth(8);
            $sheet->getColumnDimension("B")->setWidth(33);
            $sheet->getColumnDimension("C")->setWidth(15);
//            $sheet->getColumnDimension("D")->setWidth(13);
            $sheet->getColumnDimension("D")->setWidth(0); //убрать при возвращении сранного оригинала
            $sheet->getColumnDimension("E")->setWidth(17);
            $sheet->getColumnDimension("F")->setWidth(17);
            $sheet->getColumnDimension("G")->setWidth(17);
            $sheet->getColumnDimension("H")->setWidth(17);
            $sheet->getColumnDimension("I")->setWidth(11);
            $sheet->getColumnDimension("J")->setWidth(12);
            $sheet->getColumnDimension("K")->setWidth(12);
            $sheet->getColumnDimension("L")->setWidth(13);
            $sheet->getColumnDimension("M")->setWidth(13);

            $bg_green = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '006600')
                )
            );
            $bg_red = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ef1010')
                )
            );
            $border = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );
            $border_yellow = array(
                'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => 'f7ef00')
                    )
                )
            );
            foreach ($studyForms as $studyForm) {
                if (isset($studyForm->stat)) {
                    foreach ($studyForm->stat as $category) {
                        if (isset($category->preparationLevels)) {
                            foreach ($category->preparationLevels as $preparationLevel) {
                                if (isset($preparationLevel->faculties)) {
                                    foreach ($preparationLevel->faculties as $faculty) {
                                        $is_asp = false;
                                        if ($faculty->name == 'Аспирантура' || $faculty->name == 'Ординатура') {
                                            $is_asp = true;
                                        }
                                        if (isset($faculty->specialities)) {
                                            foreach ($faculty->specialities as $k0 => $speciality) {
                                                if (isset($speciality->specializations)) {
                                                    foreach ($speciality->specializations as $specialization) {
                                                        if (isset($specialization->competitions)) {
                                                            foreach ($specialization->competitions as $competition) {
                                                                if (isset($competition->admissionBases)) {
                                                                    foreach ($competition->admissionBases as $admissionBasis) {
//                                                        if (isset($specialization->admissionBases)) {
//                                                            foreach ($specialization->admissionBases as $admissionBasis) {
                                                                        //значение
                                                                        $sheet->setCellValueByColumnAndRow(0, $c, "Факультет / институт:");
                                                                        $sheet->setCellValueByColumnAndRow(0, $c + 1, "Направление подготовки / специальность:");
                                                                        $sheet->setCellValueByColumnAndRow(0, $c + 2, "Уровень подготовки:");
                                                                        //объединение
                                                                        $sheet->mergeCellsByColumnAndRow(0, $c, 3, $c);
                                                                        $sheet->mergeCellsByColumnAndRow(0, $c + 1, 3, $c + 1);
                                                                        $sheet->mergeCellsByColumnAndRow(0, $c + 2, 3, $c + 2);
                                                                        //
                                                                        $sheet->setCellValueByColumnAndRow(4, $c, $faculty->name);
                                                                        if ($specialization->name == '') {
                                                                            $spec_string = $speciality->name;
                                                                        } else {
                                                                            $spec_string = $speciality->name . '(' . $specialization->name . ')';
                                                                        }

                                                                        $sheet->setCellValueByColumnAndRow(4, $c + 1, $spec_string);
                                                                        $sheet->setCellValueByColumnAndRow(4, $c + 2, $preparationLevel->name);
                                                                        //жирность
                                                                        $sheet->getStyleByColumnAndRow(4, $c)->getFont()->setBold(true);
                                                                        $sheet->getStyleByColumnAndRow(4, $c + 1)->getFont()->setBold(true);
                                                                        $sheet->getStyleByColumnAndRow(4, $c + 2)->getFont()->setBold(true);

                                                                        $sheet->mergeCellsByColumnAndRow(4, $c, 6, $c);
                                                                        $sheet->mergeCellsByColumnAndRow(4, $c + 1, 6, $c + 1);
                                                                        $sheet->mergeCellsByColumnAndRow(4, $c + 2, 6, $c + 2);

                                                                        $sheet->setCellValueByColumnAndRow(7, $c, "Основание для поступления:");
                                                                        $sheet->setCellValueByColumnAndRow(7, $c + 1, "Форма обучения:");
                                                                        $sheet->setCellValueByColumnAndRow(7, $c + 2, "Категория приема:");

                                                                        $sheet->mergeCellsByColumnAndRow(7, $c, 8, $c);
                                                                        $sheet->mergeCellsByColumnAndRow(7, $c + 1, 8, $c + 1);
                                                                        $sheet->mergeCellsByColumnAndRow(7, $c + 2, 8, $c + 2);

                                                                        $sheet->setCellValueByColumnAndRow(9, $c, $admissionBasis->name);
                                                                        $sheet->setCellValueByColumnAndRow(9, $c + 1, $studyForm->name);
                                                                        $sheet->setCellValueByColumnAndRow(9, $c + 2, $category->name);

                                                                        $sheet->getStyleByColumnAndRow(9, $c)->getFont()->setBold(true);
                                                                        $sheet->getStyleByColumnAndRow(9, $c + 1)->getFont()->setBold(true);
                                                                        $sheet->getStyleByColumnAndRow(9, $c + 2)->getFont()->setBold(true);


                                                                        $sheet->mergeCellsByColumnAndRow(9, $c, 12, $c);
                                                                        $sheet->mergeCellsByColumnAndRow(9, $c + 1, 12, $c + 1);
                                                                        $sheet->mergeCellsByColumnAndRow(9, $c + 2, 12, $c + 2);
                                                                        if($admissionBasis->stage_title == NULL || $admissionBasis->stage_title == false) {
                                                                            $sheet->setCellValueByColumnAndRow(0, $c + 4, "Кол-во мест:");
                                                                            $sheet->setCellValueByColumnAndRow(4, $c + 4, $admissionBasis->freeSeatsNumber);
                                                                        }else{
                                                                            $sheet->setCellValueByColumnAndRow(0, $c + 4, $admissionBasis->stage_title);
                                                                            $sheet->setCellValueByColumnAndRow(4, $c + 4, $admissionBasis->stage);
                                                                        }
                                                                       /* if ($admissionBasis->stage != false && $admissionBasis->stage != NULL) {
                                                                            if ($admissionBasis->stage_title != false && $admissionBasis->stage_title != NULL) {
                                                                                $sheet->setCellValueByColumnAndRow(5, $c + 4, $admissionBasis->stage_title);
                                                                                $sheet->setCellValueByColumnAndRow(8, $c + 4, $admissionBasis->stage);
                                                                            }
                                                                        }*/

                                                                        $c = $c + 6;

                                                                        if (isset($admissionBasis->abiturs)) {
                                                                            //шапка таблицы
                                                                            $sheet->setCellValueByColumnAndRow(0, $c, "№ п/п");
                                                                            $sheet->mergeCellsByColumnAndRow(0, $c, 0, $c + 1);
                                                                            if($admissionBasis->abiturs->first()->snils_show == true){
                                                                                $sheet->setCellValueByColumnAndRow(1, $c, "СНИЛС/ ID абитуриента");
                                                                            }else{
                                                                                $sheet->setCellValueByColumnAndRow(1, $c, "Фамилия, имя, отчество");
                                                                            }

                                                                            $sheet->mergeCellsByColumnAndRow(1, $c, 1, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(2, $c, "Согласие на зачисление");
                                                                            $sheet->mergeCellsByColumnAndRow(2, $c, 2, $c + 1);
                                                                            $sheet->mergeCellsByColumnAndRow(2, $c, 3, $c); //убрать при возвращении сранного оригинала
//                                                            $sheet->setCellValueByColumnAndRow(3, $c, "Оригинал. Копия");
//                                                            $sheet->mergeCellsByColumnAndRow(3, $c, 3, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(4, $c, "Баллы по предметам");

//
                                                                            $kolvoSub = 0;
                                                                            foreach ($admissionBasis->abiturs->first()->score as $i => $sc) {
                                                                                $sheet->setCellValueByColumnAndRow($i + 4, $c + 1, $sc->subject->name);
                                                                                $kolvoSub++;
                                                                            }
                                                                            $sheet->mergeCellsByColumnAndRow(4, $c, 3 + $kolvoSub, $c);
                                                                            $sheet->setCellValueByColumnAndRow(4 + $kolvoSub, $c, "Сумма баллов за ЕГЭ/ВИ");
                                                                            $sheet->mergeCellsByColumnAndRow(4 + $kolvoSub, $c, 4 + $kolvoSub, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, "Сумма баллов за Индивидуальные Достижения");
                                                                            $sheet->mergeCellsByColumnAndRow(5 + $kolvoSub, $c, 5 + $kolvoSub, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, "Сумма конкурсных баллов");
                                                                            $sheet->mergeCellsByColumnAndRow(6 + $kolvoSub, $c, 6 + $kolvoSub, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Нуждаемость в общежитии");
                                                                            $sheet->mergeCellsByColumnAndRow(7 + $kolvoSub, $c, 7 + $kolvoSub, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(8 + $kolvoSub, $c, "Примечание 1");
                                                                            $sheet->mergeCellsByColumnAndRow(8 + $kolvoSub, $c, 8 + $kolvoSub, $c + 1);
                                                                            $sheet->setCellValueByColumnAndRow(9 + $kolvoSub, $c, "Примечание 2");
                                                                            $sheet->mergeCellsByColumnAndRow(9 + $kolvoSub, $c, 9 + $kolvoSub, $c + 1);


                                                                            $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c + 1)->applyFromArray($border);
                                                                            for ($i = 0; $i < 2; $i++) {
                                                                                $sheet->getRowDimension($c + $i)->setRowHeight(45);
                                                                                for ($j = 0; $j < 10 + $kolvoSub; $j++) {
                                                                                    $sheet->getStyleByColumnAndRow($j, $c + $i)->getAlignment()->setWrapText(true);
                                                                                    $sheet->getStyleByColumnAndRow($j, $c + $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                                                    $sheet->getStyleByColumnAndRow($j, $c + $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                                                                }
                                                                            }
                                                                            $c = $c + 2;
                                                                            //основная часть таблицы
                                                                            foreach ($admissionBasis->abiturs as $k => $abitur) {
                                                                                $sheet->setCellValueByColumnAndRow(0, $c, $k + 1);
                                                                                if($abitur->snils_show == true){
                                                                                    $sheet->setCellValueByColumnAndRow(1, $c, $abitur->student->snils2);
                                                                                }else{
                                                                                    $sheet->setCellValueByColumnAndRow(1, $c, $abitur->student->fio);
                                                                                }

                                                                                if ($abitur->acceptCount > 0) {
                                                                                    $sheet->setCellValueByColumnAndRow(2, $c, "✔");
                                                                                    $sheet->getStyleByColumnAndRow(2, $c)->applyFromArray($bg_green);
                                                                                    if ($abitur->acceptCount > 1) {
                                                                                        $sheet->getStyleByColumnAndRow(2, $c)->applyFromArray($bg_red);
                                                                                    }
                                                                                }
                                                                                $sheet->mergeCellsByColumnAndRow(2, $c, 3, $c); //убрать при возвращении сранного оригинала
//                                                                if ($abitur->original) {
//                                                                    $sheet->setCellValueByColumnAndRow(3, $c, "Оригинал");
//                                                                } else {
//                                                                    $sheet->setCellValueByColumnAndRow(3, $c, "Копия");
//                                                                }

                                                                                $kolvoSub = 0;
                                                                                $indAchVis = 0;
                                                                                foreach ($abitur->score as $o => $ab_sc) {
                                                                                    if ($ab_sc->score != 0) {
                                                                                        $indAchVis++;
                                                                                        $sheet->setCellValueByColumnAndRow($o + 4, $c, $ab_sc->score);
                                                                                    }
                                                                                    $kolvoSub++;
                                                                                }
                                                                                if ($abitur->summ != 0) {
                                                                                    $sheet->setCellValueByColumnAndRow(4 + $kolvoSub, $c, $abitur->summ);
                                                                                }
                                                                                if ($abitur->indAchievement != 0) {
                                                                                    if ($is_asp) {
                                                                                        if ($indAchVis != 0) {
                                                                                            $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, $abitur->indAchievement);
                                                                                        }
                                                                                    } else {
                                                                                        $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, $abitur->indAchievement);
                                                                                    }
                                                                                }
                                                                                if ($abitur->summContest != 0) {
                                                                                    if ($is_asp) {
                                                                                        if ($indAchVis != 0) {
                                                                                            $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, $abitur->summContest);
                                                                                        }
                                                                                    } else {
                                                                                        $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, $abitur->summContest);
                                                                                    }
                                                                                }
                                                                                if ($abitur->needHostel) {
                                                                                    $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Да");
                                                                                } else {
                                                                                    $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Нет");
                                                                                }
                                                                                $sheet->setCellValueByColumnAndRow(8 + $kolvoSub, $c, $abitur->notice1);
                                                                                $sheet->setCellValueByColumnAndRow(9 + $kolvoSub, $c, $abitur->notice2);

                                                                                $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c)->applyFromArray($border);

                                                                                if ($abitur->yellowline) {
                                                                                    $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c)->applyFromArray($border_yellow);
                                                                                }

                                                                                for ($j = 0; $j < 8 + $kolvoSub; $j++) {
                                                                                    if ($j != 1) {
                                                                                        $sheet->getStyleByColumnAndRow($j, $c)->getAlignment()->setWrapText(true);
                                                                                        $sheet->getStyleByColumnAndRow($j, $c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                                                        $sheet->getStyleByColumnAndRow($j, $c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                                                                                    }
                                                                                }

                                                                                $c++;
                                                                            }
                                                                            $c = $c + 2;
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
                            }
                        }
                    }
                }
            }

            $objWriter = new PHPExcel_Writer_Excel5($xls);
            if ($file_name_stat == "") {
                $file_name = mt_rand() / mt_getrandmax();
                $file_name = base_convert($file_name, 10, 36);
                $file_name2 = mt_rand() / mt_getrandmax();
                $file_name .= base_convert($file_name2, 10, 36);
                $file_name3 = mt_rand() / mt_getrandmax();
                $file_name .= base_convert($file_name3, 10, 36);
            } else {
                $file_name = $file_name_stat;
            }

            try {
//                        if($stat === true){
//                            $objWriter->save('E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files-xls-stat\\' . $file_name . '.xls');
//                        }else{
//                            $objWriter->save('E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files-xls\\' . $file_name . '.xls');
//                        }
                if ($stat === true && $directory != "") {
                    $objWriter->save(storage_path('app/public/files-xls-stat/') . $directory . '/' . $file_name . '.xls');
                } else {
                    $objWriter->save(storage_path('app/public/files-xls/') . $file_name . '.xls');
                }
            } catch (ErrorException $e) {
                echo $e;
            }
            return $file_name;
        }
    }

    public function createXlsDynamic($studyForms, $stat = false, $file_name_stat = "", $directory = "")
    {
        if (isset($studyForms)) {
            try {
                require_once(__DIR__ . '/../Http/Controllers/Classes/PHPExcel.php');
                require_once(__DIR__ . '/../Http/Controllers/Classes/PHPExcel/Writer/Excel5.php');

                // Создаем объект класса PHPExcel
                $xls = new PHPExcel();
// Устанавливаем индекс активного листа
                $xls->setActiveSheetIndex(0);
// Получаем активный лист
                $sheet = $xls->getActiveSheet();
// Подписываем лист
                $sheet->setTitle('Списки');

// Вставляем текст в ячейку A1
                $sheet->setCellValue("A1", '');
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getFont()->setSize(14);
                $sheet->getRowDimension("1")->setRowHeight(80);
                $sheet->getStyle("A1")->getAlignment()->setWrapText(true);

// Объединяем ячейки
                $sheet->mergeCells('A1:M1');

// Выравнивание текста
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);;
                $c = 5;
                //ширина столбцов
                $sheet->getColumnDimension("A")->setWidth(8);
                $sheet->getColumnDimension("B")->setWidth(33);
                $sheet->getColumnDimension("C")->setWidth(15);
//            $sheet->getColumnDimension("D")->setWidth(13);
                $sheet->getColumnDimension("D")->setWidth(0); //убрать при возвращении сранного оригинала
                $sheet->getColumnDimension("E")->setWidth(17);
                $sheet->getColumnDimension("F")->setWidth(17);
                $sheet->getColumnDimension("G")->setWidth(17);
                $sheet->getColumnDimension("H")->setWidth(17);
                $sheet->getColumnDimension("I")->setWidth(11);
                $sheet->getColumnDimension("J")->setWidth(12);
                $sheet->getColumnDimension("K")->setWidth(12);
                $sheet->getColumnDimension("L")->setWidth(13);
                $sheet->getColumnDimension("M")->setWidth(13);

                $bg_green = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '006600')
                    )
                );
                $bg_red = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ef1010')
                    )
                );
                $border = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    )
                );
                $border_yellow = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THICK,
                            'color' => array('rgb' => 'f7ef00')
                        )
                    )
                );
                foreach ($studyForms as $studyForm) {
                    if (isset($studyForm->stat)) {
                        foreach ($studyForm->stat as $category) {
                            if (isset($category->preparationLevels)) {
                                foreach ($category->preparationLevels as $preparationLevel) {
                                    if (isset($preparationLevel->faculties)) {
                                        foreach ($preparationLevel->faculties as $faculty) {
                                            $is_asp = false;
                                            if ($faculty->name == 'Аспирантура' || $faculty->name == 'Ординатура') {
                                                $is_asp = true;
                                            }
                                            if (isset($faculty->specialities)) {
                                                foreach ($faculty->specialities as $k0 => $speciality) {
                                                    if (isset($speciality->specializations)) {
                                                        foreach ($speciality->specializations as $specialization) {
                                                            if (isset($specialization->competitions)) {
                                                                foreach ($specialization->competitions as $competition) {
                                                                    if (isset($competition->admissionBases)) {
                                                                        foreach ($competition->admissionBases as $admissionBasis) {
                                                                            //значение
                                                                            $sheet->setCellValueByColumnAndRow(0, $c, "Факультет / институт:");
                                                                            $sheet->setCellValueByColumnAndRow(0, $c + 1, "Направление подготовки / специальность:");
                                                                            $sheet->setCellValueByColumnAndRow(0, $c + 2, "Уровень подготовки:");
                                                                            //объединение
                                                                            $sheet->mergeCellsByColumnAndRow(0, $c, 3, $c);
                                                                            $sheet->mergeCellsByColumnAndRow(0, $c + 1, 3, $c + 1);
                                                                            $sheet->mergeCellsByColumnAndRow(0, $c + 2, 3, $c + 2);
                                                                            //
                                                                            $sheet->setCellValueByColumnAndRow(4, $c, $faculty->name);
                                                                            if ($specialization->name == '') {
                                                                                $spec_string = $speciality->name;
                                                                            } else {
                                                                                $spec_string = $speciality->name . '(' . $specialization->name . ')';
                                                                            }

                                                                            $sheet->setCellValueByColumnAndRow(4, $c + 1, $spec_string);
                                                                            $sheet->setCellValueByColumnAndRow(4, $c + 2, $preparationLevel->name);
                                                                            //жирность
                                                                            $sheet->getStyleByColumnAndRow(4, $c)->getFont()->setBold(true);
                                                                            $sheet->getStyleByColumnAndRow(4, $c + 1)->getFont()->setBold(true);
                                                                            $sheet->getStyleByColumnAndRow(4, $c + 2)->getFont()->setBold(true);

                                                                            $sheet->mergeCellsByColumnAndRow(4, $c, 6, $c);
                                                                            $sheet->mergeCellsByColumnAndRow(4, $c + 1, 6, $c + 1);
                                                                            $sheet->mergeCellsByColumnAndRow(4, $c + 2, 6, $c + 2);

                                                                            $sheet->setCellValueByColumnAndRow(7, $c, "Основание для поступления:");
                                                                            $sheet->setCellValueByColumnAndRow(7, $c + 1, "Форма обучения:");
                                                                            $sheet->setCellValueByColumnAndRow(7, $c + 2, "Категория приема:");

                                                                            $sheet->mergeCellsByColumnAndRow(7, $c, 8, $c);
                                                                            $sheet->mergeCellsByColumnAndRow(7, $c + 1, 8, $c + 1);
                                                                            $sheet->mergeCellsByColumnAndRow(7, $c + 2, 8, $c + 2);

                                                                            $sheet->setCellValueByColumnAndRow(9, $c, $admissionBasis->name);
                                                                            $sheet->setCellValueByColumnAndRow(9, $c + 1, $studyForm->name);
                                                                            $sheet->setCellValueByColumnAndRow(9, $c + 2, $category->name);

                                                                            $sheet->getStyleByColumnAndRow(9, $c)->getFont()->setBold(true);
                                                                            $sheet->getStyleByColumnAndRow(9, $c + 1)->getFont()->setBold(true);
                                                                            $sheet->getStyleByColumnAndRow(9, $c + 2)->getFont()->setBold(true);


                                                                            $sheet->mergeCellsByColumnAndRow(9, $c, 12, $c);
                                                                            $sheet->mergeCellsByColumnAndRow(9, $c + 1, 12, $c + 1);
                                                                            $sheet->mergeCellsByColumnAndRow(9, $c + 2, 12, $c + 2);

                                                                            $sheet->setCellValueByColumnAndRow(0, $c + 4, "Кол-во мест:");
                                                                            $sheet->setCellValueByColumnAndRow(4, $c + 4, $admissionBasis->freeSeatsNumber);
                                                                            if ($admissionBasis->stage != false && $admissionBasis->stage != NULL) {
                                                                                if ($admissionBasis->stage_title != false && $admissionBasis->stage_title != NULL) {
                                                                                    $sheet->setCellValueByColumnAndRow(5, $c + 4, $admissionBasis->stage_title);
                                                                                    $sheet->setCellValueByColumnAndRow(8, $c + 4, $admissionBasis->stage);
                                                                                }
                                                                            }

                                                                            $c = $c + 6;

                                                                            if (isset($admissionBasis->abiturs)) {
                                                                                //шапка таблицы
                                                                                $sheet->setCellValueByColumnAndRow(0, $c, "№ п/п");
                                                                                $sheet->mergeCellsByColumnAndRow(0, $c, 0, $c + 1);
                                                                                if($admissionBasis->abiturs->first()->snils_show == true){
                                                                                    $sheet->setCellValueByColumnAndRow(1, $c, "СНИЛС / ID абитуриента");
                                                                                }else{
                                                                                    $sheet->setCellValueByColumnAndRow(1, $c, "Фамилия, имя, отчество");
                                                                                }
                                                                                $sheet->mergeCellsByColumnAndRow(1, $c, 1, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(2, $c, "Согласие на зачисление");
                                                                                $sheet->mergeCellsByColumnAndRow(2, $c, 2, $c + 1);
                                                                                $sheet->mergeCellsByColumnAndRow(2, $c, 3, $c); //убрать при возвращении сранного оригинала
//                                                            $sheet->setCellValueByColumnAndRow(3, $c, "Оригинал. Копия");
//                                                            $sheet->mergeCellsByColumnAndRow(3, $c, 3, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(4, $c, "Баллы по предметам");

//
                                                                                $kolvoSub = 0;

                                                                                if(mb_stristr($preparationLevel->name, "СПО")) {

                                                                                    $collection = StatisticAsp::hydrate($admissionBasis->abiturs);
                                                                                    $admissionBasis->abiturs = $collection;
                                                                                    foreach ($admissionBasis->abiturs->first()->score as $i => $sc) {

                                                                                        $sheet->setCellValueByColumnAndRow($i + 4, $c + 1, $sc->subject->name);
                                                                                        $kolvoSub++;
                                                                                    }
                                                                                }else {
                                                                                    foreach ($admissionBasis->subs as $i => $sc) {
                                                                                        $sheet->setCellValueByColumnAndRow($i + 4, $c + 1, $sc);
                                                                                        $kolvoSub++;
                                                                                    }
                                                                                }

//                                                                    var_dump($admissionBasis->abiturs);
//                                                                    return;

                                                                                $sheet->mergeCellsByColumnAndRow(4, $c, 3 + $kolvoSub, $c);
                                                                                $sheet->setCellValueByColumnAndRow(4 + $kolvoSub, $c, "Сумма баллов за ЕГЭ/ВИ");
                                                                                $sheet->mergeCellsByColumnAndRow(4 + $kolvoSub, $c, 4 + $kolvoSub, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, "Сумма баллов за Индивидуальные Достижения");
                                                                                $sheet->mergeCellsByColumnAndRow(5 + $kolvoSub, $c, 5 + $kolvoSub, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, "Сумма конкурсных баллов");
                                                                                $sheet->mergeCellsByColumnAndRow(6 + $kolvoSub, $c, 6 + $kolvoSub, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Нуждаемость в общежитии");
                                                                                $sheet->mergeCellsByColumnAndRow(7 + $kolvoSub, $c, 7 + $kolvoSub, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(8 + $kolvoSub, $c, "Примечание 1");
                                                                                $sheet->mergeCellsByColumnAndRow(8 + $kolvoSub, $c, 8 + $kolvoSub, $c + 1);
                                                                                $sheet->setCellValueByColumnAndRow(9 + $kolvoSub, $c, "Примечание 2");
                                                                                $sheet->mergeCellsByColumnAndRow(9 + $kolvoSub, $c, 9 + $kolvoSub, $c + 1);


                                                                                $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c + 1)->applyFromArray($border);
                                                                                for ($i = 0; $i < 2; $i++) {
                                                                                    $sheet->getRowDimension($c + $i)->setRowHeight(45);
                                                                                    for ($j = 0; $j < 10 + $kolvoSub; $j++) {
                                                                                        $sheet->getStyleByColumnAndRow($j, $c + $i)->getAlignment()->setWrapText(true);
                                                                                        $sheet->getStyleByColumnAndRow($j, $c + $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                                                        $sheet->getStyleByColumnAndRow($j, $c + $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                                                                    }
                                                                                }
                                                                                $c = $c + 2;
                                                                                //основная часть таблицы
                                                                                foreach ($admissionBasis->abiturs as $k => $abitur) {
                                                                                    $sheet->setCellValueByColumnAndRow(0, $c, $k + 1);
                                                                                    if($abitur->snils_show == true){
                                                                                        $sheet->setCellValueByColumnAndRow(1, $c, $abitur->student->snils2);
                                                                                    }else{
                                                                                        $sheet->setCellValueByColumnAndRow(1, $c, $abitur->student->fio);
                                                                                    }

                                                                                    if ($abitur->acceptCount > 0) {
                                                                                        $sheet->setCellValueByColumnAndRow(2, $c, "✔");
                                                                                        $sheet->getStyleByColumnAndRow(2, $c)->applyFromArray($bg_green);
                                                                                        if ($abitur->acceptCount > 1) {
                                                                                            $sheet->getStyleByColumnAndRow(2, $c)->applyFromArray($bg_red);
                                                                                        }
                                                                                    }
                                                                                    $sheet->mergeCellsByColumnAndRow(2, $c, 3, $c); //убрать при возвращении сранного оригинала
//                                                                if ($abitur->original) {
//                                                                    $sheet->setCellValueByColumnAndRow(3, $c, "Оригинал");
//                                                                } else {
//                                                                    $sheet->setCellValueByColumnAndRow(3, $c, "Копия");
//                                                                }

                                                                                    $kolvoSub = 0;
                                                                                    $indAchVis = 0;
                                                                                    foreach ($abitur->score as $o => $ab_sc) {
                                                                                        if ($ab_sc->score != 0) {
                                                                                            $indAchVis++;
                                                                                            $sheet->setCellValueByColumnAndRow($o + 4, $c, $ab_sc->score);
                                                                                        }
                                                                                        $kolvoSub++;
                                                                                    }
                                                                                    if ($abitur->summ != 0) {
                                                                                        $sheet->setCellValueByColumnAndRow(4 + $kolvoSub, $c, $abitur->summ);
                                                                                    }
                                                                                    if ($abitur->indAchievement != 0) {
                                                                                        if ($is_asp) {
                                                                                            if ($indAchVis != 0) {
                                                                                                $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, $abitur->indAchievement);
                                                                                            }
                                                                                        } else {
                                                                                            $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, $abitur->indAchievement);
                                                                                        }
                                                                                    }
                                                                                    if ($abitur->summContest != 0) {
                                                                                        if ($is_asp) {
                                                                                            if ($indAchVis != 0) {
                                                                                                $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, $abitur->summContest);
                                                                                            }
                                                                                        } else {
                                                                                            $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, $abitur->summContest);
                                                                                        }
                                                                                    }
                                                                                    if ($abitur->needHostel) {
                                                                                        $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Да");
                                                                                    } else {
                                                                                        $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Нет");
                                                                                    }
                                                                                    $sheet->setCellValueByColumnAndRow(8 + $kolvoSub, $c, $abitur->notice1);
                                                                                    $sheet->setCellValueByColumnAndRow(9 + $kolvoSub, $c, $abitur->notice2);

                                                                                    $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c)->applyFromArray($border);

                                                                                    if ($abitur->yellowline) {
                                                                                        $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c)->applyFromArray($border_yellow);
                                                                                    }

                                                                                    for ($j = 0; $j < 8 + $kolvoSub; $j++) {
                                                                                        if ($j != 1) {
                                                                                            $sheet->getStyleByColumnAndRow($j, $c)->getAlignment()->setWrapText(true);
                                                                                            $sheet->getStyleByColumnAndRow($j, $c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                                                            $sheet->getStyleByColumnAndRow($j, $c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                                                                                        }
                                                                                    }

                                                                                    $c++;
                                                                                }
                                                                                $c = $c + 2;
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
                                }
                            }
                        }
                    }
                }

                $objWriter = new PHPExcel_Writer_Excel5($xls);
                if ($file_name_stat == "") {
                    $file_name = mt_rand() / mt_getrandmax();
                    $file_name = base_convert($file_name, 10, 36);
                    $file_name2 = mt_rand() / mt_getrandmax();
                    $file_name .= base_convert($file_name2, 10, 36);
                    $file_name3 = mt_rand() / mt_getrandmax();
                    $file_name .= base_convert($file_name3, 10, 36);
                } else {
                    $file_name = $file_name_stat;
                }
            } catch (ErrorException $e) {
                echo $e;
                return $e;
            }

            try {
                if ($stat === true && $directory != "") {
                    $objWriter->save(storage_path('app/public/files-xls-stat/') . $directory . '/' . $file_name . '.xls');
                } else {
                    $objWriter->save(storage_path('app/public/files-xls/') . $file_name . '.xls');
                }
            } catch (ErrorException $e) {
                echo $e;
                return $e;
            }
            return $file_name;
        }
    }

    public function queryXls($q_category, $q_adm, $q_studyForm, $q_prepLevel, $file_name_stat = "", $modelName)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(1200);

        $names_arr = $this->makeModelsNames($modelName);

        if ($q_prepLevel != null) {
            $info_faculties = $names_arr['Statistic']::select('id_studyForm', 'id_category', 'id_admissionBasis', 'id_preparationLevel', 'id_speciality', 'id_competition', 'id_faculty')
                ->whereIn('id_category', $q_category)
                ->where('id_studyForm', $q_studyForm)
                ->whereIn('id_admissionBasis', $q_adm)
                ->whereIn('id_preparationLevel', $q_prepLevel)
                ->distinct()
                ->get();
        } else {
            $info_faculties = $names_arr['Statistic']::select('id_studyForm', 'id_category', 'id_admissionBasis', 'id_preparationLevel', 'id_speciality', 'id_competition', 'id_faculty')
                ->whereIn('id_category', $q_category)
                ->where('id_studyForm', $q_studyForm)
                ->whereIn('id_admissionBasis', $q_adm)
                ->distinct()
                ->get();
        }



        $id_forms_arr = array();
        $id_cat_arr = array();
        $id_adm_arr = array();
        $id_prep_arr = array();
        $id_spec_arr = array();
        $id_comp_arr = array();
        $id_fac_arr = array();

        foreach ($info_faculties as $stat) {
            $id_forms_arr[] = $stat->id_studyForm;
            $id_cat_arr[] = $stat->id_category;
            $id_adm_arr[] = $stat->id_admissionBasis;
            $id_prep_arr[] = $stat->id_preparationLevel;
            $id_spec_arr[] = $stat->id_speciality;
            $id_comp_arr[] = $stat->id_competition;
            $id_fac_arr[] = $stat->id_faculty;
        }
        $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
        $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
        $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
        $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);
        $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);
        $id_comp_arr = array_unique($id_comp_arr, SORT_REGULAR);
        $id_fac_arr = array_unique($id_fac_arr, SORT_REGULAR);


        $studyForms = StudyForm::whereIn('id', $id_forms_arr)->get();

        foreach ($studyForms as $k5 => $studyForm) {

            $categories = Category::whereIn('id', $id_cat_arr)->get();

            foreach ($categories as $k4 => $category) {

                $preparationLevels = PreparationLevel::whereIn('id', $id_prep_arr)->get();

                foreach ($preparationLevels as $k2 => $preparationLevel) {

                    //находим нужные нам факультеты их имена
                    $faculties = Faculty::whereIn('id', $id_fac_arr)->get();

                    foreach ($faculties as $k1 => $faculty) {
                        //для выбора названий специальностей
                        $specialities = Speciality::whereIn('id', $id_spec_arr)->get();

                        foreach ($specialities as $k0 => $speciality) {

                            $specializations = Specialization::where('id_speciality', '=', $speciality->id)->get();

                            if ($specializations->count() == 0) {
                                $specializations = collect(new Specialization);
                                //добавить в коллеекцию элемент

                                $element = Specialization::where('id', '=', 1)->first();
                                $element->id = 0;
                                $element->specializationId = '0';
                                $element->id_speciality = '0';
                                $element->name = '';

                                $specializations->push($element);
//                                        return $specializations;
                            } else {

                                $element = Specialization::where('id', '=', 1)->first();
                                $element->id = 0;
                                $element->specializationId = '0';
                                $element->id_speciality = '0';
                                $element->name = '';

                                $specializations->push($element);
//                                        return $specializations;
                            }

                            foreach ($specializations as $kend => $specialization) {

                                $cmp1 = $names_arr['Statistic']::
                                where('id_studyForm', '=', $studyForm->id)
                                    ->where('id_speciality', '=', $speciality->id)
                                    ->where('id_preparationLevel', '=', $preparationLevel->id)
                                    ->where('id_category', '=', $category->id)
                                    ->where('id_faculty', '=', $faculty->id)
                                    ->select('id_competition')
                                    ->get();

//                                var_dump($cmp1);
                                $id_comp_arr = array();
                                foreach ($cmp1 as $stat) {
                                    $id_comp_arr[] = $stat->id_competition;
                                }
                                $id_comp_arr = array_unique($id_comp_arr, SORT_REGULAR);

//                                if(count($id_comp_arr) != 0) {
//                                    var_dump($id_comp_arr);
//                                    echo('||||||||||||||');
//                                }
                                $competitions = $names_arr['Competition']::whereIn('id', $id_comp_arr)->get();

                                foreach ($competitions as $k6 => $competition) {


                                    $admissionBases = AdmissionBasis::whereIn('id', $id_adm_arr)->get();

                                    //самая костыльная сортировка на свете
                                    $newadm = collect(new AdmissionBasis);
                                    foreach ($admissionBases as $k3 => $admissionBasis) {
                                        if ($admissionBasis->name == "Особое право") {
                                            $element0 = AdmissionBasis::where('name', '=', "Особое право")->first();
                                        }
                                        if ($admissionBasis->name == "Целевой прием") {
                                            $element1 = AdmissionBasis::where('name', '=', "Целевой прием")->first();
                                        }
                                        if ($admissionBasis->name == "Бюджетная основа") {
                                            $element2 = AdmissionBasis::where('name', '=', "Бюджетная основа")->first();
                                        }
                                        if ($admissionBasis->name == "Полное возмещение затрат") {
                                            $element3 = AdmissionBasis::where('name', '=', "Полное возмещение затрат")->first();
                                        }
                                    }

                                    if (isset($element0)) {
                                        $newadm->push($element0);
                                    }
                                    if (isset($element1)) {
                                        $newadm->push($element1);
                                    }
                                    if (isset($element2)) {
                                        $newadm->push($element2);
                                    }
                                    if (isset($element3)) {
                                        $newadm->push($element3);
                                    }

                                    $admissionBases = $newadm;
                                    foreach ($admissionBases as $k3 => $admissionBasis) {
                                        if ($specialization->id == 0) {
                                            $spez_id = null;
                                        } else {
                                            $spez_id = $specialization->id;
                                        }

                                        $temp = $names_arr['Statistic']::where('id_studyForm', '=', $studyForm->id)
                                            ->where('id_speciality', '=', $speciality->id)
                                            ->where('id_specialization', '=', $spez_id)
                                            ->where('id_preparationLevel', '=', $preparationLevel->id)
                                            ->where('id_admissionBasis', '=', $admissionBasis->id)
                                            ->where('id_category', '=', $category->id)
                                            ->where('id_faculty', '=', $faculty->id)
                                            ->where('id_competition', '=', $competition->id)
                                            ->get();


                                        $id_plan_c = $names_arr['PlanCompetition']::where('id_competition', '=', $competition->id)->first();
                                        if (!empty($id_plan_c)) {
                                            $idPlan = $names_arr['Plan']::where('id_speciality', '=', $speciality->id)
                                                ->where('id_studyForm', '=', $studyForm->id)
                                                ->where('id_specialization', '=', $spez_id)
                                                ->where('id_faculty', '=', $faculty->id)
                                                ->where('id', $id_plan_c->id_plan)
                                                ->first();
                                        }

                                        if (isset($idPlan)) {
                                            if (!empty($idPlan)) {
//                                        $id_plan_comps = PlanCompetition::where('id_plan', '=', intval($idPlan->id))->first();
                                                $id_plan_comps = $names_arr['PlanCompetition']::where('id_competition', '=', intval($competition->id))->first();

                                                if (!empty($id_plan_comps)) {
                                                    $freeSeatsNumber = $names_arr['Freeseats']::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                                    where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                                }
                                            }
                                        }

                                        if ($temp->count()) {
                                            $admissionBasis->abiturs = $temp; //добавляем запись
                                            $temp_stage = $temp->first();

                                            $stage = $temp_stage->stage;
                                            /*if ($stage[0] == '(') {
                                                $stage = substr($stage, 1, -1);
                                            }*/
                                            $admissionBasis->stage = $stage;

                                            $stage_title = $temp_stage->stage_title;
                                            if ($stage_title[0] == '(') {
                                                $stage_title = substr($stage_title, 1, -1);
                                            }
                                            $admissionBasis->stage_title = $stage_title;

                                            $originalsCount = 0;
                                            foreach ($temp as $student) {
                                                if ($student->original == true) {
                                                    $originalsCount += 1;
                                                }
                                            }
                                            if (!empty($freeSeatsNumber)) {
                                                $admissionBasis->freeSeatsNumber = $freeSeatsNumber->value;
                                                if ($freeSeatsNumber->value != 0) {
                                                    $admissionBasis->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->value, 2);
                                                }
                                            } else {
                                                $admissionBasis->originalsCount = null;
                                                $admissionBasis->freeSeatsNumber = null;
                                            }
                                        } else {
                                            $admissionBasis->abiturs = null;
                                        }
                                        if (empty($admissionBasis->abiturs)) {
                                            unset($admissionBases[$k3]);
                                        }
                                    }
//
                                    $admissionBases->count() ? $competition->admissionBases = $admissionBases : null;
                                    if (empty($competition->admissionBases)) {
                                        unset($competitions[$k6]);
                                    }
                                }
                                $competitions->count() ? $specialization->competitions = $competitions : null; //В любом случае не пустые
                                if (empty($specialization->competitions)) {
                                    unset($specializations[$kend]);
                                }
                            }
                            $specializations->count() ? $speciality->specializations = $specializations : null; //В любом случае не пустые
                            if (empty($speciality->specializations)) {
                                unset($specialities[$k0]);
                            }
                        }
                        $specialities->count() ? $faculty->specialities = $specialities : null; //В любом случае не пустые
                        if (empty($faculty->specialities)) {
                            unset($faculties[$k1]);
                        }
                    }
                    $faculties->count() ? $preparationLevel->faculties = $faculties : null;
                    if (empty($preparationLevel->faculties)) {
                        unset($preparationLevels[$k2]);
                    }
                }
                $preparationLevels->count() ? $category->preparationLevels = $preparationLevels : null;
                if (empty($category->preparationLevels)) {
                    unset($categories[$k4]);
                }
            }
            $categories->count() ? $studyForm->stat = $categories : null;
            if (empty($studyForm->stat)) {
                unset($studyForms[$k5]);
            }
        }

        $this->createXls($studyForms, true, $file_name_stat, $names_arr['folder']);
    }

    public function XlsBach()
    {
        $this->queryXls([1], [3], 1, null, "Очная форма, бюджет", 'Statistic');
        $this->queryXls([1], [6], 1, null, "Очная форма, особое право", 'Statistic');
        $this->queryXls([1], [8, 9, 10], 1, null, "Очная форма, целевое обучение", 'Statistic');

       // $this->queryXls([2], [3], 1, null, "Очная форма, без вступительных испытаний", 'Statistic');

        $this->queryXls([1], [3], 3, null, "Заочная форма, бюджет", 'Statistic');
        $this->queryXls([1], [6], 3, null, "Заочная форма, особое право", 'Statistic');
        $this->queryXls([1], [8, 9, 10], 3, null, "Заочная форма, целевое обучение", 'Statistic');

        $this->queryXls([1], [3], 2, null, "Очно-заочная форма, бюджет", 'Statistic');
        $this->queryXls([1], [6], 2, null, "Очно-заочная форма, особое право", 'Statistic');
    }

    public function XlsMaster()
    {
        $this->queryXls([1], [3], 1, null, "Очная форма, бюджет", 'StatisticMaster');
        $this->queryXls([1], [8, 9, 10], 1, null, "Очная форма, целевое обучение", 'StatisticMaster');
        $this->queryXls([1], [3], 3, null, "Заочная форма, бюджет", 'StatisticMaster');
        $this->queryXls([1], [3], 2, null, "Очно-заочная форма, бюджет", 'StatisticMaster');
    }

    public function XlsAsp()
    {
        $this->queryXls([1], [3], 1, [6], "Очная форма, бюджет, аспирантура", 'StatisticAsp');
        $this->queryXls([1], [3], 1, [7], "Очная форма, бюджет, ординатура", 'StatisticAsp');
    }

    public function XlsSpo()
    {
        $this->queryXls([1, 2], [3], 1, null, "Очная форма, бюджет", 'StatisticSpo');
    }

    //иностранцы
    public function XlsBachForeigner()
    {
        $this->queryXls([1], [7], 1, null, "Очная форма, полное возмещение затрат", 'StatisticForeigner');
        $this->queryXls([1], [7], 3, null, "Заочная форма, полное возмещение затрат", 'StatisticForeigner');
        $this->queryXls([1], [7], 2, null, "Очно-заочная форма, полное возмещение затрат", 'StatisticForeigner');

    }

    public function XlsMasterForeigner()
    {
        $this->queryXls([1], [7], 1, null, "Очная форма, полное возмещение затрат", 'StatisticMasterForeigner');
        $this->queryXls([1], [7], 3, null, "Заочная форма, полное возмещение затрат", 'StatisticMasterForeigner');
        $this->queryXls([1], [7], 2, null, "Очно-заочная форма, полное возмещение затрат", 'StatisticMasterForeigner');
    }

    public function XlsAspForeigner()
    {
        $this->queryXls([1], [7], 1, [6], "Очная форма, полное возмещение затрат, аспирантура", 'StatisticAspForeigner');
        $this->queryXls([1], [7], 1, [7], "Очная форма, полное возмещение затрат, ординатура", 'StatisticAspForeigner');
    }
}
