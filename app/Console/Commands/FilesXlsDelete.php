<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Psy\Exception\ErrorException;

class FilesXlsDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filesxls:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete temporary dynamic xls files';

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
        if ($dir = scandir(storage_path('app/public/files-xls'))) {
            $files_xls = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $files_xls[] = $file;
            }
            if(count($files_xls)>0) {
                foreach ($files_xls as $file_name) {
                    try{
                        unlink(storage_path('app/public/files-xls/'.$file_name));
                    }catch (ErrorException $e){
                        $this->info($e);
                        return;
                    }
                }
            }else{
                $this->info("The directory is empty");
               return;
            }
            $this->info("Files have deleted successful!");
            return;
        }else{
            $this->info("Can't open the directory");
            return ;
        }

    }
}
