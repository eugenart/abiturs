<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">Выгрузка данных о специальностях и специализациях</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <button class="btn btn-sm btn-success w-100"
                                                        @click="this.parseSpecialities">Начать выгрузку
                                                </button>
                                            </div>
                                            <div class="col-8 text-center">
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
                                <div class="card mt-4">
                                    <div class="card-header">Выгрузка данных о статистике приема абитуриентов</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <button class="btn btn-sm btn-success w-100"
                                                        @click="this.parseStudents">Начать выгрузку
                                                </button>
                                            </div>
                                            <div class="col-8 text-center">
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
                                <div class="card mt-4">
                                    <div class="card-header">Выгрузка данных о ценах на обучение</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <button class="btn btn-sm btn-success w-100"
                                                        @click="this.parseAreas">Начать выгрузку
                                                </button>
                                            </div>
                                            <div class="col-8 text-center">
                                                <div v-if="loadingparseAreasStatus" class="lds-ring">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                                <p v-else>{{parseAreasStatus}}</p>
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
        name: "parse",
        data() {
            return {
                parseSpecialitiesStatus: null,
                parseStudentsStatus: null,
                parseAreasStatus: null,
                loadingparseSpecialitiesStatus: false,
                loadingparseStudentsStatus: false,
                loadingparseAreasStatus: false,
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
            parseStudents: function () {
                this.loadingparseStudentsStatus = true;
                let data = axios.get('/admin/parse-students')
                    .then(response => {
                        this.loadingparseStudentsStatus = false;
                        this.parseStudentsStatus = response.data
                    })
            },
            parseAreas: function () {
                this.loadingparseAreasStatus = true;
                let data = axios.get('/admin/parse-areas')
                    .then(response => {
                        this.loadingparseAreasStatus = false;
                        this.parseAreasStatus = response.data
                    })
            }
        },
    }
</script>

<style scoped>
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
