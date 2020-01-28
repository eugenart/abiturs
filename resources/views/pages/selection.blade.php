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
                        <div class="col-12 mt-3">
                            <table class="table table-sm w-100 ">
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  end modal  --}}


    <div class="container-fluid p-5">
        <div class="row mt-5">
            <div class="col-12 col-sm-8 m-auto">
                <h1 class="text-center h1-mrsu">Подбор образовательных программ</h1>
                <h5 class="text-center h5-mrsu">Подберите направление подготовки по предметам ЕГЭ или из списка
                    направлений
                    подготовки и специальностей факультета или института
                </h5>
            </div>
        </div>


        <div class="row mt-5">
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

        <div class="col-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row mt-5 d-flex flex-column-reverse flex-sm-row">
                        <div class="col-12 col-sm-9">
                            <div class="row">
                                @foreach($faculties as $faculty)
                                    @if(count($faculty->tArea))
                                        <div class="col-12 mb-5 search-div"
                                             data-exams="{{ implode(',', $faculty->subjects) }}">
                                            <h3><a href="" target="_blank" class="main-color">{{$faculty->name}}</a></h3>
                                            <table class="table table-sm table-scores">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Направление подготовки</th>
                                                    {{--                                                    <th width="10%">Форма обучения</th>--}}
                                                    {{--                            <th>Проходной балл предыдущего года</th>--}}
                                                    <th width="50%">Вступительные испытания в порядке приоритетности для
                                                        ранжирования
                                                    </th>
                                                    <th width="10%">Минимальные баллы</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($faculty->tArea as $item)
                                                    <tr class="nps-tr search-tr"
                                                        data-exams="{{ implode(',', $item->subjects) }}">
                                                        <td rowspan="{{count($item->area->scores)}}">
                                                            <button type="button" class="btn btn-link"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable"
                                                                    data-content="{{$item->area}}">
                                                                <b>{{$item->area->sp_name->name}}</b>
                                                            </button>

                                                        </td>
                                                        {{--                                                        <td rowspan="{{count($item->area->scores)}}">{{$item->area->trainingForm}}</td>--}}
                                                    </tr>
                                                    @foreach($item->area->scores as $score)
                                                        @if (!strpos($score->subject->name, 'достижение'))
                                                            <tr class="nps-tr search-tr"
                                                                data-exams="{{ implode(',', $item->subjects) }}">
                                                                <td>{{$score->subject->name}}</td>
                                                                <td>{{$score->minScore}}</td>
                                                            </tr>
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
                        <div class="col-12 col-sm-3">
                            <h4 class="mb-3">Мои ступительные испытания</h4>
                            <div class="row text-uppercase mb-5">
                                @foreach($subjects as $subject)
                                    <div class="col-6 col-sm-12">
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
                    <div class="row mt-5 d-flex flex-column-reverse flex-sm-row">
                        <div class="col-12 col-sm-9">
                            <div class="row">
                                @foreach($faculties as $faculty)
                                    @if(count($faculty->tArea))
                                        <div class="col-12 mb-5 search-div-by-faculties"
                                             data-faculty="{{ $faculty->name }}"
                                             data-exams="{{ implode(',', $faculty->subjects) }}">
                                            <h3><a href="" style="color: #2366a5" target="_blank">{{$faculty->name}}</a></h3>
                                            <table class="table table-sm table-scores">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Направление подготовки</th>
                                                    {{--                                                    <th width="10%">Форма обучения</th>--}}
                                                    {{--                            <th>Проходной балл предыдущего года</th>--}}
                                                    <th width="40%">Вступительные испытания в порядке приоритетности для
                                                        ранжирования
                                                    </th>
                                                    <th width="10%">Минимальные баллы</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($faculty->tArea as $item)
                                                    <tr class="nps-tr search-tr-by-faculties"
                                                        data-exams="{{ implode(',', $item->subjects) }}">
                                                        <td rowspan="{{count($item->area->scores)}}">
                                                            <button type="button" class="btn btn-link"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable"
                                                                    data-content="{{$item->area}}">
                                                                <b>{{$item->area->sp_name->name}}</b>
                                                            </button>
                                                        </td>
                                                        {{--                                                        <td rowspan="{{count($item->area->scores)}}">{{$item->area->trainingForm}}</td>--}}
                                                    </tr>
                                                    @foreach($item->area->scores as $score)
                                                        @if (!strpos($score->subject->name, 'достижение'))
                                                            <tr class="nps-tr search-tr-by-faculties"
                                                                data-exams="{{ implode(',', $item->subjects) }}">
                                                                <td>{{$score->subject->name}}</td>
                                                                <td>{{$score->minScore}}</td>
                                                            </tr>
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
                        <div class="col-12 col-sm-3">
                            <h4 class="mb-3">Факультеты и институты</h4>
                            <div class="row text-uppercase mb-5">
                                @foreach($faculties as $faculty)
                                    @if(count($faculty->tArea))
                                        <div class="col-12">
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
            modal.find('#directionName').empty().text(recipient.sp_name.name)
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
            let number = recipient.years.toString().slice(-1)
            let year = years[number];
            let templateRecipient = "<tr id=\"intramural\">\n" +
                "                                <td>\n" +
                "                                    <strong>" + recipient.studyForm.name + "</strong>\n" +
                "                                    <br>\n" +
                "                                    <span>" + recipient.years + " " + year + " обучения</span>\n" +
                "                                </td>\n" +
                "                                <td>\n" +
                "                                    <strong>" + recipient.freeSeatsNumber + "</strong>\n" +
                "                                    <br>\n" +
                "                                    <span>бюджетных мест</span>\n" +
                "                                </td>\n" +
                "                                <td>\n" +
                "                                    <strong>" + (recipient.price / recipient.years).toFixed(0) + "</strong>\n" +
                "                                    <br>\n" +
                "                                    <span>рублей в год</span>\n" +
                "                                </td>\n" +
                "                            </tr>";
            modal.find('table').append(templateRecipient)


            if (recipient.partTime) {
                let number = recipient.partTime.year.toString().slice(-1)
                let year = years[number]
                let templatePartTime = "<tr id=\"partTime\">\n" +
                    "                                <td>\n" +
                    "                                    <strong>" + recipient.partTime.name + "</strong>\n" +
                    "                                    <br>\n" +
                    "                                    <span>" + recipient.partTime.year + " " + year + " обучения</span>\n" +
                    "                                </td>\n" +
                    "                                <td>\n" +
                    "                                    <strong>" + recipient.partTime.budget + "</strong>\n" +
                    "                                    <br>\n" +
                    "                                    <span>бюджетных мест</span>\n" +
                    "                                </td>\n" +
                    "                                <td>\n" +
                    "                                    <strong>" + $.number(recipient.partTime.price, 0, '', ' ') + "</strong>\n" +
                    "                                    <br>\n" +
                    "                                    <span>рублей в год</span>\n" +
                    "                                </td>\n" +
                    "                            </tr>";
                modal.find('table').append(templatePartTime)
            }

            if (recipient.correspondence) {
                let number = recipient.correspondence.year.toString().slice(-1)
                let year = years[number]
                let templateCorrespondece = "<tr id=\"templateCorrespondece\">\n" +
                    "                                <td>\n" +
                    "                                    <strong>" + recipient.correspondence.name + "</strong>\n" +
                    "                                    <br>\n" +
                    "                                    <span>" + recipient.correspondence.year + " " + year + " обучения</span>\n" +
                    "                                </td>\n" +
                    "                                <td>\n" +
                    "                                    <strong>" + recipient.correspondence.budget + "</strong>\n" +
                    "                                    <br>\n" +
                    "                                    <span>бюджетных мест</span>\n" +
                    "                                </td>\n" +
                    "                                <td>\n" +
                    "                                    <strong>" + $.number(recipient.correspondence.price, 0, '', ' ') + "</strong>\n" +
                    "                                    <br>\n" +
                    "                                    <span>рублей в год</span>\n" +
                    "                                </td>\n" +
                    "                            </tr>";
                modal.find('table').append(templateCorrespondece)
            }

            //template.format(recipient.intramural.name, recipient.intramural.year, recipient.intramural.budget, recipient.intramural.price)
            // modal.find('.modal-body input').val(recipient)
        })

    </script>
@endsection
