<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div v-for="fc in scores">
                                    <h3>{{fc.name}}</h3>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <th>Специальности</th>
                                            <th>Форма обучения</th>
                                            <th>Предметы</th>
                                            <th>Оценки</th>
                                        </thead>
                                        <tbody v-for="tarea in fc.tArea">
                                            <tr class="bordered">
                                                <td :rowspan="tarea.area.scores.length + 1">{{tarea.area.sp_name.code}} {{tarea.area.sp_name.name}}</td>
                                                <td :rowspan="tarea.area.scores.length + 1">{{tarea.area.trainingForm}}</td>
                                            </tr>
                                            <tr v-for="score in tarea.area.scores">
                                                <td>
                                                    {{score.subject.name}}
                                                </td>
                                                <td>
                                                    <b>{{score.minScore}}</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
        name: "minScore",
        data() {
            return {
                scores: [],
            }
        },
        mounted() {
            this.fetchScores()
        },
        computed: {},
        methods: {

            fetchScores() {
                let data = axios.get('/admin/minscore')
                    .then(response => (this.scores = response.data))
            }
        }
    }
</script>

<style scoped>

</style>
