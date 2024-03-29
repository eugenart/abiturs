<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md flex-md-nowrap p-2 fixed-top bg-white">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
{{--                        @if (Route::has('register'))--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column mt-5">

                        <li class="nav-item">
                            <a class="nav-link  {{ Request::is('admin/infoblock*') ? 'active' : null }}"
                               href="{{route('infoblock.index')}}">
                                <span data-feather="file"></span>
                                Разделы сайта
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/section*') ? 'active' : null }}" href="{{route('section.index')}}">
                                <span data-feather="shopping-cart"></span>
                                Подразделы сайта
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link {{ Request::is('admin/speciality') ? 'active' : null }}" href="{{route('speciality.index')}}">--}}
{{--                                <span data-feather="shopping-cart"></span>--}}
{{--                                Направления подготовки--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link {{ Request::is('admin/subjects') ? 'active' : null }}" href="{{route('subjects.index')}}">--}}
{{--                                <span data-feather="shopping-cart"></span>--}}
{{--                                Вступительные испытания--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link {{ Request::is('admin/minscore') ? 'active' : null }}" href="{{route('minscore.index')}}">--}}
{{--                                <span data-feather="users"></span>--}}
{{--                                Минимальные баллы вступительных испытаний--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link {{ Request::is('admin/price') ? 'active' : null }}" href="{{route('price.index')}}">--}}
{{--                                <span data-feather="users"></span>--}}
{{--                                Свободные места и стоимость обучения--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        @role('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/parse') ? 'active' : null }}" href="{{route('parse.index')}}">
                                <span data-feather="users"></span>
                                Выгрузка данных
                            </a>
                        </li>
                        @endrole

                        @if(Auth::id() == 5 )
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/parse') ? 'active' : null }}" href="{{route('parse.index')}}">
                                <span data-feather="users"></span>
                                Выгрузка данных
                            </a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/slider*') ? 'active' : null }}" href="{{route('slider.index')}}">
                                <span data-feather="users"></span>
                                Слайдер
                            </a>
                        </li>
                        <li class="nav-item" style="margin-top:0.5em; margin-bottom: 0.5em; border-top:1px solid rgb(0, 123, 255, 0.5);"></li>
                        @role('admin')
{{--                        <li class="nav-item " >--}}
{{--                            <a class="nav-link {{ Request::is('admin/year') ? 'active' : null }}" href="{{route('year.index')}}">--}}
{{--                                <span data-feather="users"></span>--}}
{{--                                Год приемной кампании--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/times') ? 'active' : null }}" href="{{route('times.index')}}">
                                <span data-feather="users"></span>
                                Время выгрузки
                            </a>
                        </li>
                        @endrole
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/archive') ? 'active' : null }}" href="{{route('archive.indexadmin')}}">
                                <span data-feather="users"></span>
                                Архивы
                            </a>
                        </li>
                        @role('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/cleansing') ? 'active' : null }}" href="{{route('cleansing.index')}}">
                                <span data-feather="users"></span>
                                Очищение данных
                            </a>
                        </li>
                        @endrole

                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 mt-5 px-4 pt-1">
                @yield('content')
            </main>
        </div>
    </div>
</div>
</body>
</html>
