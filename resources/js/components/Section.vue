<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="!isSectionUpdate? addSection() : updateSection()" class="col-12 p-0"
                  enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0">Создание/редактирование подраздела</p>
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
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
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
                                    <b-tab title="Родительский элемент">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="badge">Родительский подраздел</label>
                                                <div class="form-group">
                                                    <select v-model="section.sectionID" class="form-control form-control-sm">
                                                        <option :value="sec.id" v-for="sec in sections"
                                                                v-if="sec.id !== section.id && section.id !== sec.sectionID">
                                                            {{sec.name}} {{sec.id}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label class="badge">Родительский инфоблок</label>
                                                <div class="form-group">
                                                    <select v-model="section.infoblockID" class="form-control form-control-sm">
                                                        <option :value="block.id" v-for="block in blocks">
                                                            {{block.name}}
                                                        </option>
                                                    </select>
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
                                        type="submit">
                                    Создать
                                </button>
                                <button v-show="isSectionUpdate" class="btn col-12 btn-success"
                                        type="submit">
                                    Сохранить изменения
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-light col-12" type="button" @click="clearCurrentSection">Очистить
                                    форму
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12">
            <ul v-for="block in blocks">
                <li>
                    <a href="#" @click="getBlockSections(block.id)">{{block.name}}</a>
                </li>
            </ul>
        </div>
        <div class="col-12">
            <table class="table" v-show="blocksections.length">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>Описание</th>
                    <th>SectionID</th>
                    <th>infoblockID</th>
                    <th>На главной</th>
                    <th>Приоритет на главной</th>
                    <th>Активность</th>
                    <th>От</th>
                    <th>До</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(section, index) in blocksections">
                    <td>{{section.name}} {{section.id}}</td>
                    <td>{{section.url}}</td>
                    <td>{{section.sectionID}}</td>
                    <td>{{section.infoblockID}}</td>
                    <td>{{section.startPage}}</td>
                    <td>{{section.startPagePriority}}</td>
                    <td>{{section.activity}}</td>
                    <td>{{section.activityFrom}}</td>
                    <td>{{section.activityTo}}</td>
                    <td>
                        <button @click="changeSection(section)">Редактировать</button>
                        <button @click="removeSection(section.id,index)">Удалить</button>
                    </td>
                </tr>
                </tbody>
            </table>
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
                },
                isSectionUpdate: false,
                currentSection: {},
                currentBlockID: null,
                formStatus: false
            }
        },


        mounted() {
            this.currentSection = {...this.section}
            this.$store.dispatch('GET_SECTIONS')
            this.$store.dispatch('GET_BLOCKS')
        },

        computed: {

            blocks() {
                return this.$store.getters.BLOCKS
            },

            sections() {
                return this.$store.getters.SECTIONS
            },

            blocksections() {
                return this.$store.getters.BLOCKSECTIONS
            }

        },

        methods: {

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
                this.section.url = this.section.name.split('').map(function (char) {
                    return a[char] || char.match(letters);
                }).join("");
            },

            getBlockSections(id) {
                console.log(id)
                this.$store.dispatch('GET_INFOBLOCK_SECTIONS', id)
            },

            addSection() {
                this.isSectionUpdate = false;
                this.$store.dispatch('SAVE_SECTION', this.section);
                this.clearCurrentSection();

            },

            changeSection(section) {
                this.section = section;
                this.isSectionUpdate = true
            },

            updateSection() {
                console.log('up')
                this.$store.dispatch('UPDATE_SECTION', this.section);
                this.isSectionUpdate = false
                this.clearCurrentSection()

            },

            removeSection(id) {
                this.$store.dispatch('DELETE_SECTION', id)
            },

            clearCurrentSection() {
                this.section = {...this.currentSection}
            }

        }
    }
</script>
