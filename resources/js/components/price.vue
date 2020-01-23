<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div v-for="fc in prices" v-if="fc.tArea.length !== 0">
                                    <h3>{{fc.name}}</h3>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <th>Специальности</th>
                                        <th>Форма обучения</th>
                                        <th>Количество бюджетных мест</th>
                                        <th>Количество лет обучения</th>
                                        <th>Цена обучения за год</th>
                                        </thead>
                                        <tbody v-for="tarea in fc.tArea">
                                        <tr class="bordered">
                                            <td>
                                                {{tarea.area.sp_name.code}}
                                                {{tarea.area.sp_name.name}}
                                            </td>
                                            <td>{{tarea.area.trainingForm}}</td>
                                            <td>{{tarea.area.freeSeatsNumber}}</td>
                                            <td>{{tarea.area.years}}</td>
                                            <td>{{Math.ceil(tarea.area.price / tarea.area.years)}} руб.</td>
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
                    .then(response => (this.prices = response.data, console.log(response.data)))
            }
        }
    }
</script>

<style scoped>

</style>
