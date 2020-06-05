<?php

namespace App\Console\Commands;

use App\Infoblock;
use App\SectionsContent;
use Illuminate\Console\Command;
use Psy\Exception\ErrorException;

class FilesPreviewDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filesPreview:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes unused infoblocks files';

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
        if ($dir = scandir(storage_path('app/public/preview'))) {
            $all_files = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $all_files[] = $file;
            }

            if (count($all_files) > 0) {
                $used = Infoblock::select('image')->get(); //используемые файлы

                $used_arr = array();
                foreach ($used as $use) {
                    $used_arr[] = $use->image;
                }
                $unused = array_diff($all_files, $used_arr);

                foreach ($unused as $file_name) {
                    try {
                        unlink(storage_path('app/public/preview/' . $file_name));
                    } catch (ErrorException $e) {
                        $this->info($e);
                        return;
                    }
                }
            } else {
                $this->info("The directory is empty");
                return;
            }
            $this->info("Files have deleted successful!");
            return;
        } else {
            $this->info("Can't open the directory");
            return;
        }
    }
}
