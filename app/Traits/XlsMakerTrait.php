<?php

namespace App\Traits;

use App\AdmissionBasis;
use App\Category;
use App\Faculty;
use App\Freeseats_bases;
use App\Freeseats_basesMaster;
use App\Plan;
use App\PlanCompetition;
use App\PlanCompetitionMaster;
use App\PlanMaster;
use App\PreparationLevel;
use App\Speciality;
use App\Statistic;
use App\StatisticMaster;
use App\StudyForm;
use ErrorException;
use PHPExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Font;
use PHPExcel_Style;
use PHPExcel_Writer_Excel5;

trait XlsMakerTrait
{
    public function createXls($studyForms, $stat = false, $file_name_stat = "")
    {
        if (isset($studyForms)) {


            require_once (__DIR__.'\..\Http\Controllers\Classes\PHPExcel.php');
            require_once(__DIR__.'\..\Http\Controllers\Classes\PHPExcel\Writer\Excel5.php');

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
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1')->getFont()->setSize(14);
            $sheet->getRowDimension("1")->setRowHeight(80);
            $sheet->getStyle("A1")->getAlignment()->setWrapText(true);

//

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
            $sheet->getColumnDimension("D")->setWidth(13);
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
                                                    foreach ($faculty->specialities as $k0 => $speciality) {

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
                                                        $sheet->setCellValueByColumnAndRow(4, $c + 1, $speciality->name);
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
                                                        $sheet->setCellValueByColumnAndRow(4, $c + 4, $speciality->freeSeatsNumber);

                                                        $c = $c + 6;

                                                        if (isset($speciality->abiturs)) {
                                                            //шапка таблицы
                                                            $sheet->setCellValueByColumnAndRow(0, $c, "№ п/п");
                                                            $sheet->mergeCellsByColumnAndRow(0, $c, 0, $c + 1);
                                                            $sheet->setCellValueByColumnAndRow(1, $c, "Фамилия, имя, отчество");
                                                            $sheet->mergeCellsByColumnAndRow(1, $c, 1, $c + 1);
                                                            $sheet->setCellValueByColumnAndRow(2, $c, "Согласие на зачисление");
                                                            $sheet->mergeCellsByColumnAndRow(2, $c, 2, $c + 1);
                                                            $sheet->setCellValueByColumnAndRow(3, $c, "Оригинал. Копия");
                                                            $sheet->mergeCellsByColumnAndRow(3, $c, 3, $c + 1);
                                                            $sheet->setCellValueByColumnAndRow(4, $c, "Баллы по предметам");

//
                                                            $kolvoSub = 0;
                                                            foreach ($speciality->abiturs->first()->score as $i => $sc) {
                                                                $sheet->setCellValueByColumnAndRow($i + 4, $c + 1, $sc->subject->name);
                                                                $kolvoSub++;
                                                            }
                                                            $sheet->mergeCellsByColumnAndRow(4, $c, 3+$kolvoSub, $c);
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
                                                            foreach ($speciality->abiturs as $k => $abitur) {
                                                                $sheet->setCellValueByColumnAndRow(0, $c, $k + 1);
                                                                $sheet->setCellValueByColumnAndRow(1, $c, $abitur->student->fio);
                                                                if ($abitur->accept) {
                                                                    $sheet->setCellValueByColumnAndRow(2, $c, "✔");
                                                                    $sheet->getStyleByColumnAndRow(2, $c)->applyFromArray($bg_green);
                                                                    if ($abitur->acceptCount > 0) {
                                                                        $sheet->getStyleByColumnAndRow(2, $c)->applyFromArray($bg_red);
                                                                    }
                                                                }
                                                                if ($abitur->original) {
                                                                    $sheet->setCellValueByColumnAndRow(3, $c, "Оригинал");
                                                                } else {
                                                                    $sheet->setCellValueByColumnAndRow(3, $c, "Копия");
                                                                }

                                                                $kolvoSub = 0;
                                                                foreach ($abitur->score as $o => $ab_sc) {
                                                                    if ($ab_sc->score != 0)
                                                                        $sheet->setCellValueByColumnAndRow($o + 4, $c, $ab_sc->score);
                                                                    $kolvoSub++;
                                                                }
                                                                if ($abitur->summ != 0) {
                                                                    $sheet->setCellValueByColumnAndRow(4 + $kolvoSub, $c, $abitur->summ);
                                                                }
                                                                if ($abitur->indAchievement != 0) {
                                                                    $sheet->setCellValueByColumnAndRow(5 + $kolvoSub, $c, $abitur->indAchievement);
                                                                }
                                                                if ($abitur->summContest != 0) {
                                                                    $sheet->setCellValueByColumnAndRow(6 + $kolvoSub, $c, $abitur->summContest);
                                                                }
                                                                if ($abitur->needHostel) {
                                                                    $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Да");
                                                                } else {
                                                                    $sheet->setCellValueByColumnAndRow(7 + $kolvoSub, $c, "Нет");
                                                                }
                                                                $sheet->setCellValueByColumnAndRow(8 + $kolvoSub, $c, $abitur->notice1);
                                                                $sheet->setCellValueByColumnAndRow(9 + $kolvoSub, $c, $abitur->notice2);

                                                                $sheet->getStyleByColumnAndRow(0, $c, 9 + $kolvoSub, $c)->applyFromArray($border);

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


                    $objWriter = new PHPExcel_Writer_Excel5($xls);
                    if($file_name_stat=="") {
                        $file_name = mt_rand() / mt_getrandmax();
                        $file_name = base_convert($file_name, 10, 36);
                        $file_name2 = mt_rand() / mt_getrandmax();
                        $file_name .= base_convert($file_name2, 10, 36);
                        $file_name3 = mt_rand() / mt_getrandmax();
                        $file_name .= base_convert($file_name3, 10, 36);
                    }
                    else{
                        $file_name=$file_name_stat;
                    }

                    try {
//                        if($stat === true){
//                            $objWriter->save('E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files-xls-stat\\' . $file_name . '.xls');
//                        }else{
//                            $objWriter->save('E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files-xls\\' . $file_name . '.xls');
//                        }
                        if($stat === true){
                            $objWriter->save(storage_path('app/public/files-xls-stat/') . $file_name . '.xls');
                        }else{
                            $objWriter->save(storage_path('app/public/files-xls/') . $file_name . '.xls');
                        }
                    } catch (ErrorException $e) {
                        echo $e;
                    }
                    return $file_name;
                }
            }
        }
    }

    public function queryXlsBach($q_category, $q_adm, $q_studyForm, $file_name_stat = ""){
        ini_set('memory_limit', '1024M');
        set_time_limit(1200);

        //если запросили по факультетам или спец
//        if (!empty($search_faculties)) {
            $info_faculties = Statistic::select('id_studyForm', 'id_category', 'id_admissionBasis', 'id_preparationLevel', 'id_speciality')
                ->distinct()
                ->get();

            $id_forms_arr = array();
            $id_cat_arr = array();
            $id_adm_arr = array();
            $id_prep_arr = array();
            $id_spec_arr = array();
            foreach ($info_faculties as $stat) {
                $id_forms_arr[] = $stat->id_studyForm;
                $id_cat_arr[] = $stat->id_category;
                $id_adm_arr[] = $stat->id_admissionBasis;
                $id_prep_arr[] = $stat->id_preparationLevel;
                $id_spec_arr[] = $stat->id_speciality;
            }
            $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
            $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
            $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
            $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);

//            if (!empty($search_specialities_arr)) {
//                $id_spec_arr = array_intersect($id_spec_arr, $search_specialities_arr);
//            }
            $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);
            //var_dump($id_spec_arr);

