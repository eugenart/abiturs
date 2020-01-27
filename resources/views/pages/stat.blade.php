@extends('pages.layout')
@section('style')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
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
        <form action="{{ route('stat.searchfio') }}" id="sendFormWithFacultets" method="POST">
            @csrf
            <div class="row">
                <select class="selectpicker form-control-sm col-3" multiple
                        title="Факультет / Институт" name="faculties[]" id="faculties">
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
                <div class="col-2">
                    <button class="w-100 btn btn-success btn-sm" id="submitInfo" type="submit">Поиск</button>
                </div>
                <div class="col-1">
                    <button class="w-100 btn btn-warning btn-sm" type="button" id="clearSelects">Сбросить</button>
                </div>
            </div>
        </form>
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
                                                                                        <p class="m-0 text-uppercase font-weight-bold">{{$faculty->name}}</p>
                                                                                        <p class="m-0 font-weight-bold">{{$speciality->name}}</p>
                                                                                        <p class="m-0">Кол-во бюджетных
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
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.9/js/i18n/defaults-ru_RU.min.js"></script>
    <script>
        $(document).ready(() => {
            faculties = {!! json_encode($faculties) !!};
            fillFaculties(faculties);
            fillSpecialitiesWithCheck(faculties)
        })

        function fillFaculties(faculties) {
            $.each(faculties, (k, faculty) => {
                $('#faculties').append('<option value="' + faculty.id + '">' + faculty.name + '</option>')
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
            $('#faculties, #specialities, #studyforms').selectpicker('refresh');
        }

        function makeFacultiesChecked(faculties, facultiesIds) {
            $.each(faculties, (k, faculty) => {
                if (facultiesIds.length > 0) {
                    $('#faculties').selectpicker('val', facultiesIds);
                }
            })
        }

        $('#faculties').change(() => {
            let facultiesIds = $('#faculties').val();
         //   console.log($('#faculties').val());
            $('#specialities').find('option').remove().find('optgroup').end();
            fillSpecialitiesWithCheck(faculties, facultiesIds.map(Number))
        })

        $('#specialities').change(() => {
            //console.log($('#specialities').val())
            let facultiesIds = []
            let specialitiesIds = []
            $.each($('#specialities').val(), (k, v) => {
                facultiesIds.push(v.split(';')[0])
                specialitiesIds.push(v.split(';')[1])
            })
            makeFacultiesChecked(faculties, facultiesIds.map(Number));
            //console.log($.unique(specialitiesIds.map(Number)))
            refreshInputs()
        })

        $('#clearSelects').click(() => {
            $('#faculties, #specialities').selectpicker('deselectAll');
        })
    </script>
@endsection
