@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 contact-us-div">
                <h1 class="text-center main-color">Остались вопросы? Напишите нам</h1>
                <h5 class="text-center">Воспользуйтесь формой обратной связи, чтобы задать интересующие Вас
                    вопросы:</h5>
                <form action="" class="contact-us d-flex align-items-center justify-content-center flex-column p-0">
                    <input name="fio" type="text" placeholder="ФИО *" required>
                    <input name="email" type="email" placeholder="Email *" required>
                    <input id="phone" name="phone" type="tel" placeholder="Номер телефона *" required>
                    <textarea name="question" id="question" cols="60" rows="5" placeholder="Текст вопроса *"
                              required></textarea>
                    <button type="submit">ОТПРАВИТЬ</button>
                </form>
            </div>
            <div class="col-12 m-5 text-center form-sent">
                <i class="fa fa-check"></i>
                <br>
                <span>Вопрос успешно отправлен! <br> Мы свяжемся с Вами в ближайшее время.</span>
                <br>
                <a href="/">Вернуться на главную</a>
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

        $('button').click(() => {
            $('.contact-us-div').hide();
            $('.form-sent').show();
        })
    </script>
@endsection
