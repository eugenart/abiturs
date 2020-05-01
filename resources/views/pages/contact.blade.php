@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 contact-us-div">
                <h1 class="text-center main-color">Остались вопросы? Напишите нам</h1>
                <h5 class="text-center">Воспользуйтесь формой обратной связи, чтобы задать интересующие Вас
                    вопросы:</h5>

                <form id="contactform" method="GET" action=""
                      class="contact-us d-flex align-items-center justify-content-center flex-column p-0">
                    @csrf
                    <input name="fio" id="fio" pattern="^[A-Za-zА-Яа-яЁё\s]+$" type="text" placeholder="ФИО *" value=""
                           required>
                    <input name="email" id="email" type="email" placeholder="Email *" required>
                    <input name="phone" id="phone"
                           {{--pattern="[+]\d[(][0-9]{3}[)]\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}"--}} type="tel"
                           placeholder="Номер телефона *" required>
                    <textarea name="question" id="question" cols="60" rows="5" placeholder="Текст вопроса *"
                              required></textarea>
                    <button type="submit" id="btn-submit">ОТПРАВИТЬ</button>
                </form>

            </div>
            <div class="col-12 mt-5 text-center form-sent">
                {{--                                <i class="fa fa-check"></i>--}}
                {{--                                <br>--}}
                {{--                                <span>Вопрос успешно отправлен! <br> Мы свяжемся с Вами в ближайшее время.</span>--}}
                {{--                                <br>--}}
                {{--                                <a href="/">Вернуться на главную</a>--}}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
    <script>
        $(document).ready(() => {
            $("#phone").mask("+7(999) 999-9999");
            $('.form-sent').hide();
        })

        // $('button[type="submit"]').click(() => {
        //     $('.contact-us-div').hide();
        //     $('.form-sent').show();
        // })

        $(document).ready(function () {
            $('#contactform').submit(function (e) {
                let serializedData = $('#contactform').serialize();
                e.preventDefault();
                // собираем данные с формы
                $.ajax({
                    url: "/send_mail", // куда отправляем
                    type: "get", // метод передачи
                    dataType: "json", // тип передачи данных
                    data: serializedData,

                    // после получения ответа сервера
                    success: function (data) {
                        $('.contact-us-div').hide();
                        $('.form-sent').show();
                        $('.form-sent').html(data[0]); // выводим ответ сервера
                        $('form input').val('')
                        console.log(data[1])
                    }
                });
            });
        });
    </script>
@endsection
