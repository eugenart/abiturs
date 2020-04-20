<?php

namespace App\Http\Controllers;

use App\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{


    public function index(Request $request)
    {
        $fio = $request->fio;
        $email = $request->email;
        $phone = $request->phone;
        $question = $request->question;

        $mail = new ContactMail;
        $mail->fio = $fio;
        $mail->email = $email;
        $mail->phone = $phone;
        $mail->question = $question;
        $mail->save();

        $to      = 'eugen.art@mail.ru';
        $subject = 'the subject';
        $message = 'hello';
        $headers = array(
            'From' => 'webmaster@example.com',
            'Reply-To' => 'webmaster@example.com',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        mail($to, $subject, $message, $headers);


        $result = array(
            'result' => "<i class=\"fa fa-check\"></i>
                                <br>
                                <span>Вопрос успешно отправлен! <br> Мы свяжемся с Вами в ближайшее время.</span>
                                <br>
                                <a href=\"/\">Вернуться на главную</a>"
        );
        return json_encode($result);

    }

//    public function send()
//    {
//        $to = 'artashkinep@mrsu.ru';
//        $subject = 'the subject';
//        $message = 'hello';
//        $headers = 'From: webmaster@example.com' . "\r\n" .
//            'Reply-To: webmaster@example.com' . "\r\n" .
//            'X-Mailer: PHP/' . phpversion();
//
//        mail($to, $subject, $message, $headers);
//
//        return 'ok';
//    }
}