            if (!empty($q_studyForm)) {
                $studyForms = StudyForm::where('id', '=', $q_studyForm)
                    ->whereIn('id', $id_forms_arr)
                    ->get();

            } else {
                $studyForms = StudyForm::whereIn('id', $id_forms_arr)->get();
            }

            foreach ($studyForms as $k5 => $studyForm) {
//                $categories = Category::whereIn('id', $id_cat_arr)->get();
                $categories = Category::whereIn('id', $q_category)->get();

                foreach ($categories as $k4 => $category) {
//                    $admissionBases = AdmissionBasis::whereIn('id', $id_adm_arr)->get();
                    $admissionBases = AdmissionBasis::whereIn('id', $q_adm)->get();
                    foreach ($admissionBases as $k3 => $admissionBasis) {
                        $preparationLevels = PreparationLevel::whereIn('id', $id_prep_arr)->get();

                        foreach ($preparationLevels as $k2 => $preparationLevel) {
                            //находим нужные нам факультеты их имена
                            $faculties = Faculty::all();

                            foreach ($faculties as $k1 => $faculty) {

                                //для выбора названий специальностей
                                $specialities = Speciality::whereIn('id', $id_spec_arr)->get();
                                foreach ($specialities as $k0 => $speciality) {
                                    $temp = Statistic::where('id_studyForm', '=', $studyForm->id)
                                        ->where('id_speciality', '=', $speciality->id)
                                        ->where('id_preparationLevel', '=', $preparationLevel->id)
                                        ->where('id_admissionBasis', '=', $admissionBasis->id)
                                        ->where('id_category', '=', $category->id)
                                        ->where('id_faculty', '=', $faculty->id)
                                        ->get();

                                    $idPlan = Plan::where('id_speciality', '=', $speciality->id)
                                        ->where('id_studyForm', '=', $studyForm->id)
                                        ->first();
                                    if (!empty($idPlan)) {
                                        $id_plan_comps = PlanCompetition::where('id_plan', '=', intval($idPlan->id))->first();
                                        if (!empty($id_plan_comps)) {
                                            $freeSeatsNumber = Freeseats_bases::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                            where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                        }
                                    }

                                    if ($temp->count()) {
                                        $speciality->abiturs = $temp; //добавляем запись

                                        $originalsCount = 0;
                                        foreach ($temp as $student) {
                                            if ($student->original == true) {
                                                $originalsCount += 1;
                                            }
                                        }
                                        if (!empty($freeSeatsNumber)) {
                                            $speciality->freeSeatsNumber = $freeSeatsNumber->value;
                                            if ($freeSeatsNumber->value != 0) {
                                                $speciality->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->value, 2);
                                            }
                                        } else {
                                            $speciality->originalsCount = null;
                                            $speciality->freeSeatsNumber = null;
                                        }
                                    } else {
                                        $speciality->abiturs = null;
                                    }
                                    if (empty($speciality->abiturs)) {
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
                        $preparationLevels->count() ? $admissionBasis->preparationLevels = $preparationLevels : null;
                        if (empty($admissionBasis->preparationLevels)) {
                            unset($admissionBases[$k3]);
                        }
                    }
                    $admissionBases->count() ? $category->admissionBases = $admissionBases : null;
                    if (empty($category->admissionBases)) {
                        unset($categories[$k4]);
                    }
                }
                $categories->count() ? $studyForm->stat = $categories : null;
                if (empty($studyForm->stat)) {
                    unset($studyForms[$k5]);
                }
            }
//        }
//        return $studyForms;
//        echo "query ".$q_category. " ". $q_adm. " ". $q_studyForm;
        $this->createXls($studyForms, true, $file_name_stat);
    }

    public function queryXlsMaster($q_category, $q_adm, $q_studyForm, $file_name_stat = ""){
        ini_set('memory_limit', '1024M');
        set_time_limit(1200);

        //если запросили по факультетам или спец
//        if (!empty($search_faculties)) {
        $info_faculties = StatisticMaster::select('id_studyForm', 'id_category', 'id_admissionBasis', 'id_preparationLevel', 'id_speciality')
            ->distinct()
            ->get();

        $id_forms_arr = array();
        $id_cat_arr = array();
        $id_adm_arr = array();
        $id_prep_arr = array();
        $id_spec_arr = array();
        foreach ($info_faculties as $stat) {
            $id_forms_arr[] = $stat->id_studyForm;
            $id_cat_arr[] = $stat->id_category;
            $id_adm_arr[] = $stat->id_admissionBasis;
            $id_prep_arr[] = $stat->id_preparationLevel;
            $id_spec_arr[] = $stat->id_speciality;
        }
        $id_forms_arr = array_unique($id_forms_arr, SORT_REGULAR);
        $id_cat_arr = array_unique($id_cat_arr, SORT_REGULAR);
        $id_adm_arr = array_unique($id_adm_arr, SORT_REGULAR);
        $id_prep_arr = array_unique($id_prep_arr, SORT_REGULAR);

//            if (!empty($search_specialities_arr)) {
//                $id_spec_arr = array_intersect($id_spec_arr, $search_specialities_arr);
//            }
        $id_spec_arr = array_unique($id_spec_arr, SORT_REGULAR);
        //var_dump($id_spec_arr);

        if (!empty($q_studyForm)) {
            $studyForms = StudyForm::where('id', '=', $q_studyForm)
                ->whereIn('id', $id_forms_arr)
                ->get();

        } else {
            $studyForms = StudyForm::whereIn('id', $id_forms_arr)->get();
        }

        foreach ($studyForms as $k5 => $studyForm) {
//                $categories = Category::whereIn('id', $id_cat_arr)->get();
            $categories = Category::whereIn('id', $q_category)->get();

            foreach ($categories as $k4 => $category) {
//                    $admissionBases = AdmissionBasis::whereIn('id', $id_adm_arr)->get();
                $admissionBases = AdmissionBasis::whereIn('id', $q_adm)->get();
                foreach ($admissionBases as $k3 => $admissionBasis) {
                    $preparationLevels = PreparationLevel::whereIn('id', $id_prep_arr)->get();

                    foreach ($preparationLevels as $k2 => $preparationLevel) {
                        //находим нужные нам факультеты их имена
                        $faculties = Faculty::all();

                        foreach ($faculties as $k1 => $faculty) {

                            //для выбора названий специальностей
                            $specialities = Speciality::whereIn('id', $id_spec_arr)->get();
                            foreach ($specialities as $k0 => $speciality) {
                                $temp = StatisticMaster::where('id_studyForm', '=', $studyForm->id)
                                    ->where('id_speciality', '=', $speciality->id)
                                    ->where('id_preparationLevel', '=', $preparationLevel->id)
                                    ->where('id_admissionBasis', '=', $admissionBasis->id)
                                    ->where('id_category', '=', $category->id)
                                    ->where('id_faculty', '=', $faculty->id)
                                    ->get();

                                $idPlan = PlanMaster::where('id_speciality', '=', $speciality->id)
                                    ->where('id_studyForm', '=', $studyForm->id)
                                    ->first();
                                if (!empty($idPlan)) {
                                    $id_plan_comps = PlanCompetitionMaster::where('id_plan', '=', intval($idPlan->id))->first();
                                    if (!empty($id_plan_comps)) {
                                        $freeSeatsNumber = Freeseats_basesMaster::where('id_plan_comp', '=', intval($id_plan_comps->id))->
                                        where('id_admissionBasis', '=', intval($admissionBasis->id))->first();
                                    }
                                }

                                if ($temp->count()) {
                                    $speciality->abiturs = $temp; //добавляем запись

                                    $originalsCount = 0;
                                    foreach ($temp as $student) {
                                        if ($student->original == true) {
                                            $originalsCount += 1;
                                        }
                                    }
                                    if (!empty($freeSeatsNumber)) {
                                        $speciality->freeSeatsNumber = $freeSeatsNumber->value;
                                        if ($freeSeatsNumber->value != 0) {
                                            $speciality->originalsCount = round(floatval($originalsCount) / $freeSeatsNumber->value, 2);
                                        }
                                    } else {
                                        $speciality->originalsCount = null;
                                        $speciality->freeSeatsNumber = null;
                                    }
                                } else {
                                    $speciality->abiturs = null;
                                }
                                if (empty($speciality->abiturs)) {
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
                    $preparationLevels->count() ? $admissionBasis->preparationLevels = $preparationLevels : null;
                    if (empty($admissionBasis->preparationLevels)) {
                        unset($admissionBases[$k3]);
                    }
                }
                $admissionBases->count() ? $category->admissionBases = $admissionBases : null;
                if (empty($category->admissionBases)) {
                    unset($categories[$k4]);
                }
            }
            $categories->count() ? $studyForm->stat = $categories : null;
            if (empty($studyForm->stat)) {
                unset($studyForms[$k5]);
            }
        }
//        }
//        return $studyForms;
        $this->createXls($studyForms, true, $file_name_stat);
    }

    public function XlsBach(){
        $this->queryXlsBach([1], [3], 1, "Списки_Очно_Бюджет_БакалавриатСпециалитет");
        $this->queryXlsBach([1], [6], 1, "Списки_Очно_ОсобоеПраво_БакалавриатСпециалитет");
        $this->queryXlsBach([1], [8, 9, 10], 1, "Списки_Очно_ЦелевоеОбучение_БакалавриатСпециалитет");

        $this->queryXlsBach([1], [3], 3, "Списки_Заочно_Бюджет_БакалавриатСпециалитет");
        $this->queryXlsBach([1], [6], 3, "Списки_Заочно_ОсобоеПраво_БакалавриатСпециалитет");
        $this->queryXlsBach([1], [8, 9, 10], 3, "Списки_Заочно_ЦелевоеОбучение_БакалавриатСпециалитет");

        $this->queryXlsBach([1], [3], 2, "Списки_Очно-заочно_Бюджет_БакалавриатСпециалитет");
        $this->queryXlsBach([1], [6], 2, "Списки_Очно-заочно_ОсобоеПраво_БакалавриатСпециалитет");
    }

    public function XlsMaster(){
        $this->queryXlsMaster([1], [3], 1, "Списки_Очно_Бюджет_Магистратура");
        $this->queryXlsMaster([1], [8, 9, 10], 1, "Списки_Очно_ЦелевоеОбучение_Магистратура");
        $this->queryXlsMaster([1], [3], 3, "Списки_Заочно_Бюджет_Магистратура");
        $this->queryXlsMaster([1], [3], 2, "Списки_Очно-заочно_Бюджет_Магистратура");
    }
}
