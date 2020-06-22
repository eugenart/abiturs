<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
//        \App\Console\Commands\FilesXlsDelete::class
        '\App\Console\Commands\FilesXlsDelete',
        '\App\Console\Commands\FilesContentDelete',
        '\App\Console\Commands\FilesPreviewDelete',
        '\App\Console\Commands\DumperCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('filesxls:delete')->cron('0 */2 * * *'); // every 2 hours
        $schedule->command('filesxls:delete')->daily();
        $schedule->command('filesContent:delete')->monthlyOn(6, '00:02');
        $schedule->command('filesPreview:delete')->monthlyOn(6, '00:04');
        $schedule->command('dumper:create')->daily();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
