<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
    public function index(Request $request)
    {
//        echo $request->file_name;
        $file_name = $request->file_name;

        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        if ($file_name=="disciplines.xls" || $file_name=="specializations.xls"
            || $file_name=="specialities.xls"|| $file_name=="admission_bases.xls"
            || $file_name=="faculties.xls"){
            $directory = "catalogs";
        }
        elseif($file_name=="past_contests.json" ){
            $directory = "pastContests";
        }
        elseif($file_name=="stat_asp.json" || $file_name=="stat_bach.json"
            || $file_name=="stat_master.json"|| $file_name=="stat_spo.json"){
            $directory = "statistics";
        }
        elseif($file_name=="plans_kov_spo.json" ){
            $directory = "plans/plans_kov";
        }
        elseif($file_name=="plans_rim_bach.json" || $file_name=="plans_rim_master.json" || $file_name=="plans_rim_spo.json"){
            $directory = "plans/plans_rim";
        }
        elseif($file_name=="plans_sar_master.json" || $file_name=="plans_sar_bach.json"
            || $file_name=="plans_sar_spo.json"|| $file_name=="plans_sar_asp.json"){
            $directory = "plans/plans_saransk";
        }

        $remoteDir = '/home/icmrsu/'. $directory;
        $localDir = '/var/www/html/abiturs/storage/app/public/files/'. $directory;
//      $localDir = 'E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files\\' . $directory;
        echo $localDir;

        if (!function_exists("ssh2_connect"))
            die('Function ssh2_connect not found, you cannot use ssh2 here');

        if (!$connection = ssh2_connect($host, $port))
            die('Unable to connect');

        if (!ssh2_auth_password($connection, $username, $password))
            die('Unable to authenticate.');

        if (!$stream = ssh2_sftp($connection))
            die('Unable to create a stream.');


        if (!$dir = scandir("ssh2.sftp://{$stream}{$remoteDir}"))
            die('Could not open the directory');

        $files = array();
        foreach ($dir as $file) {
            if ($file == "." || $file == "..")
                continue;
            $files[] = $file;
        }

//        var_dump($files);
//        echo "</br>";

        $key = array_search($file_name, $files);
        if (!($key === false)) {
            $file = $files[$key];

            echo "Copying file: $file\n";

            $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
            $local_file_path = $localDir . '/' . $file;

            if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                if (filesize($remote_file_path) == filesize($local_file_path)
                    && md5_file($remote_file_path) == md5_file($local_file_path)) {
                    echo "</br>Файлы совпадают";
                    return;
                }
            } elseif (file_exists($remote_file_path) && !file_exists($local_file_path)) {
                if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                    die("Unable to open remote file: $file\n");
                }

                if (!$local = @fopen($localDir . '/' . $file, 'w')) {
                    fclose($remote);
                    die("Unable to create local file: $file\n");
                }
                $read = 0;
                $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                    $read += strlen($buffer);
                    if (fwrite($local, $buffer) === FALSE) {
                        echo "Unable to write to local file: $file\n";
                        break;
                    }
                }
                if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                    if (filesize($remote_file_path) == filesize($local_file_path)
                        && md5_file($remote_file_path) == md5_file($local_file_path)) {
                        echo "</br>Файл успешно загружен";
                    }
                }
                fclose($local);
                fclose($remote);
            }


        }else{
            echo "</br>Файл ". $file_name ." отсутвует на удаленном сервере";
            return;
        }
    }

    public function show(Request $request)
    {
        return view('pages.files');
    }


}

