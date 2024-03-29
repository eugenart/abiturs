@extends('pages.layout')
@section('page')
    <div id="square">
        <i class="fa fa-arrow-up"></i>
    </div>
{{--    {{var_dump($news)}}--}}
    <div class="container-fluid pt-lg-3 pt-xl-3 pt-md-3 pt-sm-3 pt-3">
        @if (count($news))
            <div class="row">
                <div class="col-12">
                    <marquee behavior="" direction="" class="mt-2" style="color:#f11818;">
                        @foreach($news as $item)
                        {{$loop->first ? "• " : null}}
                        {{$item}} &bull;
                        @endforeach
                    </marquee>
                </div>
            </div>
        @endif
    </div>
    <div class="container">
        <div class="row mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12">
                <h1 class="text-center h1-mrsu main-color m-0">Бакалавриат и специалитет</h1>
            </div>
        </div>
    </div>

    @if(isset($studyForms))
        <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered mt-5" role="document">
                <div class="modal-content modal-stat">
                    <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                    <div class="row w-100 m-0 p-0">
                        <div class="topline-stat col-12 d-flex align-items-center justify-content-center">
                            <h5 class="m-0 text-center">Списки в формате .xls</h5>
                        </div>
                    </div>
                    <div class="modal-header pb-0 pt-0 modal-header-ovz">
                        <div class="row w-100 m-auto pt-3 pb-3">
                            <div class="col-12">
                                {{--                                                                <a href="{{ asset('storage/files-xls/' . $studyForms->file_xls . '.xls') }}">Скачать файл с данными запроса</a>--}}
                                {{--								@if($studyForms->file_xls != '')--}}
                                <ul class="files-list">
                                    <li>
                                        <div>
                                            @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/xls.png'))
                                                <img width="60px" height="60px"
                                                     src="{{ asset('storage/file-types/xls.png' )}}"
                                                     alt="">
                                            @else
                                                <img width="60px" height="60px"
                                                     src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                                     alt="">
                                            @endif
                                        </div>
                                        <div class="file-link-div ">
                                            @php
                                                $pointer = &$studyForms;
                                            @endphp
                                            <form method="post" action="" id="fileform">
                                                @csrf
                                                <div class="p-3 row">
                                                    <button class="btn btn-link m-0 p-0 col" style="color: #1b4b72;"
                                                            type="submit" id="btn-submit">Сгенерировать и скачать файл с
                                                        данными запроса
                                                    </button>
                                                    <div class="col text-center d-flex">
                                                        <div id="loading" class="lds-ring" style="display:none">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                    <div class="col text-center d-flex">
                                                        <div id="error" class="text-danger" style="display:none"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                                {{--								@endif--}}
                                <h5 class="m-0 text-center">Полные списки поступающих. Бакалавриат и специалитет</h5>
                                <ul class="files-list">

                                    @if(!empty($files_xls))
                                        @foreach($files_xls as $file_xls_stat)
                                            @if(round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/files-xls-stat/bach/' . $file_xls_stat)[7] / 1024 /1024, 2) > 0)
                                                <li>
                                                    <div>
                                                        @if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/file-types/xls.png'))
                                                            <img width="60px" height="60px"
                                                                 src="{{ asset('storage/file-types/xls.png' )}}"
                                                                 alt="">
                                                        @else
                                                            <img width="60px" height="60px"
                                                                 src="{{ asset('storage/file-types/nofile.jpg' )}}"
                                                                 alt="">
                                                        @endif
                                                    </div>
                                                    <div class="file-link-div ">

                                                        <a href="{{ asset('storage/files-xls-stat/bach/' . $file_xls_stat) }}"
                                                           target="_blank">
                                                            {{substr($file_xls_stat, 0, -4)}}
                                                        </a>
                                                        <br>
                                                        <span>{{round(stat($_SERVER['DOCUMENT_ROOT'] . '/storage/files-xls-stat/bach/' . $file_xls_stat)[7] / 1024 /1024, 2)}} MB</span>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="m-2 text-center">
                                            Файлы отсутствуют
                                        </div>
                                    @endif
                                    <div>
                                        {{$notification_files}}
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="legend" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered mt-5" role="document">
                <div class="modal-content">
                    <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times fa-2x"></i>
                    </button>
                    <div class="row w-100 m-0 p-0">
                        <div class="topline-stat col-12 d-flex align-items-center justify-content-center">
                            <h5 class="m-0 text-white text-center">Легенда</h5>
                        </div>
                    </div>
                    <div class="modal-header pb-0 pt-0 modal-header-ovz">
                        <div class="row w-100 m-auto pt-3 pb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div
                                        class="font-weight-bold d-xl-block d-lg-none d-none col-12">
                                        Согласие:
                                    </div>
                                    <div class="d-xl-block d-lg-none d-none col-12"><i
                                            class="fa fa-check-circle "
                                            style="color: rgba(0,128,0,0.51)"></i>
                                        &mdash; первое согласие на зачисление
                                    </div>
                                    <div class="d-xl-block d-lg-none d-none col-12"><i
                                            class="fa fa-check-circle"
                                            style="color: rgba(225,0,0,0.51)"></i>
                                        &mdash; второе согласие на зачисление
                                    </div>
                                </div>
                                <div
                                    class="d-xl-none d-lg-flex d-md-flex d-sm-flex flex-column">
                                    {{--                                    <span class="d-inline-block w-100"><b>О</b> &mdash; оригинал диплома</span>--}}
                                    <span class="d-inline-block w-100"><b>C</b> &mdash; согласие на зачисление:</span>
                                    <ol class="d-inline-block w-100 mb-0 list-unstyled pl-2">
                                        <li><span><i class="fa fa-check-circle "
                                                     style="color: rgba(0,128,0,0.51)"></i>
                                                                                                            &mdash; первое согласие</span>
                                        </li>
                                        <li><span><i class="fa fa-check-circle"
                                                     style="color: rgba(225,0,0,0.51)"></i>
                                                                                                            &mdash; второе согласие</span>
                                        </li>
                                    </ol>
                                    <span
                                        class="d-xl-inline-block w-100 d-sm-inline d-none"><b>БИД</b> &mdash; балл за индивидуальные достижения</span>
                                    <span
                                        class="d-inline-block w-100"><b>СКБ</b> &mdash; сумма конкурсных баллов</span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--  end modal  --}}
    @endif
    <div class="container pt-0 padding-0 mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
        <form class="ovz-form" action="{{ route('stat.index') }}" id="sendFormWithFacultets" method="get">
            <div class="row">
                <div class="col-12 main-ver-div">
                    <div class="row ovz-row">
                        <select
                            {{--                            style="font-size: 16px !important;"--}}
                            class="selectpicker form-control-sm col-lg-3 col-xl-3 col-md-3 col-12" multiple
                            title="Факультет / Институт" name="faculties[]" id="allfaculties">
                        </select>
                        <select class="selectpicker form-control-sm col-lg-3 col-xl-3 col-md-3 col-12"
                                data-live-search="true" multiple
                                title="Направление / Специальность"
                                name="specialities[]" id="specialities">
                        </select>

                        <select class="selectpicker form-control-sm col-lg-3 col-xl-3 col-md-3 col-12" multiple
                                title="Форма обучения"
                                name="studyforms[]"
                                id="studyforms">
                            @foreach ($studyFormsForInputs as $form)
                                <option style="white-space: normal" value="{{$form->id}}">{{$form->name}}</option>
                            @endforeach
                        </select>
                        <div
                            class="col-lg-3 col-xl-3 col-md-3 col-12 mt-xl-0 mt-md-1 mt-1 d-flex justify-content-center align-items-center">
                            <button class="mrsu-bg-button-ovz w-100 btn btn-warning btn-sm" type="button"
                                    id="clearSelects">Отменить
                                выбор
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2 mb-2">
                    <div class="row">
                        <div class="col-md-10 col-9">
                            <input class="form-control form-control-sm" type="search" placeholder="Поиск по ФИО или СНИЛС / ID "
                                   aria-label="Search" name="fio">
                        </div>
                        <div class="col-md-2 col-3">
                            <button class="btn btn-sm btn-primary d-block w-100 mrsu-bg-button ovz-fa" type="submit">
                                <i class="fa fa-search"></i>
                                <span>Найти</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12">
                @if(isset($studyForms))

                    <span
                        class="m-0 p-0 main-color d-lg-none d-md-inline w-100">Обновлено: <b>@if(isset($date_update)){{substr($date_update->date_update, 0, -3)}}@endif</b></span>

                    <button style="white-space: normal;" type="button"
                            class="files-stat spec-ovz-link btn btn-link text-left d-lg-none d-md-block w-100 p-0 ovz-text"
                            data-toggle="modal"
                            data-target="#exampleModalScrollable"
                        {{--                data-content="{{$item}}"--}}
                    >
                        <b><u>Скачать списки</u></b>
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div class="container-fluid pt-0 padding-0 mb-5 mt-xl-3">
        <div class="row">
            <div class="col-12">
                @if(isset($notification))
                    <div class="text-center m-4 h4">{{$notification}}</div>
                @endif
                @if(isset($notification_green))
                    <div class="text-center m-4 h4 text-success">{{$notification_green}}</div>
                @endif
                @if(isset($studyForms))
                    @foreach($studyForms as $studyForm)
                        @if(isset($studyForm->stat ))
                            @foreach($studyForm->stat as $category)
                                @if(isset($category->preparationLevels))
                                    @foreach($category->preparationLevels as $preparationLevel)
                                        {{--                                        @if(isset($admissionBasis->preparationLevels))--}}
                                        {{--                                            @foreach($admissionBasis->preparationLevels as $preparationLevel)--}}
                                        @if(isset($preparationLevel->faculties))
                                            @foreach($preparationLevel->faculties as $faculty)
                                                @if(isset($faculty->specialities))
                                                    @foreach($faculty->specialities as $speciality)
                                                        @if(isset($speciality->specializations))
                                                            @foreach($speciality->specializations as $specialization)
                                                                @if(isset($specialization->competitions))
                                                                    @foreach($specialization->competitions as $competition)
                                                                        @if(isset($competition->admissionBases))
                                                                            @foreach($competition->admissionBases as $admissionBasis)
                                                                                <div
                                                                                    class="row mt-1 justify-content-start">
                                                                                    <div
                                                                                        class="col-xl-8 col-lg-8 col-md-12 col-12">
                                                                                        <div
                                                                                            class="exam-info-outer w-100 d-lg-flex flex-lg-row d-sm-flex flex-sm-column d-flex flex-column">
                                                                                            <div
                                                                                                class="exam-info-bottom col-xl-6 col-lg-6 col-12 float-left p-0 d-flex align-items-stretch">
                                                                                                <div
                                                                                                    class="examInfo-bottom pl-4">
                                                                                                    <div
                                                                                                        class="row d-flex align-items-center justify-content-center h-100">
                                                                                                        <div
                                                                                                            class="col-12">
                                                                                                            <p class="m-0 text-uppercase font-weight-bold">{{$faculty->name}}</p>
                                                                                                            <p class="m-0">{{$speciality->code}}
                                                                                                                <span
                                                                                                                    class=" font-weight-bold">{{$speciality->name}}</span>
                                                                                                            </p>
                                                                                                            <p class="m-0">{{$specialization->name}}</p>
                                                                                                            @if($admissionBasis->stage_title == NULL)
                                                                                                            <p class="m-0">
                                                                                                                Количество
                                                                                                                мест:
                                                                                                                <span
                                                                                                                    class="font-weight-bold">{{$admissionBasis->freeSeatsNumber}}</span>
                                                                                                            </p>
                                                                                                            @else
                                                                                                                <p class="m-0">
                                                                                                                    {{$admissionBasis->stage_title}}
                                                                                                                    :
                                                                                                                    <span
                                                                                                                        class="font-weight-bold">{{$admissionBasis->stage}}</span>
                                                                                                                </p>
                                                                                                            @endif
                                                                                                            <p class="m-0">
                                                                                                                Конкурс:
                                                                                                                <span
                                                                                                                    class="font-weight-bold">{{$admissionBasis->originalsCount}}</span>
                                                                                                                чел.
                                                                                                                / место
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-xl-6 col-lg-6 col-12 float-left p-0">
                                                                                                <div
                                                                                                    class="examInfo p-3">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-12">
                                                                                                            <table>
                                                                                                                <tbody>
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        Форма
                                                                                                                        обучения
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <b class="mrsu-uppertext">{{$studyForm->name}}</b>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        Категория
                                                                                                                        приема
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <b class="mrsu-uppertext">{{ $category->name }}</b>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        Основание
                                                                                                                        для
                                                                                                                        поступления
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <b class="mrsu-uppertext">{{ $admissionBasis->name }}</b>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        Уровень
                                                                                                                        подготовки
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
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-xl-4 col-lg-4 col-md-12 col-12 d-lg-flex d-md-none d-none flex-column justify-content-around">
                                                                                        @if(isset($studyForms))
                                                                                            @if  ($admissionBasis->dateUp != NULL)
                                                                                                <span class="m-0 p-0 main-color d-lg-inline d-md-none w-100">Обновлено: <b>{{$admissionBasis->dateUp}}</b></span>
                                                                                            @else
                                                                                                <span class="m-0 p-0 main-color d-lg-inline d-md-none w-100">Обновлено: <b>@if(isset($date_update)){{substr($date_update->date_update, 0, -3)}}@endif</b></span>
                                                                                            @endif


                                                                                            <button
                                                                                                style="white-space: normal;"
                                                                                                type="button"
                                                                                                class="files-stat spec-ovz-link btn btn-link text-left d-lg-block d-md-none w-100 p-0 ovz-text"
                                                                                                data-toggle="modal"
                                                                                                data-target="#exampleModalScrollable"
                                                                                                {{--                data-content="{{$item}}"--}}
                                                                                            >
                                                                                                <b><u>Скачать списки</u></b>
                                                                                            </button>
                                                                                        @endif
                                                                                        <div
                                                                                            class="m-0 p-0 h6 d-lg-block d-md-none d-sm-none d-none"
                                                                                            style="height: fit-content">
                                                                                            <div class="row">
                                                                                                @if (isset($studyForms))
                                                                                                    <div
                                                                                                        class="col-lg-4 pr-0 w-50">
                                                                                                        <img
                                                                                                            class="d-block float-left"
                                                                                                            style="width: 100px; height: auto;"
                                                                                                            src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{$actual_link}}&choe=UTF-8"/>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="col-lg-8 pl-0 w-50 d-flex justify-content-center align-items-center">
                                                                                    <span
                                                                                        class="">Сохранить параметры запроса на мобильном устройстве</span>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>
                                                                                @if(isset($admissionBasis->chosenStudents))
                                                                                    <div class="chosen-student-ovz">
                                                                                        @foreach($admissionBasis->chosenStudents as $chosenStudent)
                                                                                            <div class="main-color h6">

                                                                                                @if($admissionBasis->abiturs->first()->snils_show == true)
                                                                                                    <span class="font-weight-bold">{{$chosenStudent->snils2}} </span>
                                                                                                @else
                                                                                                    <span class="font-weight-bold">{{$chosenStudent->fio}} </span>
                                                                                                @endif
                                                                                                &mdash;
                                                                                                <a class="main-color underline-label h6"
                                                                                                   href="#stud-{{$chosenStudent->id}}-{{$speciality->id}}">конкурсное
                                                                                                    место
                                                                                                    <b>{{$chosenStudent->serialNum}}</b></a>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                                @if(isset($admissionBasis->abiturs))
                                                                                    <div class="row p-0 m-0">
                                                                                        <div
                                                                                            class="col-12 d-flex justify-content-end">
                                                                                            <button data-toggle="modal"
                                                                                                    data-target="#legend"
                                                                                                    class="btn btn-sm btn-link p-0 legend">
                                                                                                Легенда
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <table
                                                                                        class="table table-bordered table-stat table-ovz table-sm base-exams-table mt-0">
                                                                                        <thead>
                                                                                        <tr style="vertical-align: center">
                                                                                            <th rowspan="2"
                                                                                                class="text-center">
                                                                                                №
                                                                                            </th>
                                                                                            <th rowspan="2"
                                                                                                class="text-center">

                                                                                            @if($admissionBasis->abiturs->first()->snils_show == true)
                                                                                                    <span class="d-xl-table-cell d-lg-none d-none">СНИЛС / ID абитуриента</span>
                                                                                                    <span class="d-xl-none d-lg-table-cell d-lg-table-cell">СНИЛС / ID </span>
                                                                                            @else
                                                                                                    <span class="d-xl-table-cell d-lg-none d-none">Фамилия, имя, отчество</span>
                                                                                                    <span class="d-xl-none d-lg-table-cell d-lg-table-cell">ФИО</span>
                                                                                            @endif


                                                                                            </th>
                                                                                            {{--                                                                            <th rowspan="2" class="text-center">--}}
                                                                                            {{--                                                                                <span--}}
                                                                                            {{--                                                                                    class="d-xl-inline d-lg-none d-none">Оригинал</span>--}}
                                                                                            {{--                                                                                <span--}}
                                                                                            {{--                                                                                    class="d-xl-none d-lg-inline d-inline">O</span>--}}
                                                                                            {{--                                                                            </th>--}}
                                                                                            <th rowspan="2"
                                                                                                class="text-center">
                                                                                <span
                                                                                    class="d-xl-inline d-lg-none d-none">Согласие</span>
                                                                                                <span
                                                                                                    class="d-xl-none d-lg-inline d-inline">С</span>
                                                                                            </th>
                                                                                            <th class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none"
                                                                                                colspan="{{count($admissionBasis->subs) + 1}}">

                                                                                                @foreach($admissionBasis->subs as $i => $sc)
                                                                                                    @if($i < count($admissionBasis->subs) -1)
                                                                                                        <p class="m-0"> {{$i+1}}
                                                                                                            ) {{$sc}}</p>
                                                                                                    @else
                                                                                                        <p class="m-0"> {{$i+1}}
                                                                                                            ) {{$sc}}</p>
                                                                                                        <p class="m-0 d-xl-inline d-lg-none d-none">{{$i + 2}}
                                                                                                            ) Балл
                                                                                                            за
                                                                                                            индивидуальные
                                                                                                            достижения</p>
                                                                                                        <p class="m-0 d-xl-none d-lg-inline d-inline">{{$i + 2}}
                                                                                                            ) БИД</p>
                                                                                                    @endif
                                                                                                @endforeach

                                                                                            </th>
                                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                                rowspan="2">Сумма
                                                                                                баллов<br/> за
                                                                                                ЕГЭ/ВИ
                                                                                            </th>
                                                                                            <th class="text-center"
                                                                                                rowspan="2">
                                                                                <span
                                                                                    class="d-xl-inline d-lg-none d-none">Сумма<br/>
                                                                                конкурсных<br/> баллов</span>
                                                                                                <span
                                                                                                    class="d-xl-none d-lg-inline d-inline">СКБ</span>
                                                                                            </th>
                                                                                            {{--                                                                                    <th class="text-center d-xl-table-cell d-lg-none d-none"--}}
                                                                                            {{--                                                                                        rowspan="2">Тип--}}
                                                                                            {{--                                                                                        экзамена--}}
                                                                                            {{--                                                                                    </th>--}}
                                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                                rowspan="2">Статус
                                                                                                проверки
                                                                                            </th>
                                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                                rowspan="2">
                                                                                                Нуждаемость <br> в
                                                                                                общежитии
                                                                                            </th>
                                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                                rowspan="2">
                                                                                                Примечание
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr class="text-center d-lg-table-row d-xl-table-row d-md-table-row d-sm-table-row d-none">
                                                                                            @foreach($admissionBasis->abiturs->first()->score as $i => $sc)
                                                                                                @if($i < count($admissionBasis->abiturs->first()->score) -1)
                                                                                                    <th>{{$sc->priority}}</th>
                                                                                                @else
                                                                                                    <th>{{$sc->priority}}</th>
                                                                                                    <th>{{$i + 2}}</th>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        @foreach($admissionBasis->abiturs as $k => $abitur)
                                                                                            @if($abitur->is_chosen)
                                                                                                <tr class="text-center chosen-student">
                                                                                            @else
                                                                                                <tr class="text-center">
                                                                                                    @endif
                                                                                                    <td class="text-center">{{$k + 1}}</td>

                                                                                                        <td class="text-left" id="stud-{{$abitur->student->id}}-{{$abitur->id_speciality}}">

                                                                                                            @if($abitur->snils_show == true)
                                                                                                                 {{$abitur->student->snils2}}
                                                                                                            @else
                                                                                                                {{$abitur->student->fio}}
                                                                                                            @endif
                                                                                                        </td>


                                                                                                    {{--                                                                                    <td>--}}
                                                                                                    {{--                                                                                        @if($abitur->original)--}}
                                                                                                    {{--                                                                                            <i class="fa fa-check-circle"--}}
                                                                                                    {{--                                                                                               style="color: rgba(0,128,0,0.51)"></i>--}}
                                                                                                    {{--                                                                                        @endif--}}
                                                                                                    {{--                                                                                    </td>--}}
                                                                                                    <td>
                                                                                                        @if($abitur->acceptCount > 0)
                                                                                                            @if($abitur->acceptCount > 1)
                                                                                                                <i class="fa fa-check-circle"
                                                                                                                   style="color: rgba(225,0,0,0.51)"></i>
                                                                                                            @else
                                                                                                                <i class="fa fa-check-circle"
                                                                                                                   style="color: rgba(0,128,0,0.51)"></i>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    @foreach($abitur->score as $ab_sc)
                                                                                                        <td class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">{{$ab_sc->score}}</td>
                                                                                                    @endforeach
                                                                                                    <td class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">{{$abitur->indAchievement}}</td>
                                                                                                    <td class="d-xl-table-cell d-lg-none d-none">{{$abitur->summ}}</td>
                                                                                                    <td>{{$abitur->summContest}}</td>
                                                                                                    {{--                                                                                            <td class="d-xl-table-cell d-lg-none d-none">--}}
                                                                                                    {{--                                                                                                ЕГЭ--}}
                                                                                                    {{--                                                                                            </td>--}}
                                                                                                    <td class="d-xl-table-cell d-lg-none d-none">{{$abitur->notice1}}</td>
                                                                                                    <td class="d-xl-table-cell d-lg-none d-none">
                                                                                                        @if($abitur->needHostel)
                                                                                                            <i class="fa fa-check-circle"
                                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td class="d-xl-table-cell d-lg-none d-none">{{$abitur->notice2}}</td>
                                                                                                </tr>
                                                                                                @if($abitur->yellowline)
                                                                                                    <tr style="background-color: yellow;">
                                                                                                        <td colspan="100%"
                                                                                                            class="text-center">
                                                                                                            Граница проходного балла на текущем этапе конкурса
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endif
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
                            @endforeach
                        @endif
                    @endforeach

                @else
                    @if(!isset($notification_green))
                        <div class="text-center m-4 h4">Введите <b>ФИО</b> или выберите <b>факультет/институт</b>
                            для
                            вывода списков поступающих
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#fileform').submit(function (e) {
                // let serializedData = $('#contactform').serialize();
                e.preventDefault();
                let mydata = '<?php if (isset($studyForms)) {
                    echo $studyForms;
                } ?>';
                $('#loading').show();
                $('#error').hide();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/statistic/getfile", // куда отправляем
                    type: "post", // метод передачи
                    dataType: "json", // тип передачи данных
                    contentType: 'application/json',
                    processData: false,
                    data: JSON.stringify(mydata),

                    // // после получения ответа сервера
                    success: function (data) {
                        //console.log(data)
                        window.location.replace('/storage/files-xls/' + data + '.xls');
                        $('#loading').hide();
                    },
                    error: function (jqXHR, exception) {
                        $('#loading').hide();
                        $('#error').show();
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        console.log(msg);

                    }
                });
            });
        });
    </script>
    <script>
        $(window).scroll(() => {
            if ($(window).scrollTop()) {
                $('#square').fadeIn()
            } else {
                $('#square').fadeOut()
            }
        })

        $('#square').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
            return false;
        });
    </script>


    <script>
        $('select').click(() => {
            $('.selectpicker .dropdown-menu').css({'min-width': '0', 'max-width': '100vw'})
        })
        $(document).ready(() => {
            $('#submitInfo').attr('disabled', true)
            faculties = {!! json_encode($faculties) !!};
            fillFaculties(faculties);
            fillSpecialitiesWithCheck(faculties)
            // if (/android|webos|iphone|ipad|ipod|blackberry|windows phone|/i.test(navigator.userAgent.toLowerCase())) {
            //     $('.selectpicker').selectpicker('mobile');
            //     console.log('mobile')
            // }
            // else {
            //     $('.selectpicker').selectpicker({});
            // }
        })

        function fillFaculties(faculties) {
            // faculties.sort((prev, next) => {
            //     if (prev.name < next.name) return -1;
            //     if (prev.name < next.name) return 1;
            // });
            $.each(faculties, (k, faculty) => {
                if ((faculty.speciality).length) {
                    $('#allfaculties').append('<option style="word-break: break-all;" value="' + faculty.id + '">' + faculty.name + '</option>')
                }
                refreshInputs();
            })
        }

        function fillSpecialities(faculty) {
            $('#specialities').append('<optgroup label="' + faculty.name + '">')
            $.each(faculty.speciality, (key, spec) => {
                $('#specialities optgroup:last').append('<option value="' + faculty.id + ';' + spec.id + '">' + spec.code + ' ' + spec.name + '</option>')
            })
            $('#specialities').append('</optgroup>')

        }

        function fillSpecialitiesWithCheck(faculties, facultiesIds = []) {
            console.log(facultiesIds);
            $.each(faculties, (k, faculty) => {
                if (facultiesIds.length > 0) {
                    if ($.inArray(faculty.id, facultiesIds) !== -1) {
                        fillSpecialities(faculty)
                    }
                } else {
                    fillSpecialities(faculty)
                }
            })
            refreshInputs();
        }

        function refreshInputs() {
            $('#allfaculties, #specialities, #studyforms').selectpicker('refresh');
        }

        function makeFacultiesChecked(faculties, facultiesIds) {
            $.each(faculties, (k, faculty) => {
                if (facultiesIds.length > 0) {
                    $('#allfaculties').selectpicker('val', facultiesIds);
                }
            })
        }

        $('#allfaculties').change(() => {
            let facultiesIds = $('#allfaculties').val();
            $('#specialities').find('option').remove().find('optgroup').end();
            fillSpecialitiesWithCheck(faculties, facultiesIds.map(Number))
            if ($('#allfaculties').val().length > 0 || $('#specialities').val().length > 0) {
                $('#submitInfo').attr('disabled', false)
            } else {
                $('#submitInfo').attr('disabled', true)
            }
        })

        $('#specialities').change(() => {
            let facultiesIds = []
            let specialitiesIds = []
            $.each($('#specialities').val(), (k, v) => {
                facultiesIds.push(v.split(';')[0])
                specialitiesIds.push(v.split(';')[1])
            })
            makeFacultiesChecked(faculties, facultiesIds.map(Number));
            refreshInputs()
            if ($('#allfaculties').val().length > 0 || $('#specialities').val().length > 0) {
                $('#submitInfo').attr('disabled', false)
            } else {
                $('#submitInfo').attr('disabled', true)
            }
        })

        $('#clearSelects').click(() => {
            $('#allfaculties, #specialities').selectpicker('deselectAll');
        })
    </script>

    <script>
        $('#exampleModalScrollable').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('content') // Extract info from data-* attributes

        })
    </script>

@endsection
