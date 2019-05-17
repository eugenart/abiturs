<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="!isSectionUpdate? addSection() : updateSection()">
                <input v-model="section.name" type="text" placeholder="Название раздела">
                <input v-model="section.url" type="text" placeholder="Ссылка на раздел">
                <input v-model="section.description" type="text" placeholder="Описание раздела">
                <label><input v-model="section.startPage" type="checkbox">Отображать на главной странице</label>
                <label><input v-model="section.startPagePriority" type="number">Приоритет на главной странице</label>
                <label><input v-model="section.activity" type="checkbox">Активность</label>
                <input v-model="section.activityFrom" type="date">
                <input v-model="section.activityTo" type="date">
                <select v-model="section.sectionID">
                    <option :value="sec.id" v-for="sec in sections"
                            v-if="sec.id !== section.id && section.id !== sec.sectionID">
                        {{sec.name}} {{sec.id}}
                    </option>
                </select>
                <select v-model="section.infoblockID">
                    <option :value="block.id" v-for="block in blocks">
                        {{block.name}}
                    </option>
                </select>
                <button v-show="!isSectionUpdate" type="submit">Создать</button>
                <button v-show="isSectionUpdate" type="submit">Сохранить изменения</button>
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
                    <td>{{section.description}}</td>
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
                    description: null,
                },
                isSectionUpdate: false,
                currentSection: {},
                currentBlockID: null
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

            removeSection(id, index) {
                this.$store.dispatch('DELETE_SECTION', id, index)
            },

            clearCurrentSection() {
                this.section = {...this.currentSection}
            }

        }
    }
</script>
