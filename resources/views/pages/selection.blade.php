@extends('pages.layout')

@section('page')

    <div id="square">
        <i class="fa fa-arrow-up"></i>
    </div>

    {{--  modal  --}}

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered mt-5" role="document">
            <div class="modal-content">
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-2x"></i>
                </button>
                <div class="row w-100 m-0 p-0">
                    <div class="topline col-12 d-flex align-items-center justify-content-center">
                        <h5 class="m-0 text-white text-center" id="facultyName">-</h5>
                    </div>
                </div>
                <div class="modal-header pb-0 pt-0 modal-header-ovz">
                    <div class="row w-100 m-auto text-center pt-3 pb-3">
                        <div class="col-12"></div>
                        <div class="col-12"><h5 class="m-0"><b id="directionName">-</b><br><span id="spec"></span></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-12" id="examsNames">-</div>
                        <div class="col-12">
                            <hr class="w-100 bg-white">
                        </div>
                        <div class="col-12" id="forms">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  end modal  --}}


    <div class="container-fluid pr-5 pl-5 pb-5 pt-0">
        <div class="row mt-lg-5 mt-xl-5 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12 m-auto">
                <h3 class="text-center h1-mrsu main-color m-0">Подбор образовательных программ</h3>
                {{--                <h5 class="text-center h5-mrsu">Выберите направление подготовки из списка --}}
                {{--                </h5>--}}
            </div>
        </div>


        <div class="row mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12 p-0">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item swith-priem">
                        <a class="nav-link border-priem active text-uppercase btn btn-lg" id="pills-profile-tab"
                           data-toggle="pill"
                           href="#pills-profile" role="tab"
                           aria-controls="pills-profile" aria-selected="true">ПО ФАКУЛЬТЕТАМ И ИНСТИТУТАМ</a>
                    </li>
                    <li class="nav-item swith-priem">
                        <a class="nav-link border-priem text-uppercase btn btn-lg" id="pills-home-tab"
                           data-toggle="pill" href="#pills-home" role="tab"
                           aria-controls="pills-home" aria-selected="false">ПО ПРЕДМЕТАМ ЕГЭ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade " id="pills-home" role="tabpanel"
                         aria-labelledby="pills-home-tab">
                        <div class="row mt-2 d-flex flex-xl-row flex-column-reverse flex-sm-column-reverse">
                            <div class="col-12 col-xl-9 col-sm-12 pl-0 pr-0">
                                @foreach($faculties as $faculty)
                                    @if(count($faculty->plan))
                                        <div class="col-12 mb-5 search-div"
                                             data-exams="{{ implode(',', $faculty->subjects) }}">
                                            <h4><a href="{{$faculty->link}}" target="_blank" class="main-color"
                                                   style="text-decoration: underline">{{$faculty->name}}</a>
                                            </h4>
                                            <table style="width: 100% !important;"
                                                   class="table table-sm table-scores w-100 table-b-border table-ovz-select">
                                                <thead>
                                                <tr>
                                                    <th width="40%" rowspan="3" style="vertical-align: middle">
                                                        Направление
                                                        подготовки / Специальность
                                                    </th>
                                                    <th width="20%" rowspan="3" style="vertical-align: middle">
                                                        Вступительные
                                                        испытания в порядке
                                                        приоритетности для
                                                        ранжирования
                                                    </th>
                                                    <th width="10%" rowspan="3" style="vertical-align: middle"
                                                        class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">
                                                        Минимальные
                                                        баллы
                                                    </th>
                                                    <th width="10%" rowspan="3" style="vertical-align: middle"
                                                        class="d-lg-none d-xl-none d-md-none d-sm-none d-table-cell">
                                                        Мин. баллы
                                                    </th>
                                                    <th width="10%" rowspan="3" style="vertical-align: middle"
                                                        class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">
                                                        Формы
                                                        обучения
                                                    </th>
                                                    <th colspan="4" width="20%"
                                                        class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">
                                                        Статистика проходных баллов <br> (бюджет, общий конкурс)
                                                    </th>
                                                </tr>
                                                <tr class="d-lg-table-row d-xl-table-row d-md-table-row d-sm-table-row d-none">
                                                    <th
                                                        style="vertical-align: middle">{{strval(date ( 'Y' ) - 1)}}
                                                    </th>
                                                    <th
                                                        style="vertical-align: middle">{{strval(date ( 'Y' ) - 2)}}
                                                    </th>
                                                    <th class=""
                                                        style="vertical-align: middle">{{strval(date ( 'Y' ) - 3)}}
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($faculty->plan as $item)
                                                    <tr class="nps-tr search-tr"
                                                        data-exams="{{ implode(',', $item->subjects) }}">
                                                        <td rowspan="{{count($item->scores) }}"
                                                            class="bold-border-imp"
                                                            {{--                                                            style="border-bottom: 2px solid #2366a5 !important;"--}}
                                                        >
                                                            <button style="white-space: normal;" type="button"
                                                                    class=" spec-ovz-link btn btn-link text-left d-block w-100 p-0 ovz-text"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable"
                                                                    data-content="{{$item}}">
                                                                {{$item->speciality->code}}<br>
                                                                <b><u>{{$item->speciality->name}}</u></b>@if($item->specialization)
                                                                    <br>{{$item->specialization->name}}

                                                                @endif
                                                            </button>
                                                        </td>
                                                        @foreach($item->scores as $k => $score)
                                                            @if (!strpos($score->subject->name, 'достижение'))
                                                                @if($k == 0)
                                                                    <td>{{$score->subject->name}}</td>
                                                                    <td class="text-center">{{$score->minScore}}</td>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        <td rowspan="{{count($item->scores) }}"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                            {{--                                                            style="border-bottom:2px solid #2366a5 !important;"--}}
                                                        >
                                                            @foreach($item->studyForm as $sf)
                                                                <span style="white-space: nowrap">{{$sf->name}}</span>
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                        <td rowspan="{{count($item->scores)}}"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                            {{--                                                            style="border-bottom:2px solid #2366a5 !important;"--}}
                                                        >
                                                            @foreach($item->studyForm as $sf)
                                                                @php
                                                                    $counter = 0;
                                                                @endphp
                                                                @foreach($sf->freeseats as $fs)

                                                                    @if($fs->admissionBasis->short_name == 'БО')
                                                                        @php
                                                                            $counter++;
                                                                        @endphp
                                                                        @if(!$fs->pastContests->contains('year', strval(date ( 'Y' ) - 1)))
                                                                            <span>-</span>
                                                                            <br>
                                                                        @endif
                                                                        @foreach($fs->pastContests as $pc)
                                                                            @if($pc->year === strval(date ( 'Y' ) - 1))
                                                                                <span>{{$pc->minScore}}</span>
                                                                                <br>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                                @if(!$counter)
                                                                    <span>-</span>
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td rowspan="{{count($item->scores) }}"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                            {{--                                                            style="border-bottom:2px solid #2366a5 !important;"--}}
                                                        >
                                                            @foreach($item->studyForm as $sf)
                                                                @php
                                                                    $counter = 0;
                                                                @endphp
                                                                @foreach($sf->freeseats as $fs)
                                                                    @if($fs->admissionBasis->short_name == 'БО')
                                                                        @php
                                                                            $counter = 1;
                                                                        @endphp
                                                                        @if(!$fs->pastContests->contains('year', strval(date ( 'Y' ) - 2)))
                                                                            <span>-</span>
                                                                            <br>
                                                                        @endif
                                                                        @foreach($fs->pastContests as $pc)
                                                                            @if($pc->year == strval(date ( 'Y' ) - 2))
                                                                                <span>{{$pc->minScore}}</span>
                                                                                <br>
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                                @if(!$counter)
                                                                    <span>-</span>
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td rowspan="{{count($item->scores) }}"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-right-imp"
                                                            {{--                                                            style="border-bottom:2px solid #2366a5 !important; border-right:2px solid #2366a5 !important;"--}}
                                                        >
                                                            @foreach($item->studyForm as $sf)
                                                                @php
                                                                    $counter = 0;
                                                                @endphp
                                                                @foreach($sf->freeseats as $fs)

                                                                    @if($fs->admissionBasis->short_name == 'БО')
                                                                        @php
                                                                            $counter++;
                                                                        @endphp

                                                                        @if(!$fs->pastContests->contains('year', strval(date ( 'Y' ) - 3)))
                                                                            <span>-</span>
                                                                            <br>
                                                                        @endif

                                                                        @foreach($fs->pastContests as $pc)
                                                                            @if($pc->year === strval(date ( 'Y' ) - 3))
                                                                                <span>{{$pc->minScore}}</span>
                                                                                <br>
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                                @if(!$counter)
                                                                    <span>-</span>
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                    </tr>
                                                    @foreach($item->scores as $k => $score)
                                                        @if (!strpos($score->subject->name, 'достижение'))
                                                            @if($k !== 0 && $k !== (count($item->scores)-1))
                                                                <tr class="nps-tr search-tr"
                                                                    data-exams="{{ implode(',', $item->subjects) }}">
                                                                    <td>{{$score->subject->name}}</td>
                                                                    <td class="text-center">{{$score->minScore}}</td>
                                                                </tr>
                                                            @elseif ($k == (count($item->scores)-1))
                                                                <tr class="nps-tr search-tr"
                                                                    data-exams="{{ implode(',', $item->subjects) }}">
                                                                    <td class="bold-border-imp"
                                                                        {{--                                                                        style="border-bottom: 2px solid #2366a5 !important;"--}}
                                                                    >{{$score->subject->name}}</td>
                                                                    <td
                                                                        {{--                                                                        style="border-bottom: 2px solid #2366a5 !important;;"--}}
                                                                        class="text-center bold-border-imp">{{$score->minScore}}</td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="col-12 col-xl-3 col-lg-12 col-sm-12">
                                <h4 class="mb-3 text-xl-left text-lg-center text-md-center text-sm-center main-color text-md-center text-center">
                                    Мои ЕГЭ</h4>
                                <div class="row text-uppercase mb-5">
                                    @foreach($subjects as $subject)
                                        <div class="col-12 col-xl-12 col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group form-check check-subjects">
                                                <input type="checkbox" class="form-check-input"
                                                       id="option{{ $loop->index }}"
                                                       onclick="addToChosenExams('{{ $subject->name }}')">
                                                <label class="form-check-label ml-2 underline-label"
                                                       for="option{{ $loop->index }}">{{ $subject->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                         aria-labelledby="pills-profile-tab">
                        <div class="row mt-2 d-flex flex-xl-row flex-column-reverse flex-sm-column-reverse">
                            <div class="col-12 col-xl-9 col-sm-12">
                                <div class="row">
                                    @foreach($faculties as $faculty)
                                        @if(count($faculty->plan))
                                            <div class="col-12 mb-5 search-div-by-faculties"
                                                 data-faculty="{{ $faculty->name }}"
                                                 data-exams="{{ implode(',', $faculty->subjects) }}">
                                                <h4><a href="{{$faculty->link}}"
                                                       class="faculty-head" style="text-decoration: underline"
                                                       {{--                                                       style="color: #2366a5"--}}
                                                       target="_blank">{{$faculty->name}}</a>
                                                </h4>
                                                <table
                                                    class="table table-b-border table-sm table-scores w-100 table-ovz-select">
                                                    <thead>
                                                    <tr>
                                                        <th width="40%" rowspan="3" style="vertical-align: middle">
                                                            Направление
                                                            подготовки / Специальность
                                                        </th>
                                                        <th width="20%" rowspan="3" style="vertical-align: middle">
                                                            Вступительные
                                                            испытания в порядке
                                                            приоритетности для
                                                            ранжирования
                                                        </th>
                                                        <th width="10%" rowspan="3" style="vertical-align: middle"
                                                            class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">
                                                            Минимальные
                                                            баллы
                                                        </th>
                                                        <th width="10%" rowspan="3" style="vertical-align: middle"
                                                            class="d-lg-none d-xl-none d-md-none d-sm-none d-table-cell">
                                                            Мин. баллы
                                                        </th>
                                                        <th width="10%"
                                                            class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none"
                                                            rowspan="3" style="vertical-align: middle">Формы
                                                            обучения
                                                        </th>
                                                        <th colspan="4" width="20%"
                                                            class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">
                                                            Статистика проходных баллов <br> (бюджет, общий конкурс)
                                                        </th>
                                                    </tr>
                                                    <tr class="d-lg-table-row d-xl-table-row d-md-table-row d-sm-table-row d-none">
                                                        <th
                                                            style="vertical-align: middle">{{strval(date ( 'Y' ) - 1)}}
                                                        </th>
                                                        <th
                                                            style="vertical-align: middle">{{strval(date ( 'Y' ) - 2)}}
                                                        </th>
                                                        <th class="bold-border-right-imp"
                                                            style="vertical-align: middle">{{strval(date ( 'Y' ) - 3)}}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($faculty->plan as $item)
                                                        <tr class="nps-tr search-tr-by-faculties"
                                                            data-exams="{{ implode(',', $item->subjects) }}">
                                                            <td rowspan="{{count($item->scores)}}"
                                                                class="bold-border-imp"
                                                                {{--                                                                style="border-bottom: 2px solid #2366a5 !important;"--}}
                                                            >
                                                                <button style="white-space: normal;" type="button"
                                                                        class="spec-ovz-link btn btn-link text-left w-100 p-0 d-block  ovz-text"
                                                                        data-toggle="modal"
                                                                        data-target="#exampleModalScrollable"
                                                                        data-content="{{$item}}">
                                                                    {{$item->speciality->code}}<br>
                                                                    <b><u>{{$item->speciality->name}}</u></b>@if($item->specialization)
                                                                        <br>{{$item->specialization->name}}
                                                                    @endif
                                                                </button>
                                                            </td>
                                                            @foreach($item->scores as $k => $score)
                                                                @if (!strpos($score->subject->name, 'достижение'))
                                                                    @if($k == 0)
                                                                        <td>{{$score->subject->name}}</td>
                                                                        <td class="text-center">{{$score->minScore}}</td>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                            <td rowspan="{{count($item->scores)}}"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    <span style="white-space: nowrap"
                                                                          class="text-center">{{$sf->name}}</span>
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="{{count($item->scores)}}"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    @php
                                                                        $counter = 0;
                                                                    @endphp
                                                                    @foreach($sf->freeseats as $fs)

                                                                        @if($fs->admissionBasis->short_name == 'БО')
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if(!$fs->pastContests->contains('year', strval(date ( 'Y' ) - 1)))
                                                                                <span class="text-center">-</span>
                                                                                <br>
                                                                            @endif
                                                                            @foreach($fs->pastContests as $pc)
                                                                                @if($pc->year === strval(date ( 'Y' ) - 1))
                                                                                    <span
                                                                                        class="text-center">{{$pc->minScore}}</span>
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                                                                    @if(!$counter)
                                                                        <span>-</span>
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="{{count($item->scores)}}"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    @php
                                                                        $counter = 0;
                                                                    @endphp
                                                                    @foreach($sf->freeseats as $fs)
                                                                        @if($fs->admissionBasis->short_name == 'БО')
                                                                            @php
                                                                                $counter = 1;
                                                                            @endphp
                                                                            @if(!$fs->pastContests->contains('year', strval(date ( 'Y' ) - 2)))
                                                                                <span class="text-center">-</span>
                                                                                <br>
                                                                            @endif
                                                                            @foreach($fs->pastContests as $pc)
                                                                                @if($pc->year == strval(date ( 'Y' ) - 2))
                                                                                    <span
                                                                                        class="text-center">{{$pc->minScore}}</span>
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                                                                    @if(!$counter)
                                                                        <span>-</span>
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="{{count($item->scores)}}"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-right-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important; border-right:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    @php
                                                                        $counter = 0;
                                                                    @endphp
                                                                    @foreach($sf->freeseats as $fs)

                                                                        @if($fs->admissionBasis->short_name == 'БО')
                                                                            @php
                                                                                $counter++;
                                                                            @endphp

                                                                            @if(!$fs->pastContests->contains('year', strval(date ( 'Y' ) - 3)))
                                                                                <span class="text-center">-</span>
                                                                                <br>
                                                                            @endif

                                                                            @foreach($fs->pastContests as $pc)
                                                                                @if($pc->year === strval(date ( 'Y' ) - 3))
                                                                                    <span
                                                                                        class="text-center">{{$pc->minScore}}</span>
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach

                                                                        @endif
                                                                    @endforeach
                                                                    @if(!$counter)
                                                                        <span>-</span>
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>

                                                        @foreach($item->scores as $k => $score)
                                                            @if (!strpos($score->subject->name, 'достижение'))
                                                                @if($k !== 0 && $k !== (count($item->scores) - 1))
                                                                    <tr class="nps-tr search-tr-by-facluties"
                                                                        data-exams="{{ implode(',', $item->subjects) }}">
                                                                        <td>{{$score->subject->name}}</td>
                                                                        <td class="text-center">{{$score->minScore}}</td>
                                                                    </tr>
                                                                @elseif ($k == (count($item->scores) - 1))
                                                                    <tr class="nps-tr search-tr-by-facluties"
                                                                        data-exams="{{ implode(',', $item->subjects) }}">
                                                                        <td class="bold-border-imp"
                                                                            {{--                                                                            style="border-bottom: 2px solid #2366a5 !important;"--}}
                                                                        >{{$score->subject->name}}</td>
                                                                        <td
                                                                            {{--                                                                            style="border-bottom: 2px solid #2366a5 !important;;"--}}
                                                                            class="text-center bold-border-imp">{{$score->minScore}}</td>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-xl-3 col-lg-12 col-sm-12">
                                <h4 class="mb-3 text-xl-left text-lg-center text-md-center text-sm-center text-md-center main-color text-center">
                                    Факультеты и институты</h4>
                                <div class="row text-uppercase mb-5">
                                    @foreach($faculties as $faculty)
                                        @if(count($faculty->plan))
                                            <div class="col-12 col-xl-12 col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group form-check check-faculties">
                                                    <input type="checkbox" class="form-check-input"
                                                           id="optionFaculties{{ $loop->index }}"
                                                           onclick="addToChosenFaculties('{{ $faculty->name }}')">
                                                    <label class="form-check-label ml-2 underline-label"
                                                           for="optionFaculties{{ $loop->index }}">{{ $faculty->name }}</label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        var chosenExams = [];
        var chosenFaculties = [];
        $(document).ready(() => {
            $('.form-check-input').prop('checked', false);
            chosenExams = [];
            chosenFaculties = [];
        })


        function addToChosenExams(exam) {
            let idx = chosenExams.indexOf(exam);
            idx !== -1 ? chosenExams.splice(idx, 1) : chosenExams.push(exam);
            search();
        }

        function search() {
            let searchDivs = $('.search-div');
            $.each(searchDivs, function (index, searchDiv) {
                let showDiv = false;
                $.each($(searchDiv).find('.search-tr'), function (i, item) {
                    let exams = $(item).data("exams").split(',');
                    if (exams.length <= chosenExams.length && chosenExams.length > 0) {
                        if (include(exams, chosenExams)) {
                            $(item).show();
                            showDiv = true;
                        } else {
                            $(item).hide()
                        }
                    } else {
                        $(item).hide()
                    }
                });
                showDiv ? $(searchDiv).show() : $(searchDiv).hide();
            });
        }

        function include(array1, array2) {
            let count = 0;
            $.each(array1, function (k, v) {
                $.inArray(v, array2) !== -1 ? count += 1 : null;
            });
            return (count === array1.length);
        }

        function addToChosenFaculties(faculty) {
            let idx = chosenFaculties.indexOf(faculty);
            idx !== -1 ? chosenFaculties.splice(idx, 1) : chosenFaculties.push(faculty)
            searchByFac();
        }

        function searchByFac() {
            let searchDivs = $('.search-div-by-faculties');
            $.each(searchDivs, function (index, searchDiv) {
                if (chosenFaculties.length > 0) {
                    $.inArray($(searchDiv).data('faculty'), chosenFaculties) !== -1 ? $(searchDiv).show() : $(searchDiv).hide();
                } else {
                    $(searchDiv).show()
                }
            });
        }

        function changeNum(n) {
            return (n + "").split("").reverse().join("").replace(/(\d{3})/g, "$1 ").split("").reverse().join("").replace(/^ /, "");
        }


        $('#exampleModalScrollable').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('content') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            let years = {
                0: 'лет',
                1: 'год',
                2: 'года',
                3: 'года',
                4: 'года',
                5: 'лет',
                6: 'лет',
                7: 'лет',
                8: 'лет',
                9: 'лет',
            };
            let codes = {
                3: 'Бакалавриат',
                4: 'Магистратура',
                5: 'Специалитет',
                2: 'Среднее профессиональное образование',
                6: 'Аспирантура',
                7: 'Ординатура',
                9: 'Ассистентура'
            }
            var modal = $(this)
            if ((recipient.faculty).length > 30) {
                $('#facultyName').css({'font-size': '1.25rem'})
            } else {
                $('#facultyName').css({'font-size': '1.5rem'})
            }
            modal.find('#facultyName').empty().text(recipient.faculty)
            modal.find('#directionName').empty().text(recipient.speciality.code + ' ' + recipient.speciality.name)
            modal.find('#spec').empty().text((recipient.specialization !== null ? recipient.specialization.name : ''))
            let names = ''
            $.each(recipient.subjects, function (k, v) {
                if (k === recipient.subjects.length - 1) {
                    names += v
                } else {
                    names += v + ', '
                }
            });
            let specCode = recipient.speciality.code[4];
            modal.find('table').empty()
            modal.find('#examsNames').empty().text(codes[specCode])
            modal.find('#examsNames').css({'font-size': '20px', 'text-transform': 'uppercase'})
            modal.find('#forms').empty()

            let temp_item_o = null;
            let temp_item_z = null;
            let temp_item_oz = null;
            let sortedForms = [];

            $.each(recipient.studyForm, (k, v) => {
                console.log(v)
                if (v.name.trim() === "Очная") {
                    temp_item_o = v
                }
                if (v.name.trim() === "Очно-заочная") {
                    temp_item_oz = v
                }
                if (v.name.trim() === "Заочная") {
                    temp_item_z = v
                }
            })

            if (temp_item_o) {
                sortedForms.push(temp_item_o)
            }
            if (temp_item_oz) {
                sortedForms.push(temp_item_oz)
            }
            if (temp_item_z) {
                sortedForms.push(temp_item_z)
            }
            console.log(recipient.studyForm, sortedForms)
            $.each(sortedForms, (k, v) => {
                let number = v.years.toString().slice(-1)
                let year = years[number];
                let templateRecipient =
                    "<div class=''>" +
                    "<div class='row d-flex justify-content-cetner'>" +
                    "<div class='col-12 d-flex align-items-center justify-content-center flex-column'>" +
                    "<h5><strong>" + v.name + " форма, " + v.years + " " + year + "</strong></h5>" +
                    "</div><div class='col-12 col-lg-6 col-xl-6 col-md-6 col-sm-12 mb-2'><h5 class='text-center mb-0'><strong>Количество мест:</strong></h5>"

                v.freeseats.sort((a,b) => (a.admissionBasis.name.length > b.admissionBasis.name.length) ? 1 : ((b.admissionBasis.name.length > a.admissionBasis.name.length) ? -1 : 0));

                $.each(v.freeseats, (key, seat) => {
                    //templateRecipient += "<tr><td>" + seat.admissionBasis.name + "</td><td>" + seat.value + "</td></tr>"
                    templateRecipient += "<p class='mb-0 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 text-left'><span>" + seat.admissionBasis.name + " - </span><b>" + seat.value + "</b></p>"
                });

                //templateRecipient += "</tbody></table></div></div>";
                templateRecipient += "</div>";
                templateRecipient += "<div class='col-12 col-lg-6 col-xl-6 col-md-6 col-sm-12 mb-2'>";
                templateRecipient += "<h5 class='text-center mb-0'><strong>Cтоимость обучения:</strong></h5>"
                $.each(v.prices, (key, price) => {
                    if (price.price !== 0) {
                        templateRecipient += "<p class='mb-0 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 text-left'><span>" + price.info + " - </span><b>" + price.price + " ₽/год</b></p>"
                    }
                })
                templateRecipient += "</div></div><div class='col-12'><hr class='w-100 bg-white' /></div>";

                modal.find('#forms').append(templateRecipient)
            })
            //

            //template.format(recipient.intramural.name, recipient.intramural.year, recipient.intramural.budget, recipient.intramural.price)
            // modal.find('.modal-body input').val(recipient)
        })

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
@endsection
