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

        view()->composer('pages.layout', function($view)
        {
            $infoblocks = Infoblock::where('activity', true)->where('menu', true)->orderBy('menuPriority', 'desc')->where('foreigner', '=', 0)->where('archive', '=', 0)->get();
            $infoblocks_int = Infoblock::where('activity', true)->where('menu', true)->orderBy('menuPriority', 'desc')->where('foreigner', '=', 1)->where('archive', '=', 0)->get();
            $view->with(['pages' => $infoblocks, 'infoblocks_int' => $infoblocks_int]);
        });
    }
}
