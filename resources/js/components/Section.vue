<template>
    <div>
        <div class="row">
            <div class="col-12">
                <form @submit.prevent="!isSectionUpdate? addSection() : updateSection()" class="col-12 p-0"
                      enctype="multipart/form-data" id="infoblockForm">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><p class="m-0">Создание/редактирование подраздела</p></div>
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
                                                    <label class="badge">Название подраздела</label>
                                                    <input v-model="section.name" @keyup="transliterate" type="text"
                                                           class="form-control form-control-sm" required>
                                                </div>
                                                <div class="form-group col-6" v-show='!isFolder'>
                                                    <label class="badge">Ссылка на подраздел</label>
                                                    <input v-model="section.url" type="text"
                                                           class="form-control form-control-sm" required
                                                           @keyup="transliterate">
                                                </div>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Отображение и приоритет">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <div class="form-check">
                                                        <input v-model="section.startPage" type="checkbox">
                                                        <label>Отображать на главной
                                                            странице</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="badge">Приоритет на главной странице</label>
                                                            <input required v-model="section.startPagePriority"
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
                                                    <label class="badge">Активность подраздела</label>
                                                    <div class="form-check">
                                                        <input v-model="section.activity" type="checkbox">
                                                        <label>Активность</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="badge">Дата начала активности</label>
                                                        <input class="form-control form-control-sm"
                                                               v-model="section.activityFrom"
                                                               type="date">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="badge">Дата конца активности</label>
                                                        <input class="form-control form-control-sm"
                                                               v-model="section.activityTo"
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
                                    <button v-show="!isSectionUpdate" class="btn col-12 btn-primary"
                                            type="submit" onclick="$('#infoblockForm').hide()">
                                        Создать
                                    </button>
                                    <button v-show="isSectionUpdate" class="btn col-12 btn-success"
                                            type="submit" onclick="$('#infoblockForm').hide()">
                                        Сохранить изменения
                                    </button>
                                </div>
                                <div class="col-6">
