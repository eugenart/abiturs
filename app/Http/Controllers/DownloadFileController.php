<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
    //194.54.64.15 KUGyjk76$$q@ icmrsu
    public function index(Request $request)
    {
        $host = '194.54.64.15';
        $port = 22;
        $username = 'icmrsu';
        $password = 'KUGyjk76$$q@';
        $remoteDir = '/home/icmrsu/catalogs';
        $localDir = 'E:\Open Server 5.3.5\OSPanel\domains\abiturs\storage\app\public\files\catalogs';

        if (!function_exists("ssh2_connect"))
            die('Function ssh2_connect not found, you cannot use ssh2 here');

        if (!$connection = ssh2_connect($host, $port))
            die('Unable to connect');

        if (!ssh2_auth_password($connection, $username, $password))
            die('Unable to authenticate.');

        if (!$stream = ssh2_sftp($connection))
            die('Unable to create a stream.');

        if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
            die('Could not open the directory');

        $files = array();
        while (false !== ($file = readdir($dir))) {
            if ($file == "." || $file == "..")
                continue;
            $files[] = $file;
        }



        foreach ($files as $file) {
            echo "Copying file: $file\n";

            if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}/{$file}", 'r')) {
                echo "Unable to open remote file: $file\n";
                continue;
            }

            if (!$local = @fopen($localDir .'/'. $file, 'w')) {
                echo "Unable to create local file: $file\n";
                continue;
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
            fclose($local);
            fclose($remote);
    }



    }
}

