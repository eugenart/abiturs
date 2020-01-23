<template>
    <div>
<!--        <div class="row mt-4">-->
<!--            <div class="col-12">-->
<!--                <b-form @submit.prevent="addSubject()">-->
<!--                    <div class="card">-->
<!--                        <div class="card-header">-->
<!--                            <p class="m-0">Добавление вступительного испытания</p>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!--                            <b-form-group-->
<!--                                label="Название вступительного испытания:">-->
<!--                                <b-form-input-->
<!--                                    type="text"-->
<!--                                    required-->
<!--                                    v-model="subject.name"-->
<!--                                    placeholder="Введите название">-->
<!--                                </b-form-input>-->
<!--                            </b-form-group>-->
<!--                            <b-form-checkbox-->
<!--                                v-model="subject.internal">-->
<!--                                Внутренний экзамен-->
<!--                            </b-form-checkbox>-->
<!--                        </div>-->
<!--                        <div class="card-footer">-->
<!--                            <div class="row">-->
<!--                                <div class="col-6">-->
<!--                                    <b-button type="submit" squared variant="outline-success" class="col-12"-->
<!--                                    >-->
<!--                                        Добавить-->
<!--                                    </b-button>-->
<!--                                </div>-->
<!--                                <div class="col-6">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </b-form>-->
<!--            </div>-->
<!--        </div>-->
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
                    .then(response => (this.subjects = response.data, console.log(response.data)))
            }
        }
    }
</script>

<style scoped>

</style>
