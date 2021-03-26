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
<div class="container cont-w-100" style="z-index: 500 !important;">
    <div class="row header p-2">
        <div class="col-6 pl-2">
            <a href="{{ trans('layout.main') }}"><img src="{{asset('storage/images/iconka_mrsu_white.png')}}"
                                                      class="mrsu-logo-img d-lg-none d-md-block" alt=""></a>
            <a href="{{ trans('layout.main') }}">
                @if(trans("layout.locale") == 'ru')
                    <img src="{{asset('storage/images/logo_mrsu.png')}}"
                         class="mrsu-logo-img mrsu-logo-blue d-lg-block d-md-none d-sm-none"
                         alt="">
                @endif
                @if(trans("layout.locale") == 'en')
                    <img src="{{asset('storage/images/logo_mrsu_en.png')}}"
                         class="mrsu-logo-img mrsu-logo-blue d-lg-block d-md-none d-sm-none"
                         alt="">
                @endif
            </a>
            <a href="{{ trans('layout.main') }}"><img src="{{asset('storage/images/logo_mrsu-ovz.png')}}"
                                                      class="mrsu-logo-img-ovz mrsu-logo-blue d-lg-block d-md-none d-sm-none"
                                                      alt=""></a>
        </div>
        <div class="col-6 justify-content-end d-flex align-items-center">

            {{-- Версия для иностранцев--}}
            {{--            @role('developer')--}}
            <a href="{{ trans('layout.href') }}" class="ml-3 mr-4 foreign-link ">{{ trans('layout.lang') }}</a>
            {{--            @endrole--}}


            {{--            <img src="{{asset('storage/images/eye-white.png')}}" class="ml-2 mr-4 d-lg-none d-md-block" width="35" height="auto" alt="">--}}
            <a href="{{route('ses.toOvzVer')}}"><img id="ovz_version" src="{{asset('storage/images/eye-blue.png')}}"
                                                     class="ml-2 mr-4 d-lg-block d-md-none d-sm-none mrsu-eye-blue"
                                                     width="35" height="auto"
                                                     alt=""> </a>
            <a href="{{route('ses.backToMainVer')}}"><img id="main_version"
                                                          src="{{asset('storage/images/eye-black.png')}}"
                                                          class="ml-2 mr-4 d-lg-block d-md-none d-sm-none mrsu-eye-black"
                                                          width="35" height="auto"
                                                          alt=""></a>
            <button class="hamburger hamburger--collapse  d-lg-none d-md-block" type="button" data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
</div>

