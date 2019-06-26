@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($slider as $slide)

                            @if ($loop->index == 0)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"
                                    class="active"></li>
                            @else
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"></li>
                            @endif
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($slider->sortByDesc('startPagePriority') as $slide)
                            @if ($loop->index == 0)
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                </div>
                            @else
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-4">


            @foreach($infoblocks->sortByDesc('startPagePriority') as $infoblock)
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="card infoblock-card">
                        <a href="{{ $infoblock->url }}">
                            <div class="card-body mrsu-bg">
                                <img src="storage/preview/{{ $infoblock->image }}" class="w-100" alt="">
                                <p class="text-center m-0 pt-2 mrsu-uppertext">{{ $infoblock->name }}</p>
                            </div>
                        </a>
                        <div class="card-footer">
                            <ul class="mrsu-uppertext m-0">
                                @foreach($infoblock->sections as $section)
                                    <li><a href="{{ $section->url }}">{{ $section->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection
