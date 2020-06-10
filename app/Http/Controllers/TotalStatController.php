<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

//        $key = array_search($file_name, $files); //находим файл на фтп
//        if (!($key === false)) {
//            $file = $files[$key];
        foreach ($files as $file) {

            $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
            $local_file = $file;
            $local_file_path = $localDir . '/' . $local_file;

//            if (file_exists($remote_file_path) && file_exists($local_file_path)) {
//                if (filesize($remote_file_path) == filesize($local_file_path)
//                    && md5_file($remote_file_path) == md5_file($local_file_path)) {
//                    echo "Файлы " . $file . " совпадают.\n";
//                    return 2;
//                } else {
                    if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                        echo "Невозможно открыть файл на удаленном сервере: $file\n";
                        continue;
                    }

                    if (!$local = @fopen($localDir . '/' . $local_file, 'w')) {
                        fclose($remote);
                        echo "Невозможно создать файл на локальном сервере: $file\n";
                        continue;
                    }
                    $read = 0;

                    $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                    while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                        $read += strlen($buffer);
                        if (fwrite($local, $buffer) === FALSE) {
                            echo "Невозможно записать локальный файл: $file\n";
                            fclose($local);
                            fclose($remote);
                            break;
                        }
                    }
                    //Проверка
                    if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                        if (filesize($remote_file_path) == filesize($local_file_path)
                            && md5_file($remote_file_path) == md5_file($local_file_path)) {
                            echo "Файл " . $file . " успешно загружен.\n";
                            fclose($local);
                            fclose($remote);
//                            return 0;
                        } else {
                            fclose($local);
                            fclose($remote);
//                            return 1;
                        }
                    }

//                }
//            } elseif (file_exists($remote_file_path) && !file_exists($local_file_path)) {
//                if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
//                    die("Невозможно открыть файл на удаленном сервере: $file\n");
//                }
//
//                if (!$local = @fopen($localDir . '/' . $local_file, 'w')) {
//                    fclose($remote);
//                    die("Невозможно создать файл на локальном сервере: $file\n");
//                }
//                $read = 0;
//                $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
//                while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
//                    $read += strlen($buffer);
//                    if (fwrite($local, $buffer) === FALSE) {
//                        echo "Невозможно записать локальный файл: $file\n";
//                        fclose($local);
//                        fclose($remote);
//                        break;
//                    }
//                }
//                if (file_exists($remote_file_path) && file_exists($local_file_path)) {
//                    if (filesize($remote_file_path) == filesize($local_file_path)
//                        && md5_file($remote_file_path) == md5_file($local_file_path)) {
//                        echo "Файл " . $file . " успешно загружен.\n";
//                        fclose($local);
//                        fclose($remote);
//                        return 0;
//                    } else {
//                        fclose($local);
//                        fclose($remote);
//                        return 1;
//                    }
//                }
//            }
        }
//        } else {
//            echo "Файл " . $file_name . " отсутвует на удаленном сервере";
//            return 1;
//        }
    }
}
