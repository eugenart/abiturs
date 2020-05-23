<?php

namespace App\Http\Controllers;

use App\Traits\ParserXlsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ParserJsonController as ParserJsonController;
use App\Http\Controllers\ParserController;

class DownloadFileController extends Controller
{
    use ParserXlsTrait;

    public function index(Request $request)
    {
        $param = $request->param;

        if ($param == "specialities" || $param == "faculties" || $param == "admission_bases" || $param == "stat_bach_catalogs") {
            $directory = "catalogs";
            if ($param == "specialities") {
                $res = $this->download($directory, "specialities.xls");
                if ($res === 0) {
                    $res = $this->download($directory, "specializations.xls");
                    if ($res === 0) {
                        $result = $this->parseSpecialities();
                        return $result;
                    }
                }
            } elseif ($param == "faculties") {
                $res = $this->download($directory, "faculties.xls");
                $res1 = $this->download($directory, "subjects.xls");
                if ($res === 0 && $res1 === 0) {
                    $result = $this->parseSubFac();
                    return $result;
                } elseif ($res === 0 && $res1 != 0) {
                    $result = $this->parseFaculties();
                    return $result;
                } elseif ($res != 0 && $res1 === 0) {
                    $result = $this->parseSubjects();
                    return $result;
                }
            } elseif ($param == "admission_bases"){
                $res = $this->download($directory, "admission_bases.xls");
                if ($res === 0) {
                    $result = $this->parseAdmissionBases();
                    return $result;
                }
            }
        } elseif ($param == "past_contests") {
            $directory = "pastContests";
        } elseif
        ($param == "stat_bach" || $param == "stat_master"
            || $param == "stat_asp" || $param == "stat_spo") {
            $directory = "statistics";
        }

    }

    public
    function show(Request $request)
    {
        return view('pages.files');
    }

    public
    function download($directory, $file_name)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        $remoteDir = '/home/icmrsu/' . $directory;
//        $localDir = '/var/www/html/abiturs/storage/app/public/files/'. $directory;
        $localDir = 'E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files\\' . $directory;


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

