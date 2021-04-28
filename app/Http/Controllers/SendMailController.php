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
        $mailSMTP = new SendMailSmtpClass('mailer@abiturs.mrsu.ru', 'Azd!@sxf146', 'ssl://m.mrsu.ru', 'Evgeniy', 465);

        $header = "Date: " . date("D, j M Y G:i:s") . " +0300\r\n";
        $header .= "From: =?UTF-8?B?" . base64_encode('Приёмная кампания 2020') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Mailer: Mail.Ru Mailer 1.0\r\n";
        $header .= "Reply-To: =?UTF-8?B?" . base64_encode('Приёмная кампания 2020') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Priority: 3 (Normal)\r\n";
        $header .= "Message-ID: <172562218." . date("YmjHis") . "@abiturs.mrsu.ru>\r\n";
        $header .= "To: =?UTF-8?B?" . base64_encode('Петрова Елена Сергеевна') . "?= <entrance-exam@adm.mrsu.ru>\r\n";
        $header .= "Subject: =?UTF-8?B?" . base64_encode('Вопрос от абитуриента') . "?=\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/plain; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n";
        $text = "ФИО: " . $request->fio . "\r\n";
        $text .= "Email: " . $request->email . "\r\n";
        $text .= "Номер телефона: " . $request->phone . "\r\n";
        $text .= "Текст вопроса: " . $request->question . ".\r\n";

        if ($request->fio && $request->email && $request->phone && $request->question) {

            $result = $mailSMTP->send('entrance-exam@adm.mrsu.ru', 'Вопрос от абитуриента', $text, $header); // отправляем письмо

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
        }else{
            return;
        }

    }

    public function english(Request $request)
    {
        $mailSMTP = new SendMailSmtpClass('mailer@abiturs.mrsu.ru', 'Azd!@sxf146', 'ssl://m.mrsu.ru', 'Evgeniy', 465);

        $header = "Date: " . date("D, j M Y G:i:s") . " +0300\r\n";
        $header .= "From: =?UTF-8?B?" . base64_encode('Приёмная кампания 2020') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Mailer: Mail.Ru Mailer 1.0\r\n";
        $header .= "Reply-To: =?UTF-8?B?" . base64_encode('Приёмная кампания 2020') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Priority: 3 (Normal)\r\n";
        $header .= "Message-ID: <172562218." . date("YmjHis") . "@abiturs.mrsu.ru>\r\n";
        $header .= "To: =?UTF-8?B?" . base64_encode('УМС') . "?= <dep-inter@adm.mrsu.ru>\r\n";
        $header .= "Subject: =?UTF-8?B?" . base64_encode('Вопрос от абитуриента') . "?=\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/plain; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n";
        $text = "ФИО: " . $request->fio . "\r\n";
        $text .= "Email: " . $request->email . "\r\n";
        $text .= "Номер телефона: " . $request->phone . "\r\n";
        $text .= "Текст вопроса: " . $request->question . ".\r\n";

        if ($request->fio && $request->email && $request->phone && $request->question) {

            $result = $mailSMTP->send('dep-inter@adm.mrsu.ru', 'Вопрос от абитуриента', $text, $header); // отправляем письмо

            if ($result) {
                $answer[0] = "<i class=\"fa fa-check\"></i>
                <br>
                <span>The question has been successfully sent! <br> We'll get back to you soon.</span>
                <br>
                <a href=\"/\">Вернуться на главную</a>";
            } else {
                $answer[0] = "<i class=\"fa fa-times\"></i>
                <br>
                <span>The letter can't be sent. <br> The queue of letters is crowded. Please try again later.</span>
                <br>
                <a href=\"/\">Back to the main page</a>";
            }
            return json_encode($answer);
        }else{
            return;
        }

    }
	
	 public function mrsu(Request $request)
    {
        $mailSMTP = new SendMailSmtpClass('mailer@abiturs.mrsu.ru', 'Azd!@sxf146', 'ssl://m.mrsu.ru', 'Evgeniy', 465);

        $header = "Date: " . date("D, j M Y G:i:s") . " +0300\r\n";
        $header .= "From: =?UTF-8?B?" . base64_encode('Сайт МГУ') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Mailer: Mail.Ru Mailer 1.0\r\n";
        $header .= "Reply-To: =?UTF-8?B?" . base64_encode('Сайт МГУ') . "?= <abiturs@mrsu.ru>\r\n";
        $header .= "X-Priority: 3 (Normal)\r\n";
        $header .= "Message-ID: <172562218." . date("YmjHis") . "@abiturs.mrsu.ru>\r\n";
        $header .= "To: =?UTF-8?B?" . base64_encode('Обращения граждан') . "?= <kirdyashkinaei@mrsu.ru priem@mrsu.ru>\r\n";
        $header .= "Subject: =?UTF-8?B?" . base64_encode('Обращения граждан') . "?=\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/plain; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n";
		
        
		$text = "ФИО: " . $request->surname ." " . $request->name ." ". $request->mname ."\r\n";
        $text .= "Организация: " . $request->organization . "\r\n";
        $text .= "Email: " . $request->email . "\r\n";
        $text .= "Номер телефона: " . $request->phone . "\r\n";
        $text .= "Тема обращения: " . $request->topic . "\r\n";
        $text .= "Текст обращения: " . $request->text . "\r\n";
		

        if ($request->surname && $request->name && $request->email && $request->topic && $request->text) {

            $result = $mailSMTP->send('kirdyashkinaei@mrsu.ru', 'Обращения граждан', $text, $header); // отправляем письмо
            $result = $mailSMTP->send('priem@mrsu.ru', 'Обращения граждан', $text, $header); // отправляем письмо

            if ($result) {
                $answer[0] = "<i class=\"fa fa-check\"></i>
                <br>
                <span>Вопрос успешно отправлен! <br> Мы свяжемся с Вами в ближайшее время.</span>
                <br>";
            } else {
                $answer[0] = "<i class=\"fa fa-times\"></i>
                <br>
                <span>Письмо не может быть отправлено. <br> Очередь писем переполненна. Пожалуйста, попробуйте еще раз позже.</span>
                <br>";
            }
            return json_encode($answer);
        }else{
            return;
        }

    }
	
}
