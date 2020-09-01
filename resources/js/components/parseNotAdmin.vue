<template>
    <div class="row mt-4">
        <div class="col-12">




            <div class="card mt-3">
                <div class="card-header  font-weight-bold">Планы, цены за обучение и количество мест</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <div class="card mt-3">
                                <div class="card-header">Аспирантура</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parsePlansAsp">Выгрузить данные
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

                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header font-weight-bold">Пофамильные списки абитуриентов</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <div class="card mt-3">
                                <div class="card-header">Аспирантура</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-success w-100"
                                                    @click="this.parseStudentsAsp">Выгрузить списки
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
                parseStatStatus: null,
                parseOrderStatus: null,


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

                loadingparseStatStatus: false,
                loadingparseOrderStatus: false,
            }
        },
        computed: {},
        methods: {
            parseSpecialities: function () {
                this.loadingparseSpecialitiesStatus = true;
                let data = axios.post('/admin/download', 'param=specialities')
                    .then(response => {
                        this.loadingparseSpecialitiesStatus = false;
                        this.parseSpecialitiesStatus = response.data;
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log('here', error);
                    });
            },

            parseSub: function () {
                this.loadingparseSubStatus = true;
                let data = axios.post('/admin/download', {'param': 'faculties'})
                    .then(response => {
                        this.loadingparseSubStatus = false;
                        this.parseSubStatus = response.data
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log('here2', error);
                        console.log(error);
                    });
            },

            parseAdmissionBasis: function () {
                this.loadingparseAdmissionBasis = true;
                let data = axios.post('/admin/download', {'param': 'admission_bases'})
                    .then(response => {
                        this.loadingparseAdmissionBasis = false;
                        this.parseAdmissionBasisStatus = response.data
                    })
            },

            parseCatalogs: function () {
                console.log('test')
                this.loadingparseCatalogsStatus = true;
                let data = axios.post('/admin/download', {'param': 'stat_bach_catalogs'})
                    .then(response => {
                        this.loadingparseCatalogsStatus = false;
                        this.parseCatalogsStatus = response.data
                    })
            },

            parsePlansBach: function () {
                console.log('test')
                this.loadingparsePlansBachStatus = true;
                let data = axios.post('/admin/download', {'param': 'plans_bach'})
                    .then(response => {
                        this.loadingparsePlansBachStatus = false;
                        this.parsePlansBachStatus = response.data
                    })
            },

            parsePlansMaster: function () {
                console.log('test')
                this.loadingparsePlansMasterStatus = true;
                let data = axios.post('/admin/download', {'param': 'plans_master'})
                    .then(response => {
                        this.loadingparsePlansMasterStatus = false;
                        this.parsePlansMasterStatus = response.data
                    })
            },

            parsePlansAsp: function () {
                console.log('test')
                this.loadingparsePlansAspStatus = true;
                let data = axios.post('/admin/download', {'param': 'plans_asp'})
                    .then(response => {
                        this.loadingparsePlansAspStatus = false;
                        this.parsePlansAspStatus = response.data
                    })
            },

            parsePlansSpo: function () {
                console.log('test')
                this.loadingparsePlansSpoStatus = true;
                let data = axios.post('/admin/download', {'param': 'plans_spo'})
                    .then(response => {
                        this.loadingparsePlansSpoStatus = false;
                        this.parsePlansSpoStatus = response.data
                    })
            },

            parseStudents: function () {
                this.loadingparseStudentsStatus = true;
                let data = axios.post('/admin/download', {'param': 'stat_bach'})
                    .then(response => {
                        this.loadingparseStudentsStatus = false;
                        this.parseStudentsStatus = response.data
                    })
            },

            parseStudentsMaster: function () {
                this.loadingparseStudentsMasterStatus = true;
                let data = axios.post('/admin/download', {'param': 'stat_master'})
                    .then(response => {
                        this.loadingparseStudentsMasterStatus = false;
                        this.parseStudentsMasterStatus = response.data
                    })
            },

            parseStudentsAsp: function () {
                this.loadingparseStudentsAspStatus = true;
                let data = axios.post('/admin/download', {'param': 'stat_asp'})
                    .then(response => {
                        this.loadingparseStudentsAspStatus = false;
                        this.parseStudentsAspStatus = response.data
                    })
            },

            parseStudentsSpo: function () {
                this.loadingparseStudentsSpoStatus = true;
                let data = axios.post('/admin/download', {'param': 'stat_spo'})
                    .then(response => {
                        this.loadingparseStudentsSpoStatus = false;
                        this.parseStudentsSpoStatus = response.data
                    })
            },

            parseContests: function () {
                this.loadingparseContestsStatus = true;
                let data = axios.post('/admin/download', {'param': 'past_contests'})
                    .then(response => {
                        this.loadingparseContestsStatus = false;
                        this.parseContestsStatus = response.data
                    })
            },

            parseStat: function () {
                this.loadingparseStatStatus = true;
                let data = axios.get('/admin/download-stat-priem')
                    .then(response => {
                        this.loadingparseStatStatus = false;
                        this.parseStatStatus = response.data
                    })
            },

            parseOrder: function () {
                this.loadingparseOrderStatus = true;
                let data = axios.get('/admin/download-orders')
                    .then(response => {
                        this.loadingparseOrderStatus = false;
                        this.parseOrderStatus = response.data
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
