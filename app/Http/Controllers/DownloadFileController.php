<?php

namespace App\Http\Controllers;

use App\Traits\ParserXlsTrait;
use App\Traits\ParserJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ParserJsonController as ParserJsonController;
use App\Http\Controllers\ParserController;

class DownloadFileController extends Controller
{
    use ParserXlsTrait;
    use ParserJsonTrait;

    public function index(Request $request)
    {
        $param = $request->param;

        if ($param == "specialities" || $param == "faculties" || $param == "admission_bases" || $param == "stat_bach_catalogs") {
            $directory = "catalogs";
            if ($param == "specialities") {
                $res = $this->download($directory, "specialities.xls");
                if ($res === 0 || $res === 2) {
                    $res1 = $this->download($directory, "specializations.xls");
                    if (($res1 === 0 && $res === 0) || ($res === 2 && $res1 === 0) || ($res === 0 && $res1 === 2)) {
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
            } elseif ($param == "admission_bases") {
                $res = $this->download($directory, "admission_bases.xls");
                if ($res === 0) {
                    $result = $this->parseAdmissionBases();
                    return $result;
                }
            }
        } elseif ($param == "past_contests") {
            $directory = "pastContests";
            $res = $this->download($directory, "past_contests.json");
            if ($res === 0) {
                $result = $this->parsePastContests();
                return $result;
            }
        } elseif ($param == "stat_bach" || $param == "stat_master" || $param == "stat_asp" || $param == "stat_spo" || $param == "stat_bach_catalogs") {
            $directory = "statistics";
            if ($param == "stat_bach_catalogs") {
                $res = $this->download($directory, "stat_bach.json");
                if ($res === 0 || $res === 2) {
                    $result = $this->parseCatalogs();
                    return $result;
                }
            } elseif ($param == "stat_bach") {
                $res = $this->download($directory, "stat_bach.json");
                if ($res === 0) {
                    $result = $this->parseStatBachAll();
                    return $result;
                }
            } elseif ($param == "stat_master") {
                $res = $this->download($directory, "stat_master.json");
                if ($res === 0) {
                    $result = $this->parseStatMasterAll();
                    return $result;
                }
            } elseif ($param == "stat_asp") {
                $res = $this->download($directory, "stat_asp.json");
                if ($res === 0) {
                    $result = $this->parseStatAspAll();
                    return $result;
                }
            } elseif ($param == "stat_spo") {
                $res = $this->download($directory, "stat_spo.json");
                if ($res === 0) {
                    $result = $this->parseStatSpoAll();
                    return $result;
                }
            }
        } elseif ($param == "plans_bach" || $param == "plans_master" || $param == "plans_asp" || $param == "plans_spo") {
            if ($param == "plans_bach") {
                $directory = "plans/plans_saransk";
                $res = $this->download($directory, "plans_sar_bach.json");
                $directory = "plans/plans_rim";
                $res1 = $this->download($directory, "plans_rim_bach.json");
                //если оба новые, или один из них новый
                if (($res === 0 && $res1 === 0) || ($res === 2 && $res1 === 0) || ($res === 0 && $res1 === 2)) {
                    $result = $this->parsePlansBach();
                    return $result;
                }
            } elseif ($param == "plans_master") {
                $directory = "plans/plans_saransk";
                $res = $this->download($directory, "plans_sar_master.json");
                $directory = "plans/plans_rim";
                $res1 = $this->download($directory, "plans_rim_master.json");
                if (($res === 0 && $res1 === 0) || ($res === 2 && $res1 === 0) || ($res === 0 && $res1 === 2)) {
                    $result = $this->parsePlansMaster();
                    return $result;
                }
            } elseif ($param == "plans_asp") {
                $directory = "plans/plans_saransk";
                $res = $this->download($directory, "plans_sar_asp.json");
                if ($res === 0) {
                    $result = $this->parsePlansAspMain();
                    return $result;
                }
            } elseif ($param == "plans_spo") {
                $directory = "plans/plans_saransk";
                $res = $this->download($directory, "plans_sar_spo.json");
                $directory = "plans/plans_rim";
                $res1 = $this->download($directory, "plans_rim_spo.json");
                $directory = "plans/plans_kov";
                $res2 = $this->download($directory, "plans_kov_spo.json");
                if (!($res === 2 && $res1 === 2 && $res2 === 2)) {
                    $result = $this->parsePlansSpo();
                    return $result;
                }
            }
        }

    }


    public function download($directory, $file_name)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        $remoteDir = '/home/icmrsu/' . $directory;
        $localDir = '/var/www/html/abiturs/storage/app/public/files/'. $directory;
//        $localDir = 'E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files\\' . $directory;


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
                    echo "Файлы " . $file . " совпадают.\n";
                    return 2;
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
                            echo "Файл ". $file ." успешно загружен.\n";
                            return 0;
                        } else {
                            return 1;
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
                        echo "Файл ". $file ." успешно загружен.\n";
                        return 0;
                    } else {
                        return 1;
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

    public function show(Request $request)
    {
        return view('pages.files');
    }


}

