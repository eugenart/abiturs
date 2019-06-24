<template>
    <div>
        <div class="row">
            <div class="col-6">
                <label class="badge">Факультет / институт</label>
                <select type="text" class="form-control form-control-sm" v-model="chosenFaculty">
                    <option v-for="(f,i) in faculties" :value="f">
                        {{f.name}}
                    </option>
                </select>
            </div>
            <div class="col-6">
                <label class="badge">Направление подготовки</label>
                <select v-if="chosenFaculty" v-model="chosenCourse" type="text"
                        class="form-control form-control-sm">
                    <option v-for="(c,i) in chosenFaculty.courses" :value="c">
                        {{c.name}}
                    </option>
                </select>
            </div>
            <div class="col-6">
                <label class="badge">Направление подготовки</label>
                <b-form-group>
                    <b-form-checkbox-group
                        v-model="chosenCourse.studyForm"
                        :options="forms"
                    ></b-form-checkbox-group>
                </b-form-group>
                <!--                <multiselect class="col-12" v-if="chosenCourse.name" multiple v-model="chosenCourse.studyForm"-->
                <!--                             track-by="value" label="name" placeholder="Выберите направление" :options="forms"-->
                <!--                             :searchable="false" :allow-empty="false">-->
                <!--                </multiselect>-->
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <b-button v-if="chosenCourse" pill variant="light">Добавить экзамен к "{{chosenCourse.name}}"</b-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "egeSelect",
        data() {
            return {
                faculties: [],
                chosenFaculty: null,
                chosenCourse: {
                    name: null,
                    studyForm: []
                },
                exams: [],
                forms: [
                    {text: "Очная", value: '1'},
                    {text: "Очно-заочная", value: '2'},
                    {text: "Заочная", value: '3'}
                ]
            }
        },

        mounted() {
            this.fetchFaculty()
        },

        methods: {
            fetchFaculty() {
                let data = axios.get('/course')
                    .then(response => (this.faculties = response.data))
            },
            chooseFaculty(f) {
                this.chosenFaculty = f
            }

        }
    }
</script>

<style scoped>

</style>
