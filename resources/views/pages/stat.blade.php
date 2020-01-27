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
                @if(isset($studyForms))
                    @foreach($studyForms as $studyForm)
                        @if(isset($studyForm->stat ))
                            @foreach($studyForm->stat as $category)
                                @if(isset($category->admissionBases))
                                    @foreach($category->admissionBases as $admissionBasis)
                                        @if(isset($admissionBasis->preparationLevels))
                                            @foreach($admissionBasis->preparationLevels as $preparationLevel)
                                                @if(isset($preparationLevel->faculties))
                                                    @foreach($preparationLevel->faculties as $faculty)
                                                        @if(isset($faculty->specialities))
                                                            @foreach($faculty->specialities as $speciality)
                                                                <div class="row mt-4">
                                                                    <div class="exam-info-outer">
                                                                        <div class="col-12">
                                                                            <div class="examInfo p-3">
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <table>
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td>Форма обучения</td>
                                                                                                <td>
                                                                                                    <b class="mrsu-uppertext">{{$studyForm->name}}</b>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Категория приема
                                                                                                </td>
                                                                                                <td>
                                                                                                    <b class="mrsu-uppertext">{{ $category->name }}</b>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Основание для
                                                                                                    поступления
                                                                                                </td>
                                                                                                <td>
                                                                                                    <b class="mrsu-uppertext">{{ $admissionBasis->name }}</b>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Уровень подготовки
                                                                                                </td>
                                                                                                <td>
                                                                                                    <b class="mrsu-uppertext">{{$preparationLevel->name}}</b>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="examInfo-bottom">
                                                                                <div class="row">
                                                                                    <div class="col-12">
{{--                                                                                        <table>--}}
{{--                                                                                            <tbody>--}}
{{--                                                                                            <tr>--}}
{{--                                                                                                <td></td>--}}
{{--                                                                                                <td>--}}
{{--                                                                                                    <b class="mrsu-uppertext">{{$faculty->name}}</b>--}}
{{--                                                                                                </td>--}}
{{--                                                                                            </tr>--}}
{{--                                                                                            <tr>--}}
{{--                                                                                                <td></td>--}}
{{--                                                                                                <td>--}}
{{--                                                                                                    <b class="mrsu-uppertext">{{$speciality->name}}</b>--}}
{{--                                                                                                </td>--}}
{{--                                                                                            </tr>--}}
{{--                                                                                            <tr>--}}
{{--                                                                                                <td>Кол-во бюджетных мест: <span class="font-weight-bold">{{$speciality->freeSeatsNumber}}</span>--}}
{{--                                                                                                </td>--}}
{{--                                                                                                <td>--}}
{{--                                                                                                </td>--}}
{{--                                                                                            </tr>--}}
{{--                                                                                            <tr>--}}
{{--                                                                                                <td>Конкурс: <span class="font-weight-bold">{{$speciality->originalsCount}}</span>  чел./ место--}}
{{--                                                                                                </td>--}}
{{--                                                                                                <td>--}}
{{--                                                                                                </td>--}}
{{--                                                                                            </tr>--}}
{{--                                                                                            </tbody>--}}
{{--                                                                                        </table>--}}
                                                                                        <p class="m-0 text-uppercase font-weight-bold">{{$faculty->name}}</p>
                                                                                        <p class="m-0 font-weight-bold">{{$speciality->name}}</p>
                                                                                        <p class="m-0">Кол-во бюджетных
                                                                                            мест:
                                                                                            <span
                                                                                            class="font-weight-bold">{{$speciality->freeSeatsNumber}}</span>
                                                                                        </p>
                                                                                        <p class="m-0">
                                                                                            Конкурс: <span
                                                                                                class="font-weight-bold">{{$speciality->originalsCount}}</span>
                                                                                            чел.
                                                                                            / место
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if(isset($speciality->abiturs))
                                                                    <table
                                                                        class="table table-bordered table-sm base-exams-table">
                                                                        <thead>
                                                                        <tr style="vertical-align: center">
                                                                            <td rowspan="2" class="text-center">№</td>
                                                                            <td rowspan="2" class="text-center">Фамилия,
                                                                                имя, отчество
                                                                            </td>
                                                                            <td rowspan="2" class="text-center">
                                                                                Оригинал
                                                                            </td>
                                                                            <td rowspan="2" class="text-center">
                                                                                Согласие
                                                                            </td>

                                                                            <td colspan="{{count($speciality->abiturs->first()->score) + 1}}">
                                                                                @foreach($speciality->abiturs->first()->score as $i => $sc)
                                                                                    @if($i < count($speciality->abiturs->first()->score) -1)
                                                                                        <p class="m-0"> {{$i + 1}}
                                                                                            ) {{$sc->subject->name}}</p>
                                                                                    @else
                                                                                        <p class="m-0"> {{$i + 1}}
                                                                                            ) {{$sc->subject->name}}</p>
                                                                                        <p class="m-0">{{$i + 2}}) Балл
                                                                                            за
                                                                                            индивидуальные
                                                                                            достижения</p>
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <td class="text-center" rowspan="2">Сумма
                                                                                баллов<br/> за
                                                                                ЕГЭ/ВИ
                                                                            </td>
                                                                            <td class="text-center" rowspan="2">
                                                                                Сумма<br/>
                                                                                конкурсных<br/> баллов
                                                                            </td>
                                                                            <td class="text-center" rowspan="2">Тип
                                                                                экзамена
                                                                            </td>
                                                                            <td class="text-center" rowspan="2">Статус
                                                                                проверки
                                                                            </td>
                                                                            <td class="text-center" rowspan="2">
                                                                                Нуждаемость <br> в
                                                                                общежитии
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            @foreach($speciality->abiturs->first()->score as $i => $sc)
                                                                                @if($i < count($speciality->abiturs->first()->score) -1)
                                                                                    <td>{{$i + 1}}</td>
                                                                                @else
                                                                                    <td>{{$i + 1}}</td>
                                                                                    <td>{{$i + 2}}</td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($speciality->abiturs as $k => $abitur)
                                                                            @if($abitur->is_chosen)
                                                                                <tr class="text-center chosen-student">
                                                                            @else
                                                                                <tr class="text-center">
                                                                                    @endif
                                                                                    <td class="text-center">{{$k + 1}}</td>
                                                                                    <td class="text-left">{{$abitur->student->fio}}</td>
                                                                                    @if($abitur->original)
                                                                                        <td>
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <i class="fa fa-times-circle"
                                                                                               style="color: rgba(128,0,0,0.51)"></i>
                                                                                        </td>
                                                                                    @endif
                                                                                    @if($abitur->accept)
                                                                                        <td>
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            <i class="fa fa-times-circle"
                                                                                               style="color: rgba(128,0,0,0.51)"></i>
                                                                                        </td>
                                                                                    @endif
                                                                                    @foreach($abitur->score as $ab_sc)
                                                                                        <td>{{$ab_sc->score}}</td>
                                                                                    @endforeach

                                                                                    <td>{{$abitur->indAchievement}}</td>
                                                                                    <td>{{$abitur->summ}}</td>
                                                                                    <td>{{$abitur->summContest}}</td>
                                                                                    <td>ЕГЭ</td>
                                                                                    <td>{{$abitur->notice1}}</td>
                                                                                    @if($abitur->needHostel)
                                                                                        <td>Да</td>
                                                                                    @else
                                                                                        <td>Нет</td>
                                                                                    @endif
                                                                                </tr>
                                                                                @endforeach

                                                                        </tbody>
                                                                    </table>

                                                                @endif
                                                                {{--                                                                </ul>--}}
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
                {{--                <table class="table table-bordered table-sm base-exams-table">--}}
                {{--                    <thead>--}}
                {{--                    <tr style="vertical-align: center">--}}
                {{--                        <td rowspan="2">№</td>--}}
                {{--                        <td rowspan="2">Фамилия, имя, отчество</td>--}}
                {{--                        <td rowspan="2">Оригинал</td>--}}
                {{--                        <td rowspan="2">Согласие</td>--}}

                {{--                        <td colspan="4">--}}
                {{--                            <p class="m-0">1) Химия</p>--}}
                {{--                            <p class="m-0">2) Математика (профильная)</p>--}}
                {{--                            <p class="m-0">3) Русский язык</p>--}}
                {{--                            <p class="m-0">4) Балл за индивидуальные достижения</p>--}}
                {{--                        </td>--}}
                {{--                        <td rowspan="2">Сумма баллов<br/> за ЕГЭ/ВИ</td>--}}
                {{--                        <td rowspan="2">Сумма<br/> конкурсных<br/> баллов</td>--}}
                {{--                        --}}{{--                        <td rowspan="2">Тип экзамена</td>--}}
                {{--                        <td rowspan="2">Статус проверки</td>--}}
                {{--                        <td rowspan="2">Нуждаемость в общежитии</td>--}}
                {{--                    </tr>--}}
                {{--                    <tr>--}}
                {{--                        <td>1</td>--}}
                {{--                        <td>2</td>--}}
                {{--                        <td>3</td>--}}
                {{--                        <td>4</td>--}}
                {{--                    </tr>--}}
                {{--                    </thead>--}}
                {{--                    <tbody>--}}
                {{--                    <tr>--}}
                {{--                        <td class="exam-rights" colspan="14">--}}
                {{--                            <b>Квота (особое право)</b>. Количество мест: <b>4</b>--}}
                {{--                        </td>--}}
                {{--                    </tr>--}}

                {{--                    @foreach($statistics as $k => $stat)--}}
                {{--                        <tr class="text-center">--}}
                {{--                            <td class="text-center">{{$k + 1}}</td>--}}
                {{--                            <td>{{$stat->student->fio}}</td>--}}
                {{--                            @if($stat->original)--}}
                {{--                                <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>--}}
                {{--                            @else--}}
                {{--                                <td><i class="fa fa-times-circle" style="color: rgba(128,0,0,0.51)"></i></td>--}}
                {{--                            @endif--}}
                {{--                            @if($stat->accept)--}}
                {{--                                <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>--}}
                {{--                            @else--}}
                {{--                                <td><i class="fa fa-times-circle" style="color: rgba(128,0,0,0.51)"></i></td>--}}
                {{--                            @endif--}}

                {{--                            <td>80</td>--}}
                {{--                            <td>80</td>--}}
                {{--                            <td>80</td>--}}

                {{--                            <td>{{$stat->indAchievement}}</td>--}}
                {{--                            <td>{{$stat->summ}}</td>--}}
                {{--                            <td>{{$stat->summContest}}</td>--}}
                {{--                            --}}{{--                            <td>ЕГЭ</td>--}}
                {{--                            <td>{{$stat->notice1}}</td>--}}
                {{--                            @if($stat->needHostel)--}}
                {{--                                <td>Да</td>--}}
                {{--                            @else--}}
                {{--                                <td>Нет</td>--}}
                {{--                            @endif--}}
                {{--                        </tr>--}}
                {{--                    @endforeach--}}
                {{--                    </tbody>--}}
                {{--                </table>--}}
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
