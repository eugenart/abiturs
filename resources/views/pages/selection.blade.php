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
                <button type="button" class="btn close-btn" data-dismiss="modal" aria-label="Close">
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
                <h1 class="text-center h1-mrsu main-color m-0">Подбор образовательных программ</h1>
                {{--                <h5 class="text-center h5-mrsu">Выберите направление подготовки из списка --}}
                {{--                </h5>--}}
            </div>
        </div>


        <div class="row mt-lg-4 mt-xl-4 mt-md-3 mt-sm-3 mt-3">
            <div class="col-12 p-0">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center switch-panel" id="pills-tab" role="tablist">
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
        <div class="row" >
            <div class="col-12">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade " id="pills-home" role="tabpanel"
                         aria-labelledby="pills-home-tab">
                        <div class="row mt-2 d-flex flex-xl-row flex-column-reverse flex-sm-column-reverse" >
                            <div class="col-12 col-xl-9 col-sm-12 pl-0 pr-0" >
                                @foreach($faculties as $faculty)
                                    @if(count($faculty->plan))
                                        <div class="col-12 mb-5 search-div"
                                             data-exams="{{ implode(',', $faculty->subjects) }}">
                                            <h4><a href="{{$faculty->link}}" target="_blank" class="main-color"
                                                   style="text-decoration: underline">{{$faculty->name}}</a>
                                            </h4>
                                            <table style="width: 100% !important; "
                                                   class="table table-sm table-scores w-100 table-b-border table-ovz-select">
                                                <thead>
                                                <tr>
                                                    <th width="40%" rowspan="3" style="vertical-align: middle">
                                                        Направление
                                                        подготовки
                                                    </th>
                                                    <th width="20%" rowspan="3" style="vertical-align: middle">
                                                        Вступительные
                                                        испытания <br/><span class="small-text-thead text-lowercase">(в приоритетном порядке)</span>
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
                                                        Статистика проходных баллов <br> <span class="small-text-thead text-lowercase">(бюджет, общий конкурс)</span>
                                                    </th>
                                                </tr>
                                                <tr class="d-lg-table-row d-xl-table-row d-md-table-row d-sm-table-row d-none">
                                                    <th
                                                        style="vertical-align: middle">{{strval($year - 1)}}
                                                    </th>
                                                    <th
                                                        style="vertical-align: middle">{{strval($year - 2)}}
                                                    </th>
                                                    <th class=""
                                                        style="vertical-align: middle">{{strval($year - 3)}}
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($faculty->plan as $item)

                                                    <tr class="nps-tr search-tr"
                                                        data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                        <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                            class="bold-border-imp">
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
                                                        {{-- Имя предмета и баллы--}}
                                                        @php $chable_true_ege = false; @endphp
                                                        @foreach($item->scores as $k => $score)
                                                            @if (!strpos($score->subject->name, 'достижение'))
                                                                @if($k == 0)
                                                                    @if(in_array($score, $item->changeable_subs))
                                                                        <td>
                                                                            @foreach($item->changeable_subs as $k1 => $chable)
                                                                                {{$chable->subject->name}}
                                                                                @if($k1 == 0)
                                                                                    /
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @foreach($item->changeable_subs as $k1 => $chable)
                                                                                {{$chable->minScore}}
                                                                                @if($k1 == 0)
                                                                                    /
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                        @php $chable_true_ege = true; @endphp
                                                                    @else
                                                                        <td> {{$score->subject->name}}</td>
                                                                        <td class="text-center">{{$score->minScore}}</td>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach

                                                        <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                            {{--                                                            style="border-bottom:2px solid #2366a5 !important;"--}}
                                                        >
                                                            @foreach($item->studyForm as $sf)
                                                                <span style="white-space: nowrap">{{$sf->name}}</span>
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                        <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp">
                                                            @foreach($item->studyForm as $sf)
                                                                @php
                                                                    $counter = 0;
                                                                    $id_comp = $sf->freeseats->first()->id_plan_comp;
                                                                @endphp

                                                                @foreach($sf->freeseats as $fs)
                                                                    @if($sf->freeseats->count() != 1)
                                                                        @if($fs->admissionBasis->short_name == 'БО' )
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if($fs->id_plan_comp == $id_comp)
                                                                                @if(!$fs->pastContests->contains('year', strval($year - 1)))
                                                                                    <span>-</span>
                                                                                    <br>
                                                                                @endif
                                                                                @foreach($fs->pastContests as $pc)
                                                                                    @if($pc->year === strval($year - 1))
                                                                                        <span>{{$pc->minScore}}</span>
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @php
                                                                            $counter++;
                                                                        @endphp
                                                                        @if(!$fs->pastContests->contains('year', strval($year - 1)))
                                                                            <span>-</span>
                                                                            <br>
                                                                        @endif
                                                                        @foreach($fs->pastContests as $pc)
                                                                            @if($pc->year === strval($year - 1))
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
                                                        <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp">
                                                            @foreach($item->studyForm as $sf)
                                                                @php
                                                                    $counter = 0;
                                                                        $id_comp = $sf->freeseats->first()->id_plan_comp;
                                                                @endphp
                                                                @foreach($sf->freeseats as $fs)
                                                                    @if($sf->freeseats->count() != 1)
                                                                        @if($fs->admissionBasis->short_name == 'БО')
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if($fs->id_plan_comp == $id_comp)
                                                                                @if(!$fs->pastContests->contains('year', strval($year - 2)))
                                                                                    <span>-</span>
                                                                                    <br>
                                                                                @endif
                                                                                @foreach($fs->pastContests as $pc)
                                                                                    @if($pc->year === strval($year - 2))
                                                                                        <span>{{$pc->minScore}}</span>
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @php
                                                                            $counter++;
                                                                        @endphp
                                                                        @if($fs->id_plan_comp == $id_comp)
                                                                            @if(!$fs->pastContests->contains('year', strval($year - 2)))
                                                                                <span>-</span>
                                                                                <br>
                                                                            @endif
                                                                            @foreach($fs->pastContests as $pc)
                                                                                @if($pc->year === strval($year - 2))
                                                                                    <span>{{$pc->minScore}}</span>
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                                @if(!$counter)
                                                                    <span>-</span>
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                            class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-right-imp">
                                                            @foreach($item->studyForm as $sf)
                                                                @php
                                                                    $counter = 0;
                                                                        $id_comp = $sf->freeseats->first()->id_plan_comp;
                                                                @endphp
                                                                @foreach($sf->freeseats as $fs)
                                                                    @if($sf->freeseats->count() != 1)
                                                                        @if($fs->admissionBasis->short_name == 'БО')
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if($fs->id_plan_comp == $id_comp)
                                                                                @if(!$fs->pastContests->contains('year', strval($year - 3)))
                                                                                    <span>-</span>
                                                                                    <br>
                                                                                @endif
                                                                                @foreach($fs->pastContests as $pc)
                                                                                    @if($pc->year === strval($year - 3))
                                                                                        <span>{{$pc->minScore}}</span>
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @php
                                                                            $counter++;
                                                                        @endphp
                                                                        @if(!$fs->pastContests->contains('year', strval($year - 3)))
                                                                            <span>-</span>
                                                                            <br>
                                                                        @endif
                                                                        @foreach($fs->pastContests as $pc)
                                                                            @if($pc->year === strval($year - 3))
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
                                                                @if(in_array($score, $item->changeable_subs))
                                                                    @if(!$chable_true_ege)
                                                                        {{--Если предмет на выбор но еще не был выведен--}}
                                                                        <tr class="nps-tr search-tr"
                                                                            data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                            @if($k == (count($item->scores) - 2))
                                                                                <td class="bold-border-imp">
                                                                            @else
                                                                                <td>
                                                                                    @endif
                                                                                    @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                        {{$chable->subject->name}}
                                                                                        @if($k1 == 0)
                                                                                            /
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                                @if($k == (count($item->scores) - 2))
                                                                                    <td class="text-center bold-border-imp">
                                                                                @else
                                                                                    <td class="text-center">
                                                                                        @endif

                                                                                        @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                            {{$chable->minScore}}
                                                                                            @if($k1 == 0)
                                                                                                /
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </td>
                                                                        </tr>
                                                                        @php $chable_true_ege = true; @endphp
                                                                    @endif{{--Если предмет на выбор но уже был выведен то ничего--}}
                                                                @else{{--Если предмет не на выбор--}}
                                                                <tr class="nps-tr search-tr"
                                                                    data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                    <td>{{$score->subject->name}}</td>
                                                                    <td class="text-center"> {{$score->minScore}}</td>
                                                                </tr>
                                                                @endif
                                                            @elseif ($k == (count($item->scores)-1))
                                                                @if(in_array($score, $item->changeable_subs))
                                                                    @if(!$chable_true_ege)
                                                                        {{--Если предмет на выбор но еще не был выведен--}}
                                                                        <tr class="nps-tr search-tr"
                                                                            data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                            <td class="bold-border-imp">
                                                                                @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                    {{$chable->subject->name}}
                                                                                    @if($k1 == 0)
                                                                                        /
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <td class="text-center bold-border-imp">
                                                                                @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                    {{$chable->minScore}}
                                                                                    @if($k1 == 0)
                                                                                        /
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                        </tr>
                                                                        @php $chable_true_ege = true; @endphp
                                                                    @endif{{--Если предмет на выбор но уже был выведен то ничего--}}
                                                                @else{{--Если предмет не на выбор--}}
                                                                <tr class="nps-tr search-tr"
                                                                    data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                    <td class="bold-border-imp">{{$score->subject->name}}</td>
                                                                    <td class="text-center bold-border-imp">{{$score->minScore}}</td>
                                                                </tr>
                                                                @endif

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
                            <div id="right-menu" class="col-12 col-xl-3 col-lg-12 col-sm-12">
                                <div class="right-menu-big">
                                    <h4 class="right-menu-title mb-3 text-xl-left text-lg-center text-md-center text-sm-center main-color text-md-center text-center">
                                        Мои ЕГЭ
                                    </h4>
                                    <div class="right-menu-checkbox-group row text-uppercase">
                                        @foreach($subjects as $subject)
                                                <div class="col-12 col-xl-12 col-lg-4 col-md-4 col-sm-4 checkbox-column">
                                                    <div class="form-group form-check check-subjects">
                                                        <input type="checkbox"
                                                               class="form-check-input right-menu-checkbox"
                                                               id="option{{ $loop->index }}"
                                                               onclick="addToChosenExams('{{ $subject->name }}')">
                                                        <label
                                                            class="form-check-label ml-2 underline-label right-menu-label "
                                                            for="option{{ $loop->index }}">{{ $subject->name }}</label>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="right-menu-small">
                                    <div class="right-menu-checkbox-group-down">
                                        <h4 class="right-menu-title mb-3 text-xl-left text-lg-center text-md-center text-sm-center main-color text-md-center text-center">
                                            Мои ЕГЭ
                                        </h4>
                                        <div class="right-menu-small-ege-collapse">
                                            @foreach($subjects as $subject)
                                                    <div class="col-12 d-flex justify-content-center align-item-center flex-column checkbox-column">
                                                        <div class="form-group form-check check-subjects">
                                                            <input type="checkbox"
                                                                   class="form-check-input right-menu-small-ege-checkbox"
                                                                   id="option{{ $loop->index }}s"
                                                                   onclick="addToChosenExams('{{ $subject->name }}')">
                                                            <label
                                                                class="form-check-label ml-2 underline-label right-menu-small-ege-label d-flex"
                                                                for="option{{ $loop->index }}s">{{ $subject->name }}</label>
                                                        </div>
                                                    </div>

                                            @endforeach
                                        </div>
                                    </div>
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
                                                            подготовки
                                                        </th>
                                                        <th width="20%" rowspan="3" style="vertical-align: middle">
                                                            Вступительные
                                                            испытания <br/> <span class="small-text-thead text-lowercase">(в приоритетном порядке)</span>
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
                                                            Статистика проходных баллов <br> <span class="small-text-thead text-lowercase">(бюджет, общий конкурс)</span>
                                                        </th>
                                                    </tr>
                                                    <tr class="d-lg-table-row d-xl-table-row d-md-table-row d-sm-table-row d-none">
                                                        <th
                                                            style="vertical-align: middle">{{strval($year - 1)}}
                                                        </th>
                                                        <th
                                                            style="vertical-align: middle">{{strval($year - 2)}}
                                                        </th>
                                                        <th class="bold-border-right-imp"
                                                            style="vertical-align: middle">{{strval($year - 3)}}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($faculty->plan as $item)
                                                        <tr class="nps-tr search-tr-by-faculties"
                                                            data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                            <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
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

                                                            {{-- Имя предмета и баллы--}}
                                                            @php $chable_true = false; @endphp
                                                            @foreach($item->scores as $k => $score)
                                                                @if (!strpos($score->subject->name, 'достижение'))
                                                                    @if($k == 0)
                                                                        @if(in_array($score, $item->changeable_subs))
                                                                            <td>
                                                                                @foreach($item->changeable_subs as $k1 => $chable)
                                                                                    {{$chable->subject->name}}
                                                                                    @if($k1 == 0)
                                                                                        /
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <td class="text-center">
                                                                                @foreach($item->changeable_subs as $k1 => $chable)
                                                                                    {{$chable->minScore}}
                                                                                    @if($k1 == 0)
                                                                                        /
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            @php $chable_true = true; @endphp
                                                                        @else
                                                                            <td> {{$score->subject->name}}</td>
                                                                            <td class="text-center">{{$score->minScore}}</td>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach

                                                            <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    <span style="white-space: nowrap"
                                                                          class="text-center">{{$sf->name}}</span>
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    @php
                                                                        $counter = 0;
                                                                        $id_comp = $sf->freeseats->first()->id_plan_comp;
                                                                    @endphp
                                                                    @foreach($sf->freeseats as $fs)
                                                                        @if($sf->freeseats->count() != 1)
                                                                            @if($fs->admissionBasis->short_name == 'БО')
                                                                                @php
                                                                                    $counter++;
                                                                                @endphp
                                                                                @if($fs->id_plan_comp == $id_comp)
                                                                                    @if(!$fs->pastContests->contains('year', strval($year - 1)))
                                                                                        <span>-</span>
                                                                                        <br>
                                                                                    @endif
                                                                                    @foreach($fs->pastContests as $pc)
                                                                                        @if($pc->year === strval($year - 1))
                                                                                            <span>{{$pc->minScore}}</span>
                                                                                            <br>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if($fs->id_plan_comp == $id_comp)
                                                                                @if(!$fs->pastContests->contains('year', strval($year - 1)))
                                                                                    <span>-</span>
                                                                                    <br>
                                                                                @endif
                                                                                @foreach($fs->pastContests as $pc)
                                                                                    @if($pc->year === strval($year - 1))
                                                                                        <span>{{$pc->minScore}}</span>
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                    @if(!$counter)
                                                                        <span>-</span>
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-imp"
                                                                {{--                                                                style="border-bottom:2px solid #2366a5 !important;"--}}
                                                            >
                                                                @foreach($item->studyForm as $sf)
                                                                    @php
                                                                        $counter = 0;
                                                                        $id_comp = $sf->freeseats->first()->id_plan_comp;
                                                                    @endphp
                                                                    @foreach($sf->freeseats as $fs)
                                                                        @if($sf->freeseats->count() != 1)
                                                                            @if($fs->admissionBasis->short_name == 'БО')
                                                                                @php
                                                                                    $counter++;
                                                                                @endphp
                                                                                @if($fs->id_plan_comp == $id_comp)
                                                                                    @if(!$fs->pastContests->contains('year', strval($year - 2)))
                                                                                        <span>-</span>
                                                                                        <br>
                                                                                    @endif
                                                                                    @foreach($fs->pastContests as $pc)
                                                                                        @if($pc->year === strval($year - 2))
                                                                                            <span>{{$pc->minScore}}</span>
                                                                                            <br>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if($fs->id_plan_comp == $id_comp)
                                                                                @if(!$fs->pastContests->contains('year', strval($year - 2)))
                                                                                    <span>-</span>
                                                                                    <br>
                                                                                @endif
                                                                                @foreach($fs->pastContests as $pc)
                                                                                    @if($pc->year === strval($year - 2))
                                                                                        <span>{{$pc->minScore}}</span>
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                    @if(!$counter)
                                                                        <span>-</span>
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="@if(count($item->changeable_subs)!=0){{count($item->scores)-1 }} @else {{count($item->scores)}} @endif"
                                                                class="text-center d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none bold-border-right-imp" >
                                                                @foreach($item->studyForm as $sf)
                                                                    @php
                                                                        $counter = 0;
                                                                        $id_comp = $sf->freeseats->first()->id_plan_comp;
                                                                    @endphp
                                                                    @foreach($sf->freeseats as $fs)

                                                                        @if($sf->freeseats->count() != 1)
                                                                            @if($fs->admissionBasis->short_name == 'БО')
                                                                                @php
                                                                                    $counter++;
                                                                                @endphp
                                                                                @if($fs->id_plan_comp == $id_comp)
                                                                                    @if(!$fs->pastContests->contains('year', strval($year - 3)))
                                                                                        <span>-</span>
                                                                                        <br>
                                                                                    @endif
                                                                                    @foreach($fs->pastContests as $pc)
                                                                                        @if($pc->year === strval($year - 3))
                                                                                            <span>{{$pc->minScore}}</span>
                                                                                            <br>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            @php
                                                                                $counter++;
                                                                            @endphp
                                                                            @if($fs->id_plan_comp == $id_comp)
                                                                                @if(!$fs->pastContests->contains('year', strval($year - 3)))
                                                                                    <span>-</span>
                                                                                    <br>
                                                                                @endif
                                                                                @foreach($fs->pastContests as $pc)
                                                                                    @if($pc->year === strval($year - 3))
                                                                                        <span>{{$pc->minScore}}</span>
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
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
                                                                    @if(in_array($score, $item->changeable_subs))
                                                                        @if(!$chable_true)
                                                                            {{--Если предмет на выбор но еще не был выведен--}}
                                                                            <tr class="nps-tr search-tr-by-facluties"
                                                                                data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                                @if($k == (count($item->scores) - 2))
                                                                                    <td class="bold-border-imp">
                                                                                @else
                                                                                    <td>
                                                                                        @endif
                                                                                        @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                            {{$chable->subject->name}}
                                                                                            @if($k1 == 0)
                                                                                                /
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </td>
                                                                                    @if($k == (count($item->scores) - 2))
                                                                                        <td class="text-center bold-border-imp">
                                                                                    @else
                                                                                        <td class="text-center">
                                                                                            @endif
                                                                                            @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                                {{$chable->minScore}}
                                                                                                @if($k1 == 0)
                                                                                                    /
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </td>
                                                                            </tr>
                                                                            @php $chable_true = true; @endphp
                                                                        @endif{{--Если предмет на выбор но уже был выведен то ничего--}}
                                                                    @else{{--Если предмет не на выбор--}}
                                                                    <tr class="nps-tr search-tr-by-facluties"
                                                                        data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                        <td>{{$score->subject->name}}</td>
                                                                        <td class="text-center"> {{$score->minScore}}</td>
                                                                    </tr>
                                                                    @endif
                                                                @elseif ($k == (count($item->scores) - 1))
                                                                    @if(in_array($score, $item->changeable_subs))
                                                                        @if(!$chable_true)
                                                                            {{--Если предмет на выбор но еще не был выведен--}}
                                                                            <tr class="nps-tr search-tr-by-facluties"
                                                                                data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                                <td class="bold-border-imp">
                                                                                    @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                        {{$chable->subject->name}}
                                                                                        @if($k1 == 0)
                                                                                            /
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                                <td class="text-center bold-border-imp">
                                                                                    @foreach ( $item->changeable_subs as $k1 => $chable)
                                                                                        {{$chable->minScore}}
                                                                                        @if($k1 == 0)
                                                                                            /
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                            </tr>
                                                                            @php $chable_true = true; @endphp
                                                                        @endif{{--Если предмет на выбор но уже был выведен то ничего--}}
                                                                    @else{{--Если предмет не на выбор--}}
                                                                    <tr class="nps-tr search-tr-by-facluties"
                                                                        data-exams="{{ implode(',', $item->subjects) }}" data-exams_ch="{{ implode(',', $item->subjects_ch) }}">
                                                                        <td class="bold-border-imp">{{$score->subject->name}}</td>
                                                                        <td class="text-center bold-border-imp">{{$score->minScore}}</td>
                                                                    </tr>
                                                                    @endif
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
                            <div id="right-menu" class="col-12 col-xl-3 col-lg-12 col-sm-12">
                                <div class="right-menu-big">
                                    <h4 class="right-menu-title text-xl-left text-lg-center text-md-center text-sm-center text-md-center main-color text-center">
                                        Факультеты и институты
                                    </h4>
                                    <div class="right-menu-checkbox-group row text-uppercase">
                                        @foreach($faculties as $faculty)
                                            @if(count($faculty->plan))
                                                <div
                                                    class="col-12 col-xl-12 col-lg-4 col-md-4 col-sm-4 checkbox-column">
                                                    <div class="form-group form-check check-faculties">
                                                        <input type="checkbox"
                                                               class="form-check-input right-menu-checkbox"
                                                               id="optionFaculties{{ $loop->index }}"
                                                               onclick="addToChosenFaculties('{{ $faculty->name }}')">
                                                        <label
                                                            class="form-check-label ml-2 underline-label right-menu-label d-flex"
                                                            for="optionFaculties{{ $loop->index }}">{{ $faculty->name }}</label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="right-menu-small">

                                    <div class="right-menu-checkbox-group-down">
                                        <div>
                                            <a class="btn btn-primary collapsed" data-toggle="collapse" href="#collapseExample"
                                               role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-angle-down rotate-icon"></i> Фильтр
                                            </a>
                                        </div>

                                        <div class="collapse right-menu-small-collapse" id="collapseExample">
                                            @foreach($faculties as $faculty)
                                                @if(count($faculty->plan))
                                                    <div class="col-12 d-flex justify-content-center align-item-center flex-column checkbox-column">
                                                        <div class="form-group form-check check-faculties">
                                                            <input type="checkbox"
                                                                   class="form-check-input right-menu-small-checkbox"
                                                                   id="optionFaculties{{ $loop->index }}s"
                                                                   onclick="addToChosenFaculties('{{ $faculty->name }}')">
                                                            <label
                                                                class="form-check-label ml-2 underline-label right-menu-small-label d-flex"
                                                                for="optionFaculties{{ $loop->index }}s">{{ $faculty->name }}</label>
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
                    let exams_ch = $(item).data("exams_ch").split(',');

                    // console.log(exams_ch)

                    if (exams.length <= chosenExams.length && chosenExams.length >= 2) {
                        let required = include(exams, chosenExams); //полное попадание

                        let changeable;
                        if (exams_ch.length > 1) {
                            changeable = include_ch(exams_ch, chosenExams); //хотя бы 1
                        }else{
                            changeable = true;
                        }
                        if (required && changeable) {
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
        function include_ch(exams, choosenExams) {
            let count = 0; //количество совпадений массивов
            $.each(exams, function (k, v) {
                $.inArray(v, choosenExams) !== -1 ? count += 1 : null;
            });
            return (count >= 1);
        }
        function include(exams, choosenExams) {
            let count = 0; //количество совпадений массивов
            $.each(exams, function (k, v) {
                $.inArray(v, choosenExams) !== -1 ? count += 1 : null;
            });
            return (count === exams.length);
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

        $('.right-menu-big').click(function () {
            if ($('.right-menu-checkbox').is(':checked')) {
                if ($('.right-menu-checkbox:checked').length === 1) {
                    console.log($('.right-menu-checkbox:checked').length)
                    $('body,html').animate({
                        scrollTop: 0
                    }, 400);
                }
                // $('#dropdownMenuLink').html("Выбранно "+chosenFaculties.length+" элемента");
            } else {
                // $('#dropdownMenuLink').html("Выбрать... ");
            }
        });
        $('.right-menu-small-label').click(function () {

            console.log( $('.right-menu-small-label').html())
                console.log('s1=' + $('body,html').scrollTop())
                    var s = $('body,html').scrollTop();
                    $('body,html').animate({
                        scrollTop: s
                    }, 100);
                console.log('s2=' + $('body,html').scrollTop())

        });
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
            // console.log(recipient.studyForm, sortedForms)

            $.each(sortedForms, (k, v) => {
                console.log(v.freeseats[0])
                let number = v.years.toString().slice(-1)
                let year = years[number];
                let templateRecipient =
                    "<div class=''>" +
                    "<div class='row d-flex justify-content-cetner'>" +
                    "<div class='col-12 d-flex align-items-center justify-content-center flex-column'>" +
                    "<h5><strong>" + v.name + " форма " + /*v.years + " " + year + */"</strong></h5>" +
                    "</div><div class='col-12 col-lg-6 col-xl-6 col-md-6 col-sm-12 mb-2'><h5 class='text-left ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3mb-0 '><strong>Количество мест:</strong></h5>"

                v.freeseats.sort((a, b) => (a.admissionBasis.name.length > b.admissionBasis.name.length) ? 1 : ((b.admissionBasis.name.length > a.admissionBasis.name.length) ? -1 : 0));

                let idplancoms = [];
                $.each(v.freeseats, (key, seat) => {
                    idplancoms.push(seat.id_plan_comp);
                });

                let id_comp = Math.min.apply(Math,idplancoms);
               //let id_comp = v.freeseats[0].id_plan_comp
                console.log('id_comp =' + id_comp);

                $.each(v.freeseats, (key, seat) => {
                    console.log(seat.id_plan_comp);
                    if (seat.id_plan_comp === id_comp) {
                        if(seat.organization){
                            templateRecipient += "<h5 class='text-left mb-0 mt-2 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3' style='font-weight: normal; font-size: 16px;'><strong>"+seat.organization+":</strong></h5>"
                        }
                        templateRecipient += "<p class='mb-0   ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3  text-left'><span>" + seat.admissionBasis.name + " - </span><b>" + seat.value + "</b></p>"
                        templateRecipient += "<hr class='mb-0  ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 mb-0 mt-1' style='border-color: #6696b7;'>"
                    }
                });

                let ccc = 0;
                $.each(v.freeseats, (key, seat) => {
                    console.log(seat.id_plan_comp);
                    if (seat.id_plan_comp != id_comp) {
                         if (ccc === 0) {
                            templateRecipient += "<h5 class='text-left mb-0 mt-2 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3' ><strong>Дополнительный прием:</strong></h5>"
                        }
                        ccc++;
                        templateRecipient += "<p class='mb-0 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 text-left'><span>" + seat.admissionBasis.name + " - </span><b>" + seat.value + "</b></p>"
                        templateRecipient += "<hr class='mb-0  ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 mb-0 mt-1' style='border-color: #6696b7;'>"
                    }
                });

                //templateRecipient += "</tbody></table></div></div>";
                templateRecipient += "</div>";
                templateRecipient += "<div class='col-12 col-lg-6 col-xl-6 col-md-6 col-sm-12 mb-2'>";
                templateRecipient += "<h5 class='text-left mb-0 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3'><strong>Cтоимость обучения:</strong></h5>"
                $.each(v.prices, (key, price) => {
                    if (price.price !== 0 && price.id_plan_comp === id_comp) {
                        templateRecipient += "<p class='mb-0 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 text-left'><span>" + price.info + " - </span><b>" + price.price + " ₽/год</b></p>"
                    }
                })

                if(v.prices.length === 0) {
                    templateRecipient += "<p class='mb-0 ml-lg-5 ml-xl-5 ml-md-5 ml-sm-3 ml-lg-0 ml-md-2 ml-3 text-left'><a class='text-white' style='text-decoration:underline;' href='{{url('/Bakalavriat-i-spetsialitet-2020-Stoimosti-obucheniya')}}'>Стоимость обучения за 2020 год</a></p>";
                }
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
        });

        $('#square').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
            return false;
        });


    </script>
@endsection
