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
                                                {{parseSpecialitiesStatus}}
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
                                                {{parseStudentsStatus}}
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
                                                {{parseAreasStatus}}
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
            }
        },
        computed: {},
        methods: {
            parseSpecialities: function () {
                let data = axios.get('/admin/parse-specialities')
                    .then(response => (this.parseSpecialitiesStatus = response.data))
            },
            parseStudents: function () {
                let data = axios.get('/admin/parse-students')
                    .then(response => (this.parseStudentsStatus = response.data))
            },
            parseAreas: function () {
                let data = axios.get('/admin/parse-areas')
                    .then(response => (this.parseAreasStatus = response.data))
            }
        },
    }
</script>

<style scoped>

</style>
