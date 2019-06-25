<template>
    <div>
        <div class="row">
            <div class="col-12">
                <b-form @submit.prevent="addFaculty()">
                    <div class="card">
                        <div class="card-header">
                            <p class="m-0">Добавление / редактирование факультета / института</p>
                        </div>
                        <div class="card-body">
                            <b-form-group
                                label="Название факультета / института:">
                                <b-form-input
                                    type="text"
                                    required
                                    v-model="faculty.name"
                                    placeholder="Введите название">
                                </b-form-input>
                            </b-form-group>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <b-button type="submit" squared variant="outline-success" class="col-12"
                                    >
                                        Добавить
                                    </b-button>
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </b-form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a v-for="(f,i) in faculties" :key="i"
                               class="mb-3 list-group-item list-group-item-action d-block" :id="'list-course-list'+i"
                               data-toggle="list" :href="'#list-course'+i" role="tab"
                               :aria-controls="'course'+i">
                                <div class="row">
                                    <div class="col-8">
                                        <p v-if="!f.isEdit">{{f.name}}</p>
                                        <b-form-input
                                            v-if="f.isEdit"
                                            type="text"
                                            required
                                            class="h-100"
                                            v-model="f.name"
                                            :placeholder="'Введите название'">
                                        </b-form-input>
                                    </div>
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <b-button v-if="!f.isEdit" squared variant="warning"
                                                  class="col-12"
                                                  @click="editFaculty(f)">
                                            <i class="fas fa-pen"></i>
                                        </b-button>
                                        <b-button v-else squared variant="warning"
                                                  class="col-12"
                                                  @click="changeFaculty(f);">
                                            <i class="fas fa-check"></i>
                                        </b-button>
                                    </div>
                                    <div class="col-2 d-flex align-items-center justify-content-center ">
                                        <b-button squared variant="danger" class="col-12"
                                                  @click="deleteFaculty(f.id)">
                                            <i class="fas fa-trash"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade"
                                 v-for="(f,i) in faculties" :key="i"
                                 :id="'list-course' + i"
                                 role="tabpanel"
                                 :aria-labelledby="'list-course-list' + i">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span class="badge">Название направления</span>
                                                        <b-form-group>
                                                            <b-form-input
                                                                type="text"
                                                                required
                                                                class="mb-2"
                                                                v-model="course.name"
                                                                placeholder="">
                                                            </b-form-input>
                                                        </b-form-group>
                                                    </div>
                                                    <div class="col-2">
                                                        <span class="badge">Формы обучения</span>
                                                        <b-form-group>
                                                            <b-form-checkbox-group
                                                                class="w-100"
                                                                v-model="course.studyForm"
                                                                :options="forms"
                                                                stacked
                                                            ></b-form-checkbox-group>
                                                        </b-form-group>
                                                    </div>
                                                    <div class="col-2">
                                                        <span class="badge">Проходной балл</span>
                                                        <b-form-input
                                                            type="text"
                                                            required
                                                            class="mb-2"
                                                            v-model="course.score"
                                                            placeholder="">
                                                        </b-form-input>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <span class="badge">&nbsp;</span>
                                                                        <b-button class="m-auto d-block"
                                                                                  variant="outline-success"
                                                                                  @click="addCourse(f.id)"><i
                                                                            class="fas fa-check"></i>
                                                                        </b-button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="">
                                                <div v-for="(c,i) in f.courses">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p v-if="!c.isEdit">{{c.name}}</p>
                                                                    <b-form-input
                                                                        v-if="c.isEdit"
                                                                        type="text"
                                                                        required
                                                                        class="mb-2"
                                                                        v-model="c.name"
                                                                        :placeholder="'Введите название'">
                                                                    </b-form-input>
                                                                </div>
                                                                <div class="col-2">
                                                                    <p class="mb-0" v-if="!c.isEdit"
                                                                       v-for="sf in c.studyForm">
                                                                        {{sf}}</p>
                                                                    <b-form-group v-if="c.isEdit">
                                                                        <b-form-checkbox-group
                                                                            v-model="c.studyForm"
                                                                            :options="forms"
                                                                            stacked
                                                                        ></b-form-checkbox-group>
                                                                    </b-form-group>
                                                                </div>
                                                                <div class="col-2">
                                                                    <p v-if="!c.isEdit">{{c.score}}</p>
                                                                    <b-form-input
                                                                        v-if="c.isEdit"
                                                                        type="text"
                                                                        required
                                                                        class="mb-2"
                                                                        v-model="c.score"
                                                                        :placeholder="'Проходной балл'">
                                                                    </b-form-input>
                                                                </div>
                                                                <div class="col-2">
                                                                    <i v-if="c.isEdit" style="cursor:pointer;"
                                                                       class="fas fa-check"
                                                                       @click="changeCourse(c)"></i>

                                                                    <i v-if="!c.isEdit" style="cursor:pointer;"
                                                                       class="fas fa-pen"
                                                                       @click="editCourse(c)"></i>
                                                                    <i style="cursor:pointer; color:red;"
                                                                       class="fas fa-trash"
                                                                       @click="deleteCourse(c.id)"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "faculties",
        data() {
            return {
                faculty: {
                    name: null,
                    id: null,
                    isEdit: false,
                    courses: []
                },
                faculties: [],
                course: {
                    name: null,
                    id: null,
                    isEdit: false,
                    score: null,
                    studyForm: []

                },

                forms: [
                    {text: "Очная", value: 'Очная'},
                    {text: "Очно-заочная", value: 'Очно-заочная'},
                    {text: "Заочная", value: 'Заочная'}
                ],

                currentFaculty: {
                    name: null,
                    id: null,
                    courses: []
                },
                currentCourse: {
                    name: null,
                    id: null,
                    isEdit: false,
                    score: null,
                    studyForm: []
                }

            }
        },
        mounted() {
            this.fetchFaculty()
        },
        computed: {},
        methods: {

            changeFaculty(f) {
                axios.post('/course/' + f.id, {
                    name: f.name
                });
                this.fetchFaculty()
                this.clearCurrentFaculty()
            },

            editFaculty(f) {
                f.isEdit = !f.isEdit
            },

            addFaculty() {
                axios.post('/course', {
                    name: this.faculty.name,
                    parent_id: null
                });
                this.clearCurrentFaculty();
                this.fetchFaculty()
            },

            changeCourse(c) {
                axios.post('/course/' + c.id, {
                    name: c.name,
                    studyForm: c.studyForm,
                    score: c.score,
                });
                console.log(c)
                this.clearCurrentCourse();
                this.fetchFaculty()
            },

            editCourse(c) {
                console.log('asdasdasdas')
                c.isEdit = !c.isEdit
            },

            deleteFaculty(id) {
                axios.delete('/course/' + id)
                this.fetchFaculty()
            },

            addCourse(id) {
                axios.post('/course', {
                    name: this.course.name,
                    parent_id: id,
                    studyForm: this.course.studyForm,
                    score: this.course.score,
                });
                this.fetchFaculty()
                this.clearCurrentCourse()
            },

            deleteCourse(id) {
                axios.delete('/course/' + id)
                this.fetchFaculty()
            },

            clearCurrentCourse() {
                this.course = {...this.currentCourse}
            },

            clearCurrentFaculty() {
                this.faculty = {...this.currentFaculty}
            },

            fetchFaculty() {
                let data = axios.get('/course')
                    .then(response => (this.faculties = response.data))
            }
        }
    }
</script>

<style scoped>
    .list-group-item.list-group-item-action.d-block.active {
        background-color: #eaeaea;
        border-color: #eaeaea;
        color: black;
    }
</style>
