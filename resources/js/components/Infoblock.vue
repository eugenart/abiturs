<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <form @submit.prevent="!isBlockUpdate? addInfoblock() : updateInfoblock()" class="col-12 p-0"
                      enctype="multipart/form-data" id="infoblockForm">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><p class="m-0">Создание/редактирование инфоблока</p></div>
                                <div class="col-6 text-right">
                                    <button type="button" onclick="$('#infoblockForm').hide()" class="close"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
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
                                        <b-tab title="Новости">
                                            <div class="row">
                                                <div class="col-10">
                                                    <form novalidate>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="Новость" v-model="news">
                                                    </form>
                                                </div>
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-success btn-sm"
                                                            @click="addNews"><i
                                                        class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <p v-for="(n,i) in infoblock.news"><i class="fa fa-times"
                                                                                          style="cursor: pointer; color:red;"
                                                                                          @click="removeNews(i)"></i>
                                                        {{n}}</p>
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
                                    <button class="btn btn-light col-12" type="button" @click="clearCurrentInfoblock">
                                        Очистить
                                        форму
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <p class="m-0">Инфоблоки</p>
                            </div>
                            <div class="col-6">
                                <button class="float-right btn btn-sm btn-info" onclick="$('#infoblockForm').show()">
                                    Добавить
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4" v-for="(block, index) in blocks">
                                <div class="card infoblock-сard-text">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-8">
                                                <p class="m-0"><strong>{{block.name}}</strong></p>
                                            </div>
                                            <div class="col-4">
                                                <p>
                                                    <span class="float-right">
                                                        <i class="far fa-eye" style="cursor: pointer"
                                                           v-if="block.activity"
                                                           @click="changeActivity(block)"></i>
                                                        <i class="far fa-eye-slash" style="cursor: pointer"
                                                           v-else
                                                           @click="changeActivity(block)"></i>
                                                        &nbsp;
                                                        <i class="fas fa-pen" style="cursor: pointer"
                                                           @click="changeInfoblock(block)"></i>
                                                         &nbsp;
                                                        <i class="fas fa-trash-alt" style="cursor: pointer; color:red;"
                                                           @click="removeInfoblock(block.id,index)"></i>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <label class="badge m-0">Предпросмотр изображения</label>
                                            <img class="w-100"
                                                 :src="'../../../storage/preview/' + block.image" alt="">
                                        </div>
                                        <div>
                                            <label class="badge m-0">Ссылка</label>
                                            <p class="ml-2 mb-1"><a :href="rootUrl + '/'+block.url" target="_blank">{{block.url}}</a>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">В меню (приоритет)</label>
                                            <p class="ml-2 mb-1">
                                                <span v-if="block.menu">Да</span>
                                                <span v-else>Нет</span>
                                                <span> ({{block.menuPriority}})</span>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">На главной странице (приоритет)</label>
                                            <p class="ml-2 mb-1">
                                                <span v-if="block.startPage">Да</span>
                                                <span v-else>Нет</span>
                                                <span> ({{block.startPagePriority}})</span>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Активность (от / до)</label>
                                            <p class="ml-2 mb-1">
                                                <span class="ml-2 mb-1" v-if="block.activity">Да </span>
                                                <span class="ml-2 mb-1" v-else>Нет </span>
                                                (
                                                <span
                                                    v-if="block.activityFrom">{{block.activityFrom | formatDate}}</span>
                                                <span v-else>-</span>
                                                /
                                                <span v-if="block.activityTo">{{block.activityTo | formatDate}}</span>
                                                <span v-else>-</span>
                                                )
                                            </p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Новости</label>
                                            <p class="mb-1" v-for="n in block.news">
                                                {{n}}
                                            </p>
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
                rootUrl: window.location.origin,
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
                    image: null,
                    news: []
                },
                isBlockUpdate: false,
                currentInfoblock: {},
                errorImage: '',
                previewUrl: '../../storage/preview/default.jpg',
                formStatus: false,
                news: null
            }
        },


        mounted() {
            this.currentInfoblock = {...this.infoblock}
            this.$store.dispatch('GET_BLOCKS')
            $('#infoblockForm').hide()
        },

        computed: {

            blocks() {
                return this.$store.getters.BLOCKS
            }

        },

        methods: {

            addNews() {
                this.infoblock.news.push(this.news)
                this.news = null
            },

            removeNews(i) {
                this.infoblock.news.splice(i, 1)
            },

            changeActivity(block) {
                block.activity = !block.activity
                this.infoblock = block
                this.updateInfoblock()
            },

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
                    "А": "A",
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
                $('#infoblockForm').show()
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

<style scoped>
    .badge {
        color: gray;
        margin: 0;
    }

    .infoblock-сard-text p > span {
        font-size: 14px;
    }
</style>