<!--                                    <button class="btn btn-light col-12" type="button" @click="clearCurrentSection">-->
<!--                                        Очистить-->
<!--                                        форму-->
<!--                                    </button>-->
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
                                <p class="m-0">Подразделы</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6" v-for="block in blocks">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-6">
                                                    {{block.name}}
                                                </div>
                                                <div class="col-6 float-right">
                                                    <p class="text-right m-0">

                                                        <i style="font-size: 20px; cursor: pointer"
                                                           class="fas fa-file-medical"
                                                           v-b-tooltip.hover title="Добавить элемент"
                                                           @click="changeParents(block.id, null, false)">
                                                        </i>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div v-for="sec in sections" v-if="sec.infoblockID === block.id">
                                                <div v-if="!sec.isFolder">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <p>
                                                                <i class="far fa-file-alt"></i>
                                                                <a
                                                                    :href="'/admin/section-content/' + sec.id"><span>{{sec.name}}</span></a>
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p>
                                                    <span class="float-right">
                                                        <i class="far fa-eye" v-if="sec.activity"
                                                           style="cursor: pointer"
                                                           @click="changeActivity(sec)"/>
                                                        <i class="far fa-eye-slash"
                                                           style="cursor: pointer"
                                                           v-else
                                                           @click="changeActivity(sec)"/>
                                                        &nbsp;
                                                        <i class="fas fa-pen" style="cursor: pointer"
                                                           @click="changeSection(sec)"/>
                                                         &nbsp;
                                                        <i class="fas fa-trash-alt" style="cursor: pointer; color:red;"
                                                           @click="removeSection(sec.id, sec.infoblockID, sec.sectionID)"/>
                                                    </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <p>
                                                                <i class="far fa-folder"></i>
                                                                <span>{{sec.name}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p>
                                                    <span class="float-right">
                                                        <i
                                                            style="font-size: 20px; cursor: pointer"
                                                            class="fas fa-file-medical"
                                                            v-b-tooltip.hover title="Добавить элемент"
                                                            @click="changeParents(section.id, sec.id, false)">
                                                                                                                </i>

                                                        <i class="far fa-eye" v-if="sec.activity"
                                                           style="cursor: pointer"
                                                           @click="changeActivity(sec)"></i>
                                                        <i class="far fa-eye-slash"
                                                           style="cursor: pointer"
                                                           v-else
                                                           @click="changeActivity(sec)"></i>
                                                        &nbsp;
                                                        <i class="fas fa-pen" style="cursor: pointer"
                                                           @click="changeSection(sec)"></i>
                                                         &nbsp;
                                                        <i class="fas fa-trash-alt" style="cursor: pointer; color:red;"
                                                           @click="removeSection(sec.id, sec.infoblockID, sec.sectionID)"></i>
                                                    </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="" v-for="f in sec.folder">
                                                        <div class="row">
                                                            <div class="col-8 offset-1">
                                                                <p>
                                                                    <i class="far fa-file-alt"></i>
                                                                    <a
                                                                        :href="'/admin/section-content/' + f.id"><span>{{f.name}}</span></a>
                                                                </p>
                                                            </div>
                                                            <div class="col-3">
                                                                <p>
                                                                    <span class="float-right">
                                                                        <i class="far fa-eye" v-if="f.activity"
                                                                           style="cursor: pointer"
                                                                           @click="changeActivity(f)"></i>
                                                                        <i class="far fa-eye-slash"
                                                                           style="cursor: pointer"
                                                                           v-else
                                                                           @click="changeActivity(f)"></i>
                                                                        &nbsp;
                                                                        <i class="fas fa-pen" style="cursor: pointer"
                                                                           @click="changeSection(f)"></i>
                                                                         &nbsp;
                                                                        <i class="fas fa-trash-alt"
                                                                           style="cursor: pointer; color:red;"
                                                                           @click="removeSection(f.id, sec.infoblockID, f.sectionID)"></i>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
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
        name: 'Section',
        data() {
            return {
                section: {
                    name: null,
                    url: null,
                    startPage: true,
                    startPagePriority: 500,
                    activity: true,
                    activityFrom: null,
                    activityTo: null,
                    sectionID: null,
                    infoblockID: null,
                    isFolder: false,
                    realLink: null
                },
                isSectionUpdate: false,
                currentSection: {},
                currentBlockID: null,
                formStatus: false,
                isFolder: false,
            }
        },


        mounted() {
            this.currentSection = {...this.section};
            this.$store.dispatch('GET_SECTIONS');
            this.$store.dispatch('GET_BLOCKS');
            $('#infoblockForm').hide()
        },

        computed: {

            blocks() {
                return this.$store.getters.BLOCKS
            },

            sections() {
                return this.$store.getters.SECTIONS
            },

        },

        methods: {

            changeActivity(section) {
                section.activity = !section.activity
                this.section = section
                this.updateSection()
            },

            changeParents(block, section, folder) {
                $('#infoblockForm').show()
                this.isFolder = folder
                this.isSectionUpdate = false;
                this.clearCurrentSection();
                this.section.isFolder = folder;
                this.section.infoblockID = block;
                this.section.sectionID = section;
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
                this.section.url = this.section.name.split('').map(function (char) {
                    return a[char] || char.match(letters);
                }).join("");
                this.section.realLink = this.section.block_name.split('').map(function (char) {
                    return a[char] || char.match(letters);
                }).join("");
                this.section.realLink += '-' + this.section.url;
            },

            addSection() {
                this.isSectionUpdate = false;
                this.$store.dispatch('SAVE_SECTION', this.section);
                this.clearCurrentSection();
            },

            changeSection(section) {
                this.section = section;
                this.isSectionUpdate = true
                $('#infoblockForm').show()
            },

            updateSection() {
                this.$store.dispatch('UPDATE_SECTION', this.section);
                this.isSectionUpdate = false
                this.clearCurrentSection()
            },

            removeSection(id, iId, sId) {
                let payload = {}
                payload.id = id
                payload.iId = iId
                payload.sId = sId
                let isDelete = confirm("Вы действительно хотите удалить выбранный подраздел? Данное действие нельзя отменить");
                isDelete ? this.$store.dispatch('DELETE_SECTION', payload) : null;
            },

            clearCurrentSection() {
                this.section = {...this.currentSection}
            }

        }
    }
</script>
