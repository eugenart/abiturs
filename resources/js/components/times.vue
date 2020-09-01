<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header  font-weight-bold">Время выгрузки</div>
                            <div class="card-body">
                                <div class="card border-success" style="width:fit-content;">
                                    <div class="card-body">
                                        <b>Обратите внимание!</b> <br/>
                                        При выгрузке нового файла списков время будет изменено на текущее время выгрузки.<br/>
                                        Вы можете изменить время на нужное после окончания выгрузки.
                                    </div>
                                </div>
                                <div v-for="(time, index) in times" :key="time.id" v-if="time.name_file === 'stat_bach' || time.name_file === 'stat_master' || time.name_file === 'stat_asp' || time.name_file === 'stat_spo'">
                                    <form @submit.prevent="updateTime(time)"
                                          class="col-12 p-0"
                                          enctype="multipart/form-data" :id="time.id+'Form'">
                                        <label class="badge" v-show="time.name_file === 'stat_bach'">Списки бакалавриата и специалитета</label>
                                        <label class="badge" v-show="time.name_file === 'stat_master'">Списки магистратуры</label>
                                        <label class="badge" v-show="time.name_file === 'stat_asp'">Списки аспирантуры и ординатуры</label>
                                        <label class="badge" v-show="time.name_file === 'stat_spo'">Списки СПО</label>
                                        <div class="row" style="margin-left: 4px;">
                                            <input class="form-control form-control-sm"
                                                   style="width: 300px;"
                                                   v-model="time.date_update"
                                                   type="datetime-local">
                                            <button class="btn btn-sm btn-success" style="margin-left: 8px;" type="submit">
                                                Сохранить
                                            </button>
                                            <div class="text-success ml-2" v-show="id_notice === time.id">{{notice}}</div>
                                        </div>
                                    </form>
                                </div>


                                <table class="table table-bordered table-sm mt-3" style="display:none;">
                                    <thead>
                                    <tr>
                                        <th scope="col">Имя файла</th>
                                        <th scope="col">Время выгрузки</th>
                                        <th scope="col">Пользователь</th>
                                        <th scope="col">Факт. время обновления</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(time, index) in times" :key="time.id">
                                        <th scope="row">{{time.name_file}}</th>
                                        <td>{{time.date_update.replace('T', ' ')}}</td>
                                        <td>{{time.username}}</td>
                                        <td>{{time.updated_at}}</td>
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
    name: 'times',
    data() {
        return {
            time: {
                name_file: null,
                date_update: null,
                username: null,
                updated_at: null
            },
            notice: '',
            id_notice: null
        }
    },

    mounted() {
        this.$store.dispatch('GET_TIMES')
    },

    computed: {

        times() {
            return this.$store.getters.TIMES
        }

    },

    methods: {

        updateTime(time) {
            this.$store.dispatch('UPDATE_TIME', time);
            this.showNotice(time.id)
            // this.isSlideUpdate = false


        },

        showNotice(id_n) {
            this.id_notice = id_n;
            this.notice = 'Дата и время сохранено!'
        }

    }
}
</script>
