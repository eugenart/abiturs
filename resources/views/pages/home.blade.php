@extends('pages.layout')

@section('page')
    <div class="container">
        @if(trans('layout.locale') == 'ru')
            @if (count($slider))
                <div class="row img_main">
                    <div class="col-12 mt-4">
                        <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
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
                            <div class="carousel-inner ">
                                @foreach($slider as $slide)
                                    @if ($loop->index == 0)
                                        <div class="carousel-item active">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                            @endif
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                                </a>
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
            @if (count($slider_i))
                <div class="row img_ipad">
                    <div class="col-12 mt-4">
                        <div id="carouselExampleIndicators1" class="carousel slide " data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($slider_i as $slide)
                                    @if ($loop->index == 0)
                                        <li data-target="#carouselExampleIndicators1" data-slide-to="{{ $loop->index }}"
                                            class="active"></li>
                                    @else
                                        <li data-target="#carouselExampleIndicators1"
                                            data-slide-to="{{ $loop->index }}"></li>
                                    @endif
                                @endforeach
                            </ol>
                            <div class="carousel-inner ">
                                @foreach($slider_i as $slide)
                                    @if ($loop->index == 0)
                                        <div class="carousel-item active">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_ipad }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_ipad }}">
                                            @endif
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_ipad }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_ipad }}">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if (count($slider_m))
                <div class="row img_mobile">
                    <div class="col-12 mt-4">
                        <div id="carouselExampleIndicators2" class="carousel slide " data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($slider_m as $slide)
                                    @if ($loop->index == 0)
                                        <li data-target="#carouselExampleIndicators2" data-slide-to="{{ $loop->index }}"
                                            class="active"></li>
                                    @else
                                        <li data-target="#carouselExampleIndicators2"
                                            data-slide-to="{{ $loop->index }}"></li>
                                    @endif
                                @endforeach
                            </ol>
                            <div class="carousel-inner ">
                                @foreach($slider_m as $slide)
                                    @if ($loop->index == 0)
                                        <div class="carousel-item active">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_mobile }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_mobile }}">
                                            @endif
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_mobile }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_mobile }}">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        @if(trans('layout.locale') == 'en')
            @if (count($slider_f))
                <div class="row img_main">
                    <div class="col-12 mt-4">
                        <div id="carouselExampleIndicatorsf" class="carousel slide " data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($slider_f as $slide)
                                    @if ($loop->index == 0)
                                        <li data-target="#carouselExampleIndicatorsf" data-slide-to="{{ $loop->index }}"
                                            class="active"></li>
                                    @else
                                        <li data-target="#carouselExampleIndicatorsf"
                                            data-slide-to="{{ $loop->index }}"></li>
                                    @endif
                                @endforeach
                            </ol>
                            <div class="carousel-inner ">
                                @foreach($slider_f as $slide)
                                    @if ($loop->index == 0)
                                        <div class="carousel-item active">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                            @endif
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100" src="storage/slider/{{ $slide->image }}">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            <a class="carousel-control-prev" href="#carouselExampleIndicatorsf" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicatorsf" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if (count($slider_i_f))
                <div class="row img_ipad">
                    <div class="col-12 mt-4">
                        <div id="carouselExampleIndicatorsf1" class="carousel slide img_ipad" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($slider_i_f as $slide)
                                    @if ($loop->index == 0)
                                        <li data-target="#carouselExampleIndicatorsf1"
                                            data-slide-to="{{ $loop->index }}"
                                            class="active"></li>
                                    @else
                                        <li data-target="#carouselExampleIndicatorsf1"
                                            data-slide-to="{{ $loop->index }}"></li>
                                    @endif
                                @endforeach
                            </ol>
                            <div class="carousel-inner ">
                                @foreach($slider_i_f as $slide)
                                    @if ($loop->index == 0)
                                        <div class="carousel-item active">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_ipad }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_ipad }}">
                                            @endif
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_ipad }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_ipad }}">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            <a class="carousel-control-prev" href="#carouselExampleIndicatorsf1" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicatorsf1" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if (count($slider_m_f))
                <div class="row img_mobile">
                    <div class="col-12 mt-4">
                        <div id="carouselExampleIndicatorsf2" class="carousel slide img_mobile" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($slider_m_f as $slide)
                                    @if ($loop->index == 0)
                                        <li data-target="#carouselExampleIndicatorsf2"
                                            data-slide-to="{{ $loop->index }}"
                                            class="active"></li>
                                    @else
                                        <li data-target="#carouselExampleIndicatorsf2"
                                            data-slide-to="{{ $loop->index }}"></li>
                                    @endif
                                @endforeach
                            </ol>
                            <div class="carousel-inner ">
                                @foreach($slider_m_f as $slide)
                                    @if ($loop->index == 0)
                                        <div class="carousel-item active">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_mobile }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_mobile }}">
                                            @endif
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            @if ($slide->url != null)
                                                <a href="{{ $slide->url }}" target="_blank">
                                                    <img class="d-block w-100"
                                                         src="storage/slider/{{ $slide->image_mobile }}">
                                                </a>
                                            @else
                                                <img class="d-block w-100"
                                                     src="storage/slider/{{ $slide->image_mobile }}">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            <a class="carousel-control-prev" href="#carouselExampleIndicatorsf2" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicatorsf2" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <h1 style="display:none">Приемная кампания МГУ им. Н.П.Огарева </h1>
        @if(trans('layout.locale') == 'ru')
            @if($infoblocks->count() < 3)
                <div class="row justify-content-center mb-30px">
                    @else
                        <div class="row mb-30px">
                            @endif
                            @foreach($infoblocks as $infoblock)
                                @if((($date_now > $infoblock->activityFrom || $date_now == $infoblock->activityFrom) &&
                                    ($date_now < $infoblock->activityTo || $date_now == $infoblock->activityTo))
                                    ||(is_null($infoblock->activityFrom) && is_null($infoblock->activityTo)))
                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                        <div class="card infoblock-card">
                                            <a href="{{ $infoblock->url }}">
                                                <div class="card-body mrsu-bg">
                                                    <img src="storage/preview/{{ $infoblock->image }}" class="w-100"
                                                         alt="">
                                                    <p class="text-center m-0 pt-2 mrsu-uppertext">{{ $infoblock->name }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if(trans('layout.locale') == 'en')
                        @if($infoblocks_int->count() < 3)
                            <div class="row justify-content-center mb-30px">
                                @else
                                    <div class="row mb-30px">
                                        @endif
                                        @foreach($infoblocks_int as $infoblock)
                                            @if((($date_now > $infoblock->activityFrom || $date_now == $infoblock->activityFrom) &&
                                                ($date_now < $infoblock->activityTo || $date_now == $infoblock->activityTo))
                                                ||(is_null($infoblock->activityFrom) && is_null($infoblock->activityTo)))
                                                <div class="col-lg-4 col-md-6 col-sm-6 mb-4 align-self-center">
                                                    <div class="card infoblock-card">
                                                        <a href="{{ $infoblock->url }}">
                                                            <div class="card-body mrsu-bg">
                                                                <img src="storage/preview/{{ $infoblock->image }}"
                                                                     class="w-100"
                                                                     alt="">
                                                                <p class="text-center m-0 pt-2 mrsu-uppertext">{{ $infoblock->name }}</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif


                            </div>
@endsection
