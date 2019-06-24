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
                                                  @click="f.isEdit = true">
                                            <i class="fas fa-pen"></i>
                                        </b-button>
                                        <b-button v-else squared variant="warning"
                                                  class="col-12"
                                                  @click="changeFaculty; f.isEdit = false">
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
                                                    <div class="col-10">
                                                        <b-form-group>
                                                            <b-form-input
                                                                type="text"
                                                                required
                                                                class="mb-2"
                                                                v-model="course.name"
                                                                :placeholder="'Введите название'">
                                                            </b-form-input>
                                                        </b-form-group>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <b-button class="m-auto d-block"
                                                                                  variant="outline-success"
                                                                                  @click="addCourse(f.id)"><i
                                                                            class="fas fa-plus"></i>
                                                                        </b-button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-for="(c,i) in f.courses">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-10">
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

                                                                    <i v-if="c.isEdit" style="cursor:pointer;"
                                                                       class="fas fa-check"
                                                                       @click="editCourse(c); c.isEdit = false"></i>

                                                                    <i v-if="!c.isEdit" style="cursor:pointer;"
                                                                       class="fas fa-pen"
                                                                       @click="c.isEdit = true"></i>

                                                                    &nbsp;
                                                                    <i style="cursor:pointer; color:red;"
                                                                       class="fas fa-trash"
                                                                       @click="deleteCourse(f.courses, i)"></i>
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
                    isEdit: false
                },

                currentFaculty: {
                    name: null,
                    id: null,
                    courses: []
                },
                currentCourse: {
                    name: null,
                    id: null,
                    isEdit: false
                }

            }
        },
        mounted() {
            this.fetchFaculty()
        },
        computed: {},
        methods: {

            changeFaculty() {
                this.faculty.isEdit = false;
                this.clearCurrentFaculty()
            },

            addFaculty() {
                axios.post('/course', {
                    name: this.faculty.name,
                    parent_id: null
                });
                this.clearCurrentFaculty();
                this.fetchFaculty()
            },

            deleteFaculty(id) {
                axios.delete('/course/' + id)
                this.fetchFaculty()
            },

            addCourse(id) {
                axios.post('/course', {
                    name: this.course.name,
                    parent_id: id
                });
                this.fetchFaculty()
                this.clearCurrentCourse()
            },

            deleteCourse() {
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
