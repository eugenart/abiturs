@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 m-5">
                <form action="" class="contact-us mrsu-card d-flex align-items-center justify-content-center flex-column">
                    <p class="mrsu-uppertext" style="color: #1b4b72"><b>Задайте нам вопрос!</b></p>
                    <input type="text" placeholder="ФИО">
                    <input type="email" placeholder="Email">
                    <textarea name="" id="" cols="60" rows="5" placeholder="Текст вопроса"></textarea>
                    <button type="submit"><i class="far fa-paper-plane fa-1x"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
