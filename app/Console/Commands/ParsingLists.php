<?php

namespace App\Console\Commands;

use App\DateUpdate;
use App\Traits\ParserJsonTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class ParsingLists extends Command
{

    use ParserJsonTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsing:begin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and parse new files list abiturs';

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
        //загрузить новые файлы с сервера
        $directory = "statistics";

        $param = "stat_bach";
        $res = $this->download_file($directory, "stat_bach.json");
        if ($res === 0) {
            $result = $this->parseStatBachAll();
            if ($result) {
                $this->date_update($param);
            }
        }


        $param = "stat_master";
        $res = $this->download_file($directory, "stat_master.json");
        if ($res === 0) {
            $result = $this->parseStatMasterAll();
            if ($result) {
                $this->date_update($param);
            }
        }

        $param = "stat_asp";
        $res = $this->download_file($directory, "stat_asp.json");
        if ($res === 0) {
            $result = $this->parseStatAspAll();
            if ($result) {
                $this->date_update($param);
            }
        }

        $param = "stat_spo";
        $res = $this->download_file($directory, "stat_spo.json");
        if ($res === 0) {
            $result = $this->parseStatSpoAll();
            if ($result) {
                $this->date_update($param);
            }
        }

    }

    public function date_update($name_file){
        $date_last = DateUpdate::where('name_file', '=', $name_file)->first();
        if(!empty($date_last)){
            $date_update = DateUpdate::find($date_last->id);
            $today = Carbon::today();
            $max =  Carbon::create($today->year, $today->month, $today->day, 18, 00, 00);
            if(Carbon::now() > $max){
                $date_update->date_update = $max;
            }else{
                $t = Carbon::now();
                $date_update->date_update = Carbon::create($t->year, $t->month, $t->day, $t->hour, $t->minute, 00);
            }
            $user = User::where('id', '=', Auth::id())->first();
            $date_update->username = $user->name;
            $date_update->save();
        }else{
            $date_update = new DateUpdate;
            $date_update->name_file = $name_file;
            $today = Carbon::today();
            $max =  Carbon::create($today->year, $today->month, $today->day, 18, 00, 00);
            if(Carbon::now() > $max){
                $date_update->date_update = $max;
            }else{
                $t = Carbon::now();
                $date_update->date_update = Carbon::create($t->year, $t->month, $t->day, $t->hour, $t->minute, 00);
            }
            $user = User::where('id', '=', Auth::id())->first();
            $date_update->username = $user->name;
            $date_update->save();
        }
        echo 'Дата обновления изменена \n';
    }

    public function download_file($directory, $file_name, $catalog = false)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        $remoteDir = '/home/icmrsu/' . $directory;
        $localDir = storage_path('app/public/files/') . $directory;

        $logs = fopen(storage_path('app/public/logs/parse_logs.txt'), 'a');
        fwrite($logs, date("Y-m-d H:i:s "));
        fwrite($logs, $file_name);

        if (!function_exists("ssh2_connect")) {
            fwrite($logs, ' Функция ssh2_connect не найдена');
            fclose($logs);
            die('Функция ssh2_connect не найдена');
        }

        if (!$connection = ssh2_connect($host, $port)) {
            fwrite($logs, ' Невозможно произвести соединение');
            fclose($logs);
            die('Невозможно произвести соединение');
        }

        if (!ssh2_auth_password($connection, $username, $password)) {
            fwrite($logs, ' Невозможно авторизоваться');
            fclose($logs);
            die('Невозможно авторизоваться');
        }

        if (!$stream = ssh2_sftp($connection)) {
            fwrite($logs, ' Невозможно создать поток соединения');
            fclose($logs);
            die('Невозможно создать поток соединения');
        }

        if (!$dir = scandir("ssh2.sftp://{$stream}{$remoteDir}")){
            fwrite($logs, ' Невозможно открыть директорию');
            fclose($logs);
            die('Невозможно открыть директорию');
        }


        $files = array();
        foreach ($dir as $file) {
            if ($file == "." || $file == "..")
                continue;
            $files[] = $file;
        }

        $key = array_search($file_name, $files); //находим файл на фтп
        if (!($key === false)) {
            $file = $files[$key];

            $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
            if($catalog) {
                $local_file = "stat_bach_catalog.json";
            }else{
                $local_file = $file;
            }
            $local_file_path = $localDir . '/' . $local_file;

            if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                if (filesize($remote_file_path) == filesize($local_file_path)
                    && md5_file($remote_file_path) == md5_file($local_file_path)) {
                    fwrite($logs,  " Файлы " . $file . " совпадают.\n");
                    fclose($logs);
                    echo "Файлы " . $file . " совпадают.\n";
                    return 2;
                } else {
                    if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                        fwrite($logs,  " Невозможно открыть файл на удаленном сервере: $file\n");
                        fclose($logs);
                        die("Невозможно открыть файл на удаленном сервере: $file\n");
                    }

                    if (!$local = @fopen($localDir . '/' . $local_file, 'w')) {
                        fclose($remote);
                        fwrite($logs,  " Невозможно создать файл на локальном сервере: $file\n");
                        fclose($logs);
                        die("Невозможно создать файл на локальном сервере: $file\n");
                    }
                    $read = 0;

                    $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                    while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                        $read += strlen($buffer);
                        if (fwrite($local, $buffer) === FALSE) {
                            fwrite($logs,  " Невозможно записать локальный файл: $file\n");
                            echo "Невозможно записать локальный файл: $file\n";
                            fclose($local);
                            fclose($remote);
                            fclose($logs);
                            break;
                        }
                    }
                    if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                        if (filesize($remote_file_path) == filesize($local_file_path)
                            && md5_file($remote_file_path) == md5_file($local_file_path)) {
                            fwrite($logs,  " Файл " . $file . " успешно загружен.\n");
                            echo "Файл " . $file . " успешно загружен.\n";
                            fclose($local);
                            fclose($remote);
                            fclose($logs);
                            return 0;
                        } else {
                            fclose($local);
                            fclose($remote);
                            fclose($logs);
                            return 1;
                        }
                    }

                }
            } elseif (file_exists($remote_file_path) && !file_exists($local_file_path)) {
                if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                    fwrite($logs,  " Невозможно открыть файл на удаленном сервере: $file\n");
                    fclose($logs);
                    die("Невозможно открыть файл на удаленном сервере: $file\n");
                }

                if (!$local = @fopen($localDir . '/' . $local_file, 'w')) {
                    fclose($remote);
                    fwrite($logs,  " Невозможно создать файл на локальном сервере: $file\n");
                    fclose($logs);
                    die("Невозможно создать файл на локальном сервере: $file\n");
                }
                $read = 0;
                $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                    $read += strlen($buffer);
                    if (fwrite($local, $buffer) === FALSE) {
                        fwrite($logs, " Невозможно записать локальный файл: $file\n" );
                        echo "Невозможно записать локальный файл: $file\n";
                        fclose($local);
                        fclose($remote);
                        fclose($logs);
                        break;
                    }
                }
                if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                    if (filesize($remote_file_path) == filesize($local_file_path)
                        && md5_file($remote_file_path) == md5_file($local_file_path)) {
                        fwrite($logs, " Файл " . $file . " успешно загружен.\n" );
                        fclose($logs);
                        echo "Файл " . $file . " успешно загружен.\n";
                        fclose($local);
                        fclose($remote);
                        return 0;
                    } else {
                        fclose($local);
                        fclose($remote);
                        fclose($logs);
                        return 1;
                    }
                }
            }
        } else {
            fwrite($logs, " Файл " . $file_name . " отсутвует на удаленном сервере");
            echo "Файл " . $file_name . " отсутвует на удаленном сервере";
            fclose($logs);
            return 1;
        }
    }
}
