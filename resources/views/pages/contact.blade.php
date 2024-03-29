@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3 contact-us-div">
                <div class="row">
                    <div class="col-lg-6 col-md-12 d-flex align-items-center flex-column contact-div pt-0">
                        <h1 class="text-center main-color h1-mrsu mb-0">{{ trans('contacts.contacts') }}</h1>
                        <div class="mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
                            @if(trans('layout.locale') == 'ru')
                                <h3 class="mb-0 text-center main-color contact-main-tel text-decoration-none">
                                    <a href="tel:8 800 222 13 77">8 800 222 13 77</a>
                                </h3>
                                <div class="text-center">{{ trans('contacts.hot_line') }}</div>
                            @endif
                            @if(trans('layout.locale') == 'en')
                                <h3 class="mb-0 text-center main-color contact-main-tel-en text-decoration-none">
                                    <a class='main-color' href="tel:+78342247951"> +7 (8342) 24 79 51 </a>
                                </h3>
                                <div class="text-center">{{ trans('contacts.hot_line_en') }}</div>
                            @endif
                        </div>

                        <table
                            class="table table-borderless d-flex align-items-center justify-content-center flex-column mb-3">
                            <tbody>
                            @if(trans('layout.locale') == 'ru')
                                <tr>
                                    <th scope="row" class="text-right"><span
                                            class="font-weight-bold main-color">{{ trans('contacts.tel_title') }}</span>
                                    </th>
                                    <td>
                                        {{ trans('contacts.tel_foreigner') }}<br>
                                        <a class='main-color' href="tel:+78342247951"> +7 (8342) 24-79-51 </a>
                                        <br>
                                        {{ trans('contacts.tel_kov') }} <br>
                                        <a class='main-color' href="tel:88345342910">8 (8345) 34-29-10</a>
                                        <br>
                                        {{ trans('contacts.tel_ruz') }} <br>
                                        <a class='main-color' href="tel:88342222996">8 (8342) 22-29-96</a>
                                        <br>
{{--                                        Добавочные номера:<br>--}}
{{--                                        1217 - Подача документов в электронном виде	<br>--}}
{{--                                        1064 - Заключение договоров на оплату обучения<br>--}}
{{--                                        1081 - Прием документов по программам ординатуры<br>--}}
{{--                                        1642, 1647, 1648 - Прием документов по программам аспирантуры<br>--}}
{{--                                        1073 - Аграрный институт<br>--}}
{{--                                        1074 - Архитектурно-строительный факультет<br>--}}
{{--                                        1067 - Географический факультет<br>--}}
{{--                                        1070 - Институт механики и энергетики<br>--}}
{{--                                        1079 - Институт национальной культуры<br>--}}
{{--                                        1078 - Институт физики и химии<br>--}}
{{--                                        1071 - Институт электроники и светотехники<br>--}}
{{--                                        1077 - Историко-социологический институт<br>--}}
{{--                                        1069 - Медицинский институт<br>--}}
{{--                                        2605 - Рузаевский институт машиностроения<br>--}}
{{--                                        1066 - Факультет биотехнологии и биологии<br>--}}
{{--                                        1062 - Факультет довузовской подготовки и СПО<br>--}}
{{--                                        1068 - Факультет иностранных языков<br>--}}
{{--                                        1072 - Факультет математики и информационных технологий<br>--}}
{{--                                        1065 - Филологический факультет<br>--}}
{{--                                        1075 - Экономический факультет<br>--}}
{{--                                        1076 - Юридический факультет--}}


                                        {{--  {{ trans('contacts.tel_paid') }}<br>
                                          <a class='main-color' href="tel:88342244804">8 (8342) 24-48-04</a>
                                          <br>
                                          <a class='main-color' href="tel:88342233381">8 (8342) 23-33-81</a>
                                          <br>
                                          {{ trans('contacts.tel_ord') }}<br>
                                          <a class='main-color' href="tel:88342223230">8 (8342)
                                              22-32-30 </a>({{ trans('contacts.add') }} 1081)
                                          <br>
                                          {{ trans('contacts.tel_asp') }}
                                          <br>
                                          <a class='main-color' href="tel:88342270722">8 (8342) 27-07-22</a>
                                          <br>
                                          <a class='main-color' href="tel:88342270723">8 (8342) 27-07-23</a>
                                          <br>
                                          <a class='main-color' href="tel:88342270725">8 (8342) 27-07-25</a>--}}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th scope="row" class="text-right"><span
                                        class="font-weight-bold main-color">{{ trans('contacts.adr_title') }}</span>
                                </th>
                                <td>{{ trans('contacts.adr1') }} <br> {{ trans('contacts.adr2') }}<br><br>
                                    {{ trans('contacts.adr_asp1') }} <br> {{ trans('contacts.adr_asp2') }}
                                </td>

                            </tr>
                            <tr>
                                <th scope="row" rowspan="4" class="text-right" style="border-bottom: 1px solid #dee2e6"><span
                                        class="main-color font-weight-bold">{{ trans('contacts.time_title') }}</span>
                                </th>
                                <td colspan="2">{{ trans('contacts.time_monfr') }}
                                    <br/> {{ trans('contacts.time_break') }}
                                </td>

                            </tr>


                            @if(trans('layout.locale')== 'ru')
{{--                                <tr>--}}
{{--                                    <td colspan="2">{{ trans('contacts.time_sat') }}</td>--}}
{{--                                </tr>--}}
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <td colspan="2">{{ trans('contacts.time_sun') }}</td>
                                </tr>
                            @endif
                            @if(trans('layout.locale')== 'en')
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <td colspan="2">{{ trans('contacts.time_sat') }}</td>
                                </tr>
                            @endif
                            <tr style="border-bottom: 1px solid #dee2e6">
                                <td colspan="2">
                                    {{ trans('contacts.time_asp') }}<br>
                                    {{ trans('contacts.time_asp1') }}<br>
                                    {{ trans('contacts.time_asp2') }}<br>
{{--                                    {{ trans('contacts.time_asp3') }}<br>--}}

                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-md-12" id="to-hide">
                        <h3 class="text-center main-color h1-mrsu mb-3 mb-3">{{ trans('contacts.form_title') }}</h3>
                        @if(trans('layout.locale') == 'ru')
                            <form id="contactform" method="GET" action=""
                                  class="contact-us d-flex align-items-center justify-content-center flex-column p-0">
                                @csrf
                                <input name="fio" id="fio" pattern="^[A-Za-zА-Яа-яЁё\s]+$" type="text"
                                       placeholder="{{ trans('contacts.form_fio') }}"
                                       value=""
                                       required>
                                <input name="email" id="email" type="email" placeholder="Email *" required>
                                <input name="phone" id="phone"
                                       {{--pattern="[+]\d[(][0-9]{3}[)]\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}"--}} type="tel"
                                       placeholder="{{ trans('contacts.form_tel') }}" required>
                                <textarea name="question" id="question" cols="60" rows="5"
                                          placeholder="{{ trans('contacts.form_text') }}"
                                          required></textarea>
                                <button type="submit" id="btn-submit">{{ trans('contacts.form_sub') }}</button>
                            </form>
                        @endif
                        @if(trans('layout.locale') == 'en')
                            <form id="contactformen" method="GET" action=""
                                  class="contact-us d-flex align-items-center justify-content-center flex-column p-0">
                                @csrf
                                <input name="fio" id="fio" pattern="^[A-Za-zА-Яа-яЁё\s]+$" type="text"
                                       placeholder="{{ trans('contacts.form_fio') }}"
                                       value=""
                                       required>
                                <input name="email" id="email" type="email" placeholder="Email *" required>
                                <input name="phone" id="phone"
                                       {{--pattern="[+]\d[(][0-9]{3}[)]\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}"--}} type="tel"
                                       placeholder="{{ trans('contacts.form_tel') }}" required>
                                <textarea name="question" id="question" cols="60" rows="5"
                                          placeholder="{{ trans('contacts.form_text') }}"
                                          required></textarea>
                                <button type="submit" id="btn-submit">{{ trans('contacts.form_sub') }}</button>
                            </form>
                        @endif
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

        $(document).ready(function () {
            $('#contactformen').submit(function (e) {
                let serializedData = $('#contactformen').serialize();
                e.preventDefault();
                // собираем данные с формы
                $.ajax({
                    url: "/send_mail_en", // куда отправляем
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
