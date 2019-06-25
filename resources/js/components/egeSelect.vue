<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="badge">Факультет / институт</label>
                                <select type="text" class="form-control form-control-sm" v-model="chosenFaculty">
                                    <option v-for="(f,i) in faculties" :value="f">
                                        {{f.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="badge">Направление подготовки</label>
                                <select v-if="chosenFaculty" v-model="chosenCourse.name" type="text"
                                        class="form-control form-control-sm">
                                    <option v-for="(c,i) in chosenFaculty.courses" :value="c.name">
                                        {{c.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="badge">Направление подготовки</label>
                                <b-form-group>
                                    <b-form-checkbox-group
                                        v-model="chosenCourse.studyForm"
                                        :options="forms"
                                    ></b-form-checkbox-group>
                                </b-form-group>
                                <multiselect class="col-12" v-if="chosenCourse.name" multiple v-model="chosenSubject"
                                             track-by="name" label="name" placeholder="Выберите предметы"
                                             :options="subjects"
                                             :searchable="true" :allow-empty="true" @select="setSubject">
                                </multiselect>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-sm table-bordered" v-if="chosenSubject">
                                    <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Минимальный балл</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="s in chosenSubject">
                                        <td>{{s.name}}</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-sm btn-success">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h4>Аграрный институт</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Направление подготовки</th>
                        <th>Формы обучения</th>
                        <th>Проходной балл 2018</th>
                        <th>Вступительные испытания
                            в порядке приоритетности для ранжирования
                        </th>
                        <th>Минимальный балл</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-top: 2px solid black;">
                        <td rowspan="3">Агрономия</td>
                        <td rowspan="3">Очная, заочная</td>
                        <td rowspan="3">250</td>
                        <td>Математика</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td>Русский</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>Китайский</td>
                        <td>01</td>
                    </tr>
                    <tr style="border-top: 2px solid black;">
                        <td rowspan="4">Ветеринария</td>
                        <td rowspan="4">Очная</td>
                        <td rowspan="4">150</td>
                        <td>Математика</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td>Русский</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>Китайский</td>
                        <td>01</td>
                    </tr>
                    <tr>
                        <td>Биология</td>
                        <td>25</td>
                    </tr>
                    <tr style="border-top: 2px solid black;">
                        <td rowspan="3">Агрономия</td>
                        <td rowspan="3">Очная, заочная</td>
                        <td rowspan="3">250</td>
                        <td>Математика</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td>Русский</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>Китайский</td>
                        <td>01</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "egeSelect",
        data() {
            return {
                faculties: [],
                chosenFaculty: null,
                chosenCourse: {
                    name: null,
                    studyForm: []
                },
                exams: [],
                forms: [
                    {text: "Очная", value: '1'},
                    {text: "Очно-заочная", value: '2'},
                    {text: "Заочная", value: '3'}
                ],

                subjects: [],
                chosenSubject: []
            }
        },

        mounted() {
            this.fetchFaculty()
            this.fetchForms()
        },

        methods: {

            setSubject() {
                console.log(this.chosenSubject)
            },

            fetchFaculty() {
                let data = axios.get('/course')
                    .then(response => (this.faculties = response.data))
            },
            fetchForms() {
                let data = axios.get('/subject')
                    .then(response => (this.subjects = response.data))
            },
            chooseFaculty(f) {
                this.chosenFaculty = f
            }

        }
    }
</script>

<style scoped>

</style>
