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
        $files_bach = $this->get_files('statistic_priem/bach', $notif_bach);

        $notif_master = '';
        $files_master = $this->get_files('statistic_priem/master', $notif_master);

        $notif_asp = '';
        $files_asp = $this->get_files('statistic_priem/asp', $notif_asp);

        $notif_spo = '';
        $files_spo = $this->get_files('statistic_priem/spo', $notif_spo);

        return view('pages.totalstat', ['files_bach' => $files_bach, 'notif_bach' => $notif_bach,
            'files_master' => $files_master, 'notif_master' => $notif_master,
            'files_asp' => $files_asp, 'notif_asp' => $notif_asp,
            'files_spo' => $files_spo, 'notif_spo' => $notif_spo]);
    }

    public function index_foreigner()
    {
        //получим все файлы бакалавров
        $notif_bach = '';
        $files_bach = $this->get_files('statistic_priem_foreigner/bach', $notif_bach);

        $notif_master = '';
        $files_master = $this->get_files('statistic_priem_foreigner/master', $notif_master);

        $notif_asp = '';
        $files_asp = $this->get_files('statistic_priem_foreigner/asp', $notif_asp);


        return view('pages.totalstatf', ['files_bach' => $files_bach, 'notif_bach' => $notif_bach,
            'files_master' => $files_master, 'notif_master' => $notif_master,
            'files_asp' => $files_asp, 'notif_asp' => $notif_asp]);
    }


    public function get_files($directory, &$notif)
    {
        $files = array();
        $notif = "";
        if ($dir = scandir(storage_path('app/public/' . $directory))) {
            $files = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $files[] = $file;
            }
//            asort($files);

            $sort_files = array();
            foreach ($files as $file) {
                $pos1 = stripos($file, 'Очная форма ');
                $pos2 = stripos($file, 'Очно-заочная форма ');
                $pos3 = stripos($file, 'Заочная форма ');
                $pos4 = stripos($file, 'Платная основа');

                if ($pos1 !== false) {
                    $sort_files[0] = $file;
                }
                if ($pos2 !== false) {
                    $sort_files[1] = $file;
                }
                if ($pos3 !== false) {
                    $sort_files[2] = $file;
                }
                if ($pos4 !== false) {
                    $sort_files[3] = $file;
                }
            }
            ksort($sort_files);
        } else {
            $notif = "Не удалось открыть директорию с файлами";
        }
//        var_dump($sort_files);
        return $sort_files;
    }

    public function download_all_files()
    {
        $this->download('statistic_priem/bach');
        $this->download('statistic_priem/master');
        $this->download('statistic_priem/asp');
        $this->download('statistic_priem/spo');

        $this->download('statistic_priem_foreigner/bach');
        $this->download('statistic_priem_foreigner/master');
        $this->download('statistic_priem_foreigner/asp');
    }

    public function download($directory)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        $remoteDir = '/home/icmrsu/' . $directory;
        $localDir = storage_path('app/public/') . $directory;

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

        if ($dir_delete = scandir(storage_path('app/public/' . $directory))) {
            $files_delete = array();
            foreach ($dir_delete as $file_delete) {
                if ($file_delete == "." || $file_delete == "..")
                    continue;
                $files_delete[] = $file_delete;
            }

            if (count($files_delete) > 0) {
                foreach ($files_delete as $file_name) {
                    try {
                        unlink(storage_path('app/public/' . $directory . '/' . $file_name));
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
                'distance' => 'Заочная форма ',
                'evening' => 'Очно-заочная форма ',
                'full-time' => 'Очная форма ',
                'budget' => 'бюджетная основа',
                'paid' => 'Платная основа'
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
