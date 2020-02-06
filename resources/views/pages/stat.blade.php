@extends('pages.layout')
@section('style')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('page')
    @if(isset($studyForms))
        <div class="modal fade" id="QRCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img class="d-block m-auto"
                             src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{$actual_link}}&choe=UTF-8"/>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row bac-mag">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                {{--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">--}}
                {{--                    <span class="navbar-toggler-icon"></span>--}}
                {{--                </button>--}}
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link font-weight-bold" href="{{route('stat.index')}}"><b><i
                                            class="fas fa-university"></i>
                                        Бакалавриат и специалитет</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-graduation-cap"></i> Магистратура</a>
                            </li>
                        </ul>
                    </div>
                    <form class="form-inline" action="{{ route('stat.index') }}" method="get">
                        <input class="form-control mr-sm-2 form-control-sm" type="search" placeholder="Поиск по ФИО"
                               aria-label="Search" name="fio">
                        <button class="btn my-2 my-sm-0 btn-sm" type="submit">Поиск</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>
    @if(isset($studyForms))
        <div class="container">
            <div class="row m-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div class="m-0 p-0 h6"><a href="" class="underline-label main-color" data-toggle="modal"
                                               data-target="#QRCode">Получить
                            QR-код запроса</a></div>
                    <span
                        class="m-0 p-0 main-color">Дата последнего обновления инфорации: <b>20.02.2020 18:30</b></span>
                </div>
            </div>
        </div>
    @endif
    <div class="container-fluid p-5">
        <form action="{{ route('stat.index') }}" id="sendFormWithFacultets" method="get">
            <div class="row">
                <select class="selectpicker form-control-sm col-3" multiple
                        title="Факультет / Институт" name="faculties[]" id="allfaculties">
                </select>

                <select class="selectpicker form-control-sm col-3" data-live-search="true" multiple
                        title="Специальность"
                        name="specialities[]" id="specialities">
                </select>

                <select class="selectpicker form-control-sm col-2" multiple title="Форма обучения" name="studyforms[]"
                        id="studyforms">
                    @foreach ($studyFormsForInputs as $form)
                        <option value="{{$form->id}}">{{$form->name}}</option>
                    @endforeach
                </select>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <button class="w-100 btn btn-success btn-sm" id="submitInfo" type="submit">Поиск</button>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <button class="w-100 btn btn-warning btn-sm" type="button" id="clearSelects">Отменить выбор</button>
                </div>
            </div>
        </form>
        <div class="row mt-4">
            <div class="col-12">
                @if(isset($notification))
                    <div class="text-center m-4 h4">{{$notification}}</div>
                @endif
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
                                                                <div class="row mt-4 justify-content-start">
                                                                    <div class="col-8">
                                                                        <div class="exam-info-outer">
                                                                            <div class="col-6 float-left p-0">
                                                                                <div class="examInfo p-3">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <table>
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td>Форма обучения
                                                                                                    </td>
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
                                                                                                    <td>Уровень
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
                                                                            <div
                                                                                class="col-6 float-left p-0 d-flex align-items-stretch">
                                                                                <div class="examInfo-bottom pl-4">
                                                                                    <div
                                                                                        class="row d-flex align-items-center justify-content-center h-100">
                                                                                        <div class="col-12">
                                                                                            <p class="m-0 text-uppercase font-weight-bold">{{$faculty->name}}</p>
                                                                                            <p class="m-0 font-weight-bold">{{$speciality->name}}</p>
                                                                                            <p class="m-0">Кол-во
                                                                                                бюджетных
                                                                                                мест: <span
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

                                                                    <div class="col-4">
                                                                        <div class="font-weight-bold">
                                                                            Согласие:
                                                                        </div>
                                                                        <div><i class="fa fa-check-circle"
                                                                                style="color: rgba(0,128,0,0.51)"></i>
                                                                            &mdash; Первое согласие на зачисление
                                                                        </div>
                                                                        <div><i class="fa fa-check-circle"
                                                                                style="color: rgba(0,128,0,0.51)"></i>
                                                                            <i class="fa fa-check-circle"
                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                            &mdash; Второе согласие на зачисление
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                @if(isset($speciality->chosenStudents))
                                                                    <div>
                                                                        @foreach($speciality->chosenStudents as $chosenStudent)
                                                                            <div class="main-color h6">
                                                                                <span
                                                                                    class="font-weight-bold">{{$chosenStudent->fio}} </span>
                                                                                &mdash;
                                                                                <a class="main-color underline-label h6"
                                                                                   href="#stud-{{$chosenStudent->id}}-{{$speciality->id}}">конкурсное
                                                                                    место
                                                                                    <b>{{$chosenStudent->serialNum}}</b></a>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
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
                                                                                        <p class="m-0">{{$i + 2}} ) Балл
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
                                                                                    <td class="text-left"
                                                                                        id="stud-{{$abitur->student->id}}-{{$abitur->id_speciality}}">{{$abitur->student->fio}}</td>
                                                                                    <td>
                                                                                        @if($abitur->original)
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        @endif
                                                                                    </td>

                                                                                    {{--                                                                                                <i class="fa fa-times-circle"--}}
                                                                                    {{--                                                                                                   style="color: rgba(128,0,0,0.51)"></i>--}}


                                                                                    <td>
                                                                                        @if($abitur->accept)
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        @endif
                                                                                    </td>


                                                                                    @foreach($abitur->score as $ab_sc)
                                                                                        <td>{{$ab_sc->score}}</td>
                                                                                    @endforeach

                                                                                    <td>{{$abitur->indAchievement}}</td>
                                                                                    <td>{{$abitur->summ}}</td>
                                                                                    <td>{{$abitur->summContest}}</td>
                                                                                    <td>ЕГЭ</td>
                                                                                    <td>{{$abitur->notice1}}</td>

                                                                                    <td>@if($abitur->needHostel)
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        @endif
                                                                                    </td>
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

                @else
                    <div class="text-center m-4 h4">Введите <b>ФИО</b> или выберите <b>факультет/институт</b> для
                        получения
                        информации о статистике приема.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.9/js/i18n/defaults-ru_RU.min.js"></script>
    <script>
        $(document).ready(() => {
            $('#submitInfo').attr('disabled', true)
            faculties = {!! json_encode($faculties) !!};
            fillFaculties(faculties);
            fillSpecialitiesWithCheck(faculties)
        })

        function fillFaculties(faculties) {
            $.each(faculties, (k, faculty) => {
                $('#allfaculties').append('<option value="' + faculty.id + '">' + faculty.name + '</option>')
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
            $.each(faculties, (k, faculty) => {
                if (facultiesIds.length > 0) {
                    if ($.inArray(k + 1, facultiesIds) !== -1) {
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
@endsection
