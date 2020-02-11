@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row mb-30px">
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card infoblock-card">
                    <a href="{{route('pages.home')}}">
                        <div class="card-body mrsu-bg">
                            <img src="storage/preview/default.jpg" class="w-100" alt="">
                            <p class="text-center m-0 pt-2 mrsu-uppertext">Соотечественники</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card infoblock-card">
                    <a href="{{route('foreign.index')}}">
                        <div class="card-body mrsu-bg">
                            <img src="storage/preview/default.jpg" class="w-100" alt="">
                            <p class="text-center m-0 pt-2 mrsu-uppertext">Русскоговорящие иностранцы</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card infoblock-card">
                    <a href="{{route('foreign.index')}}">
                        <div class="card-body mrsu-bg">
                            <img src="storage/preview/default.jpg" class="w-100" alt="">
                            <p class="text-center m-0 pt-2 mrsu-uppertext">Иностранцы</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
