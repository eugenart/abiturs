<?php

namespace App\Http\Controllers;

use App\Archive;
use App\ArchiveInfoblock;
use App\Infoblock;
use App\Section;
use App\SectionsContent;
use App\Statistic;
use App\StatisticAsp;
use App\StatisticAspForeigner;
use App\StatisticForeigner;
use App\StatisticMaster;
use App\StatisticMasterForeigner;
use App\StatisticSpo;
use App\SupDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CleansingController extends Controller
{
    public function index(Request $request)
    {
        return view('structure.cleansing');
    }

    public function storeInfoblock()
    {
        $fileName = 'default.jpg';
        $year = SupDetail::find(1);
        $name = 'Приказы о зачислении '.$year->year_of_company;
        $check = Infoblock::where('name', '=', $name)->first();

        if (!isset($check)) {
            $infoblock = Infoblock::create([
                'name' => $name,
                'url' => 'Prikazi-'.$year->year_of_company,
                'menu' => 0,
                'menuPriority' => 500,
                'startPage' => 0,
                'startPagePriority' => 500,
                'activity' => 1,
                'activityFrom' => null,
                'activityTo' => null,
                'image' => $fileName ? $fileName : null,
                'news' => array(),
                'foreigner' => 0,
                'archive' => 1,
            ]);
            $archive = Archive::orderBy('id', 'desc')->first();
            $inf_arch = new ArchiveInfoblock;
            $inf_arch->id_archive = $archive->id;
            $inf_arch->id_infoblock = $infoblock->id;
            $inf_arch->save();
            return $infoblock;
        }
    }

    public function storeSection($name, $url, $infoblock)
    {

        $check = Section::where('name', '=', $name)->where('infoblockID', '=', $infoblock->id)->first();
        if (!isset($check)) {
            $section = Section::create([
                'name' => $name,
                'url' => $url,
                'description' => null,
                'startPage' => 0,
                'startPagePriority' => 500,
                'activity' => 1,
                'activityFrom' => null,
                'activityTo' => null,
                'sectionID' => null,
                'infoblockID' => $infoblock->id,
                'isFolder' => 0,
                'real_link' => $infoblock->url . '_' . $url
            ]);
            return $section;
        }

    }

    public function clean_orders()
    {
        $subdirs = [
            'БАКАЛАВРИАТ И СПЕЦИАЛИТЕТ' => 'bach',
            'МАГИСТРАТУРА' => 'master',
            'Аспирантура' => 'asp',
            'ОРДИНАТУРА' => 'ord',
            'СРЕДНЕЕ ПРОФЕССИОНАЛЬНОЕ ОБРАЗОВАНИЕ' => 'spo',
            'ИНОСТРАННЫЕ АБИТУРИЕНТЫ' => 'foreigner',
            'ПРИКАЗЫ ОБ ОТМЕНЕ ЗАЧИСЛЕНИЯ' => 'cancel',
            'Другое' => 'other',
        ];
        $infoblock = $this->storeInfoblock();
        $position_g = 1;
        foreach ($subdirs as $name => $sdir) {
            if ($dir = scandir(storage_path('app/public/orders/' . $sdir))) {
                $section = $this->storeSection($name, $sdir, $infoblock);

                $group = SectionsContent::create([
                    'section_id' => $section->id,
                    'name' => '',
                    'type' => 'files',
                    'position' => $position_g,
                ]);
                $position_g++;
                $files = array();
                $position = 1;
                foreach ($dir as $file) {
                    if ($file == "." || $file == "..") {
                        continue;
                    }
                    $newfile = storage_path('app/public/section-files/' . $file);
                    $old_file = storage_path('app/public/orders/' . $sdir . '/' . $file);
                    if (copy($old_file, $newfile)) {
                        $path_parts  =pathinfo(storage_path('app/public/orders/' . $sdir . '/' . $file));
                        $extension = $path_parts['extension'];
                        SectionsContent::create([//или создаем если не находим
                            'name' => $file,
                            'file_name' => $file,
                            'type' => 'file',
                            'vmodel' => null,
                            'position' => $position,
                            'parent_id' => $group->id,
                            'content' => $file,
                            'ext_file' => strval($extension)
                        ]);
                        $position++;
                    }

                    unlink(storage_path('app/public/orders/' . $sdir . '/' . $file));
                }
            }
        }
        return 'Файлы приказов успешно удалены';
    }


    public function clean_stats()
    {
        $subdirs = [
            'asp',
            'bach',
            'master',
            'spo'
        ];
        foreach ($subdirs as $sdir) {
            if ($dir = scandir(storage_path('app/public/statistic_priem/' . $sdir))) {
                $files = array();
                foreach ($dir as $file) {
                    if ($file == "." || $file == "..")
                        continue;
                    unlink(storage_path('app/public/statistic_priem/' . $sdir . '/' . $file));
                }
            }
        }
        foreach ($subdirs as $sdir) {
            if ($dir = scandir(storage_path('app/public/statistic_priem_foreigner/' . $sdir))) {
                $files = array();
                foreach ($dir as $file) {
                    if ($file == "." || $file == "..")
                        continue;
                    unlink(storage_path('app/public/statistic_priem_foreigner/' . $sdir . '/' . $file));
                }
            }
        }
        return 'Файлы статистики приема успешно удалены';
    }

    public function clean_table_stat_bach()
    {
        Statistic::where('id', '>', 0)->delete();
        StatisticForeigner::where('id', '>', 0)->delete();
        return 'Данные списков поступающих бакалавриата удалены';
    }

    public function clean_table_stat_master()
    {
        StatisticMaster::where('id', '>', 0)->delete();
        StatisticMasterForeigner::where('id', '>', 0)->delete();
        return 'Данные списков поступающих магистратуры удалены';
    }

    public function clean_table_stat_asp()
    {
        StatisticAsp::where('id', '>', 0)->delete();
        StatisticAspForeigner::where('id', '>', 0)->delete();
        return 'Данные списков поступающих аспирантуры удалены';
    }

    public function clean_table_stat_spo()
    {
        StatisticSpo::where('id', '>', 0)->delete();
        return 'Данные списков поступающих спо удалены';
    }

}
