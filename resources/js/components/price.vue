<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div v-for="fc in prices" v-if="fc.plan.length !== 0">
                                    <h3>{{fc.name}}</h3>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <th>Специальности</th>
                                        <th>Форма обучения</th>
                                        <th>Количество бюджетных мест</th>
                                        <th>Количество лет обучения</th>
                                        <th>Цена обучения за год</th>
                                        </thead>
                                        <tbody v-for="plan in fc.plan">
                                        <tr>
                                            <td>
                                                <p class="m-0">{{plan.speciality.code}}</p>
                                                <p class="m-0"><b>{{plan.speciality.name}}</b></p>
                                                <p class="m-0" v-if="plan.specialization">
                                                    {{plan.specialization.name}}</p>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <p class="m-0 text-nowrap text-center" v-for="studyForm in plan.studyForm">
                                                    {{studyForm.name}}
                                                </p>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <p class="m-0 text-nowrap text-center" v-for="studyForm in plan.studyForm">
                                                    <span class="text-nowrap" v-for="(fs, idx) in studyForm.freeseats">
                                                        {{fs.admissionBasis.short_name}} - {{fs.value}};
                                                    </span>
                                                </p>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <p class="m-0 text-nowrap text-center" v-for="studyForm in plan.studyForm">
                                                    {{studyForm.years}} года/лет
                                                </p>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <p class="m-0 text-nowrap text-center" v-for="studyForm in plan.studyForm">
                                                    <span class="text-nowrap" v-for="(ps, idx) in studyForm.prices">
                                                        {{ps.info}} - {{ps.price}} руб.;
                                                    </span>
                                                </p>
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
        name: "price",
        data() {
            return {
                prices: [],
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
                        this.prices = response.data
                    })

            }
        }
    }
</script>

<style scoped>

</style>
