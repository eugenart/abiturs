<template>
    <div>
        <div class="row mt-4">
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
        <!--        <div class="row mt-4">-->
        <!--            <div class="col-12">-->
        <!--                <div class="row">-->
        <!--                    <div class="col-12">-->
        <!--                        <div class="card">-->
        <!--                            <div class="card-body">-->
        <!--                                <div class="row">-->
        <!--                                    <div class="col-6">-->
        <!--                                        <div class="list-group" id="list-tab" role="tablist">-->
        <!--                                            <a v-for="(f,i) in faculties" :key="i"-->
        <!--                                               class="mb-3 list-group-item list-group-item-action d-block"-->
        <!--                                               :id="'list-course-list'+i"-->
        <!--                                               data-toggle="list" :href="'#list-course'+i" role="tab"-->
        <!--                                               :aria-controls="'course'+i">-->
        <!--                                                <div class="row">-->
        <!--                                                    <div class="col-8">-->
        <!--                                                        <p v-if="!f.isEdit">{{f.name}}</p>-->
        <!--                                                        <b-form-input-->
        <!--                                                            v-if="f.isEdit"-->
        <!--                                                            type="text"-->
        <!--                                                            required-->
        <!--                                                            class="h-100"-->
        <!--                                                            v-model="f.name"-->
        <!--                                                            :placeholder="'Введите название'">-->
        <!--                                                        </b-form-input>-->
        <!--                                                    </div>-->
        <!--                                                    <div class="col-2 d-flex align-items-center justify-content-center">-->
        <!--                                                        <b-button v-if="!f.isEdit" squared variant="warning"-->
        <!--                                                                  class="col-12"-->
        <!--                                                                  @click="editFaculty(f)">-->
        <!--                                                            <i class="fas fa-pen"></i>-->
        <!--                                                        </b-button>-->
        <!--                                                        <b-button v-else squared variant="warning"-->
        <!--                                                                  class="col-12"-->
        <!--                                                                  @click="changeFaculty(f);">-->
        <!--                                                            <i class="fas fa-check"></i>-->
        <!--                                                        </b-button>-->
        <!--                                                    </div>-->
        <!--                                                    <div-->
        <!--                                                        class="col-2 d-flex align-items-center justify-content-center ">-->
        <!--                                                        <b-button squared variant="danger" class="col-12"-->
        <!--                                                                  @click="deleteFaculty(f.id)">-->
        <!--                                                            <i class="fas fa-trash"></i>-->
        <!--                                                        </b-button>-->
        <!--                                                    </div>-->
        <!--                                                </div>-->
        <!--                                            </a>-->
        <!--                                        </div>-->
        <!--                                    </div>-->
        <!--                                    <div class="col-6">-->
        <!--                                        <div class="tab-content" id="nav-tabContent">-->
        <!--                                            <div class="tab-pane fade"-->
        <!--                                                 v-for="(f,i) in faculties" :key="i"-->
        <!--                                                 :id="'list-course' + i"-->
        <!--                                                 role="tabpanel"-->
        <!--                                                 :aria-labelledby="'list-course-list' + i">-->
        <!--                                                <div class="row">-->
        <!--                                                    <div class="col-12">-->
        <!--                                                        <div class="card mb-3">-->
        <!--                                                            <div class="card-body">-->
        <!--                                                                <div class="row">-->
        <!--                                                                    <div class="col-10">-->
        <!--                                                                        <span class="badge">Название направления</span>-->
        <!--                                                                        <b-form-group>-->
        <!--                                                                            <b-form-input-->
        <!--                                                                                type="text"-->
        <!--                                                                                required-->
        <!--                                                                                class="mb-2"-->
        <!--                                                                                v-model="course.name"-->
        <!--                                                                                placeholder="">-->
        <!--                                                                            </b-form-input>-->
        <!--                                                                        </b-form-group>-->
        <!--                                                                    </div>-->
        <!--                                                                    &lt;!&ndash;                                                                    <div class="col-4">&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                        <span class="badge">Проходной балл</span>&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                        <b-form-input&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                            type="text"&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                            required&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                            class="mb-2"&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                            v-model="course.score"&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                            placeholder="">&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                        </b-form-input>&ndash;&gt;-->
        <!--                                                                    &lt;!&ndash;                                                                    </div>&ndash;&gt;-->
        <!--                                                                    <div class="col-2">-->
        <!--                                                                        <div class="row">-->
        <!--                                                                            <div class="col-12">-->
        <!--                                                                                <div class="row">-->
        <!--                                                                                    <div class="col-6">-->
        <!--                                                                                        <span-->
        <!--                                                                                            class="badge">&nbsp;</span>-->
        <!--                                                                                        <b-button class="m-auto d-block"-->
        <!--                                                                                                  variant="outline-success"-->
        <!--                                                                                                  @click="addCourse(f.id)">-->
        <!--                                                                                            <i-->
        <!--                                                                                                class="fas fa-check"></i>-->
        <!--                                                                                        </b-button>-->
        <!--                                                                                    </div>-->
        <!--                                                                                </div>-->
        <!--                                                                            </div>-->
        <!--                                                                        </div>-->
        <!--                                                                    </div>-->
        <!--                                                                </div>-->
        <!--                                                                &lt;!&ndash;                                                                <div class="row">&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                    <div class="col-12">&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                        <span class="badge">Формы обучения</span>&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                        <b-form-group>&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                            <b-form-checkbox-group&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                                class="w-100"&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                                v-model="course.studyForm"&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                                :options="forms"&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                            ></b-form-checkbox-group>&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                        </b-form-group>&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                    </div>&ndash;&gt;-->
        <!--                                                                &lt;!&ndash;                                                                </div>&ndash;&gt;-->
        <!--                                                            </div>-->
        <!--                                                        </div>-->
        <!--                                                        <div class="card">-->
        <!--                                                            <div class="card-body">-->
        <!--                                                                <div v-for="(c,i) in f.courses">-->
        <!--                                                                    <div class="row">-->
        <!--                                                                        <div class="col-12">-->
        <!--                                                                            <div class="row">-->
        <!--                                                                                <div class="col-10">-->
        <!--                                                                                    <p v-if="!c.isEdit">{{c.name}}</p>-->
        <!--                                                                                    <b-form-input-->
        <!--                                                                                        v-if="c.isEdit"-->
        <!--                                                                                        type="text"-->
        <!--                                                                                        required-->
        <!--                                                                                        class="mb-2"-->
        <!--                                                                                        v-model="c.name"-->
        <!--                                                                                        :placeholder="'Введите название'">-->
        <!--                                                                                    </b-form-input>-->
        <!--                                                                                </div>-->
        <!--                                                                                &lt;!&ndash;                                                                                <div class="col-2" v-if="!c.isEdit">&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                    <p class="mb-0"&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                       v-for="sf in c.studyForm">&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        {{sf}}</p>&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                </div>&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                <div class="col-2" v-if="!c.isEdit">&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                    <p>{{c.score}}</p>&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                </div>&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                <div class="col-4" v-if="c.isEdit">&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                    <b-form-input&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        v-if="c.isEdit"&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        type="text"&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        required&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        class="mb-2"&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        v-model="c.score"&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                        :placeholder="'Проходной балл'">&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                    </b-form-input>&ndash;&gt;-->
        <!--                                                                                &lt;!&ndash;                                                                                </div>&ndash;&gt;-->
        <!--                                                                                <div class="col-2">-->
        <!--                                                                                    <i v-if="c.isEdit"-->
        <!--                                                                                       style="cursor:pointer;"-->
        <!--                                                                                       class="fas fa-check"-->
        <!--                                                                                       @click="changeCourse(c)"></i>-->

        <!--                                                                                    <i v-if="!c.isEdit"-->
        <!--                                                                                       style="cursor:pointer;"-->
        <!--                                                                                       class="fas fa-pen"-->
        <!--                                                                                       @click="editCourse(c)"></i>-->
        <!--                                                                                    <i style="cursor:pointer; color:red;"-->
        <!--                                                                                       class="fas fa-trash"-->
        <!--                                                                                       @click="deleteCourse(c.id)"></i>-->
        <!--                                                                                </div>-->
        <!--                                                                            </div>-->
        <!--                                                                            &lt;!&ndash;                                                                            <div class="row">&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                <div class="col-12">&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                    <b-form-group v-if="c.isEdit">&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                        <b-form-checkbox-group&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                            v-model="c.studyForm"&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                            :options="forms"&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                        ></b-form-checkbox-group>&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                    </b-form-group>&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                                </div>&ndash;&gt;-->
        <!--                                                                            &lt;!&ndash;                                                                            </div>&ndash;&gt;-->
        <!--                                                                        </div>-->
        <!--                                                                    </div>-->
        <!--                                                                    <hr>-->
        <!--                                                                </div>-->
        <!--                                                            </div>-->
        <!--                                                        </div>-->
        <!--                                                    </div>-->
        <!--                                                </div>-->
        <!--                                            </div>-->
        <!--                                        </div>-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->

        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div role="tablist">
                    <b-card no-body class="mb-1" v-for="(f,i) in faculties" :key="i">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block href="#" v-b-toggle="'accordion-'+i" variant="info">{{f.name}}
                            </b-button>
                        </b-card-header>
                        <b-collapse :id="'accordion-'+i" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <b-card-text>
                                    <div class="row text-center" v-if="!f.isEdit">
                                        <p class="w-100 text-center">
                                            <span class="mr-2"><b>{{ f.name }}</b></span>
                                            <i class="fa fa-pencil cursor-pointer"
                                               v-if="!f.isEdit"
                                               @click="editFaculty(f)"></i>
                                            <i class="fas fa-trash text-red cursor-pointer"
                                               @click="deleteFaculty(f.id)"></i>
                                        </p>

                                    </div>
                                    <div v-if="f.isEdit" class="row">
                                        <div class="col-10">
                                            <b-form-input
                                                type="text"
                                                required
                                                class="form-control"
                                                v-model="f.name"
                                                :placeholder="'Введите название'">
                                            </b-form-input>
                                        </div>
                                        <div class="col-2 text-center d-flex justify-content-center align-items-center">
                                            <i class="fas fa-check" @click="changeFaculty(f);"></i>
                                        </div>
                                    </div>
                                </b-card-text>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-10 mb-4">
                                                        <span class="badge">Название направления</span>
                                                        <input class="form-control" type="text" v-model="course.name">
                                                    </div>
                                                    <div class="col-2 d-flex align-items-bottom">
                                                        <b-button class="m-auto d-block"
                                                                  variant="outline-success"
                                                                  @click="addCourse(f.id)">
                                                            <i
                                                                class="fas fa-check"></i>
                                                        </b-button>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="row">
                                                        <div
                                                            class="col-3 d-flex align-items-center">
                                                            <b-form-checkbox v-model="course.intramural.name"
                                                                             value="Очная">Очная
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.intramural.budget"
                                                                   class="form-control"
                                                                   placeholder="Кол-во бюджетных мест"
                                                                   v-if="course.intramural.name">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.intramural.year"
                                                                   class="form-control"
                                                                   placeholder="Кол-во лет обучения"
                                                                   v-if="course.intramural.name">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.intramural.price"
                                                                   class="form-control"
                                                                   placeholder="Цена обучения"
                                                                   v-if="course.intramural.name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="row">
                                                        <div
                                                            class="col-3 d-flex align-items-center">
                                                            <b-form-checkbox v-model="course.partTime.name"
                                                                             value="Очно-заочная">Очно-заочная
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.partTime.budget"
                                                                   class="form-control"
                                                                   placeholder="Кол-во бюджетных мест"
                                                                   v-if="course.partTime.name">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.partTime.year"
                                                                   class="form-control"
                                                                   placeholder="Кол-во лет обучения"
                                                                   v-if="course.partTime.name">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.partTime.price"
                                                                   class="form-control"
                                                                   placeholder="Цена обучения"
                                                                   v-if="course.partTime.name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div
                                                            class="col-3 d-flex align-items-center">
                                                            <b-form-checkbox v-model="course.correspondence.name"
                                                                             value="Заочная">Заочная
                                                            </b-form-checkbox>
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.correspondence.budget"
                                                                   class="form-control"
                                                                   placeholder="Кол-во бюджетных мест"
                                                                   v-if="course.correspondence.name">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.correspondence.year"
                                                                   class="form-control"
                                                                   placeholder="Кол-во лет обучения"
                                                                   v-if="course.correspondence.name">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                   v-model="course.correspondence.price"
                                                                   class="form-control"
                                                                   placeholder="Цена обучения"
                                                                   v-if="course.correspondence.name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <b-card-text v-for="(c,k) in f.courses" :key="k">
                                            {{c.name}}
                                        </b-card-text>
                                    </div>
                                </div>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
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
                    intramural: {},
                    partTime: {},
                    correspondence: {}

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
                axios.post('/admin/course/' + f.id, {
                    name: f.name
                });
                this.fetchFaculty()
                this.clearCurrentFaculty()
            },

            editFaculty(f) {
                f.isEdit = !f.isEdit
            },

            addFaculty() {
                axios.post('/admin/course', {
                    name: this.faculty.name,
                    parent_id: null
                });
                this.clearCurrentFaculty();
                this.fetchFaculty()
            },

            changeCourse(c) {
                axios.post('/admin/course/' + c.id, {
                    name: c.name,
                    intramural: c.intramural,
                    partTime: c.partTime,
                    correspondence: c.correspondence
                });
                this.clearCurrentCourse();
                this.fetchFaculty()
            },

            editCourse(c) {
                c.isEdit = !c.isEdit
            },

            deleteFaculty(id) {
                axios.delete('/admin/course/' + id)
                this.fetchFaculty()
            },

            addCourse(id) {
                axios.post('/admin/course', {
                    name: this.course.name,
                    parent_id: id,
                    intramural: this.intramural,
                    partTime: this.partTime,
                    correspondence: this.correspondence
                });
                this.fetchFaculty()
                this.clearCurrentCourse()
            },

            deleteCourse(id) {
                axios.delete('/admin/course/' + id)
                this.fetchFaculty()
            },

            clearCurrentCourse() {
                this.course = {...this.currentCourse}
            },

            clearCurrentFaculty() {
                this.faculty = {...this.currentFaculty}
            },

            fetchFaculty() {
                let data = axios.get('/admin/course')
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
