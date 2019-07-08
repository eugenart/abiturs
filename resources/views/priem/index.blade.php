<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
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
                    <div class="col-12"><h4>Институт механики и энергетики</h4></div>
                    <div class="col-12"><h2><b>Направление подготовки</b></h2></div>
                </div>
            </div>
            <div class="modal-body text-center">
                <div class="row">
                    <div class="col-12">Вступительные испытания</div>
                    <div class="col-12">биология, математика, русский язык</div>
                    <hr class="w-50 bg-white">
                    <div class="col-12 mt-3">
                        <table class="table table-sm w-100 ">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>Очная</strong>
                                    <br>
                                    <span>4 года обучения</span>
                                </td>
                                <td>
                                    <strong>99</strong>
                                    <br>
                                    <span>бюджетных мест</span>
                                </td>
                                <td>
                                    <strong>137 000</strong>
                                    <br>
                                    <span>рублей в год</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Очно-заочная</strong>
                                    <br>
                                    <span>2 года обучения</span>
                                </td>
                                <td>
                                    <strong>45</strong>
                                    <br>
                                    <span>бюджетных мест</span>
                                </td>
                                <td>
                                    <strong>56 000</strong>
                                    <br>
                                    <span>рублей в год</span>
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

<div class="container">
    <div class="row header p-3">
        <div class="col-6">
            <img src="storage/images/logo_mrsu.png" class="mrsu-logo-img" alt="">
        </div>
        <div class="col-6 justify-content-end d-flex align-items-center p-0">
            <img src="storage/images/icon_eng.gif" class="mr-3" width="20" height="13" alt="">
            <img src="storage/images/eye.png" class="mr-2" width="22" height="13" alt="">
            <button class="navbar-toggler d-lg-none d-md-block" type="button" data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</div>
<hr class="mrsu-hr mrsu-bg m-auto">

