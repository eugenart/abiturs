<template>
    <div class="row mt-4">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p>Количество специальностей: <b>{{orderedSpecialities.length}}</b></p>
                            <table class="table-bordered table table-sm">
                                <thead>
                                    <th>Название специальности</th>
                                    <th>Название специализаций</th>
                                </thead>
                                <tbody>
                                        <tr v-for="spec in orderedSpecialities">
                                            <td><b>{{spec.code}}</b> {{spec.name}}</td>
                                            <td>
                                                <ul>
                                                    <li v-for="s in spec.sp">
                                                        {{s.name}}
                                                    </li>
                                                </ul>
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
</template>

<script>
    export default {
        name: "speciality",
        data() {
            return {
                specialities: []
            }
        },
        mounted() {
            this.fetchSpecialities()
        },

        computed: {
            orderedSpecialities: function () {
                return _.orderBy(this.specialities, 'name')
            },
        },

        methods: {
            fetchSpecialities() {
                let data = axios.get('/admin/speciality')
                    .then(response => (this.specialities = response.data))
            }
        }
    }
</script>

<style scoped>

</style>
