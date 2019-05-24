<template>
    <div>
        <div class="row">
            <div class="col-12">
                <form @submit.prevent="!isBlockUpdate? addInfoblock() : updateInfoblock()" class="col-12"
                      enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <p class="m-0">Создание/редактирование инфоблока</p>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <b-tabs content-class="mt-3">
                                        <b-tab title="Основные" active>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="badge">Название инфоблока</label>
                                                    <input v-model="infoblock.name" @keyup="transliterate" type="text"
                                                           class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="badge">Превью инфоблока</label>
                                                    <b-form-file v-model="infoblock.image"
                                                                 accept="image/*"
                                                                 placeholder="Выберите файл изображения"
                                                                 drop-placeholder="Перенесите сюда изображение"
                                                                 browse-text='Oбзор'
                                                                 @change="getPreview"
                                                    ></b-form-file>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="badge">Ссылка на инфоблок</label>
                                                    <input v-model="infoblock.url" type="text"
                                                           class="form-control form-control-sm" required
                                                           @keyup="transliterate">
                                                </div>

                                                <div class="col-6">
                                                    <img :src="previewUrl" width="320" height="180" alt=""
                                                         v-show="previewUrl" class="d-block m-auto">
                                                </div>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Отображение и приоритет">
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
                                                                <input required v-model="infoblock.menuPriority"
                                                                       type="number"
                                                                       class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="badge">Приоритет на главной странице</label>
                                                            <input required v-model="infoblock.startPagePriority"
                                                                   type="number"
                                                                   class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Активность">
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
                                                        <input class="form-control form-control-sm"
                                                               v-model="infoblock.activityFrom"
                                                               type="date">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="badge">Дата конца активности</label>
                                                        <input class="form-control form-control-sm"
                                                               v-model="infoblock.activityTo"
                                                               type="date">
                                                    </div>
                                                </div>
                                            </div>
                                        </b-tab>
                                    </b-tabs>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <button v-show="!isBlockUpdate" class="btn col-12 btn-primary"
                                            type="submit">
                                        Создать
                                    </button>
                                    <button v-show="isBlockUpdate" class="btn col-12 btn-success"
                                            type="submit">
                                        Сохранить изменения
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-light col-12" type="button" @click="clearCurrentInfoblock">Очистить
                                        форму
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                        <p class="m-0"><strong>{{block.name}}</strong></p>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <label class="badge m-0">Предпросмотр изображения</label>
                                            <img class="w-100"
                                                 :src="'../../../storage/preview/' + block.image" alt="">
                                        </div>
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
                                            <p class="ml-2 mb-1" v-if="block.activityFrom">{{block.activityFrom}}</p>
                                            <p class="ml-2 mb-1" v-else>-</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Активность до</label>
                                            <p class="ml-2 mb-1" v-if="block.activityTo">{{block.activityTo}}</p>
                                            <p class="ml-2 mb-1" v-else>-</p>
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
                errorImage: '',
                previewUrl: '../../storage/preview/default.jpg',
                formStatus: false
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

            //

            checkForm(e) {
                if (this.infoblock.name || this.infoblock.url || this.infoblock.menuPriority || this.infoblock.startPagePriority) {
                    this.formStatus = 'Не все обязательные поля заполнены'
                } else {
                    !this.isBlockUpdate ? this.addInfoblock() : this.updateInfoblock()
                }
            },

            transliterate() {
                let a = {
                    "Ё": "YO",
                    "Й": "I",
                    "Ц": "TS",
                    "У": "U",
                    "К": "K",
                    "Е": "E",
                    "Н": "N",
                    "Г": "G",
                    "Ш": "SH",
                    "Щ": "SCH",
                    "З": "Z",
                    "Х": "H",
                    "ё": "yo",
                    "й": "i",
                    "ц": "ts",
                    "у": "u",
                    "к": "k",
                    "е": "e",
                    "н": "n",
                    "г": "g",
                    "ш": "sh",
                    "щ": "sch",
                    "з": "z",
                    "х": "h",
                    "Ф": "F",
                    "Ы": "I",
                    "В": "V",
                    "А": "a",
                    "П": "P",
                    "Р": "R",
                    "О": "O",
                    "Л": "L",
                    "Д": "D",
                    "Ж": "ZH",
                    "Э": "E",
                    "ф": "f",
                    "ы": "i",
                    "в": "v",
                    "а": "a",
                    "п": "p",
                    "р": "r",
                    "о": "o",
                    "л": "l",
                    "д": "d",
                    "ж": "zh",
                    "э": "e",
                    "Я": "Ya",
                    "Ч": "CH",
                    "С": "S",
                    "М": "M",
                    "И": "I",
                    "Т": "T",
                    "Ь": "I",
                    "Б": "B",
                    "Ю": "YU",
                    "я": "ya",
                    "ч": "ch",
                    "с": "s",
                    "м": "m",
                    "и": "i",
                    "т": "t",
                    "ь": "i",
                    "б": "b",
                    "ю": "yu",
                    ' ': '-'
                };
                let letters = /^[A-Za-z]+$/;
                this.infoblock.url = this.infoblock.name.split('').map(function (char) {
                    return a[char] || char.match(letters);
                }).join("");
            },

            getPreview(e) {
                let file = e.target.files[0];
                this.previewUrl = URL.createObjectURL(file)
            },

            addInfoblock() {
                this.isBlockUpdate = false;
                this.$store.dispatch('SAVE_BLOCK', this.infoblock);
                this.clearCurrentInfoblock();

            },

            changeInfoblock(block) {
                this.infoblock = block
                this.previewUrl = '../../storage/preview/' + this.infoblock.image
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
                this.isBlockUpdate = false
                this.infoblock = {...this.currentInfoblock}
                this.previewUrl = '../../storage/preview/default.jpg'
            }

        }
    }
</script>
