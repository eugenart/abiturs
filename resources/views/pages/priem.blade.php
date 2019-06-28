@extends('pages.layout')

@section('page')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-12">
                <marquee behavior="" direction="" class="mt-2">
                    @foreach(collect($block->infoblock->news) as $item)
                    &bull; Бегущая строка
                    &bull; Бегущая строка
                    &bull; Бегущая строка
                    &bull; Бегущая строка &bull;
                    @endforeach
                </marquee>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <a href="/">Главная</a> / <a href="{{ $block->infoblock->url }}">{{ $block->infoblock->name }}</a> / <a
                        href="{{ $block->url }}">{{ $block->name }}</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-9">
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-center mrsu-uppertext pt-3 text-primary font-weight-bold">
                            {{ $block->name }}
                        </h6>
                        <hr class="mrsu-bg p-0 m-0">
                    </div>
                    <div class="col-12 pt-2 content-page">
                        @foreach($block->sectionContent->sortBy('position') as $content)
                            @if ($content->type == 'text')
                                <div>{!! nl2br($content->content) !!}</div>
                            @else
                                <p class="m-0 font-weight-bolder">{{ $content->name }}:</p>
                                <p>
                                    @foreach($content->childrenFiles->sortBy('position') as $file)

                                        <a href="{{ asset('storage/section-files/' . $file->file_name) }}">{{ $file->name }}
                                            ;</a>&nbsp;
                                    @endforeach
                                </p>
                            @endif
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mrsu-card pt-3 pb-1">
                    <p class="w-100 mrsu-uppertext title-text text-center p-1">Бакалавриат и специалитет</p>
                    <ul class="list-unstyled pl-3">
                        @foreach($block->infoblock->sections->where('activity', true) as $section)
                            @if ($section->isFolder && $section->childrenSections->where('activity', true)->count() > 0)
                                <li class="mrsu-uppertext">{{ $section->name }}</li>
                                <ul class="list-unstyled pl-4">
                                    @foreach($section->childrenSections->where('activity', true) as $subSection)
                                        <li><a href="{{ $subSection->url }}">{{ $subSection->name }}</a></li>
                                    @endforeach
                                </ul>
                            @elseif(!$section->isFolder && !$section->parentSection)
                                <li class="mrsu-uppertext"><a href="{{ $section->url }}">{{ $section->name }}</a></li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>



@endsection

