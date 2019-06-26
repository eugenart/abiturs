@extends('pages.layout')

@section('page')
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
                <div class="col-2">
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
                            <th>Форма обучения</th>
                            <th>Проходной балл предыдущего года</th>
                            <th>Вступительные испытания в порядке приоритетности для ранжирования</th>
                            <th>Минимальные баллы</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($course->children as $child)
                            @if ( $child->subjects->count() == 1 )
                            <tr class="nps-tr search-tr" data-exams="{{ implode(', ', $child->exams) }}">
                                <td>{{ $child->name }}</td>
                                <td>{{ implode(', ', $child->studyForm) }}</td>
                                <td>{{ $child->score }}</td>
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
                                    <td rowspan={{ $child->subjects->count() }}>{{ implode(', ', $child->studyForm) }}</td>
                                    <td rowspan={{ $child->subjects->count() }}>{{ $child->score }}</td>
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
@endsection
@section('js')
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
@endsection
