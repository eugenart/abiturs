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
        $header .= "Message-ID: <172562218." . date("YmjHis") . "@abiturs.mrsu.ru>\r\n";
        $header .= "To: =?UTF-8?B?" . base64_encode('Ответственный за проведение приемной кампании') . "?= <test@mrsu.ru>\r\n";
        $header .= "Subject: =?UTF-8?B?" . base64_encode('Вопрос от абитуриента') . "?=\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/plain; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n";
        $text = "ФИО: " . $request->fio . "\r\n";
        $text .= "Email: " . $request->email . "\r\n";
        $text .= "Номер телефона: " . $request->phone . "\r\n";
        $text .= "Текст вопроса: " . $request->question . ".\r\n";

        $smtp_conn = fsockopen("ssl://m.mrsu.ru", 465, $errno, $errstr);
        $data = $this->get_data($smtp_conn);

        return json_encode($data);

        fputs($smtp_conn, "EHLO Eugene Art\r\n");
        $size_msg = strlen($header . "\r\n" . $text);

        fputs($smtp_conn, "AUTH LOGIN\r\n");
        fputs($smtp_conn, base64_encode("mailer@abiturs.mrsu.ru") . "\r\n");
        fputs($smtp_conn, base64_encode("pZk-9dq-i3B-T44") . "\r\n");
        $data = $this->get_data($smtp_conn);
        return json_encode($data);

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

        $answer = array();
        $code = substr($data, 0, 3);
        if ($code == 250) {
            $answer[0] = "<i class=\"fa fa-check\"></i>
                <br>
                <span>Вопрос успешно отправлен! <br> Мы свяжемся с Вами в ближайшее время.</span>
                <br>
                <a href=\"/\">Вернуться на главную</a>";
        } else {
            $answer[0] = "<i class=\"fa fa-times\"></i>
                <br>
                <span>Письмо не может быть отправлено. <br> Очередь писем переполненна. Пожалуйста, попробуйте еще раз позже.</span>
                <br>
                <a href=\"/\">Вернуться на главную</a>";
        }
        $answer[1] = $data;

        return json_encode($answer);

    }

}
