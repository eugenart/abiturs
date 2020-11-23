<?php

namespace App\Http\Controllers;

use App\Statistic;
use App\StatisticAsp;
use App\StatisticAspForeigner;
use App\StatisticForeigner;
use App\StatisticMaster;
use App\StatisticMasterForeigner;
use App\StatisticSpo;
use Illuminate\Http\Request;

class CleansingController extends Controller
{
    public function index(Request $request)
    {
        return view('structure.cleansing');
    }

    public function clean_orders()
    {
        $subdirs = [
            'asp',
            'bach',
            'cancel',
            'foreigner',
            'master',
            'ord',
            'other',
            'spo'
        ];
        foreach ($subdirs as $sdir) {
            if ($dir = scandir(storage_path('app/public/orders/' . $sdir))) {
                $files = array();
                foreach ($dir as $file) {
                    if ($file == "." || $file == "..")
                        continue;
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

    public function clean_table_stat_bach(){
        Statistic::where('id', '>', 0)->delete();
        StatisticForeigner::where('id', '>', 0)->delete();
        return 'Данные списков поступающих бакалавриата удалены';
    }
    public function clean_table_stat_master(){
        StatisticMaster::where('id', '>', 0)->delete();
        StatisticMasterForeigner::where('id', '>', 0)->delete();
        return 'Данные списков поступающих магистратуры удалены';
    }
    public function clean_table_stat_asp(){
        StatisticAsp::where('id', '>', 0)->delete();
        StatisticAspForeigner::where('id', '>', 0)->delete();
        return 'Данные списков поступающих аспирантуры удалены';
    }
    public function clean_table_stat_spo(){
        StatisticSpo::where('id', '>', 0)->delete();
        return 'Данные списков поступающих спо удалены';
    }

}
