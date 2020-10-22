@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12">
                <h1 class="text-center h1-mrsu main-color m-0">Архив</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="container pt-0 padding-0 mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
            <div class="accordion" id="accordionExample">
                @foreach($archives as $arc)
                    <div id="{{$arc->idforblock}}">
                        <a href="" class="collapsed"  data-toggle="collapse"
                           data-target="#{{$arc->collapsed}}"
                           aria-expanded="true" aria-controls="{{$arc->collapsed}}">
                            <h5 class="header-acord m-0 pb-2 pt-2 mrsu-uppertext text-primary main-color">
                                <i class="fas fa-angle-down rotate-icon"></i> {{$arc->name}}
                            </h5>
                        </a>
                    </div>
                    <hr class="mrsu-bg p-0 m-0">
                    <div id="{{$arc->collapsed}}" class="collapse" aria-labelledby="{{$arc->idforblock}}"
                         data-parent="#accordionExample">

                        <ul class="files-list col-12">
                            @foreach($arc->infoblocks as $inf)
                                <li><a class="text-primary main-color" href="{{url($inf->url)}}"><i class="fas fa-chevron-circle-right"></i> {{$inf->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                    <div>
                        <a  href="https://mrsu.ru/ru/abit/entry.php" target="_blank">
                            <h5 class="header-acord m-0 ml-3 pb-2 pt-2 mrsu-uppertext text-primary main-color">
                                Архив 2010-2019
                            </h5>
                        </a>
                    </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
@endsection
