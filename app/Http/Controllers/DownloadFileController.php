<?php

namespace App\Http\Controllers;

use App\DateUpdate;
use App\Traits\ParserXlsTrait;
use App\Traits\ParserJsonTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ParserJsonController as ParserJsonController;
use App\Http\Controllers\ParserController;

class DownloadFileController extends Controller
{
    use ParserXlsTrait;
    use ParserJsonTrait;

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

    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $param = $request->param;

            if ($param == "specialities" || $param == "faculties" || $param == "admission_bases") {
                $directory = "catalogs";
                if ($param == "specialities") {
                    $res = $this->download($directory, "specialities.xls");
                    if ($res === 0 || $res === 2) {
                        $res1 = $this->download($directory, "specializations.xls");
                        if (($res1 === 0 && $res === 0) || ($res === 2 && $res1 === 0) || ($res === 0 && $res1 === 2)) {
                            $result = $this->parseSpecialities();
                            if ($result) {
                                $this->date_update($param);
                            }
                            return $result;

                        }
                    }
                }
                if ($param == "faculties") {
                    $res = $this->download($directory, "faculties.xls");
                    $res1 = $this->download($directory, "subjects.xls");
                    if ($res === 0 && $res1 === 0) {
                        $result = $this->parseSubFac();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    } elseif ($res === 0 && $res1 != 0) {
                        $result = $this->parseFaculties();
                        if ($result) {
                            $this->date_update("faculties.xls");
                        }
                        return $result;
                    } elseif ($res != 0 && $res1 === 0) {
                        $result = $this->parseSubjects();
                        if ($result) {
                            $this->date_update("subjects.xls");
                        }
                        return $result;
                    }
                }
                if ($param == "admission_bases") {
                    $res = $this->download($directory, "admission_bases.xls");
                    if ($res === 0) {
                        $result = $this->parseAdmissionBases();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
            }
            if ($param == "past_contests") {
                $directory = "pastContests";
                $res = $this->download($directory, "past_contests.json");
                if ($res === 0) {
                    $result = $this->parsePastContests();
                    if ($result) {
                        $this->date_update($param);
                    }
                    return $result;
                }
            }
            if ($param == "stat_bach" || $param == "stat_master" || $param == "stat_asp"
                || $param == "stat_spo" || $param == "stat_bach_catalogs") {
                $directory = "statistics";
                if ($param == "stat_bach_catalogs") {
//                $res = $this->download($directory, "stat_bach.json", true);
//                if ($res === 0 /*|| $res === 2*/) {
//                    $result = $this->parseCatalogs("stat_bach_catalog.json");
//                    if($result){
//                        $this->date_update($param);
//                    }
//                    return $result;
//                }
                    return 'Каталоги успешно выгруженны!';
                }
                if ($param == "stat_bach") {
                    $res = $this->download($directory, "stat_bach.json");
                    if ($res === 0) {
                        $result = $this->parseStatBachAll();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
                if ($param == "stat_master") {
                    $res = $this->download($directory, "stat_master.json");
                    if ($res === 0) {
                        $result = $this->parseStatMasterAll();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
                if ($param == "stat_asp") {
                    $res = $this->download($directory, "stat_asp.json");
                    if ($res === 0) {
                        $result = $this->parseStatAspAll();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
                if ($param == "stat_spo") {
                    $res = $this->download($directory, "stat_spo.json");
                    if ($res === 0) {
                        $result = $this->parseStatSpoAll();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
            }
            if ($param == "plans_bach" || $param == "plans_master" || $param == "plans_asp" || $param == "plans_spo") {
                if ($param == "plans_bach") {
                    $directory = "plans/plans_saransk";
                    $res = $this->download($directory, "plans_sar_bach.json");
                    $directory = "plans/plans_rim";
                    $res1 = $this->download($directory, "plans_rim_bach.json");
                    //если оба новые, или один из них новый
                    if (($res === 0 && $res1 === 0) || ($res === 2 && $res1 === 0) || ($res === 0 && $res1 === 2)) {
                        $result = $this->parsePlansBach();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
                if ($param == "plans_master") {
                    $directory = "plans/plans_saransk";
                    $res = $this->download($directory, "plans_sar_master.json");
                    $directory = "plans/plans_rim";
                    $res1 = $this->download($directory, "plans_rim_master.json");
                    if (($res === 0 && $res1 === 0) || ($res === 2 && $res1 === 0) || ($res === 0 && $res1 === 2)) {
                        $result = $this->parsePlansMaster();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
                if ($param == "plans_asp") {
                    $directory = "plans/plans_saransk";
                    $res = $this->download($directory, "plans_sar_asp.json");
                    $res1 = $this->download($directory, "plans_sar_ord.json");
                    if ($res === 0 || $res1 === 0) {
                        $result = $this->parsePlansAspMain();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
                if ($param == "plans_spo") {
                    $directory = "plans/plans_saransk";
                    $res = $this->download($directory, "plans_sar_spo.json");
                    $directory = "plans/plans_rim";
                    $res1 = $this->download($directory, "plans_rim_spo.json");
                    $directory = "plans/plans_kov";
                    $res2 = $this->download($directory, "plans_kov_spo.json");
                    if (!($res === 2 && $res1 === 2 && $res2 === 2)) {
                        $result = $this->parsePlansSpo();
                        if ($result) {
                            $this->date_update($param);
                        }
                        return $result;
                    }
                }
            }
        }
    }


    public function download($directory, $file_name, $catalog = false)
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

    public function show(Request $request)
    {
        return view('pages.files');
    }
    public function stop(Request $request)
    {
        return view('errors.404');
    }



}

