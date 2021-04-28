<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta property="og:title" content="Приёмная кампания МГУ им. Н.П. Огарёва {{$year}}"/>
    <meta property="og:description"
          content="Приёмная кампания МГУ им. Н.П. Огарева {{$year}}. Статистика приёма, подбор направления."/>
    <meta property="og:image" content="https://abiturs.mrsu.ru/storage/preview/20200128_163227_image.jpeg"/>
    <meta property="og:type" content="profile"/>
    <meta property="og:url" content="https://abiturs.mrsu.ru/"/>
    <meta name="theme-color" content="#2366a5">
    <meta name="keywords"
          content="Приемная кампания, МГУ Огарева, МГУ им. Н.П. Огарева, приемная комиссия, приемная комиссия {{$year}}"/>
    <meta name="subject" content="Приемная кампания МГУ им. Н.П. Огарева {{$year}}">
    <meta name="author" content="Арташкин Евгений, Кирдяшкина Элина">
    <meta name="robots" content="index,follow"/>
    <meta name="description" content="Приемная кампания МГУ им. Н.П. Огарева {{$year}}"/>
    <meta name="url" content="https://abiturs.mrsu.ru/">
    <meta name="identifier-URL" content="https://abiturs.mrsu.ru/">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet"
          href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="shortcut icon" href="{{asset('storage/images/iconka_mrsu.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    @php
        $stylesh = 'css/';
        $stylesh .= session('ovz-style', 'style');
        $stylesh .= '.css';
    @endphp
    <link href="{{asset( $stylesh )}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/hamburgers.css')}}" id="ovzCSSLink">
{{--    <link rel="stylesheet" href="{{asset('css/mainLocal.css')}}" type="text/css">--}}
{{--    <link rel="stylesheet" href="{{asset('css/mrsu2021.css')}}" type="text/css">--}}

    @section('style')
    @show
    <title>Приёмная кампания {{$year}} МГУ им. Н.П. Огарёва</title>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(65004307, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/65004307" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body>
<header class="background">
    <div class="blue-background">
        <div class="container container__mrsu">
            <div class="head">
                <div class="row autowidth">
                    <div class="lk">
                        <a href="https://p.mrsu.ru/"><i class="fas fa-user-alt"></i></a>
                    </div>
                    <div class="column">
                        <a href="http://new.mrsu.ru/" class="logo">
                            <div class="logo">
                                <div class="logo-img">

                                        <img src="{{asset('storage/images/mrsu2021/logo_without_border.png')}}"  class="mrsu-logo-img" alt="">

                                        <img src="{{asset('storage/images/mrsu2021/logo_without_border_black.png')}}" class="mrsu-logo-img-ovz"alt="">

                                </div>
                                <div class="logo-text">
                                    {{ trans('layout.mrsu_1') }}<br>{{ trans('layout.mrsu_2') }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="column menu">
                        <div class="nav">
                            <div class="nav-col">
                                <p><a href="http://new.mrsu.ru/ru/university/">{{ trans('layout.univ') }}</a></p>
                                <p><a href="http://new.mrsu.ru/ru/education/">{{ trans('layout.edu') }}</a></p>
                            </div>
                            <div class="nav-col">
                                <p><a href="http://new.mrsu.ru/ru/sci/">{{ trans('layout.sci') }}</a></p>
                                <p><a href="http://new.mrsu.ru/ru/international/">{{ trans('layout.inter') }}</a></p>
                            </div>
                            <div class="nav-col">
                                <p><a href="http://new.mrsu.ru/ru/student/">{{ trans('layout.stud') }}</a></p>
                                <p><a href="/">{{ trans('layout.abit') }}</a></p>
                            </div>
                        </div>

                        <div class="buttons">
                            <div class="see" id="ovz_version">
                                <a href="{{route('ses.toOvzVer')}}"><i class="far fa-eye"></i></a>
                            </div>
                            <div class="see" id="main_version">
                                <a href="{{route('ses.backToMainVer')}}"><i class="far fa-eye"></i></a>
                            </div>
                            <div class="lang-box">

                                <div class="hamburger-menu">
                                    <input id="menu__toggle" type="checkbox"/>
                                    <label class="menu__btn" for="menu__toggle">
                                        <span></span>
                                    </label>
                                    <div class="menu__box">
                                        <div class="container container__mrsu">
                                            <div class="row hamburger__head autowidth">
                                                <div class="column">
                                                    <a href="/" class="logo">
                                                        <div class="logo">
                                                            <div class="logo-img">
                                                                <img src="{{asset('storage/images/mrsu2021/logo_without_border.png')}}"  class="mrsu-logo-img" alt="">

                                                                <img src="{{asset('storage/images/mrsu2021/logo_without_border_black.png')}}" class="mrsu-logo-img-ovz"alt="">
                                                            </div>
                                                            <div class="logo-text">
                                                                {{ trans('layout.mrsu_1') }}<br>{{ trans('layout.mrsu_2') }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="column hamburger__search">
                                                    <form action="#">
                                                        <span>Поиск: </span>
                                                        <input type="text" name="search">
                                                        <button type="submit"><i class="fas fa-search"></i></button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="row underline-row">
                                                <ul class="hamburger__menu">
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/university/">{{ trans('layout.univ') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu1"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu1" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="http://new.mrsu.ru/ru/university/">{{ trans('layout.u-1') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/niu/">{{ trans('layout.u-2') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/faculty/">{{ trans('layout.u-3') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/srvrm/">{{ trans('layout.u-4') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/programs/">{{ trans('layout.u-5') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/it">{{ trans('layout.u-6') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/sveden/">{{ trans('layout.u-7') }}</a></li>
                                                            <li><a href="https://fund.mrsu.ru/">{{ trans('layout.u-8') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/anticorr">{{ trans('layout.u-9') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/">{{ trans('layout.u-10') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/contacts/">{{ trans('layout.u-11') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/education/">{{ trans('layout.edu') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu2"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu2" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="http://new.mrsu.ru/ru/education/">{{ trans('layout.e1') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/education/pre-university/">{{ trans('layout.e6') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/education/graduate/">{{ trans('layout.e7') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/education/asp/">{{ trans('layout.e8') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/education/ord/">{{ trans('layout.e9') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/education/dop/">{{ trans('layout.e10') }}</a></li>
                                                            <li><a href="http://p.mrsu.ru/">{{ trans('layout.e2') }}</a></li>
                                                            <li><a href="https://www.mrsu.ru/ru/edu/first_akkr.php?ID=2967">{{ trans('layout.e3') }}</a></li>
                                                            <li><a href="http://openedo.mrsu.ru/enrol/index.php?id=37">{{ trans('layout.e4') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/education/satellite/">{{ trans('layout.e5') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/sci/">{{ trans('layout.sci') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu3"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu3" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="http://new.mrsu.ru/ru/sci/diss/">{{ trans('layout.s1') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.s2') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.s3') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/sci/journals/">{{ trans('layout.s4') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/sci/conferences/">{{ trans('layout.s5') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/sci/olympiads/">{{ trans('layout.s6') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/sci/grants/">{{ trans('layout.s7') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/sci/personal-grants/">{{ trans('layout.s8') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/international/">{{ trans('layout.inter') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu4"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu4" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="http://new.mrsu.ru/ru/international/partner-net/">{{ trans('layout.i1') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/international/projects/">{{ trans('layout.i2') }}</a></li>
                                                            <li><a href="https://abiturs.mrsu.ru/Inostrannim-abiturientam">{{ trans('layout.i3') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/international/insurance/">{{ trans('layout.i4') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/international/grants/">{{ trans('layout.i5') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/student/">{{ trans('layout.stud') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu5"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu5" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="http://new.mrsu.ru/ru/student/accommodations/">{{ trans('layout.st1') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/student/coneducation/">{{ trans('layout.st2') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/depart/finansovo-ekonomicheskoe-upravlenie/docs/sec/polozhenie-o-stipendialnom-obespechenii-i/">{{ trans('layout.st3') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/depart/studencheskiy-kombinat-pitaniya-molodezhnyy/">{{ trans('layout.st4') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/student/obsport/">{{ trans('layout.st5') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/depart/sanatoriy-profilaktoriy/">{{ trans('layout.st6') }}</a></li>
                                                            <li><a href="http://www.library.mrsu.ru/">{{ trans('layout.st7') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/student/studorg/">{{ trans('layout.st8') }}</a></li>
                                                            <li><a href="http://my.nioc.mrsu.ru/">{{ trans('layout.st9') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/student/antiterror/">{{ trans('layout.st10') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="/">{{ trans('layout.abit') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu6"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu6" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="https://abiturs.mrsu.ru/Bakalavriat-i-spetsialitet">{{ trans('layout.a1') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/depart/priemnaya-komissiya/">{{ trans('layout.a2') }}</a></li>
                                                            <li><a href="https://abiturs.mrsu.ru/Bakalavriat-i-spetsialitet">{{ trans('layout.a3') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/student/accommodations/">{{ trans('layout.a4') }}</a></li>
                                                            <li><a href="https://abiturs.mrsu.ru/select/bachelor">{{ trans('layout.a5') }}</a></li>
                                                            <li><a href="https://abiturs.mrsu.ru/contact">{{ trans('layout.a6') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/university/documentation/">{{ trans('layout.documents') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu7"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu7" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/organizatsionnye-dokumenty/">{{ trans('layout.d1') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/missiya-universiteta/">{{ trans('layout.d2') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/politika-v-oblasti-kachestva/">{{ trans('layout.d3') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/prikazy/">{{ trans('layout.d4') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/konkursnaya-dokumentatsiya/">{{ trans('layout.d5') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/uslugi/">{{ trans('layout.d6') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/dokumenty-ibs/">{{ trans('layout.d7') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/litsenziya-na-pravo-vedeniya-obrazovatelnoy-deyatelnosti/">{{ trans('layout.d8') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/litsenziya-na-pravo-vedeniya-obrazovatelnoy-deyatelnosti/">{{ trans('layout.d9') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/svidetelstvo-o-gosudarstvennoy-akkreditatsii/">{{ trans('layout.d10') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/svidetelstvo-o-gosudarstvennoy-akkreditatsii-do-21-05-2019/">{{ trans('layout.d11') }}</a></li>
                                                            <li><a href="http://new.mrsu.ru/ru/university/documentation/sec/sertifikat-sootvetstviya-sistemy-menedzhmenta-kachestva-/">{{ trans('layout.d12') }}</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a class="menu__item" href="http://new.mrsu.ru/ru/rector/">{{ trans('layout.rector') }}</a>
                                                        <input type="checkbox" name="menu_item" id="checksubmenu8"
                                                               class="checksubmenuhide">
                                                        <label for="checksubmenu8" class="checksubmenu"></label>
                                                        <ul class="hamburger__submenu">
                                                            <li><a href="#">{{ trans('layout.r1') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r2') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r3') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r4') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r5') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r6') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r7') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r8') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r9') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r10') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r11') }}</a></li>
                                                            <li><a href="#">{{ trans('layout.r12') }}</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="row hamburger__footer">
                                                <div class="row foot-bottom-block">
                                                    <div
                                                        class="col-lg-6 col-md-6 col-sm-6 mb-4 col_one padding__with__header">
                                                        <p class="copyright">© 1998–<?=date("Y");?> {{ trans('layout.menu-mrsu') }}<br>
                                                            {{ trans('layout.menu-footer') }}</p>
                                                    </div>
                                                    <div
                                                        class="col-lg-6 col-md-6 col-sm-6 mb-4 social col_two padding__with__header__icon">
                                                        <a href="https://vk.com/mrsu13">

                                                            <img class="size__image__footer mrsu-logo-img"
                                                                        src="{{asset('storage/images/mrsu2021/VKW.svg')}}"
                                                                        alt="">
                                                            <img class="size__image__footer mrsu-logo-img-ovz"
                                                                        src="{{asset('storage/images/mrsu2021/VK.svg')}}"
                                                                        alt="">
                                                        </a>
                                                        <a href="https://www.facebook.com/MordovskijUniversitet">
                                                            <img class="size__image__footer mrsu-logo-img"
                                                                        src="{{asset('storage/images/mrsu2021/FacebookW.svg')}}"
                                                                        alt="">
                                                            <img class="size__image__footer mrsu-logo-img-ovz"
                                                                 src="{{asset('storage/images/mrsu2021/Facebook.svg')}}"
                                                                 alt="">
                                                        </a>
                                                        <a href="https://twitter.com/Ogarev_mrsu">
                                                            <img class="size__image__footer mrsu-logo-img"
                                                                        src="{{asset('storage/images/mrsu2021/TwitterW.svg')}}"
                                                                        alt="">
                                                            <img class="size__image__footer mrsu-logo-img-ovz"
                                                                 src="{{asset('storage/images/mrsu2021/Twitter.svg')}}"
                                                                 alt="">
                                                        </a>
                                                        <a href="https://www.instagram.com/ogarev_mrsu/">
                                                            <img class="size__image__footer mrsu-logo-img"
                                                                        src="{{asset('storage/images/mrsu2021/InstagramW.svg')}}"
                                                                        alt="">
                                                            <img class="size__image__footer mrsu-logo-img-ovz"
                                                                 src="{{asset('storage/images/mrsu2021/Instagram.svg')}}"
                                                                 alt="">
                                                        </a>
                                                        <a href="https://www.youtube.com/user/OgarevTV">
                                                            <img class="size__image__footer mrsu-logo-img"
                                                                        src="{{asset('storage/images/mrsu2021/YoutubeW.svg')}}"
                                                                        alt="">
                                                            <img class="size__image__footer mrsu-logo-img-ovz"
                                                                 src="{{asset('storage/images/mrsu2021/Youtube.svg')}}"
                                                                 alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="lang">
                                    <div class="topmenu">{{trans('layout.lang_self')}}
                                        <ul class="submenu">
                                            <li><a href="{{ trans('layout.href') }}">{{trans('layout.lang')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="bg-blur"></div>

<nav class="navbar navbar-expand-lg navbar-dark bg-light main-nav pt-0 pb-0">
    <div class="container">
{{--        <div class="collapse navbar-collapse" id="navbarNav">--}}
            <ul class="navbar-nav d-flex justify-content-between w-100 m-auto mrsu-uppertext text-center">
                @php
                    use Carbon\Carbon;
                    $date_now = Carbon::today();
                    $date_now = $date_now->toDateString();
                @endphp
                @if(trans('layout.locale') == 'ru')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.levels') }}
                        </a>
                        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                            {{--образуются в app\Providers\AppServiceProvider.php--}}
                            @foreach($pages as $page)
                                @if ((($date_now > $page->activityFrom || $date_now == $page->activityFrom) &&
                                ($date_now < $page->activityTo || $date_now == $page->activityTo))
                                || (is_null($page->activityFrom) && is_null($page->activityTo)))
                                    <a class="nav-link " href="{{url($page->url)}}">{{ $page->name }}</a>
                                @endif
                            @endforeach
                            <a class="nav-link" href="{{route('archive.index')}}">Архив</a>
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'en')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.levels') }}
                        </a>
                        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                            {{--образуются в app\Providers\AppServiceProvider.php--}}
                            @foreach($infoblocks_int as $page)
                                @if ((($date_now > $page->activityFrom || $date_now == $page->activityFrom) &&
                                ($date_now < $page->activityTo || $date_now == $page->activityTo))
                                || (is_null($page->activityFrom) && is_null($page->activityTo)))
                                    <a class="nav-link " href="{{url($page->url)}}">{{ $page->name }}</a>
                                @endif
                            @endforeach
                            <a class="nav-link " href="{{route('archive.index')}}">Archive</a>
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'ru')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.lists') }}
                        </a>
                        <div class="dropdown-menu main-color" aria-labelledby="navbarDropdown">
                            <a class="nav-link " href="{{route('stat.index')}}">{{ trans('layout.bach') }}</a>
                            <a class="nav-link "
                               href="{{route('statmaster.index')}}">{{ trans('layout.master') }}</a>
                            <a class="nav-link "
                               href="{{route('statasp.index')}}">{{ trans('layout.asp') }}</a>
                            <a class="nav-link "
                               href="{{route('statspo.index')}}">{{ trans('layout.spo') }}</a>

                            <a class="nav-link dropdown-toggle " href="" id="navbarDropdown1" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ trans('layout.foreigner') }}
                            </a>
                            <div class="dropdown-menu drop-sub main-color-dropdown" aria-labelledby="navbarDropdown1">
                                <a class="nav-link "
                                   href="{{route('statforeigner.index')}}">{{ trans('layout.bach') }}</a>
                                <a class="nav-link "
                                   href="{{route('statmasterforeigner.index')}}">{{ trans('layout.master') }}</a>
                                <a class="nav-link "
                                   href="{{route('stataspforeigner.index')}}">{{ trans('layout.asp') }}</a>
                            </div>
                            @if($count_stats > 0)
                                <a class="nav-link "
                                   href="{{route('total.index')}}">{{ trans('layout.stat') }}</a>
                            @endif
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'en')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.foreigner') }}
                        </a>
                        <div class="dropdown-menu main-color" aria-labelledby="navbarDropdown">

                            <a class="nav-link "
                               href="{{route('statforeigner.index')}}">{{ trans('layout.bach') }}</a>
                            <a class="nav-link "
                               href="{{route('statmasterforeigner.index')}}">{{ trans('layout.master') }}</a>
                            <a class="nav-link "
                               href="{{route('stataspforeigner.index')}}">{{ trans('layout.asp') }}</a>

                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'ru')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.select') }}
                        </a>
                        <div class="dropdown-menu main-color" aria-labelledby="navbarDropdown">
                            <a class="nav-link "
                               href="{{route('selection.index')}}">{{ trans('layout.bach') }}</a>
                            <a class="nav-link "
                               href="{{route('selectionf.index')}}">{{ trans('layout.for_foreigner') }}</a>
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'en')
                    <li class="nav-item active d-flex align-items-center justify-content-center">
                        <a class="nav-link" href="{{route('selectionf.index')}}">{{ trans('layout.for_foreigner') }}
                            <span
                                class="sr-only">(current)</span></a>
                    </li>
                @endif

                @if($count_orders > 0)
                    @if(trans('layout.locale') == 'ru')
                        <li class="nav-item active d-flex align-items-center justify-content-center">
                            <a class="nav-link" href="{{route('order.index')}}">{{ trans('layout.order') }}
                                <span
                                    class="sr-only">(current)</span></a>
                        </li>
                    @endif
                @endif
                <li class="nav-item active d-flex align-items-center justify-content-center">
                    <a class="nav-link" href="{{route('contact.index')}}">{{ trans('layout.contacts') }}<span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active d-flex align-items-center justify-content-center">
                    <a class="nav-link" target="_blank"
                       href="https://p.mrsu.ru/Account/Register">{{ trans('layout.docs') }}<span
                            class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
{{--    </div>--}}
</nav>

{{--<div class="preloader">--}}
    <!-- Элементы прелоадера -->
{{--    <div class="preloader-5"></div>--}}
{{--</div>--}}
<div class="contentpage">
@section('page')
@show
</div>
<footer>
    <div class="container container__mrsu footer-blocks">
        <div class="row underline-row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4 padding__with__header">
                <p class="bold bottom main__corpus">{{trans('layout.c1_title')}}</p>
                <div class="position">
                    <table border="0" class="footer-table">
                        <tr>
                            <td class="">
                                <div class="pos"><img src="{{asset('storage/images/mrsu2021/2I.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="https://yandex.ru/maps/-/CCUYE4CjoB">{{trans('layout.c1_ad')}}</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="pos"><img class="image_footer"
                                                      src="{{asset('storage/images/mrsu2021/1E.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a
                                        href="mailto:dep-general@adm.mrsu.ru">dep-general@adm.mrsu.ru</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="pos__mobile"><img class="image_footer"
                                                              src="{{asset('storage/images/mrsu2021/9H.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="tel:+78342243732">+7 (8342) 24-37-32</a></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4 padding__with__header">
                <p class="bold bottom">{{trans('layout.c2_title')}}</p>
                <div class="position">
                    <table border="0" class="footer-table">
                        <tr>
                            <td class="">
                                <div class="image_footer_glob"><img class=""
                                                                    src="{{asset('storage/images/mrsu2021/6I.svg')}}">
                                </div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="" class="">{{trans('layout.c1_priem')}}</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="pos"><img class="image_footer"
                                                      src="{{asset('storage/images/mrsu2021/1E.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="mailto:rector@adm.mrsu.ru">rector@adm.mrsu.ru</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="pos__mobile"><img class="image_footer"
                                                              src="{{asset('storage/images/mrsu2021/9H.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a class="dop-text" href="tel:+78342244888">+7 (8342) 24-48-88</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="pos-text"><span class="color__footer dop-text">+7 (8342)</span><span
                                        class="number__padding"><a class="dop-text"
                                                                   href="tel:+78342244757"> 24-47-57</a></span></div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="pos-text"><span class="color__footer dop-text">+7 (8342)</span><span
                                        class="number__padding"><a class="dop-text"
                                                                   href="tel:+78342233934"> 23-39-34</a></span></div>
                            </td>
                        </tr>
                        <!-- <tr> -->
                        <!-- <td></td> -->
                        <!-- <td><p class="top-margin"><a href="" class="underline">Показать на карте</a></p></td> -->
                        <!-- </tr> -->
                    </table>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4 padding__with__header">
                <p class="bold bottom">{{trans('layout.c3_title')}}</p>
                <div class="position">
                    <table border="0" class="footer-table">
                        <tr>
                            <td class="">
                                <div class="pos"><img class="image_footer"
                                                      src="{{asset('storage/images/mrsu2021/2I.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="https://yandex.ru/maps/-/CCUYE4gASD">{{trans('layout.c3_ad')}}</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="pos"><img class="image_footer"
                                                      src="{{asset('storage/images/mrsu2021/1E.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="mailto:entrance-exam@adm.mrsu.ru">entrance-exam@adm.mrsu.ru</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="pos__mobile"><img class="image_footer"
                                                              src="{{asset('storage/images/mrsu2021/9H.svg')}}"></div>
                            </td>
                            <td>
                                <div class="pos-text"><a href="tel:88002221317">+7 (800) 222-13-17</a></div>
                            </td>
                        </tr>
                        <!-- <tr> -->
                        <!-- <td></td> -->
                        <!-- <td><p class="top-margin"><a href="" class="underline">Показать на карте</a></p></td> -->
                        <!-- </tr> -->
                    </table>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4 padding__with__header">
                <p class="bold bottom">{{trans('layout.c4_title')}}</p>
                <div class="position__list">
                    <ul class="list_footer">
                        <li><a href="http://new.mrsu.ru/sveden/common/" class="underline">{{trans('layout.c4_s1')}}</a></li>
                        <li><a href="http://new.mrsu.ru/ru/university/anticorr/" class="underline">{{trans('layout.c4_s2')}}</a></li>
                        <li><a href="http://new.mrsu.ru/ru/university/contacts/" class="underline">{{trans('layout.c4_s3')}}</a></li>
                        <li><a href="https://iptel.mrsu.ru/" class="underline">{{trans('layout.c4_s4')}}</a></li>
                        <li><a href="https://pay.mrsu.ru/" class="underline">{{trans('layout.c4_s5')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row foot-bottom-block">
            <div class="col-lg-6 col-md-6 col-sm-6 mb-4 col_one padding__with__header">
                <p class="copyright">© 1998–2021 {{trans('layout.menu-mrsu')}}<br>
                    {{trans('layout.footer_atten')}}</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 mb-4 social col_two padding__with__header__icon">
                <a href="https://vk.com/mrsu13"><img class="size__image__footer"
                                                     src="{{asset('storage/images/mrsu2021/VK.svg')}}" alt=""></a>
                <a href="https://www.facebook.com/MordovskijUniversitet"><img class="size__image__footer"
                                                                              src="{{asset('storage/images/mrsu2021/Facebook.svg')}}"
                                                                              alt=""></a>
                <a href="https://twitter.com/Ogarev_mrsu"><img class="size__image__footer"
                                                               src="{{asset('storage/images/mrsu2021/Twitter.svg')}}"
                                                               alt=""></a>
                <a href="https://www.instagram.com/ogarev_mrsu/"><img class="size__image__footer"
                                                                      src="{{asset('storage/images/mrsu2021/Instagram.svg')}}"
                                                                      alt=""></a>
                <a href="https://www.youtube.com/user/OgarevTV"><img class="size__image__footer"
                                                                     src="{{asset('storage/images/mrsu2021/Youtube.svg')}}"
                                                                     alt=""></a>
            </div>
        </div>
    </div>
</footer>


</body>
<script src="{{asset('js/version.js')}}"></script>
<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.js')}}"></script>
<script src="{{asset('js/defaults-ru_RU.min.js')}}"></script>
<script>
    window.onload = function() {
        document.querySelector('.preloader').classList.add("preloader-remove");
    }
</script>
<script>
    $('.hamburger').click(() => {
        $('.hamburger').toggleClass('is-active');
    })
</script>
@section("js")
@show
</html>
