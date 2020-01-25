@extends('pages.layout')

@section('page')
    <div class="row bac-mag">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                {{--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">--}}
                {{--                    <span class="navbar-toggler-icon"></span>--}}
                {{--                </button>--}}
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-university"></i> Бакалавриат и специалитет</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-graduation-cap"></i> Магистратура</a>
                            </li>
                        </ul>
                    </div>
                    <form class="form-inline" action="{{ route('stat.searchfio') }}" method="post">
                        @csrf
                        <input class="form-control mr-sm-2 form-control-sm" type="search" placeholder="Поиск по ФИО"
                               aria-label="Search" name="fio">
                        <button class="btn my-2 my-sm-0 btn-sm" type="submit">Поиск</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>

    @php
        print_r('hell');

    @endphp
    <div class="container-fluid p-5">
        <div class="row">

            <div class="col-3"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Факультет / Институт</option>

                    {{--                    @foreach($faculties as $faculty)--}}
                    {{--                        <option value="{{$faculty->id}}">{{$faculty->name}}</option>--}}
                    {{--                    @endforeach--}}
                </select></div>
            <div class="col-3"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Специальность</option>
                    {{--                    @foreach($specialities as $spec)--}}
                    {{--                        <option value="{{$spec->id}}">{{$spec->name}}</option>--}}
                    {{--                    @endforeach--}}
                </select></div>
            <div class="col-2"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Внебюджет</option>
                    <option value="1">1</option>
                </select></div>
            <div class="col-2"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Форма обучения</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-1">
                <button class="w-100 btn btn-success btn-sm" id="submitInfo">Поиск</button>
            </div>
            <div class="col-1">
                <button class="w-100 btn btn-warning btn-sm" id="clearSelects">Сбросить</button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="examInfo p-3">
                    <div class="row">
                        <div class="col-8">
                            <p><u>Количество бюджетных мест</u>: <b>35</b></p>
                            <p><u>Конкурс</u>: <b>0.2</b> человек/место</p>
                            <p class="m-0"><u>Время последнего обновления</u>: <b>2019-06-26 10:01:01</b></p>
                        </div>
                        <div class="col-4">
                            <a href="http://qrcoder.ru" target="_blank"><img
                                    src="http://qrcoder.ru/code/?https%3A%2F%2Fvk.com%2Feug_art&4&0" width="132"
                                    height="132" border="0" title="QR код"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-bordered table-sm base-exams-table">
                    <thead>
                    <tr style="vertical-align: center">
                        <td rowspan="2">№</td>
                        <td rowspan="2">Фамилия, имя, отчество</td>
                        <td rowspan="2">Оригинал</td>
                        <td rowspan="2">Согласие</td>

                        <td colspan="4">
                            <p class="m-0">1) Химия</p>
                            <p class="m-0">2) Математика (профильная)</p>
                            <p class="m-0">3) Русский язык</p>
                            <p class="m-0">4) Балл за индивидуальные достижения</p>
                        </td>
                        <td rowspan="2">Сумма баллов<br/> за ЕГЭ/ВИ</td>
                        <td rowspan="2">Сумма<br/> конкурсных<br/> баллов</td>
                        {{--                        <td rowspan="2">Тип экзамена</td>--}}
                        <td rowspan="2">Статус проверки</td>
                        <td rowspan="2">Нуждаемость в общежитии</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="exam-rights" colspan="14">
                            <b>Квота (особое право)</b>. Количество мест: <b>4</b>
                        </td>
                    </tr>
                    @if(isset($statistics))
                    @foreach($statistics as $k => $stat)
                        <tr class="text-center">
                            <td class="text-center">{{$k + 1}}</td>
                            <td>{{$stat->student->fio}}</td>
                            @if($stat->original)
                                <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>
                            @else
                                <td><i class="fa fa-times-circle" style="color: rgba(128,0,0,0.51)"></i></td>
                            @endif
                            @if($stat->accept)
                                <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>
                            @else
                                <td><i class="fa fa-times-circle" style="color: rgba(128,0,0,0.51)"></i></td>
                            @endif

                            <td>80</td>
                            <td>80</td>
                            <td>80</td>

                            <td>{{$stat->indAchievement}}</td>
                            <td>{{$stat->summ}}</td>
                            <td>{{$stat->summContest}}</td>
                            {{--                            <td>ЕГЭ</td>--}}
                            <td>{{$stat->notice1}}</td>
                            @if($stat->needHostel)
                                <td>Да</td>
                            @else
                                <td>Нет</td>
                            @endif
                        </tr>
                    @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#clearSelects').click(function () {
            $('select').val('-1');
        })
    </script>
@endsection
