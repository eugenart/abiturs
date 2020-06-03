<?php

namespace App\Http\Controllers;

use App\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailSmtpClass;

class SendMailController extends Controller
{

    public function index(Request $request)
    {
        $mailSMTP = new SendMailSmtpClass('mailer@abiturs.mrsu.ru', 'pZk-9dq-i3B-T44', 'ssl://m.mrsu.ru', 'Evgeniy', 465);

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


        $result = $mailSMTP->send('artashkinep@mrsu.ru', 'Вопрос от абитуриента', $text, $header); // отправляем письмо

        if ($result) {
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
        return json_encode($answer);

    }

}
