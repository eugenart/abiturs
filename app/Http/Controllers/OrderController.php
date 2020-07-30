<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Psy\Exception\ErrorException;

class OrderController extends Controller
{
    public static function cmp($a, $b) {
        if ($a->equalTo($b)) {
            return 0;
        }
        return ($a ->greaterThan($b)) ? -1 : 1;
    }

    public function index()
    {
        //получим все файлы бакалавров
        $notif_bach = '';
        $files_bach = $this->get_files('orders/bach', $notif_bach);

        $notif_master = '';
        $files_master = $this->get_files('orders/master', $notif_master);

        $notif_asp = '';
        $files_asp = $this->get_files('orders/asp', $notif_asp);

        $notif_ord = '';
        $files_ord = $this->get_files('orders/ord', $notif_ord);

        $notif_spo = '';
        $files_spo = $this->get_files('orders/spo', $notif_spo);

        $notif_cancel = '';
        $files_cancel = $this->get_files('orders/cancel', $notif_cancel);

        $notif_other = '';
        $files_other = $this->get_files('orders/other', $notif_other);

        $notif_foreigner = '';
        $files_foreigner = $this->get_files('orders/foreigner', $notif_foreigner);

        return view('pages.order',
            ['files_bach' => $files_bach, 'notif_bach' => $notif_bach,
                'files_master' => $files_master, 'notif_master' => $notif_master,
                'files_asp' => $files_asp, 'notif_asp' => $notif_asp,
                'files_ord' => $files_ord, 'notif_ord' => $notif_ord,
                'files_spo' => $files_spo, 'notif_spo' => $notif_spo,
                'files_cancel' => $files_cancel, 'notif_cancel' => $notif_cancel,
                'files_other' => $files_other, 'notif_other' => $notif_other,
                'files_foreigner' => $files_foreigner, 'notif_foreigner' => $notif_foreigner,
            ]);
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

            $date_file = array();

            foreach ($files as $file) {
                $date = substr($file, 18, 10);
                $day = substr($date, 0, 2);
                $month = substr($date, 3, 2);
                $year = substr($date, 6, 4);
                $date_file[$file] = Carbon::create($year, $month, $day, 00, 00, 00);
            }

            uasort($date_file, array($this, "cmp"));
            $sort_file = array();
            foreach ($date_file as $k => $el){
                $sort_file[] = $k;
            }
            $files = $sort_file;
        } else {
            $notif = "Не удалось открыть директорию с файлами";
        }

