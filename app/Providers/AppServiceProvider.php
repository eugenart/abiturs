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
            $infoblocks = Infoblock::where('activity', true)->where('menu', true)->get();
            $view->with('pages', $infoblocks);
        });
    }
}
