<?php

namespace App\Console\Commands;

use App\SectionsContent;
use Illuminate\Console\Command;
use Psy\Exception\ErrorException;

class FilesContentDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filesContent:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes unused content files';

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
        //удаление файлов секций
        if ($dir = scandir(storage_path('app/public/section-files'))) {
            $all_files = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $all_files[] = $file;
            }

            if (count($all_files) > 0) {
                $used = SectionsContent::whereNotNull('file_name')->select('file_name')->get(); //используемые файлы
                if (isset($used)) {
                    $used_arr = array();
                    foreach ($used as $use) {
                        $used_arr[] = $use->file_name;
                    }
                    $unused = array_diff($all_files, $used_arr);

                    foreach ($unused as $file_name) {
                        try {
                            unlink(storage_path('app/public/section-files/' . $file_name));
                        } catch (ErrorException $e) {
                            $this->info($e);
                            return;
                        }
                    }
                }else{ //все файлы не используются
                    foreach ($all_files as $file_name) {
                        try {
                            unlink(storage_path('app/public/section-files/' . $file_name));
                        } catch (ErrorException $e) {
                            $this->info($e);
                            return;
                        }
                    }
                }
            } else {
                $this->info("The directory is empty");
                return;
            }
            $this->info("Files have deleted successful!");
            return;
        }
        else {
            $this->info("Can't open the directory");
            return;
        }


    }
}
