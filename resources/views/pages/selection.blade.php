@extends('pages.layout')

@section('page')
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="text-center">Подбор образовательных программ</h1>
            <h5 class="text-center">Подберите направление подготовки по предметам ЕГЭ
            </h5>
        </div>
    </div>
    <div class="row mt-5 text-uppercase">
        <div class="col-4">
            <div class="inputGroup" id="inputGroup1">
                <input id="option1" name="option1" type="checkbox" onclick="addToChosenExams('Русский язык')"/>
                <label for="option1">Русский язык</label>
            </div>
        </div>
        <div class="col-4">
            <div class="inputGroup">
                <input id="option2" name="option2" type="checkbox"/>
                <label for="option2">Математика</label>
            </div>
        </div>
        <div class="col-4">
            <div class="inputGroup">
                <input id="option3" name="option3" type="checkbox"/>
                <label for="option3">Физика</label>
            </div>
        </div>
        <div class="col-4">
            <div class="inputGroup">
                <input id="option4" name="option4" type="checkbox"/>
                <label for="option4">Биология</label>
            </div>
        </div>
        <div class="col-4">
            <div class="inputGroup">
                <input id="option5" name="option5" type="checkbox"/>
                <label for="option5">Обществознание</label>
            </div>
        </div>
        <div class="col-4">
            <div class="inputGroup">
                <input id="option6" name="option6" type="checkbox"/>
                <label for="option6">История</label>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 mb-5">
            <h3>ИФХ</h3>
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
                <tr>
                    <td rowspan="3">Прикладная математика и информатика</td>
                    <td rowspan="3">Очная, заочная</td>
                    <td rowspan="3">246</td>
                    <td>
                        Математика
                    </td>
                    <td>
                        23
                    </td>
                </tr>
                <tr>
                    <td>Физика</td>
                    <td>34</td>
                </tr>
                <tr>
                    <td>Русский язык</td>
                    <td>34</td>
                </tr>
                </tbody>
            </table>
            <hr>
        </div>
        <div class="col-12 mb-5">
            <h3>ИФХ</h3>
            <table class="table">
                <tbody>
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
                <tr>
                    <td rowspan="3">Прикладная математика и информатика</td>
                    <td rowspan="3">Очная, заочная</td>
                    <td rowspan="3">246</td>
                    <td>
                        Математика
                    </td>
                    <td>
                        23
                    </td>
                </tr>
                <tr>
                    <td>Физика</td>
                    <td>34</td>
                </tr>
                <tr>
                    <td>Русский язык</td>
                    <td>34</td>
                </tr>
                </tbody>
            </table>
            <hr>
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
            console.log(chosenExams)
        }
    </script>
@endsection
