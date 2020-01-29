<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta property="og:title" content="Приёмная кампания МГУ им. Н.П. Огарева 2020"/>
    <meta property="og:description"
          content="Приёмная кампания МГУ им. Н.П. Огарева 2020. Статистика рпиёма, подбор направления."/>
    <meta property="og:image" content="https://abitur.mrsu.ru/storage/preview/20200128_163227_image.jpeg"/>
    <meta property="og:type" content="profile"/>
    <meta property="og:url" content="https://abitur.mrsu.ru/"/>

    <meta name="keywords"
          content="Приемная кампания, МГУ Огарева, МГУ им. Н.П. Огарева, приемная комиссия, приемная комиссия 2020"/>
    <meta name="subject" content="Приемная кампания МГУ им. Н.П. Огарева 2020">
    <meta name="author" content="Арташкин Евгений, Элина Кирдяшкина">
    <meta name="robots" content="index,follow"/>
    <meta name="description" content="Приемная кампания МГУ им. Н.П. Огарева 2020"/>
    <meta name="url" content="https://abitur.mrsu.ru/">
    <meta name="identifier-URL" content="https://abitur.mrsu.ru/">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{asset('storage/images/iconka_mrsu.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @section('style')
    @show
    <title>Приемная кампания 2020</title>
</head>
<body>
<div class="container">
    <div class="row header p-3">
        <div class="col-6">
            <a href="/"><img src="{{asset('storage/images/logo_mrsu.png')}}" class="mrsu-logo-img" alt=""></a>
        </div>
        <div class="col-6 justify-content-end d-flex align-items-center p-0">
            <img src="{{asset('storage/images/icon_eng.gif')}}" class="mr-3" width="20" height="13" alt="">
            <img src="{{asset('storage/images/eye.png')}}" class="mr-2" width="22" height="13" alt="">
            <button class="navbar-toggler d-lg-none d-md-block" type="button" data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-light main-nav pt-0 pb-0">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex justify-content-between w-75 m-auto mrsu-uppertext text-center">
                <li class="nav-item active d-flex align-items-center justify-content-center">
                    <a class="nav-link" href="{{route('stat.index')}}">Статистика приема <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active d-flex align-items-center justify-content-center">
                    <a class="nav-link" href="{{route('selection.index')}}">Подбор направления <span class="sr-only">(current)</span></a>
                </li>
                @foreach($pages->sortByDesc('menuPriority') as $page)
                    <li class="nav-item active d-flex align-items-center justify-content-center">
                        <a class="nav-link" href="{{url($page->url)}}">{{ $page->name }}</a>
                    </li>
                @endforeach
                <li class="nav-item active d-flex align-items-center justify-content-center">
                    <a class="nav-link" href="{{route('contact.index')}}">Обратная связь <span
                            class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@section('page')

@show
<hr class="mrsu-hr mrsu-bg m-auto">

</body>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

@section("js")
@show
</html>
