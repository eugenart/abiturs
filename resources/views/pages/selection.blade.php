@extends('pages.layout')

@section('page')

    {{--  modal  --}}

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-2x"></i>
                </button>
                <div class="row w-100 m-0 p-0">
                    <div class="topline col-12">
                    </div>
                </div>
                <div class="modal-header">
                    <div class="row w-100 text-center pt-3 pb-3">
                        <div class="col-12"><h4 class="text-uppercase" id="facultyName">Институт механики и
                                энергетики</h4></div>
                        <div class="col-12"><h2><b id="directionName">Направление подготовки</b></h2></div>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-12">Вступительные испытания</div>
                        <div class="col-12" id="examsNames">биология, математика, русский язык</div>
                        <hr class="w-50 bg-white">
                        <div class="col-12" id="forms">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  end modal  --}}


    <div class="container-fluid p-5">
        <div class="row mt-2">
            <div class="col-12 col-sm-8 m-auto">
                <h2 class="text-center h1-mrsu">Подбор образовательных программ</h2>
                <h5 class="text-center h5-mrsu">Подберите направление подготовки по предметам ЕГЭ или из списка
                    направлений
                    подготовки и специальностей факультета или института
                </h5>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-12 p-0">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item swith-priem">
                        <a class="nav-link border-priem active text-uppercase btn btn-lg" id="pills-home-tab"
                           data-toggle="pill" href="#pills-home" role="tab"
                           aria-controls="pills-home" aria-selected="true">ПОДБОР ПО ПРЕДМЕТАМ ЕГЭ</a>
                    </li>
                    <li class="nav-item swith-priem">
                        <a class="nav-link border-priem text-uppercase btn btn-lg" id="pills-profile-tab"
                           data-toggle="pill"
                           href="#pills-profile" role="tab"
                           aria-controls="pills-profile" aria-selected="false">ПО ФАКУЛЬТЕТАМ И ИНСТИТУТАМ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                         aria-labelledby="pills-home-tab">
                        <div class="row mt-2 d-flex flex-xl-row flex-column-reverse flex-sm-column-reverse">
                            <div class="col-12 col-xl-9 col-sm-12">
                                @foreach($faculties as $faculty)
                                    @if(count($faculty->plan))
                                        <div class="col-12 mb-5 search-div"
                                             data-exams="{{ implode(',', $faculty->subjects) }}">
                                            <h3><a href="" target="_blank" class="main-color">{{$faculty->name}}</a>
                                            </h3>
                                            <table style="width: 100% !important;"
                                                   class="table table-sm table-scores w-100 table-b-border">
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
                                                    <th width="10%" rowspan="3" style="vertical-align: middle">
                                                        Минимальные
                                                        баллы
                                                    </th>
                                                    <th width="10%" rowspan="3" style="vertical-align: middle">Формы
                                                        обучения
                                                    </th>
                                                    <th colspan="4" width="20%">
                                                        Статистика проходных баллов <br> (бюджет, общий конкурс)
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th
                                                        style="vertical-align: middle">{{strval(date ( 'Y' ) - 1)}}
                                                    </th>
                                                    <th
                                                        style="vertical-align: middle">{{strval(date ( 'Y' ) - 2)}}
                                                    </th>
                                                    <th
                                                        style="vertical-align: middle">{{strval(date ( 'Y' ) - 3)}}
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($faculty->plan as $item)
                                                    <tr class="nps-tr search-tr"
                                                        data-exams="{{ implode(',', $item->subjects) }}">
                                                        <td rowspan="{{count($item->scores) }}"
                                                            style="border-bottom: 2px solid #2366a5 !important;">
                                                            <button style="white-space: normal;" type="button"
                                                                    class="btn btn-link text-left d-block w-100"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable"
                                                                    data-content="{{$item}}">
                                                                {{$item->speciality->code}}
                                                                <b>{{$item->speciality->name}}</b>
                                                                @if($item->specialization)
                                                                    - {{$item->specialization->name}}
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
                                                        <td rowspan="{{count($item->scores) }}" class="text-center"
                                                            style="border-bottom:2px solid #2366a5 !important;">
                                                            @foreach($item->studyForm as $sf)
                                                                <span>{{$sf->name}}</span>
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                        <td rowspan="{{count($item->scores)}}"
                                                            class="text-center"
                                                            style="border-bottom:2px solid #2366a5 !important;">
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
                                                            class="text-center"
                                                            style="border-bottom:2px solid #2366a5 !important;">
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
                                                            class="text-center"
                                                            style="border-bottom:2px solid #2366a5 !important;">
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
                                                                    <td style="border-bottom: 2px solid #2366a5 !important;">{{$score->subject->name}}</td>
                                                                    <td style="border-bottom: 2px solid #2366a5 !important;;"
                                                                        class="text-center">{{$score->minScore}}</td>
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
                            <div class="col-12 col-xl-3 col-sm-12">
                                <h4 class="mb-3">Мои вступительные испытания</h4>
                                <div class="row text-uppercase mb-5">
                                    @foreach($subjects as $subject)
                                        <div class="col-12 col-lg-12 col-sm-4">
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
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row mt-2 d-flex flex-xl-row flex-column-reverse flex-sm-column-reverse">
                            <div class="col-12 col-xl-9 col-sm-12">
                                <div class="row">
                                    @foreach($faculties as $faculty)
                                        @if(count($faculty->plan))
                                            <div class="col-12 mb-5 search-div-by-faculties"
                                                 data-faculty="{{ $faculty->name }}"
                                                 data-exams="{{ implode(',', $faculty->subjects) }}">
                                                <h3><a href="" style="color: #2366a5"
                                                       target="_blank">{{$faculty->name}}</a>
                                                </h3>
                                                <table class="table table-b-border table-sm table-scores w-100">
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
                                                        <th width="10%" rowspan="3" style="vertical-align: middle">
                                                            Минимальные
                                                            баллы
                                                        </th>
                                                        <th width="10%" rowspan="3" style="vertical-align: middle">Формы
                                                            обучения
                                                        </th>
                                                        <th colspan="4" width="20%">
                                                            Статистика проходных баллов <br> (бюджет, общий конкурс)
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th
                                                            style="vertical-align: middle">{{strval(date ( 'Y' ) - 1)}}
                                                        </th>
                                                        <th
                                                            style="vertical-align: middle">{{strval(date ( 'Y' ) - 2)}}
                                                        </th>
                                                        <th
                                                            style="vertical-align: middle">{{strval(date ( 'Y' ) - 3)}}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($faculty->plan as $item)
                                                        <tr class="nps-tr search-tr-by-faculties"
                                                            data-exams="{{ implode(',', $item->subjects) }}">
                                                            <td rowspan="{{count($item->scores)}}"
                                                                style="border-bottom: 2px solid #2366a5 !important;">
                                                                <button style="white-space: normal;" type="button"
                                                                        class="btn btn-link text-left w-100 d-block"
                                                                        data-toggle="modal"
                                                                        data-target="#exampleModalScrollable"
                                                                        data-content="{{$item}}">
                                                                    {{$item->speciality->code}}
                                                                    <b>{{$item->speciality->name}}</b>
                                                                    @if($item->specialization)
                                                                        - {{$item->specialization->name}}
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
                                                                class="text-center"
                                                                style="border-bottom:2px solid #2366a5 !important;">
                                                                @foreach($item->studyForm as $sf)
                                                                    <span style="white-space: nowrap" class="text-center">{{$sf->name}}</span>
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                            <td rowspan="{{count($item->scores)}}"
                                                                class="text-center"
                                                                style="border-bottom:2px solid #2366a5 !important;">
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
                                                                                    <span class="text-center">{{$pc->minScore}}</span>
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
                                                                class="text-center"
                                                                style="border-bottom:2px solid #2366a5 !important;">
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
                                                                                    <span class="text-center">{{$pc->minScore}}</span>
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
                                                                class="text-center"
                                                                style="border-bottom:2px solid #2366a5 !important;">
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
                                                                                    <span class="text-center">{{$pc->minScore}}</span>
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
                                                                        <td style="border-bottom: 2px solid #2366a5 !important;">{{$score->subject->name}}</td>
                                                                        <td style="border-bottom: 2px solid #2366a5 !important;;"
                                                                            class="text-center">{{$score->minScore}}</td>
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
                            <div class="col-12 col-xl-3 col-sm-12">
                                <h4 class="mb-3">Факультеты и институты</h4>
                                <div class="row text-uppercase mb-5">
                                    @foreach($faculties as $faculty)
                                        @if(count($faculty->plan))
                                            <div class="col-12 col-lg-12 col-sm-4">
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
                    if (exams.length <= chosenExams.length && chosenExams.length > 2) {
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
            var modal = $(this)
            console.log(recipient)
            modal.find('#facultyName').empty().text(recipient.faculty)
            modal.find('#directionName').empty().text(recipient.speciality.name + (recipient.specialization !== null ? ' (' + recipient.specialization.name + ')' : ''))
            let names = ''
            $.each(recipient.subjects, function (k, v) {
                if (k === recipient.subjects.length - 1) {
                    names += v
                } else {
                    names += v + ', '
                }
            });
            modal.find('table').empty()
            modal.find('#examsNames').empty().text(names)

            modal.find('#forms').empty()
            $.each(recipient.studyForm, (k, v) => {
                let number = v.years.toString().slice(-1)
                let year = years[number];
                let templateRecipient =
                    "<div class='row'>" +
                    "<div class='col-12'>" +
                    "<h4><strong>" + v.name + "</strong></h4>" +
                    "<h5><strong>Количество лет обучения: " + v.years + " " + year + "</strong></h5>"
                "<h5><strong>Количество мест - </strong></h5>" +
                "</div>" +
                "<div class='col-12'>" //+
                //"<table class='teble table-borderless table-sm'><tbody>";

                $.each(v.freeseats, (key, seat) => {
                    //templateRecipient += "<tr><td>" + seat.admissionBasis.name + "</td><td>" + seat.value + "</td></tr>"
                    templateRecipient += "<p class='text-center'><span>" + seat.admissionBasis.name + " - </span><b>" + seat.value + "</b></p>"
                });

                //templateRecipient += "</tbody></table></div></div>";
                templateRecipient += "</div>";
                templateRecipient += "<div class='col-12'>";
                templateRecipient += "<h5><strong>Цена за обучение:</strong></h5>"
                $.each(v.prices, (key, price) => {
                    templateRecipient += "<p class='text-center'><span>" + price.info + " - </span><b>" + price.price + "₽</b></p>"
                })
                templateRecipient += "<hr class='w-50 bg-white' /></div></div>";

                modal.find('#forms').append(templateRecipient)
            })
            //

            //template.format(recipient.intramural.name, recipient.intramural.year, recipient.intramural.budget, recipient.intramural.price)
            // modal.find('.modal-body input').val(recipient)
        })

    </script>
@endsection
