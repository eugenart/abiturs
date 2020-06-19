@extends('pages.layout')

@section('page')
    <div class="container">
        @if (count($slider))
            <div class="row">
                <div class="col-12 mt-4">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($slider as $slide)
                                @if ($loop->index == 0)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"
                                        class="active"></li>
                                @else
                                    <li data-target="#carouselExampleIndicators"
                                        data-slide-to="{{ $loop->index }}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
{{--                            @foreach($slider->sortByDesc('startPagePriority') as $slide)--}}
                            @foreach($slider as $slide)
                                @if ($loop->index == 0)
                                    <div class="carousel-item active">
                                        @if ($slide->url != null)
                                            <a href="{{ $slide->url }}" target="_blank"><img class="d-block w-100"
                                                                                             src="storage/slider/{{ $slide->image }}"></a>
                                        @else
                                            <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                        @endif
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        @if ($slide->url != null)
                                            <a href="{{ $slide->url }}" target="_blank"><img class="d-block w-100"
                                                                                             src="storage/slider/{{ $slide->image }}"></a>
                                        @else
                                            <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <div class="row mb-30px">
{{--            @foreach($infoblocks->sortByDesc('startPagePriority') as $infoblock)--}}
            @foreach($infoblocks as $infoblock)
                @if((($date_now > $infoblock->activityFrom || $date_now == $infoblock->activityFrom) &&
                    ($date_now < $infoblock->activityTo || $date_now == $infoblock->activityTo))
                    ||(is_null($infoblock->activityFrom) && is_null($infoblock->activityTo)))
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card infoblock-card">
                            <a href="{{ $infoblock->url }}">
                                <div class="card-body mrsu-bg">
                                    <img src="storage/preview/{{ $infoblock->image }}" class="w-100" alt="">
                                    <p class="text-center m-0 pt-2 mrsu-uppertext">{{ $infoblock->name }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card infoblock-card">
                    <a href="{{route('foreign.index')}}">
                        <div class="card-body mrsu-bg">
                            <img src="{{asset('storage/images/923.jpg')}}" class="w-100" alt="">
                            <p class="text-center m-0 pt-2 mrsu-uppertext">Foreign students</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
