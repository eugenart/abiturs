<template>
    <div>
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

                                    <label class="badge badge-danger" v-show="errorImage">{{errorImage}}</label>
                                    <input type="file" accept="image/*" @change="addImage" name="image" ref="file">
                                </div>
                                <div class="col-6">
                                    <button v-show="!isBlockUpdate" class="btn col-6 float-right btn-primary"
                                            type="submit">
                                        Создать
                                    </button>
                                    <button v-show="isBlockUpdate" class="btn col-6 float-right btn-success"
                                            type="submit">
                                        Сохранить изменения
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Инфоблоки</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3" v-for="(block, index) in blocks">
                                <div class="card">
                                    <div class="card-header">
                                        <p class="m-0">{{block.name}}</p>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <label class="badge m-0">Ссылка</label>
                                            <p class="ml-2 mb-1">{{block.url}}</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Отображать в меню</label>
                                            <p class="ml-2 mb-1" v-if="block.menu">Да</p>
                                            <p class="ml-2 mb-1" v-else>Нет</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Приоритет в меню</label>
                                            <p class="ml-2 mb-1">{{block.menuPriority}}</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Отображать на главной странице</label>
                                            <p class="ml-2 mb-1" v-if="block.startPage">Да</p>
                                            <p class="ml-2 mb-1" v-else>Нет</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Приоритет на главной странице</label>
                                            <p class="ml-2 mb-1">{{block.startPagePriority}}</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Активность</label>
                                            <p class="ml-2 mb-1" v-if="block.activity">Да</p>
                                            <p class="ml-2 mb-1" v-else>Нет</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Активность от</label>
                                            <p class="ml-2 mb-1" v-if="block.activityFrom">Да</p>
                                            <p class="ml-2 mb-1" v-else>-</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Активность до</label>
                                            <p class="ml-2 mb-1" v-if="block.activityTo">Да</p>
                                            <p class="ml-2 mb-1" v-else>-</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Предпросмотр изображения</label>
                                            <img v-if="block.image" class="w-100"
                                                 :src="'../../../storage/preview/' + block.image" alt="">
                                            <img v-else class="w-100"
                                                 src="../../../storage/app/public/preview/default.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-sm btn-dark col-12"
                                                        @click="changeInfoblock(block)">
                                                    Изменить
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class='btn btn-sm col-12'
                                                        @click="removeInfoblock(block.id,index)">Удалить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                currentInfoblock: {},
                errorImage: ''
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
                window.URL = window.URL || window.webkitURL
                let file = this.$refs.file.files[0];
                let needWidth = 800;
                let needHeight = 450;
                let img = new Image();
                img.src = window.URL.createObjectURL(file)
                img.onload = function () {
                    if (img.width != needWidth || img.height != needHeight) {
                        this.errorImage = 'Изображение должно быть ' + needWidth.toString() + 'px X ' + needHeight.toString() + ' px'
                        console.log(this.errorImage)
                    } else {
                        this.errorImage = '';
                        this.infoblock.image = file
                    }
                };


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
