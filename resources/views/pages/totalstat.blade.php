@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="container-fluid pr-5 pl-5 pb-5 pt-0">
            <div class="row mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3">
                <div class="col-12 m-auto">
                    <h3 class="text-center h1-mrsu main-color m-0">Статистика приема</h3>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
@endsection
