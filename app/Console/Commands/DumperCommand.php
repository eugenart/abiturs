<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

class DumperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dumper:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create dump db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::today();
        $date = substr(strval($date), 0, -9);
        $file_name = 'db_backup_'. $date . '.sql';
        $path = 'backups/' . $file_name;
        File::put($path, '');
        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->setHost(env('DB_HOST'))
            ->setPort(env('DB_PORT'))
            ->dumpToFile(base_path($path));
    }
}
