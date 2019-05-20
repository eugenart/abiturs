<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="m-0">Создание/редактирование инфоблока</p>
                </div>
                <div class="card-body">
                    <form @submit.prevent="!isBlockUpdate? addInfoblock() : updateInfoblock()" class="col-12"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="badge">Название инфоблока</label>
                                <input v-model="infoblock.name" type="text"
                                       class="form-control form-control-sm">
                            </div>
                            <div class="form-group col-6">
                                <label class="badge">Ссылка на инфоблок</label>
                                <input v-model="infoblock.url" type="text"
                                       class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="form-check">
                                    <input v-model="infoblock.menu" type="checkbox">
                                    <label>Отображать в меню</label>
                                </div>
                                <div class="form-check">
                                    <input v-model="infoblock.startPage" type="checkbox">
                                    <label>Отображать на главной
                                        странице</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="badge">Приоритет в меню</label>
                                            <input v-model="infoblock.menuPriority" type="number"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="badge">Приоритет на главной странице</label>
                                        <input v-model="infoblock.startPagePriority" type="number"
                                               class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label class="badge">Активность инфоблока</label>
                                <div class="form-check">
                                    <input v-model="infoblock.activity" type="checkbox">
                                    <label>Активность</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="badge">Дата начала активности</label>
                                    <input class="form-control form-control-sm" v-model="infoblock.activityFrom"
                                           type="date">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="badge">Дата конца активности</label>
                                    <input class="form-control form-control-sm" v-model="infoblock.activityTo"
                                           type="date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="custom-file">
                                    <input type="file" @change="addImage" name="image" ref="file" class="custom-file-input form-control-sm"
                                           id="customFile">
                                    <label class="custom-file-label" for="customFile">Выберите файл</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <button v-show="!isBlockUpdate" class="btn col-6 float-right btn-primary" type="submit">
                                    Создать
                                </button>
                                <button v-show="isBlockUpdate" class="btn col-6 float-right btn-success" type="submit">
                                    Сохранить изменения
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>В меню</th>
                    <th>Приоритет в меню</th>
                    <th>На главной</th>
                    <th>Приоритет на главной</th>
                    <th>Активность</th>
                    <th>Изображение</th>
                    <th>От</th>
                    <th>До</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(block, index) in blocks">
                    <td>{{block.name}}</td>
                    <td>{{block.url}}</td>
                    <td>{{block.menu}}</td>
                    <td>{{block.menuPriority}}</td>
                    <td>{{block.startPage}}</td>
                    <td>{{block.startPagePriority}}</td>
                    <td>{{block.activity}}</td>
                    <td>{{block.image}}</td>
                    <td>{{block.activityFrom}}</td>
                    <td>{{block.activityTo}}</td>
                    <td>
                        <button @click="changeInfoblock(block)">Редактировать</button>
                        <button @click="removeInfoblock(block.id,index)">Удалить</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'Infoblock',
        data() {
            return {
                infoblock: {
                    name: null,
                    url: null,
                    menu: true,
                    menuPriority: 500,
                    startPage: true,
                    startPagePriority: 500,
                    activity: true,
                    activityFrom: '',
                    activityTo: '',
                    image: null
                },
                isBlockUpdate: false,
                currentInfoblock: {}
            }
        },


        mounted() {
            this.currentInfoblock = {...this.infoblock}
            this.$store.dispatch('GET_BLOCKS')
        },

        computed: {

            blocks() {
                return this.$store.getters.BLOCKS
            }

        },

        methods: {

            addImage(e) {
                console.log(this.$refs.file.files[0])
                this.infoblock.image = this.$refs.file.files[0]
            },

            addInfoblock() {
                this.isBlockUpdate = false;
                this.$store.dispatch('SAVE_BLOCK', this.infoblock);
                this.clearCurrentInfoblock();

            },

            changeInfoblock(block) {
                this.infoblock = block
                this.isBlockUpdate = true
            },

            updateInfoblock() {
                console.log('up')
                this.$store.dispatch('UPDATE_BLOCK', this.infoblock);
                this.isBlockUpdate = false
                this.clearCurrentInfoblock()

            },

            removeInfoblock(id, index) {
                this.$store.dispatch('DELETE_BLOCK', id, index)
            },

            clearCurrentInfoblock() {
                this.infoblock = {...this.currentInfoblock}
            }

        }
    }
</script>