        $key = array_search($file_name, $files);
        if (!($key === false)) {
            $file = $files[$key];

            $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
            $local_file_path = $localDir . '/' . $file;

            if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                if (filesize($remote_file_path) == filesize($local_file_path)
                    && md5_file($remote_file_path) == md5_file($local_file_path)) {
                    echo "Файлы ". $file ." совпадают.\n";
                    return 1;
                } else {
                    if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                        die("Невозможно открыть файл на удаленном сервере: $file\n");
                    }

                    if (!$local = @fopen($localDir . '/' . $file, 'w')) {
                        fclose($remote);
                        die("Невозможно создать файл на локальном сервере: $file\n");
                    }
                    $read = 0;
                    $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                    while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                        $read += strlen($buffer);
                        if (fwrite($local, $buffer) === FALSE) {
                            echo "Невозможно записать локальный файл: $file\n";
                            break;
                        }
                    }
                    if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                        if (filesize($remote_file_path) == filesize($local_file_path)
                            && md5_file($remote_file_path) == md5_file($local_file_path)) {
//                            echo "Файл ". $file ." успешно загружен.\n";
                            return 0;
                        }
                    }
                    fclose($local);
                    fclose($remote);
                }
            } elseif (file_exists($remote_file_path) && !file_exists($local_file_path)) {
                if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                    die("Невозможно открыть файл на удаленном сервере: $file\n");
                }

                if (!$local = @fopen($localDir . '/' . $file, 'w')) {
                    fclose($remote);
                    die("Невозможно создать файл на локальном сервере: $file\n");
                }
                $read = 0;
                $filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}/{$file}");
                while ($read < $filesize && ($buffer = fread($remote, $filesize - $read))) {
                    $read += strlen($buffer);
                    if (fwrite($local, $buffer) === FALSE) {
                        echo "Невозможно записать локальный файл: $file\n";
                        break;
                    }
                }
                if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                    if (filesize($remote_file_path) == filesize($local_file_path)
                        && md5_file($remote_file_path) == md5_file($local_file_path)) {
//                        echo json_encode("Файл ". $file ." успешно загружен.\n");
                        return 0;
                    }
                }
                fclose($local);
                fclose($remote);
            }
        } else {
            echo "Файл " . $file_name . " отсутвует на удаленном сервере";
            return 1;
        }
    }


    public
    function iddex(Request $request)
    {


//        echo $request->file_name;
        $file_names = $request->file_name;
        $file_name_arr = explode(" ", $file_names);
//        var_dump($file_name_arr);

        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        if ($file_name_arr[0] == "disciplines.xls" || $file_name_arr[0] == "specializations.xls"
            || $file_name_arr[0] == "specialities.xls" || $file_name_arr[0] == "admission_bases.xls"
            || $file_name_arr[0] == "faculties.xls") {
            $directory = "catalogs";
        } elseif ($file_name_arr[0] == "past_contests.json") {
            $directory = "pastContests";
        } elseif ($file_name_arr[0] == "stat_asp.json" || $file_name_arr[0] == "stat_bach.json"
            || $file_name_arr[0] == "stat_master.json" || $file_name_arr[0] == "stat_spo.json") {
            $directory = "statistics";
        } elseif ($file_name_arr[0] == "plans_kov_spo.json") {
            $directory = "plans/plans_kov";
        } elseif ($file_name_arr[0] == "plans_rim_bach.json" || $file_name_arr[0] == "plans_rim_master.json" || $file_name_arr[0] == "plans_rim_spo.json") {
            $directory = "plans/plans_rim";
        } elseif ($file_name_arr[0] == "plans_sar_master.json" || $file_name_arr[0] == "plans_sar_bach.json"
            || $file_name_arr[0] == "plans_sar_spo.json" || $file_name_arr[0] == "plans_sar_asp.json"
            || $file_name_arr[0] == "stat_bach_catalogs") {
            $directory = "plans/plans_saransk";
        }


        $remoteDir = '/home/icmrsu/' . $directory;
//        $localDir = '/var/www/html/abiturs/storage/app/public/files/'. $directory;
        $localDir = 'D:\OSPanel\domains\abiturs\storage\app\public\files\\' . $directory;
        //echo $localDir;

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


        foreach ($file_name_arr as $file_name) {
            $temp = "";
            if ($file_name == "stat_bach_catalogs") {
                $file_name = "stat_bach.json";
                $temp = "stat_bach_catalogs";
            }
            $key = array_search($file_name, $files);
            if (!($key === false)) {
                $file = $files[$key];

                // echo "Copying file: $file\n";

                $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
                $local_file_path = $localDir . '/' . $file;

                if (file_exists($remote_file_path) && file_exists($local_file_path)) {
                    if (filesize($remote_file_path) == filesize($local_file_path)
                        && md5_file($remote_file_path) == md5_file($local_file_path)) {
                        echo "Файлы совпадают";
                        return;
                    } else {
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
                                echo "Файл успешно загружен";
                                echo "<br/>";
                                if ($file == "specialities.xls" || $file == "specializations.xls") {
//                                   $res = app('App\Http\Controllers\ParserController')->parseFromXls();
//                                   echo $res;
                                } elseif ($file == "disciplines.xls") {
                                    $res = app('App\Http\Controllers\ParserController')->parseFromXlsSub();
                                    echo $res;
                                } elseif ($file == "faculties.xls") {
                                    $res = app('App\Http\Controllers\ParserController')->parseFromXlsFaculties();
                                    echo $res;
                                } elseif ($file == "admission_bases.xls") {
                                    $res = app('App\Http\Controllers\ParserController')->parseFromXlsAdmission();
                                    echo $res;
                                } elseif ($temp == "stat_bach_catalogs") {
                                    $res = app('App\Http\Controllers\ParserJsonController')->parseCatalogs();
                                    echo $res;
                                } elseif ($temp == "stat_bach.json") {
                                    $res = app('App\Http\Controllers\ParserJsonController')->parseFromJson();
                                    echo $res;
                                } elseif ($temp == "stat_master.json") {
                                    $res = app('App\Http\Controllers\ParserJsonController')->parseFromJsonMaster();
                                    echo $res;
                                } elseif ($temp == "stat_asp.json") {
                                    $res = app('App\Http\Controllers\ParserJsonController')->parseFromJsonAsp();
                                    echo $res;
                                } elseif ($temp == "stat_spo.json") {
                                    $res = app('App\Http\Controllers\ParserJsonController')->parseFromJsonSpo();
                                    echo $res;
                                } elseif ($temp == "plans_sar_bach.json") {//plans_rim_bach
//                                   $res = app('App\Http\Controllers\ParserJsonController')->parsePlansBach();
//                                   echo $res;
                                } elseif ($temp == "plans_sar_master.json") {//plans_rim_master
//                                   $res = app('App\Http\Controllers\ParserJsonController')->parsePlansMaster();
//                                   echo $res;
                                } elseif ($temp == "plans_sar_asp.json") {
//                                   $res = app('App\Http\Controllers\ParserJsonController')->parsePlansAspMain();
//                                   echo $res;
                                } elseif ($temp == "plans_sar_spo.json") {//plans_rim_spo //plans_kov_spo
//                                   $res = app('App\Http\Controllers\ParserJsonController')->parsePlansSpo();
//                                   echo $res;
                                } elseif ($temp == "past_contests.json") {//plans_rim_spo //plans_kov_spo
//                                   $res = app('App\Http\Controllers\ParserJsonController')->parsePastContests();
//                                   echo $res;
                                }
                            }
                        }
                        fclose($local);
                        fclose($remote);
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
                            echo "Файл успешно загружен";
                        }
                    }
                    fclose($local);
                    fclose($remote);
                }
            } else {
                echo "Файл " . $file_name . " отсутвует на удаленном сервере";
//            return;
            }
        }
    }

}