<div id="bg-blur"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-light main-nav pt-0 pb-0" style="z-index: 500 !important;">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex justify-content-between w-100 m-auto mrsu-uppertext text-center">
                @php
                    use Carbon\Carbon;
                    $date_now = Carbon::today();
                    $date_now = $date_now->toDateString();
                @endphp
                @if(trans('layout.locale') == 'ru')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.levels') }}
                        </a>
                        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                            {{--образуются в app\Providers\AppServiceProvider.php--}}
                            @foreach($pages as $page)
                                @if ((($date_now > $page->activityFrom || $date_now == $page->activityFrom) &&
                                ($date_now < $page->activityTo || $date_now == $page->activityTo))
                                || (is_null($page->activityFrom) && is_null($page->activityTo)))
                                    <a class="nav-link text-white" href="{{url($page->url)}}">{{ $page->name }}</a>
                                @endif
                            @endforeach
                            <a class="nav-link text-white" href="{{route('archive.index')}}">Архив</a>
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'en')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.levels') }}
                        </a>
                        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                            {{--образуются в app\Providers\AppServiceProvider.php--}}
                            @foreach($infoblocks_int as $page)
                                @if ((($date_now > $page->activityFrom || $date_now == $page->activityFrom) &&
                                ($date_now < $page->activityTo || $date_now == $page->activityTo))
                                || (is_null($page->activityFrom) && is_null($page->activityTo)))
                                    <a class="nav-link text-white" href="{{url($page->url)}}">{{ $page->name }}</a>
                                @endif
                            @endforeach
                            <a class="nav-link text-white" href="{{route('archive.index')}}">Archive</a>
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'ru')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.lists') }}
                        </a>
                        <div class="dropdown-menu main-color" aria-labelledby="navbarDropdown">
                            <a class="nav-link text-white" href="{{route('stat.index')}}">{{ trans('layout.bach') }}</a>
                            <a class="nav-link text-white"
                               href="{{route('statmaster.index')}}">{{ trans('layout.master') }}</a>
                            <a class="nav-link text-white"
                               href="{{route('statasp.index')}}">{{ trans('layout.asp') }}</a>
                            <a class="nav-link text-white"
                               href="{{route('statspo.index')}}">{{ trans('layout.spo') }}</a>

                            <a class="nav-link dropdown-toggle text-white" href="" id="navbarDropdown1" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ trans('layout.foreigner') }}
                            </a>
                            <div class="dropdown-menu drop-sub main-color-dropdown" aria-labelledby="navbarDropdown1">
                                <a class="nav-link text-white"
                                   href="{{route('statforeigner.index')}}">{{ trans('layout.bach') }}</a>
                                <a class="nav-link text-white"
                                   href="{{route('statmasterforeigner.index')}}">{{ trans('layout.master') }}</a>
                                <a class="nav-link text-white"
                                   href="{{route('stataspforeigner.index')}}">{{ trans('layout.asp') }}</a>
                            </div>
                            @if($count_stats > 0)
                                <a class="nav-link text-white"
                                   href="{{route('total.index')}}">{{ trans('layout.stat') }}</a>
                            @endif
                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'en')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.foreigner') }}
                        </a>
                        <div class="dropdown-menu main-color" aria-labelledby="navbarDropdown">

                            <a class="nav-link text-white"
                               href="{{route('statforeigner.index')}}">{{ trans('layout.bach') }}</a>
                            <a class="nav-link text-white"
                               href="{{route('statmasterforeigner.index')}}">{{ trans('layout.master') }}</a>
                            <a class="nav-link text-white"
                               href="{{route('stataspforeigner.index')}}">{{ trans('layout.asp') }}</a>

                        </div>
                    </li>
                @endif
                @if(trans('layout.locale') == 'ru')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ trans('layout.select') }}
                        </a>
                        <div class="dropdown-menu main-color" aria-labelledby="navbarDropdown">
                            <a class="nav-link text-white"
                               href="{{route('selection.index')}}">{{ trans('layout.bach') }}</a>
                            <a class="nav-link text-white"
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
                {{--                @if(trans('layout.locale') == 'ru')--}}
                {{--                    <li class="nav-item active d-flex align-items-center justify-content-center">--}}
                {{--                        <a class="nav-link" target="_blank"--}}
                {{--                           href="https://mrsu.ru/ru/abit/entry.php">{{ trans('layout.archive') }}<span--}}
                {{--                                class="sr-only">(current)</span></a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}
            </ul>
        </div>
    </div>
</nav>

@section('page')
@show
 @role('admin')
<footer>
	<div class="container">
		<div class="row underline-row">
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4">
				<p class="bold bottom main__corpus">Главный корпус</p>
				<div class="position">
					<table border="0" class="footer-table">
						<tr>
							<td class=""><div class="pos"><img src="{{asset('storage/images/elements/2I.svg')}}"></div></td>
							<td><div class="pos-text"><a href="#">Большевистская ул., 68/1</a></div></td>
						</tr>
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/1E.svg')}}"></div></td>
							<td><div class="pos-text"><a href="mailto:dep-general@adm.mrsu.ru">dep-general@adm.mrsu.ru</a></div></td>
						</tr>
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/9H.svg')}}"></div></td>
							<td><div class="pos-text"><a href="tel:+78342243732">+7 (8342) 24-37-32</a></div></td>
						</tr>
						<!-- <tr> -->
							<!-- <td></td> -->
							<!-- <td><p class="top-margin"><a href="" class="underline">Показать на карте</a></p></td> -->
						<!-- </tr> -->
					</table>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4">
				<p class="bold bottom">Ректорат</p>
					<div class="position">
					<table border="0" class="footer-table">
						<tr>
							<td class=""><div class="pos"><img class="image_footer" class="glob" src="{{asset('storage/images/elements/6I.svg')}}"></div></td>
							<td><div class="pos-text"><a href="" class="">Виртуальная приёмная</a></div></td>
						</tr>
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/1E.svg')}}"></div></td>
							<td><div class="pos-text"><a href="mailto:rector@adm.mrsu.ru">rector@adm.mrsu.ru</a></div></td>
						</tr>
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/9H.svg')}}"></div></td>
							<td><div class="pos-text"><a class="dop-text" href="tel:+78342244888">+7 (8342) 24-48-88</a></div></td>
						</tr>
						<tr>
							<td></td>
							<td><div class="pos-text"><span class="color__footer dop-text">+7 (8342)</span><span class="number__padding"><a class="dop-text" href="tel:+78342244757"> 24-47-57</a></span></div></td>
						</tr>
						<tr>
							<td></td>
							<td><div class="pos-text"><span class="color__footer dop-text">+7 (8342)</span><span class="number__padding"><a class="dop-text" href="tel:+78342233934"> 23-39-34</a></span></div></td>
						</tr>
						<!-- <tr> -->
							<!-- <td></td> -->
							<!-- <td><p class="top-margin"><a href="" class="underline">Показать на карте</a></p></td> -->
						<!-- </tr> -->
					</table>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4">
				<p class="bold bottom">Приёмная комиссия</p>
				<div class="position">
					<table border="0" class="footer-table">
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/2I.svg')}}"></div></td>
							<td><div class="pos-text"><a href="#">Полежаева ул., 44</a></div></td>
						</tr>
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/1E.svg')}}"></div></td>
							<td><div class="pos-text"><a href="mailto:entrance-exam@adm.mrsu.ru">entrance-exam@adm.mrsu.ru</a></div></td>
						</tr>
						<tr>
							<td class=""><div class="pos"><img class="image_footer" src="{{asset('storage/images/elements/9H.svg')}}"></div></td>
							<td><div class="pos-text"><a href="tel:+78342244835">+7 (800) 222-13-17</a></div></td>
						</tr>
						<!-- <tr> -->
							<!-- <td></td> -->
							<!-- <td><p class="top-margin"><a href="" class="underline">Показать на карте</a></p></td> -->
						<!-- </tr> -->
					</table>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-4">
				<p class="bold bottom">Информация</p>
				<div class="position">
					<p class="paa"><a href="" class="underline">Сведения об образовательной организации</a></p>
					<p><a href="" class="underline">Противодействие коррупции</a></p>
					<p><a href="" class="underline">Реквизиты университета</a></p>
					<p><a href="" class="underline">Телефонный справочник</a></p>
					<p><a href="" class="underline">Оплата услуг</a></p>
				</div>
			</div>
		</div>
		<div class="row foot-bottom-block">
			<div class="col-lg-6 col-md-6 col-sm-6 mb-4 col_one">
				<p class="copyright">© 1998–2021 МГУ им. Н.П. Огарёва<br>
				При использовании текстовой информации, фото- и видеоматериалов ссылка на сайт обязательна</p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 mb-4 social col_two">
				<a href=""><img src="{{asset('storage/images/elements/VK.svg')}}" alt=""></a>
				<a href=""><img src="{{asset('storage/images/elements/Facebook.svg')}}" alt=""></a>
				<a href=""><img src="{{asset('storage/images/elements/Twitter.svg')}}" alt=""></a>
				<a href=""><img src="{{asset('storage/images/elements/Instagram.svg')}}" alt=""></a>
				<a href=""><img src="{{asset('storage/images/elements/Youtube.svg')}}" alt=""></a>
			</div>
		</div>
	</div>
</footer>
@endrole
</body>
<script src="{{asset('js/version.js')}}"></script>
<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"--}}
{{--        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"--}}
{{--        crossorigin="anonymous"></script>--}}

<script src="{{asset('js/popper.min.js')}}"></script>

{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"--}}
{{--        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"--}}
{{--        crossorigin="anonymous"></script>--}}

<script src="{{asset('js/bootstrap.min.js')}}"></script>

<script src="{{asset('js/bootstrap-select.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.9/js/i18n/defaults-ru_RU.min.js"></script>--}}
<script src="{{asset('js/defaults-ru_RU.min.js')}}"></script>

<script>
    $('.hamburger').click(() => {
        $('.hamburger').toggleClass('is-active');
    })
</script>
@section("js")
@show
</html>
