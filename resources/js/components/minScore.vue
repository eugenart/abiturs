<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div v-for="fc in scores" v-if="fc.plan.length !== 0" v-bind:key="fc.name">
                                    <h3>{{fc.name}}</h3>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <th class="text-center" width="50%">НАПРАВЛЕНИЕ ПОДГОТОВКИ /<br> СПЕЦИАЛЬНОСТЬ
                                        </th>
                                        <th class="text-center" width="30%">ВСТУПИТЕЛЬНЫЕ ИСПЫТАНИЯ В ПОРЯДКЕ
                                            ПРИОРИТЕТНОСТИ ДЛЯ РАНЖИРОВАНИЯ
                                        </th>
                                        <th class="text-center" width="10%">МИНИМАЛЬНЫЕ БАЛЛЫ</th>
                                        <th class="text-center" width="10%">ФОРМЫ ОБУЧЕНИЯ</th>
                                        </thead>
                                        <tbody v-for="plan in fc.plan">
                                        <tr>
                                            <td :rowspan="plan.subjects.length">
                                                <p class="m-0">{{plan.speciality.code}}</p>
                                                <p class="m-0"><b>{{plan.speciality.name}}</b></p>
                                                <p class="m-0" v-if="plan.specialization">
                                                    {{plan.specialization.name}}</p>
                                            </td>
                                            <td>{{plan.subjects[0]}}</td>
                                            <td>{{plan.scores[0].minScore}}</td>
                                            <td :rowspan="plan.subjects.length" style="vertical-align: middle">
                                                <p class="m-0 align-middle text-center text-nowrap" v-for="sf in plan.studyForm">
                                                    {{sf.name}}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr v-for="(subj, i) in [...Array(plan.subjects.length - 1)]">
                                            <td>{{plan.subjects[i+1]}}</td>
                                            <td>{{plan.scores[i+1].minScore}}</td>
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
                    .then(response => {
                        console.log(response.data)
                        response.data.sort((prev, next) => {
                            if ( prev.name < next.name ) return -1;
                            if ( prev.name < next.name ) return 1;
                        });
                        this.scores = response.data;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