        return $files;
    }



    public
    function download_all_files()
    {
        $this->download('orders');


    }

    public function delete_files($directory)
    {
        //удаление файлов что лежат на сервере
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
        }
    }

    public function download($directory)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';

        $remoteDir = '/home/icmrsu/' . $directory;


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
        //удаление файлов что лежат на сервере
        $this->delete_files($directory . '/asp');
        $this->delete_files($directory . '/bach');
        $this->delete_files($directory . '/cancel');
        $this->delete_files($directory . '/master');
        $this->delete_files($directory . '/ord');
        $this->delete_files($directory . '/other');
        $this->delete_files($directory . '/spo');
        $this->delete_files($directory . '/foreigner');

        $count_files = 0;

        //скачиваем заново все что лежит на ftp
        foreach ($files as $file) {
            $remote_file_path = "ssh2.sftp://{$stream}/{$remoteDir}/{$file}";
            $order = [
                '1' => ' о зачислении',
                '0' => ' об отмене зачисления',
            ];
            $prep_level = [
                '03' => '/bach',
                '04' => '/master',
                '02' => '/spo',
                '06' => '/asp',
                '08' => '/ord',
            ];
            $prep_level_name = [
                '03' => 'Бакалавриат и специалитет, ',
                '04' => 'Магистратура, ',
                '02' => 'СПО, ',
                '06' => 'Аспирантура, ',
                '08' => 'Ординатура, ',
            ];
            $filial = [
                '1' => '',
                '2' => 'РИМ',
                '3' => 'КФ',
            ];
            $study_form = [
                'FT' => 'очная форма обучения',
                'MX' => 'очно-заочная форма обучения',
                'PT' => 'заочная форма обучения',
                'XX' => '',
            ];
            $adm_basis = [
                'OP' => 'особое право',
                'CP' => 'целевой приём',
                'BO' => 'бюджетная основа',
                'PV' => 'полное возмещение затрат',
                'XX' => '',
            ];
            $category = [
                'BV' => 'без вступительных испытаний',
                'XX' => '',
            ];
            $wave = [
                '1' => '1 волна',
                '2' => '2 волна',
                '0' => '',
            ];

            $new_name = '';

            $orderf = null;
            $prep_levelf = null;
            $filialf = null;
            $study_formf = null;
            $adm_basisf = null;
            $categoryf = null;
            $wavef = null;

            $arr_name = explode("_", substr($file, 0, -4));
            if (count($arr_name) == 2) {
                list($datef, $num) = explode("_", substr($file, 0, -4));
            }
            if (count($arr_name) == 10) {
                list($orderf, $prep_levelf, $filialf, $study_formf, $adm_basisf, $categoryf, $wavef, $foreignerf, $datef, $num) = explode("_", substr($file, 0, -4));
            }

            $date = substr($datef, 0, 2) . '.' . substr($datef, 2, 2) . '.' . substr($datef, 4, 4);

            $new_name = 'Приказ от ' . $date . ' №' . $num . '-с';

            if (!is_null($orderf)) {
                $new_name .= $order[$orderf];
                if ($orderf == '1') {
                    if ($foreignerf == '0') {
                        if ($filial[$filialf] != '' || $study_form[$study_formf] != '' || $adm_basis[$adm_basisf] != '' || $category[$categoryf] != '' || $wave[$wavef] != '') {
                            $new_name .= ' (';
                            if ($filial[$filialf] != '') {
                                $new_name .= $filial[$filialf] . ', ';
                            }
                            if ($study_form[$study_formf] != '') {
                                $new_name .= $study_form[$study_formf] . ', ';
                            }
                            if ($adm_basis[$adm_basisf] != '') {
                                $new_name .= $adm_basis[$adm_basisf] . ', ';
                            }
                            if ($category[$categoryf] != '') {
                                $new_name .= $category[$categoryf] . ', ';
                            }
                            $new_name .= $wave[$wavef];
                            if (substr($new_name, -2) == ', ') {
                                $new_name = substr($new_name, 0, -2);
                            }
                            $new_name .= ')';
                        }
                    }
                    if ($foreignerf == '1') {
                        $new_name .= ' (';
                        if ($prep_level_name[$prep_levelf] != '') {
                            $new_name .= $prep_level_name[$prep_levelf] . ', ';
                        }
                        if ($filial[$filialf] != '') {
                            $new_name .= $filial[$filialf] . ', ';
                        }
                        if ($study_form[$study_formf] != '') {
                            $new_name .= $study_form[$study_formf] . ', ';
                        }
                        if ($adm_basis[$adm_basisf] != '') {
                            $new_name .= $adm_basis[$adm_basisf] . ', ';
                        }
                        if ($category[$categoryf] != '') {
                            $new_name .= $category[$categoryf] . ', ';
                        }
                        $new_name .= $wave[$wavef];
                        if (substr($new_name, -2) == ', ') {
                            $new_name = substr($new_name, 0, -2);
                        }
                        $new_name .= ')';
//                        $new_name .= ' (' . $prep_level_name[$prep_levelf] . $filial[$filialf] . $study_form[$study_formf] . $adm_basis[$adm_basisf] . $category[$categoryf] . $wave[$wavef] . ')';
                    }
                }
            }
            $new_name .= '.pdf';


            if ($new_name != '') {
                if (count($arr_name) == 2) {
                    $subdir = '/other';
                }
                if ($orderf == '0') {
                    $subdir = '/cancel';
                }
                if ($orderf == '1') {
                    if (!is_null($prep_levelf) && $foreignerf == '0') {
                        $subdir = $prep_level[$prep_levelf];
                    }
                    if ($foreignerf == '1') {
                        $subdir = '/foreigner';
                    }
                }
                $localDir = storage_path('app/public/') . $directory . $subdir;


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
//                        echo "Файл " . $local_file . " успешно загружен.\n";
                        $count_files++;
                        fclose($local);
                        fclose($remote);
//                            return 0;
                    } else {
                        fclose($local);
                        fclose($remote);
//                            return 1;
                    }
                }

            } else {
                echo "Файл " . $file . " имеет неверное имя.\n";
            }
        }

        if (count($files) == $count_files) {
            echo "Приказы успешно загружены!";
        }
    }
}
