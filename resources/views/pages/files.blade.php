@extends('pages.layout')

@section('page')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 contact-us-div">
{{--                <a href="{{route('file.getname', "faculties.xls")}}">Загрузить справочник факультетов</a>--}}

                <form method="POST" action="/admin/download">
                    @csrf
                    <input type="hidden" name="param" value="stat_bach">
                    <button type="submit">Загрузить файл</button>
                </form>
            </div>
        </div>
    </div>
@endsection
