@extends('pages.layout')

@section('page')
    <div class="row">
        <div class="col-12">
            <marquee behavior="" direction="" class="mt-2">
                &bull; Бегущая строка
                &bull; Бегущая строка
                &bull; Бегущая строка
                &bull; Бегущая строка &bull;
            </marquee>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="/">Главная</a> / <a href="">Университет</a> / <a href="">Страница</a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-9">
            <div class="row">
                <div class="col-12">
                    <h6 class="text-center mrsu-uppertext pt-3 text-primary">
                        {{ $block->name }}
                    </h6>
                    <hr class="mrsu-bg p-0 m-0">
                </div>
                <div class="col-12 pt-2">
                    @foreach($block->sectionContent as $content)
                        <div>{!! nl2br($content->content) !!}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="mrsu-card pt-3 pb-1">
                <p class="w-100 mrsu-uppertext title-text text-center p-1">Бакалавриат и специалитет</p>
                <ul class="list-unstyled pl-3">
{{--                    <li class="mrsu-uppertext"><a href="">Нормативные документы</a></li>--}}
{{--                    <li>--}}
{{--                        <ul class="list-unstyled pl-4">--}}
{{--                            <li><a href="">Документы приема</a></li>--}}
{{--                            <li><a href="">Стастистика приема документов</a></li>--}}
{{--                            <li><a href="">Списки успешно сдавших</a></li>--}}
{{--                            <li><a href="">Приказы о зачислении</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    @foreach($block->infoblock->sections as $section)
                        <li class="mrsu-uppertext"><a href="{{ $section->url }}">{{ $section->name }}</a></li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>


@endsection

