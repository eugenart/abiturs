<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\Exception\ErrorException;

class TotalStatController extends Controller
{
    public function index()
    {
        //получим все файлы бакалавров
        $notif_bach = '';
        $files_bach = $this->get_files('bach', $notif_bach);

        $notif_master = '';
        $files_master = $this->get_files('master', $notif_master);

        $notif_asp = '';
        $files_asp = $this->get_files('asp', $notif_asp);

        $notif_spo = '';
        $files_spo = $this->get_files('spo', $notif_spo);

        return view('pages.totalstat', ['files_bach' => $files_bach, 'notif_bach' => $notif_bach,
            'files_master' => $files_master, 'notif_master' => $notif_master,
            'files_asp' => $files_asp, 'notif_asp' => $notif_asp,
            'files_spo' => $files_spo, 'notif_spo' => $notif_spo]);
    }

    public function get_files($directory, &$notif)
    {
        $files = array();
        $notif = "";
        if ($dir = scandir(storage_path('app/public/statistic_priem/' . $directory))) {
            $files = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $files[] = $file;
            }
            arsort($files);
        } else {
            $notif = "Не удалось открыть директорию с файлами";
        }
        return $files;
    }

    public function download_all_files()
    {
        $this->download('bach');
        $this->download('master');
        $this->download('asp');
        $this->download('spo');

    }

    public function download($directory)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        $remoteDir = '/home/icmrsu/statistic_priem/' . $directory;
        $localDir = storage_path('app/public/statistic_priem/') . $directory;

        if (!function_exists("ssh2_connect"))
            die('Функция ssh2_connect не найдена');

        if (!$connection = ssh2_connect($host, $port))
            die('Невозможно произвести соединение');

        if (!ssh2_auth_password($connection, $username, $password))
            die('Невозможно авторизоваться');

        if (!$stream = ssh2_sftp($connection))
            die('Невозможно создать поток соединения');

        if (!$dir = scandir("ssh2.sftp://{$stream}{$remoteDir}"))
            die('Невозможно открыть директорию');

        $files = array();
        foreach ($dir as $file) {
            if ($file == "." || $file == "..")
                continue;
            $files[] = $file;
        }

        if ($dir_delete = scandir(storage_path('app/public/statistic_priem/' . $directory))) {
            $files_delete = array();
            foreach ($dir_delete as $file_delete) {
                if ($file_delete == "." || $file_delete == "..")
                    continue;
                $files_delete[] = $file_delete;
            }

            if (count($files_delete) > 0) {
                foreach ($files_delete as $file_name) {
                    try {
                        unlink(storage_path('app/public/statistic_priem/' . $directory . '/' . $file_name));
                    } catch (ErrorException $e) {
                        echo $e;
                        return;
                    }
                }
            }
//            else{
//                $this->info("The directory is empty");

//            }
//            $this->info("Files have deleted successful!");
        }
//        else{
//            $this->info("Can't open the directory");
//        }

        foreach ($files as $file) {

            $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
            $arr_names = [
                'distance' => 'Заочно ',
                'evening' => 'Очно-заочно ',
                'full-time' => 'Очно ',
                'budget' => 'Бюджет',
                'paid' => 'Платно'
            ];
            $new_name = '';
            foreach ($arr_names as $k => $name) {
                $pos1 = stripos($file, $k);
                if ($pos1 !== false) {
                    $new_name .= $name;
                }
            }
            if ($new_name != '') {
                $new_name .= '.pdf';


                $local_file = $new_name;
                $local_file_path = $localDir . '/' . $local_file;

                if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                    echo "Невозможно открыть файл на удаленном сервере: $file\n";
                    continue;
                }

                if (!$local = @fopen($localDir . '/' . $local_file, 'w')) {
                    fclose($remote);
                    echo "Невозможно создать файл на локальном сервере: $local_file\n";
                    continue;
                }
                $read = 0;

                $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                    $read += strlen($buffer);
                    if (fwrite($local, $buffer) === FALSE) {
                        echo "Невозможно записать локальный файл: $local_file\n";
                        fclose($local);
                        fclose($remote);
                        break;
                    }
                }
                //Проверка
                if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                    if (filesize($remote_file_path) == filesize($local_file_path)
                        && md5_file($remote_file_path) == md5_file($local_file_path)) {
                        echo "Файл " . $local_file . " успешно загружен.\n";
                        fclose($local);
                        fclose($remote);
//                            return 0;
                    } else {
                        fclose($local);
                        fclose($remote);
//                            return 1;
                    }
                }
            }else{
                echo "Файл " . $file . " имеет неверное имя.\n";
            }
        }
    }
}
