<template>
    <div>
        <div class="row mt-4">

           <div class="col-12 mb-3" v-for="(archive, index) in archives">

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <p class="m-0">{{ archive.name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4" v-for="(block, index) in blocks">
                                <div class="card mb-3 infoblock-сard-text"  v-if="block.archive_ob.id === archive.id">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-8">
                                                <p class="m-0"><strong>{{block.name}}</strong></p>
                                            </div>
                                            <div class="col-4">
                                                <p>
                                                    <span class="float-right">
                                                        <i class="fa fa-copy" style="cursor: pointer"
                                                           @click="copyInfoblock(block.id)">
                                                        </i>

                                                        <i class="far fa-eye" style="cursor: pointer"
                                                           v-if="block.activity"
                                                           @click="changeActivity(block)"/>
                                                        <i class="far fa-eye-slash" style="cursor: pointer"
                                                           v-else
                                                           @click="changeActivity(block)"/>
                                                        &nbsp;
                                                        <i class="fas fa-trash-alt" style="cursor: pointer; color:red;"
                                                           @click="removeInfoblock(block.id,index)"/>
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
                                            <label class="badge m-0">Архив: </label>
                                            <p class="ml-2 mb-1">{{block.archive_ob.name}}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Ссылка</label>
                                            <p class="ml-2 mb-1"><a :href="rootUrl + '/'+block.url" target="_blank">{{block.url}}</a>
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
        name: 'Archive',
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
                    news: [],
                    foreigner: false,
                    archive:true
                },

                isBlockUpdate: false,
                currentInfoblock: {},
                errorImage: '',
                previewUrl: '../../../storage/preview/default.jpg',
                formStatus: false,
                news: null
            }
        },


        mounted() {
            this.currentInfoblock = {...this.infoblock};
            this.$store.dispatch('GET_ARCHIVE_BLOCKS');
            this.$store.dispatch('GET_ARCHIVES');

            $('#infoblockForm').hide()
        },

        computed: {

            blocks() {
                return this.$store.getters.BLOCKS
            },
            archives() {
                return this.$store.getters.ARCHIVES
            }


        },

        methods: {
            countedArchives(){
                console.log('s')

            },
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
                // console.log(block)
                this.updateInfoblock()
                this.$store.dispatch('GET_ARCHIVE_BLOCKS');
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
                let letters = /^[A-Za-z0-9]+$/;
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

            copyInfoblock(bId) {
                this.$store.dispatch('COPY_BLOCK', bId);
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
                let isDelete = confirm("Вы действительно хотите удалить выбранный раздел? Данное действие нельзя отменить");
                isDelete ? this.$store.dispatch('DELETE_BLOCK', id, index) : null
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
