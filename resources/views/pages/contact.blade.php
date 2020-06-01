@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3 contact-us-div">
                <div class="row">
                    <div class="col-lg-6 col-md-12 d-flex align-items-center flex-column contact-div pt-0">
                        <h3 class="text-center main-color h1-mrsu mb-0">Контакты</h3>
                        <div class="mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
                            <h3 class="mb-0 text-center main-color contact-main-tel text-decoration-none"><a
                                    href="tel:8 800 222 13 77">8 800 222 13 77</a></h3>
                            <div class="text-center">Бесплатная горячая линия для всех регионов России</div>
                        </div>

                        <table
                            class="table table-borderless d-flex align-items-center justify-content-center flex-column mb-3">
                            <tbody>
                            <tr>
                                <th scope="row" class="text-right"><span
                                        class="font-weight-bold main-color">Адрес:</span></th>
                                <td>г. Саранск, ул. Полежаева, д. 44/3. <br> Учебный корпус № 28</td>
                            </tr>
                            <tr>
                                <th scope="row" rowspan="3" class="text-right"  style="border-bottom: 1px solid #dee2e6"><span
                                        class="main-color font-weight-bold">Режим работы:</span></th>
                                <td colspan="2">Понедельник &mdash; пятница с 9.00 до 17.00 <br/> Перерыв с 12.00 до
                                    13.00
                                </td>
                            </tr>
                            <tr>
                                {{--                            <th scope="row"></th>--}}
                                <td colspan="2">Суббота с 9.00 до 13.00</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #dee2e6">
                                {{--                            <th scope="row"></th>--}}
                                <td colspan="2">Воскресенье &mdash; выходной</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-md-12" id="to-hide">
                        <h3 class="text-center main-color h1-mrsu mb-3 mb-3">Остались вопросы? Напишите нам</h3>
                        {{--                <h5 class="text-center">Воспользуйтесь формой обратной связи, чтобы задать интересующие Вас--}}
                        {{--                    вопросы:</h5>--}}

                        <form id="contactform" method="GET" action=""
                              class="contact-us d-flex align-items-center justify-content-center flex-column p-0">
                            @csrf
                            <input name="fio" id="fio" pattern="^[A-Za-zА-Яа-яЁё\s]+$" type="text" placeholder="ФИО *"
                                   value=""
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
                    <div class="col-lg-6 col-md-12 text-center form-sent">
                    </div>
                </div>
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
                        $('#to-hide').hide();
                        $('.form-sent').show();
                        $('.form-sent').html(data[0]); // выводим ответ сервера
                        $('form input').val('')
                        console.log(data)
                    }
                });
            });
        });
    </script>
@endsection
