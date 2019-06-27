<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="badge">Факультет / институт</label>
                                <select type="text" class="form-control form-control-sm" v-model="chosenFaculty"
                                        @change="setNewFaculty()">
                                    <option v-for="(f,i) in faculties" :value="f">
                                        {{f.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="badge">Направление подготовки</label>
                                <select v-if="chosenFaculty" v-model="chosenCourse" type="text"
                                        class="form-control form-control-sm"
                                        @change="setNewCourse()">
                                    <option v-for="(c,i) in chosenFaculty.courses" :value="c">
                                        {{c.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="badge">Направление подготовки</label>
                                <multiselect class="w-100" v-if="chosenCourse.name" multiple v-model="chosenSubject"
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
                                        <td><input type="text" v-model="s.score"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-sm btn-success" @click="saveExams()">Сохранить</button>
                                <button class="btn btn-sm btn-warning" @click="clearAfterSave()">Очистить форму</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col-12" v-for="f in faculties">
                <div class="card">
                    <div class="card-header">
                        <h4>{{f.name}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th>Направление подготовки</th>
                                <th>Формы обучения</th>
                                <th>Проходной балл 2018</th>
                                <th>Вступительные испытания
                                    в порядке приоритетности для ранжирования
                                </th>
                                <th>Минимальный балл</th>
                            </tr>
                            </thead>
                            <tbody v-for="c in f.courses" v-if="f.courses">
                            <tr style="border-top: 2px solid black;">
                                <td :rowspan="c.subjects.length ? c.subjects.length : 1">{{c.name}} <i
                                    class="fa fa-pencil"
                                    style="cursor:pointer;"
                                    @click="editExams(c,f)"></i>
                                </td>
                                <td :rowspan="c.subjects.length ? c.subjects.length : 1"><p class="mb-0"
                                                                                            v-for="sf in c.studyForm">
                                    {{sf}}</p></td>
                                <td :rowspan="c.subjects.length ? c.subjects.length : 1">{{c.score}}</td>
                                <td v-if="c.subjects[0]">{{c.subjects[0].name}}</td>
                                <td v-else>-</td>
                                <td v-if="c.subjects[0]">{{c.subjects[0].score}}</td>
                                <td v-else>-</td>
                            </tr>
                            <tr v-for="(e,i) in c.subjects" v-if="i>0">
                                <td v-if="e.name">{{e.name}}</td>
                                <td v-else>-</td>
                                <td v-if="e.score">{{e.score}}</td>
                                <td v-else>-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                    id: null
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

            setNewCourse() {
                this.chosenSubject = this.chosenCourse.subjects
            },

            setNewFaculty() {
                this.chosenCourse = {
                    name: null,
                    id: null
                };
                this.chosenSubject = []
            },

            editExams(c, f) {
                this.chosenFaculty = f;
                this.chosenCourse = c;
                this.chosenSubject = c.subjects
                $('body,html').animate({
                    scrollTop: 0
                }, 400);
            },

            saveExams() {
                axios.post('/subject', {
                    chosenCourse: this.chosenCourse.id,
                    exams: this.chosenSubject
                });
                this.clearAfterSave()
                this.fetchFaculty()
                this.fetchForms()
            },

            setSubject() {
                console.log(this.chosenSubject)
            },

            fetchFaculty() {
                let data = axios.get('/course')
                    .then(response => (this.faculties = response.data))
            },
            fetchForms() {
                let data = axios.get('/subject-list')
                    .then(response => (this.subjects = response.data))
            },
            chooseFaculty(f) {
                this.chosenFaculty = f
            },

            clearAfterSave() {
                this.chosenFaculty = null;
                this.chosenCourse = {
                    name: null,
                    id: null
                };
                this.chosenSubject = []
            }

        }
    }
</script>

<style scoped>

</style>
