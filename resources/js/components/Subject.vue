<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p>Количество предметов: <b>{{subjects.length}}</b></p>
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Название вступительного испытания</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="sbj in subjects">
                                        <td>{{ sbj.name }}</td>
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
</template>

<script>
    export default {
        name: "subject",
        data() {
            return {
                subjects: [],
            }
        },
        mounted() {
            this.fetchSubjects()
        },
        computed: {},
        methods: {

            fetchSubjects() {
                let data = axios.get('/admin/subjects')
                    .then(response => (this.subjects = response.data))
            }
        }
    }
</script>

<style scoped>

</style>
