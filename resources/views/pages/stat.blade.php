@extends('pages.layout')

@section('page')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-3"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Факультет / Институт</option>
                </select></div>
            <div class="col-3"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Специальность</option>
                </select></div>
            <div class="col-2"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Внебюджет</option>
                </select></div>
            <div class="col-2"><select class="w-100 form-control form-control-sm">
                    <option value="-1">Форма обучения</option>
                </select></div>
            <div class="col-2">
                <button class="w-100 btn btn-warning btn-sm">Сбросить</button>
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
                        <td rowspan="2">Статус</td>
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
                        <td class="exam-rights" colspan="11">
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
                        <td>0</td>
                        <td>ЕГЭ</td>
                        <td>Оригинал на другом направлении</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
