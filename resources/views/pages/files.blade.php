@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 contact-us-div">
{{--                <a href="{{route('file.getname', "faculties.xls")}}">Загрузить справочник факультетов</a>--}}

                <form method="POST" action="/test">
                    @csrf
                    <input type="hidden" name="param" value="specialities">
                    <button type="submit">Загрузить файл</button>
                </form>
            </div>
        </div>
    </div>
@endsection
