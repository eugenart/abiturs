@extends('pages.layout')

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
                    <form class="form-inline">
                        <input class="form-control mr-sm-2 form-control-sm" type="search" placeholder="Поиск по ФИО"
                               aria-label="Search">
                        <button class="btn my-2 my-sm-0 btn-sm" type="submit">Поиск</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-3"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Факультет / Институт</option>
                    <option value="1">1</option>
                </select></div>
            <div class="col-3"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Специальность</option>
                    <option value="1">1</option>
                </select></div>
            <div class="col-2"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Внебюджет</option>
                    <option value="1">1</option>
                </select></div>
            <div class="col-2"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Форма обучения</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-1">
                <button class="w-100 btn btn-success btn-sm" id="submitInfo">Поиск</button>
            </div>
            <div class="col-1">
                <button class="w-100 btn btn-warning btn-sm" id="clearSelects">Сбросить</button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="examInfo p-3">
                    <div class="row">
                        <div class="col-8">
                            <p><u>Количество бюджетных мест</u>: <b>35</b></p>
                            <p><u>Конкурс</u>: <b>0.2</b> человек/место</p>
                            <p class="m-0"><u>Время последнего обновления</u>: <b>2019-06-26 10:01:01</b></p>
                        </div>
                        <div class="col-4">
                            <a href="http://qrcoder.ru" target="_blank"><img
                                    src="http://qrcoder.ru/code/?https%3A%2F%2Fvk.com%2Feug_art&4&0" width="132"
                                    height="132" border="0" title="QR код"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-bordered table-sm base-exams-table">
                    <thead>
                    <tr style="vertical-align: center">
                        <td rowspan="2">№</td>
                        <td rowspan="2">Фамилия, имя, отчество</td>
                        <td rowspan="2">Оригинал</td>
                        <td rowspan="2">Согласие</td>
                        <td rowspan="2">Общий балл</td>
                        <td colspan="4">
                            <p class="m-0">1) Химия</p>
                            <p class="m-0">2) Математика (профильная)</p>
                            <p class="m-0">3) Русский язык</p>
                            <p class="m-0">4) Балл за индивидуальные достижения</p>
                        </td>
                        <td rowspan="2">Тип экзамена</td>
                        <td rowspan="2">Статус проверки</td>
                        <td rowspan="2">Нуждаемость в общежитии</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="exam-rights" colspan="14">
                            <b>Квота (особое право)</b>. Количество мест: <b>4</b>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td class="text-center">1</td>
                        <td>Арташкин Евгений Павлович</td>
                        <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>
                        <td><i class="fa fa-times-circle" style="color: rgba(128,0,0,0.51)"></i></td>
                        <td>240</td>
                        <td>80</td>
                        <td>80</td>
                        <td>80</td>
                        <td>0</td>
                        <td>ЕГЭ</td>
                        <td>Заявление принято</td>
                        <td>Да</td>
                    </tr>
                    <tr class="text-center">
                        <td class="text-center">2</td>
                        <td>Кулягина Таисия Ивановна</td>
                        <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>
                        <td><i class="fa fa-check-circle" style="color: rgba(0,128,0,0.51)"></i></td>
                        <td>239</td>
                        <td>81</td>
                        <td>80</td>
                        <td>78</td>
                        <td>30</td>
                        <td>ЕГЭ</td>
                        <td>Заявление принято</td>
                        <td>Нет</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#clearSelects').click(function () {
            $('select').val('-1');
        })
    </script>
@endsection