<div class="container-fluid p-5">
    <div class="row mt-5">
        <div class="col-8 m-auto">
            <h1 class="text-center">Подбор образовательных программ</h1>
            <h5 class="text-center">Подберите направление подготовки по предметам ЕГЭ или из списка направлений
                подготовки и специальностей факультета или института
            </h5>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item swith-priem">
                    <a class="nav-link border-priem active text-uppercase btn btn-lg" id="pills-home-tab"
                       data-toggle="pill" href="#pills-home" role="tab"
                       aria-controls="pills-home" aria-selected="true">ПОДБОР ПО ПРЕДМЕТАМ ЕГЭ</a>
                </li>
                <li class="nav-item swith-priem">
                    <a class="nav-link border-priem text-uppercase btn btn-lg" id="pills-profile-tab" data-toggle="pill"
                       href="#pills-profile" role="tab"
                       aria-controls="pills-profile" aria-selected="false">ПО ФАКУЛЬТЕТАМ И ИНСТИТУТАМ</a>
                </li>
            </ul>
        </div>
        <div class="col-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row mt-5">
                        <div class="col-9">
                            <div class="row">
                                @foreach($courses as $course)
                                    <div class="col-12 mb-5 search-div"
                                         data-exams="{{ implode(', ', $course->exams) }}">
                                        <h3 class="text-uppercase mb-3 mt-5 course-name">{{ $course->name }}</h3>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Направление подготовки</th>
                                                <th>Вступительные испытания в порядке приоритетности для ранжирования
                                                </th>
                                                <th>Минимальные баллы</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($course->children as $child)
                                                @if ( $child->subjects->count() == 1 )
                                                    <tr class="nps-tr search-tr"
                                                        data-exams="{{ implode(', ', $child->exams) }}">
                                                        <td>
                                                            <button type="button" class="btn btn-link"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable"
                                                                    data-content="{{ $child }}">
                                                                {{ $child->name }}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->subjectsList->name }}
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->score }}
                                                        </td>
                                                    </tr>
                                                @elseif($child->subjects->count() > 1)
                                                    <tr class="nps-tr search-tr"
                                                        data-exams="{{ implode(', ', $child->exams) }}">
                                                        <td rowspan={{ $child->subjects->count() }}>
                                                            <button type="button" class="btn btn-link"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable">
                                                                {{ $child->name }}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->subjectsList->name }}
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->score }}
                                                        </td>
                                                    </tr>
                                                    @foreach($child->subjects as $subject)
                                                        @if ($loop->first) @continue @endif
                                                        <tr class="search-tr"
                                                            data-exams="{{ implode(', ', $child->exams) }}">
                                                            <td>{{ $subject->subjectsList->name }}</td>
                                                            <td>{{ $subject->score }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="col-3">
                            <h4 class="mb-3">Вступительные испытания</h4>
                            @foreach($subjects as $subject)
                                <div class="row text-uppercase">
                                    <div class="col-12">
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="option{{ $loop->index }}"
                                                   onclick="addToChosenExams('{{ $subject->name }}')">
                                            <label class="form-check-label ml-2 underline-label"
                                                   for="option{{ $loop->index }}">{{ $subject->name }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row mt-5">
                        <div class="col-9">
                            <div class="row">
                                @foreach($courses as $course)
                                    <div class="col-12 mb-5 search-div-by-faculties"
                                         data-faculty="{{ $course->name }}">
                                        <h3 class="text-uppercase mb-3 mt-5 course-name">{{ $course->name }}</h3>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Направление подготовки</th>
                                                <th>Вступительные испытания в порядке приоритетности для ранжирования
                                                </th>
                                                <th>Минимальные баллы</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($course->children as $child)
                                                @if ( $child->subjects->count() == 1 )
                                                    <tr class="nps-tr search-tr-by-faculties"
                                                        data-exams="{{ implode(', ', $child->exams) }}">
                                                        <td>
                                                            <button type="button" class="btn btn-link"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable">
                                                                {{ $child->name }}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->subjectsList->name }}
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->score }}
                                                        </td>
                                                    </tr>
                                                @elseif($child->subjects->count() > 1)
                                                    <tr class="nps-tr search-tr-by-faculties"
                                                        data-exams="{{ implode(', ', $child->exams) }}">
                                                        <td rowspan={{ $child->subjects->count() }}>
                                                            <button type="button" class="btn btn-link"
                                                                    data-toggle="modal"
                                                                    data-target="#exampleModalScrollable"
                                                                    data-content="{{ $child }}">
                                                                {{ $child->name }}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->subjectsList->name }}
                                                        </td>
                                                        <td>
                                                            {{ $child->subjects->first()->score }}
                                                        </td>
                                                    </tr>
                                                    @foreach($child->subjects as $subject)
                                                        @if ($loop->first) @continue @endif
                                                        <tr class="search-tr-by-faculties"
                                                            data-exams="{{ implode(', ', $child->exams) }}">
                                                            <td>{{ $subject->subjectsList->name }}</td>
                                                            <td>{{ $subject->score }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-3">
                            <h4 class="mb-3">Вступительные испытания</h4>
                            @foreach($courses->where('parent_id', null) as $course)
                                <div class="row text-uppercase">
                                    <div class="col-12">
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="optionFaculties{{ $loop->index }}"
                                                   onclick="addToChosenFaculties('{{ $course->name }}')">
                                            <label class="form-check-label ml-2 underline-label"
                                                   for="optionFaculties{{ $loop->index }}">{{ $course->name }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<hr class="mrsu-hr mrsu-bg m-auto">
<div class="container">
    <div class="row">
        <div class="text-right col-12">
            <span class="copy-right">&copy; 2019 <b>Made by <a href="https://ci.mrsu.ru" target="_blank">CI</a></b></span>
        </div>
    </div>
</div>
</body>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>

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
                let exams = $(item).data("exams").split(', ');
                if (exams.length <= chosenExams.length) {
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

        console.log(recipient);
        // var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })

</script>
</html>
