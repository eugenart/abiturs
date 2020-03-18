@extends('pages.layout')
@section('page')
    <div id="square">
        <i class="fa fa-arrow-up"></i>
    </div>
    {{--    @if(isset($studyForms))--}}
    {{--        <div class="modal fade" id="QRCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
    {{--             aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                            <span aria-hidden="true">&times;</span>--}}
    {{--                        </button>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-body">--}}
    {{--                        <img class="d-block m-auto"--}}
    {{--                             src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{$actual_link}}&choe=UTF-8"/>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endif--}}
    @if(isset($studyForms))
        <div class="container">
            <div class="row m-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    {{--                    <div class="m-0 p-0 h6 d-lg-block d-none"><a href="" class="underline-label main-color" data-toggle="modal"--}}
                    {{--                                               data-target="#QRCode">Получить--}}
                    {{--                            QR-код запроса</a>--}}
                    <div class="m-0 p-0 h6 d-lg-block d-none">
                        @if (isset($studyForms))
                            <img class="d-block m-auto" style="width: 100px; height: auto"
                                 src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{$actual_link}}&choe=UTF-8"/>
                        @endif
                    </div>
                    <span
                        class="m-0 p-0 main-color w-100 text-center">Дата последнего обновления: <b>20.02.2020 18:30</b></span>
                </div>
            </div>
        </div>
    @endif
    <div class="container pt-0 padding-0 mt-4">

        <form action="{{ route('statasp.index') }}" id="sendFormWithFacultets" method="get">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <select style="font-size: 16px !important;"
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
                            <button class="w-100 btn btn-warning btn-sm" type="button" id="clearSelects">Отменить
                                выбор
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2 mb-2">
                    <div class="row">
                        <div class="col-md-10 col-9">
                            <input class="form-control form-control-sm" type="search" placeholder="Поиск по ФИО"
                                   aria-label="Search" name="fio">
                        </div>
                        <div class="col-md-2 col-3">
                            <button class="btn btn-sm btn-primary d-block w-100 mrsu-bg-button" type="submit"><i
                                    class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid pt-0 padding-0 mb-5 mt-xl-3">
        <div class="row">
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
                                                                <div class="row mt-1 justify-content-start">
                                                                    <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                                                        <div
                                                                            class="exam-info-outer w-100 d-lg-flex flex-lg-row d-sm-flex flex-sm-column d-flex flex-column">
                                                                            <div
                                                                                class="col-xl-6 col-lg-6 col-12 float-left p-0">
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
                                                                                class="exam-info-bottom col-xl-6 col-lg-6 col-12 float-left p-0 d-flex align-items-stretch">
                                                                                <div class="examInfo-bottom pl-4">
                                                                                    <div
                                                                                        class="row d-flex align-items-center justify-content-center h-100">
                                                                                        <div class="col-12">
                                                                                            <p class="m-0 text-uppercase font-weight-bold">{{$faculty->name}}</p>
                                                                                            <p class="m-0 font-weight-bold">{{$speciality->name}}</p>
                                                                                            <p class="m-0">Кол-во
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
                                                                    <div
                                                                        class="col-xl-4 col-lg-12 col-md-12 col-12 mb-lg-4 mb-lg-2">
                                                                        <div
                                                                            class="font-weight-bold d-xl-block d-lg-none d-none">
                                                                            Согласие:
                                                                        </div>
                                                                        <div class="d-xl-block d-lg-none d-none"><i
                                                                                class="fa fa-check-circle "
                                                                                style="color: rgba(0,128,0,0.51)"></i>
                                                                            &mdash; Первое согласие на зачисление
                                                                        </div>
                                                                        <div class="d-xl-block d-lg-none d-none"><i
                                                                                class="fa fa-check-circle"
                                                                                style="color: rgba(0,128,0,0.51)"></i>
                                                                            <i class="fa fa-check-circle"
                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                            &mdash; Второе согласие на зачисление
                                                                        </div>
                                                                        <div
                                                                            class="d-xl-none d-lg-flex d-md-flex d-sm-flex flex-column">
                                                                            <span class="d-inline-block w-100"><b>Легенда:</b></span>
                                                                            <span class="d-inline-block w-100"><b>О</b> - оригинал диплома</span>
                                                                            <span class="d-inline-block w-100"><b>C</b> - согласие на зачисление:</span>
                                                                            <ol class="d-inline-block w-100 mb-0 list-unstyled pl-2">
                                                                                <li><span><i class="fa fa-check-circle "
                                                                                             style="color: rgba(0,128,0,0.51)"></i>
                                                                            - первое согласие</span>
                                                                                </li>
                                                                                <li><span><i class="fa fa-check-circle"
                                                                                             style="color: rgba(0,128,0,0.51)"></i>
                                                                            <i class="fa fa-check-circle"
                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                            - второе согласие</span>
                                                                                </li>
                                                                            </ol>
                                                                            <span
                                                                                class="d-inline-block w-100"><b>БИД</b> - балл за индивидуальные достижения</span>
                                                                            <span
                                                                                class="d-inline-block w-100"><b>СКБ</b> - сумма конкурсных баллов</span>

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
                                                                        class="table table-bordered table-sm base-exams-table mt-xl-2 mt-0">
                                                                        <thead style="background-color: #e9eff6">
                                                                        <tr style="vertical-align: center">
                                                                            <th rowspan="2" class="text-center">№</th>
                                                                            <th rowspan="2" class="text-center">
                                                                                <span
                                                                                    class="d-xl-table-cell d-lg-none d-none">Фамилия,
                                                                                имя, отчество</span>
                                                                                <span
                                                                                    class="d-xl-none d-lg-table-cell d-lg-table-cell">ФИО</span>
                                                                            </th>
                                                                            <th rowspan="2" class="text-center">
                                                                                <span
                                                                                    class="d-xl-inline d-lg-none d-none">Оригинал</span>
                                                                                <span
                                                                                    class="d-xl-none d-lg-inline d-inline">O</span>
                                                                            </th>
                                                                            <th rowspan="2" class="text-center">
                                                                                <span
                                                                                    class="d-xl-inline d-lg-none d-none">Согласие</span>
                                                                                <span
                                                                                    class="d-xl-none d-lg-inline d-inline">С</span>
                                                                            </th>
                                                                            <th class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none"
                                                                                colspan="{{count($speciality->abiturs->first()->score) + 1}}">
                                                                                @foreach($speciality->abiturs->first()->score as $i => $sc)
                                                                                    @if($i < count($speciality->abiturs->first()->score) -1)
                                                                                        <p class="m-0"> {{$sc->priority}}
                                                                                            ) {{$sc->subject->name}}</p>
                                                                                    @else
                                                                                        <p class="m-0"> {{$sc->priority}}
                                                                                            ) {{$sc->subject->name}}</p>
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
                                                                            <th class="text-center" rowspan="2">
                                                                                <span
                                                                                    class="d-xl-inline d-lg-none d-none">Сумма<br/>
                                                                                конкурсных<br/> баллов</span>
                                                                                <span
                                                                                    class="d-xl-none d-lg-inline d-inline">СКБ</span>
                                                                            </th>
                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                rowspan="2">Тип
                                                                                экзамена
                                                                            </th>
                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                rowspan="2">Статус
                                                                                проверки
                                                                            </th>
                                                                            <th class="text-center d-xl-table-cell d-lg-none d-none"
                                                                                rowspan="2">
                                                                                Нуждаемость <br> в
                                                                                общежитии
                                                                            </th>
                                                                        </tr>
                                                                        <tr class="text-center d-lg-table-row d-xl-table-row d-md-table-row d-sm-table-row d-none">
                                                                            @foreach($speciality->abiturs->first()->score as $i => $sc)
                                                                                @if($i < count($speciality->abiturs->first()->score) -1)
                                                                                    <th>{{$sc->priority}}</th>
                                                                                @else
                                                                                    <th>{{$sc->priority}}</th>
                                                                                    <th>{{$i + 2}}</th>
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
                                                                                    <td>
                                                                                        @if($abitur->accept)
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        @endif
                                                                                    </td>
                                                                                    @foreach($abitur->score as $ab_sc)
                                                                                        <td class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">{{$ab_sc->score}}</td>
                                                                                    @endforeach
                                                                                    <td class="d-lg-table-cell d-xl-table-cell d-md-table-cell d-sm-table-cell d-none">{{$abitur->indAchievement}}</td>
                                                                                    <td class="d-xl-table-cell d-lg-none d-none">{{$abitur->summ}}</td>
                                                                                    <td>{{$abitur->summContest}}</td>
                                                                                    <td class="d-xl-table-cell d-lg-none d-none">
                                                                                        ЕГЭ
                                                                                    </td>
                                                                                    <td class="d-xl-table-cell d-lg-none d-none">{{$abitur->notice1}}</td>
                                                                                    <td class="d-xl-table-cell d-lg-none d-none">
                                                                                        @if($abitur->needHostel)
                                                                                            <i class="fa fa-check-circle"
                                                                                               style="color: rgba(0,128,0,0.51)"></i>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                @if($abitur->yellowline)
                                                                                    <tr  style="background-color: yellow;">
                                                                                        <td colspan="100%"></td>
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

                @else
                    <div class="text-center m-4 h4">Введите <b>ФИО</b> или выберите <b>факультет/институт</b> для
                        получения
                        информации о статистике приема
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')

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
            faculties.sort((prev, next) => {
                if (prev.name < next.name) return -1;
                if (prev.name < next.name) return 1;
            });
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
