<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
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
        <div class="col-12">
            <h1 class="text-center">Подбор образовательных программ</h1>
            <h5 class="text-center">Подберите направление подготовки по предметам ЕГЭ
            </h5>
        </div>
    </div>
    <div class="row mt-5 text-uppercase">
        @foreach($subjects as $subject)
            <div class="col-3">
                <div class="inputGroup">
                    <input id="option{{ $loop->index }}" type="checkbox" onclick="addToChosenExams('{{ $subject->name }}')"/>
                    <label for="option{{ $loop->index }}">{{ $subject->name }}</label>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row mt-5">


        @foreach($courses as $course)
            <div class="col-12 mb-5 search-div" data-exams="{{ implode(', ', $course->exams) }}">
                <h3 class="text-uppercase mt-5">{{ $course->name }}</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Направление подготовки</th>
                        <th>Вступительные испытания в порядке приоритетности для ранжирования</th>
                        <th>Минимальные баллы</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($course->children as $child)
                        @if ( $child->subjects->count() == 1 )
                            <tr class="nps-tr search-tr" data-exams="{{ implode(', ', $child->exams) }}">
                                <td>{{ $child->name }}</td>
                                <td>
                                    {{ $child->subjects->first()->subjectsList->name }}
                                </td>
                                <td>
                                    {{ $child->subjects->first()->score }}
                                </td>
                            </tr>
                        @elseif($child->subjects->count() > 1)
                            <tr class="nps-tr search-tr" data-exams="{{ implode(', ', $child->exams) }}">
                                <td rowspan={{ $child->subjects->count() }}>{{ $child->name }}</td>
                                <td>
                                    {{ $child->subjects->first()->subjectsList->name }}
                                </td>
                                <td>
                                    {{ $child->subjects->first()->score }}
                                </td>
                            </tr>
                            @foreach($child->subjects as $subject)
                                @if ($loop->first) @continue @endif
                                <tr class="search-tr" data-exams="{{ implode(', ', $child->exams) }}">
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

<hr class="mrsu-hr mrsu-bg m-auto">

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script>
    var chosenExams = [];

    $(document).ready(function () {
        console.log(chosenExams)
    });

    function addToChosenExams(exam) {
        let idx = chosenExams.indexOf(exam);
        if (idx !== -1) {
            chosenExams.splice(idx, 1)
        } else {
            chosenExams.push(exam)
        }
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




        // let searchTr = $('.search-tr');
        // $.each(searchTr, function (index, item) {
        //     let exams = $(item).data("exams").split(', ');
        //     if (exams.length <= chosenExams.length) {
        //         if (include(exams, chosenExams)) {
        //             $(item).closest('.search-div').show()
        //             $(item).show()
        //         } else {
        //             $(item).hide()
        //         }
        //         // $.each($(item).find('.search-tr'), function (k,v) {
        //         //     let trExams = $(v).data("exams").split(', ');
        //         //     if (trExams.length <= chosenExams.length) {
        //         //         include(trExams, chosenExams, trExams.length) ? $(v).show() : $(v).hide()
        //         //     } else {
        //         //         $(v).hide()
        //         //     }
        //         // })
        //     } else {
        //         $(item).hide()
        //     }
        // })
    }

    function include(array1, array2) {
        let count = 0;
        $.each(array1, function (k, v) {
            $.inArray(v, array2) !== -1 ? count +=1 : null;
        });
        return (count === array1.length);
    }
</script>
</html>
