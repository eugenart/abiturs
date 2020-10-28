<?php

namespace App\Providers;

use App\Infoblock;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('pages.layout', function($view){
            $infoblocks = Infoblock::where('activity', true)->where('menu', true)->orderBy('menuPriority', 'desc')->where('foreigner', '=', 0)->where('archive', '=', 0)->get();
            $infoblocks_int = Infoblock::where('activity', true)->where('menu', true)->orderBy('menuPriority', 'desc')->where('foreigner', '=', 1)->where('archive', '=', 0)->get();

            $direcories = [
                '/asp',
                '/bach',
                '/cancel',
                '/master',
                '/ord',
                '/other',
                '/spo',
                '/foreigner'
            ];
            //подсчет файлов что лежат на сервере
            $files = array();
            foreach ($direcories as $directory) {
                if ($dir = scandir(storage_path('app/public/orders' . $directory))) {
                    foreach ($dir as $file) {
                        if ($file == "." || $file == "..")
                            continue;
                        $files[] = $file;
                    }
                }
            }
            $count_orders = count($files);

            $direcories = [
                '/asp',
                '/bach',
                '/master',
                '/spo'
            ];
            //подсчет файлов что лежат на сервере
            $files = array();
            foreach ($direcories as $directory) {
                if ($dir = scandir(storage_path('app/public/statistic_priem' . $directory))) {
                    foreach ($dir as $file) {
                        if ($file == "." || $file == "..")
                            continue;
                        $files[] = $file;
                    }
                }
            }
            $count_stats = count($files);

            $view->with(['pages' => $infoblocks, 'infoblocks_int' => $infoblocks_int, 'count_orders' => $count_orders, 'count_stats' => $count_stats]);
        });
    }
}
