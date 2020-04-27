<?php

namespace App\Http\Controllers;

use App\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{

    public function get_data($smtp_conn)
    {
        $data = "";
        while ($str = fgets($smtp_conn, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) == " ") {
                break;
            }
        }
        return $data;
    }

    public function index(Request $request)
    {
        $header = "Date: " . date("D, j M Y G:i:s") . " +0300\r\n";
        $header .= "From: =?UTF-8?B?" . base64_encode('Приёмная кампания 2020') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Mailer: Mail.Ru Mailer 1.0\r\n";
        $header .= "Reply-To: =?UTF-8?B?" . base64_encode('Приёмная кампания 2020') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Priority: 3 (Normal)\r\n";
        $header .= "Message-ID: <172562218." . date("YmjHis") . "@mail.ru>\r\n";
        $header .= "To: =?UTF-8?B?" . base64_encode('Сергей') . "?= <asd@qwe.ru>\r\n";
        $header .= "Subject: =?UTF-8?B?" . base64_encode('проверка') . "?=\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/plain; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n";
        $text = "Это текст письма\r\n";
        $smtp_conn = fsockopen("m.mrsu.ru", 25, $errno, $errstr);
        $data = $this->get_data($smtp_conn);


        fputs($smtp_conn, "EHLO Eugene Art\r\n");

        $size_msg = strlen($header . "\r\n" . $text);

        fputs($smtp_conn, "MAIL FROM: <mailer@abiturs.mrsu.ru> SIZE=" . $size_msg . "\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn, "RCPT TO: <artashkinep@mrsu.ru>\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn, "DATA\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn, $header . "\r\n" . $text . "\r\n.\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn, "QUIT\r\n");
        $data = $this->get_data($smtp_conn);

        return json_encode($data);
    }

}
