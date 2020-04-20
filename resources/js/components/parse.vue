<template>
    <!--    <div>-->
    <!--        <div class="row mt-4">-->
    <!--            <div class="col-12">-->
    <!--                <div class="row">-->
    <!--                    <div class="col-12">-->
    <!--                        <div class="card">-->
    <!--                            <div class="card-body">-->
    <!--                                <div class="card">-->
    <!--                                    <div class="card-header">Выгрузка данных о специальностях и специализациях</div>-->
    <!--                                    <div class="card-body">-->
    <!--                                        <div class="row">-->
    <!--                                            <div class="col-4">-->
    <!--                                                <button class="btn btn-sm btn-success w-100"-->
    <!--                                                        @click="this.parseSpecialities">Начать выгрузку-->
    <!--                                                </button>-->
    <!--                                            </div>-->
    <!--                                            <div class="col-8 text-center">-->
    <!--                                                <div v-if="loadingparseSpecialitiesStatus" class="lds-ring">-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                </div>-->
    <!--                                                <p v-else class="m-0">{{parseSpecialitiesStatus}}</p>-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                                <div class="card mt-4">-->
    <!--                                    <div class="card-header">Выгрузка данных о статистике приема абитуриентов</div>-->
    <!--                                    <div class="card-body">-->
    <!--                                        <div class="row">-->
    <!--                                            <div class="col-4">-->
    <!--                                                <button class="btn btn-sm btn-success w-100"-->
    <!--                                                        @click="this.parseStudents">Начать выгрузку-->
    <!--                                                </button>-->
    <!--                                            </div>-->
    <!--                                            <div class="col-8 text-center">-->
    <!--                                                <div v-if="loadingparseStudentsStatus" class="lds-ring">-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                </div>-->
    <!--                                                <p v-else>{{parseStudentsStatus}}</p>-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                                <div class="card mt-4">-->
    <!--                                    <div class="card-header">Выгрузка данных о ценах на обучение</div>-->
    <!--                                    <div class="card-body">-->
    <!--                                        <div class="row">-->
    <!--                                            <div class="col-4">-->
    <!--                                                <button class="btn btn-sm btn-success w-100"-->
    <!--                                                        @click="this.parseAreas">Начать выгрузку-->
    <!--                                                </button>-->
    <!--                                            </div>-->
    <!--                                            <div class="col-8 text-center">-->
    <!--                                                <div v-if="loadingparseAreasStatus" class="lds-ring">-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                </div>-->
    <!--                                                <p v-else>{{parseAreasStatus}}</p>-->
    <!--                                            </div>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                                <div class="card mt-4">-->
    <!--                                    <div class="card-header">Выгрузка данных о факультетах и предметах</div>-->
    <!--                                    <div class="card-body">-->
    <!--                                        <div class="row">-->
    <!--                                            <div class="col-4">-->
    <!--                                                <button class="btn btn-sm btn-success w-100"-->
    <!--                                                        @click="this.parseSub">Начать выгрузку-->
    <!--                                                </button>-->
    <!--                                            </div>-->
    <!--                                            <div class="col-8 text-center">-->
    <!--                                                <div v-if="loadingparseSubStatus" class="lds-ring">-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                    <div></div>-->
    <!--                                                </div>-->
    <!--                                                <p v-else>{{parseSubStatus}}</p>-->
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
    <!--    </div>-->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Выгрузка данных о специальностях и специализациях</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-sm btn-success w-100"
                                    @click="this.parseSpecialities">Начать выгрузку
                            </button>
                        </div>
                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                            <div v-if="loadingparseSpecialitiesStatus" class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <p v-else class="m-0">{{parseSpecialitiesStatus}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Выгрузка факультетов, институтов и дисциплин</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-sm btn-success w-100"
                                    @click="this.parseSub">Начать выгрузку факультетов, институтов и дисциплин
                            </button>
                        </div>
                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                            <div v-if="loadingparseSubStatus" class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <p v-else>{{parseSubStatus}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Выгрузка оснований для приема</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-sm btn-success w-100"
                                    @click="this.parseAdmissionBasis">Начать выгрузку оснований для приема
                            </button>
                        </div>
                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                            <div v-if="loadingparseAdmissionBasis" class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <p v-else>{{parseAdmissionBasisStatus}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Выгрузка форм обучения, категорий, уровней подготовки</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-sm btn-success w-100"
                                    @click="this.parseCatalogs">Начать выгрузку форм обучения, категорий, уровней
                                подготовки
                            </button>
                        </div>
                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                            <div v-if="loadingparseCatalogsStatus" class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <p v-else>{{parseCatalogsStatus}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Выгрузка планов, цен на обучение и количества мест</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">Бакалавриат и специалитет</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parsePlansBach">Начать выгрузку форм обучения,
                                                категорий, уровней подготовки
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparsePlansBachStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parsePlansBachStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header">Магистратура</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parsePlansMaster">Начать выгрузку форм обучения,
                                                категорий, уровней подготовки
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparsePlansMasterStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parsePlansMasterStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header">Аспирантура</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parsePlansAsp">Начать выгрузку форм обучения,
                                                категорий, уровней подготовки
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparsePlansAspStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parsePlansAspStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header">СПО</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parsePlansSpo">Начать выгрузку форм обучения,
                                                категорий, уровней подготовки
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparsePlansSpoStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parsePlansSpoStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Выгрузка статистики приема</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">Бакалавриат и специалитет</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parseStudents">Начать выгрузку статистики приема
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparseStudentsStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parseStudentsStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header">Магистратура</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parseStudentsMaster">Начать выгрузку статистики приема
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparseStudentsMasterStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parseStudentsMasterStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header">Аспирантура</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parseStudentsAsp">Начать выгрузку статистики приема
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparseStudentsAspStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parseStudentsAspStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-header">СПО</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parseStudentsSpo">Начать выгрузку статистики приема
                                            </button>
                                        </div>
                                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                                            <div v-if="loadingparseStudentsSpoStatus" class="lds-ring">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                            <p v-else>{{parseStudentsSpoStatus}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3 mb-3">
                <div class="card-header">Выгрузка статистики предыдущих лет</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-sm btn-success w-100"
                                    @click="this.parseContests">Начать выгрузку статистики предыдущих лет
                            </button>
                        </div>
                        <div class="col-8 text-center d-flex justify-content-center align-items-center">
                            <div v-if="loadingparseContestsStatus" class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <p v-else>{{parseContestsStatus}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "parse",
        data() {
            return {
                parseSpecialitiesStatus: null,
                parseSubStatus: null,
                parseAdmissionBasisStatus: null,
                parseCatalogsStatus: null,

                parsePlansBachStatus: null,
                parsePlansMasterStatus: null,
                parsePlansAspStatus: null,
                parsePlansSpoStatus: null,

                parseStudentsStatus: null,
                parseStudentsMasterStatus: null,
                parseStudentsAspStatus: null,
                parseStudentsSpoStatus: null,


                parseContestsStatus: null,


                loadingparseSpecialitiesStatus: false,
                loadingparseSubStatus: false,
                loadingparseAdmissionBasis: false,
                loadingparseCatalogsStatus: false,

                loadingparsePlansBachStatus: null,
                loadingparsePlansMasterStatus: null,
                loadingparsePlansAspStatus: null,
                loadingparsePlansSpoStatus: null,

                loadingparseStudentsStatus: null,
                loadingparseStudentsMasterStatus: null,
                loadingparseStudentsAspStatus: null,
                loadingparseStudentsSpoStatus: null,

                loadingparseContestsStatus: false,
            }
        },
        computed: {},
        methods: {
            parseSpecialities: function () {
                this.loadingparseSpecialitiesStatus = true;
                let data = axios.get('/admin/parse-specialities')
                    .then(response => {
                        this.loadingparseSpecialitiesStatus = false;
                        this.parseSpecialitiesStatus = response.data
                    })
            },

            parseSub: function () {
                this.loadingparseSubStatus = true;
                let data = axios.get('/admin/parse-sub')
                    .then(response => {
                        this.loadingparseSubStatus = false;
                        this.parseSubStatus = response.data
                    })
            },

            parseAdmissionBasis: function () {
                this.loadingparseAdmissionBasis = true;
                let data = axios.get('/admin/c')
                    .then(response => {
                        this.loadingparseAdmissionBasis = false;
                        this.parseAdmissionBasisStatus = response.data
                    })
            },

            parseCatalogs: function () {
                console.log('test')
                this.loadingparseCatalogsStatus = true;
                let data = axios.get('/admin/parse-catalogs')
                    .then(response => {
                        this.loadingparseCatalogsStatus = false;
                        this.parseCatalogsStatus = response.data
                    })
            },

            parsePlansBach: function () {
                console.log('test')
                this.loadingparsePlansBachStatus = true;
                let data = axios.get('/admin/parse-plans-bach')
                    .then(response => {
                        this.loadingparsePlansBachStatus = false;
                        this.parsePlansBachStatus = response.data
                    })
            },

            parsePlansMaster: function () {
                console.log('test')
                this.loadingparsePlansMasterStatus = true;
                let data = axios.get('/admin/parse-plans-master')
                    .then(response => {
                        this.loadingparsePlansMasterStatus = false;
                        this.parsePlansMasterStatus = response.data
                    })
            },

            parsePlansAsp: function () {
                console.log('test')
                this.loadingparsePlansAspStatus = true;
                let data = axios.get('/admin/parse-plans-asp')
                    .then(response => {
                        this.loadingparsePlansAspStatus = false;
                        this.parsePlansAspStatus = response.data
                    })
            },

            parsePlansSpo: function () {
                console.log('test')
                this.loadingparsePlansSpoStatus = true;
                let data = axios.get('/admin/parse-plans-spo')
                    .then(response => {
                        this.loadingparsePlansSpoStatus = false;
                        this.parsePlansSpoStatus = response.data
                    })
            },

            parseStudents: function () {
                this.loadingparseStudentsStatus = true;
                let data = axios.get('/admin/parse-students')
                    .then(response => {
                        this.loadingparseStudentsStatus = false;
                        this.parseStudentsStatus = response.data
                    })
            },
            parseStudentsMaster: function () {
                this.loadingparseStudentsMasterStatus = true;
                let data = axios.get('/admin/parse-students-master')
                    .then(response => {
                        this.loadingparseStudentsMasterStatus = false;
                        this.parsePlansMasterStatus = response.data
                    })
            },
            parseStudentsAsp: function () {
                this.loadingparseStudentsAspStatus = true;
                let data = axios.get('/admin/parse-students-asp')
                    .then(response => {
                        this.loadingparseStudentsAspStatus = false;
                        this.parsePlansAspStatus = response.data
                    })
            },
            parseStudentsSpo: function () {
                this.loadingparseStudentsSpoStatus = true;
                let data = axios.get('/admin/parse-students-spo')
                    .then(response => {
                        this.loadingparseStudentsSpoStatus = false;
                        this.parsePlansSpoStatus = response.data
                    })
            },

            parseContests: function () {
                this.loadingparseContestsStatus = true;
                let data = axios.get('/admin/parse-contests')
                    .then(response => {
                        this.loadingparseContestsStatus = false;
                        this.parseContestsStatus = response.data
                    })
            }
        },
    }
</script>

<style scoped>

    p {
        margin: 0 !important;
    }

    .lds-ring {
        display: inline-block;
        position: relative;
        width: 20px;
        height: 20px;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 20px;
        height: 20px;
        margin: 8px;
        border: 3px solid;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #041e42 transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>
