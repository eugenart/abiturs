@extends('pages.layout')
@section('style')
    <link rel="stylesheet" href="{{asset('css/vue2editor.css')}}">
@endsection
@section('page')
    <div class="container-fluid py-lg-5 py-xl-5 py-md-3 py-sm-3 py-3">
        @if (count($block->infoblock->news))
            <div class="row">
                <div class="col-12">
                    <marquee behavior="" direction="" class="mt-2">
                        @foreach($block->infoblock->news as $item)
                        {{$loop->first ? "• " : null}}
                        {{$item}} &bull;
                        @endforeach
                    </marquee>
                </div>
            </div>
        @endif
        <div class="row mt-2 section-content-block">
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-12">
                        @if(mb_strlen($block->name)>=70)
                            <h1 style="display:none;">{{ $block->infoblock->name }}</h1>
                        @else
                            <h1 style="display:none;">{{ $block->name }}</h1>
                        @endif
                        <h5 class="text-center mrsu-uppertext pt-3 text-primary font-weight-bold main-color">
                            {{ $block->name }}
                        </h5>
                        <hr class="mrsu-bg p-0 m-0">
                    </div>
                    <div class="col-12 pt-2 content-page">
                        @foreach($block->sectionContent->sortBy('position') as $content)
                            @if ($content->type == 'text')
                                <h5 class=" font-weight-bolder ml-0"><b>{{ $content->name }}</b></h5>
                                <div class="ql-editor">{!! nl2br($content->content) !!}</div>
                            @else
                                <h5 class="ml-0 font-weight-bolder"><b>{{ $content->name }}</b></h5>
                                <ul class="files-list">
                                    @if(isset($content->childrenFiles))
                                        @foreach($content->childrenFiles->sortBy('position') as $file)
                                            @if(!is_null($file->file_name))
                                                @if(file_exists($_SERVER['DOCUMENT_ROOT'] .'/storage/section-files/' . $file->file_name))
                                                    <li>
                                                        <div>
                                                            @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/' . mb_strtolower($file->ext_file) . '.png'))
                                                                <img
                                                                    src="{{ asset('storage/file-types/' . mb_strtolower($file->ext_file) . '.png' )}}"
                                                                    alt="">
                                                            @else
                                                                <img
                                                                    src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                                                    alt="">
                                                            @endif

                                                            {{--                                                {{ filesize(asset('storage/section-files/' . $file->file_name))}}--}}
                                                        </div>
                                                        <div class="file-link-div">
                                                            <a href="{{ asset('storage/section-files/' . $file->file_name) }}"
                                                               target="_blank">{{ $file->name }}</a>
                                                            <br>
                                                            <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $file->file_name)[7] / 1024 /1024, 2)}} MB</span>
                                                            {{--                                                <span class="badge">{{ $file->updated_at }}</span>--}}
                                                        </div>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            @endif
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="mrsu-card pt-3 pb-1">
                    <p class="w-100 mrsu-uppertext title-text text-center p-1 main-color">
                        <b>{{ $block->infoblock->name }}</b></p>
                    <ul class="list-unstyled p-3 list-sections main-color">
                        {{--                        @foreach($block->infoblock->sections->where('activity', true)->sortByDesc('startPagePriority') as $section)--}}
                        @foreach($menuSections as $section)
                            @if((($date_now > $section->activityFrom || $date_now == $section->activityFrom) &&
                            ($date_now < $section->activityTo || $date_now == $section->activityTo))
                            || (is_null($section->activityFrom) && is_null($section->activityTo)))
                                <li class="mrsu-uppertext link-section">
                                    <a class="text-white link-block"
                                       href="{{ $section->real_link }}">{{ $section->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

