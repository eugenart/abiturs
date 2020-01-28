<template>
    <div>
        <div class="row">

            <div class="col-12">
                <div class="row mt-4">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-header">
                                <p class="mb-0">
                                    <a :href="rootUrl" target="_blank">Перейти на страницу подраздела</a>
                                </p>
                            </div>
                            <div class="card-body">
                                <div id="comps">
                                    <form @submit.prevent="sendForm" enctype="multipart/form-data" id="inputsForm">
                                        <input type="submit" class="btn btn-sm btn-success col-4">
                                        <div v-for="(input,index) in inputs" :key="input.position">
                                            <hr>
                                            <div class="card" v-if="input.type === 'text'">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <p class="m-0">
                                                                <i class="fas fa-arrow-up up_down_arrow"
                                                                   @click="changePosition(input.id, '', 'down')"
                                                                   v-show="input.position !== 0"
                                                                ></i>
                                                                <i class="fas fa-arrow-down up_down_arrow"
                                                                   @click="changePosition(input.id, '', 'up')"
                                                                   v-show="input.position !== inputs.length-1"></i>
                                                            </p>
                                                            <p class="badge m-0 p-0" v-show="input.isEdit">
                                                                Название
                                                                блока</p>
                                                            <p class="m-0" v-show="!input.isEdit"><b>{{input.name}}</b>
                                                            </p>
                                                            <input type="text"
                                                                   class="form-control form-control-sm"
                                                                   v-model="input.name"
                                                                   v-show="input.isEdit">
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="inline-block text-right m-0">
                                                                <i v-if="!input.isEdit" class="fas fa-pen"
                                                                   style="cursor:pointer"
                                                                   @click="input.isEdit = !input.isEdit"></i>
                                                                <i v-if="input.isEdit" class="fas fa-times"
                                                                   style="cursor:pointer"
                                                                   @click="input.isEdit = !input.isEdit"></i>
                                                                &nbsp;
                                                                <i style="cursor:pointer"
                                                                   class="fas fa-trash-alt"
                                                                   @click="deleteInput(input.id)"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="ql-editor"
                                                         id="content-section"
                                                         style="min-height: 0px;"
                                                         v-show="!input.isEdit"
                                                         v-html="input.content">
                                                    </div>
                                                    <vue-editor v-show="input.isEdit"
                                                                v-model="input.content">
                                                    </vue-editor>
                                                </div>
                                            </div>
                                            <div v-if="input.type === 'files'" class="card mt-3">
                                                <div class="card-header">
                                                    <div class="row mb-3 mb-0"
                                                         style="margin-bottom: 0 !important;">
                                                        <div class="col-8">
                                                            <p><i class="fas fa-arrow-up up_down_arrow"
                                                                  @click="changePosition(input.id, null, 'down')"
                                                                  v-show="input.position !== 0"
                                                            ></i>
                                                                <i class="fas fa-arrow-down up_down_arrow"
                                                                   @click="changePosition(input.id, null, 'up')"
                                                                   v-show="input.position !== inputs.length-1"></i></p>
                                                            <input v-show="input.isEdit"
                                                                   type="text"
                                                                   class="form-control form-control-sm"
                                                                   v-model="input.name">
                                                            <p class="m-0" v-show="!input.isEdit"><b>{{input.name}}</b>
                                                            </p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="inline-block text-right m-0">
                                                                <i v-if="!input.isEdit" class="fas fa-pen"
                                                                   style="cursor:pointer"
                                                                   @click="input.isEdit = !input.isEdit"></i>
                                                                <i v-if="input.isEdit" class="fas fa-times"
                                                                   style="cursor:pointer"
                                                                   @click="input.isEdit = !input.isEdit"></i>
                                                                &nbsp;
                                                                <i style="cursor:pointer"
                                                                   v-if="input.id"
                                                                   class="fas fa-trash-alt"
                                                                   @click="deleteInput(input.id)"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-4">
                                                        <button type="button"
                                                                class="btn btn-sm btn-primary col-12"
                                                                @click="addDocField(index)">Добавить файл
                                                        </button>
                                                    </div>
                                                    <div v-for="(file,i) in input.content">
                                                        <div class="row mt-3" v-show="!file.isEdit">
                                                            <div class="col-4">
                                                                <span class="badge">Отображаемое название</span>
                                                                <p>{{file.name}}</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="badge">Загруженный файл</span>
                                                                <p>{{file.content}}</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <p class="inline-block text-right m-0">
                                                                    <i class="fas fa-arrow-up up_down_arrow"
                                                                       @click="changePosition(input.id, file.id, 'down')"
                                                                       v-show="file.position !== 0"
                                                                    ></i>
                                                                    <i class="fas fa-arrow-down up_down_arrow"
                                                                       @click="changePosition(input.id, file.id, 'up')"
                                                                       v-show="file.position !== input.content.length-1"></i>

                                                                    <i class="fas fa-pen" style="cursor:pointer"
                                                                       @click="file.isEdit = !file.isEdit"></i>
                                                                    &nbsp;
                                                                    <i style="cursor:pointer"
                                                                       v-if="file.id"
                                                                       class="fas fa-trash-alt"
                                                                       @click="deleteInput(file.id)"></i>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3" v-show="file.isEdit">
                                                            <div class="col-4">
                                                                <span class="badge">Отображаемое название</span>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       v-model="file.name"
                                                                       placeholder="Название файла"
                                                                >
                                                            </div>
                                                            <div class="col-6">
                                                                <span
                                                                    class="badge">Загруженный файл: {{file.content}}</span>
                                                                <b-form-file v-model="file.content"
                                                                             placeholder="Выберите файл"
                                                                             drop-placeholder="Перенесите сюда файл"
                                                                             browse-text='Oбзор'
                                                                             :name='file.vmodel'
                                                                ></b-form-file>
                                                            </div>
                                                            <div class="col-2">
                                                                <p v-if="file.id"
                                                                   class="inline-block text-right m-0">
                                                                    <i class="fas fa-times"
                                                                       style="cursor:pointer"
                                                                       @click="file.isEdit = !file.isEdit"></i>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-sm btn-primary col-12 mb-2" @click="addTextField">Текстовое поле</button>
                                <button class="btn btn-sm btn-primary col-12" @click="addFileGroup">Поле с файлами</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    import sortByPos from "../helpers/sort"

    export default {
        components: {
            VueEditor,
            sortByPos
        },
        props: ['sectionId', 'sectionLink'],
        name: "sectionInfo",
        data() {
            return {
                rootUrl: window.location.origin + '/' + this.sectionLink,
                inputs: [],
                input: {
                    type: null,
                    id: null,
                    section_id: null,
                    position: null,
                    content: null,
                    name: null,
                    vmodel: null,
                    file_name: null,
                    isEdit: true,
                },

                currentInput: {}
            }
        },

        mounted() {
            this.currentInput = {...this.input}
            this.getSectionInfo()
        },

        methods: {

            changePosition(id, cId, type,) {
                axios.post('/admin/section-content', {
                    updown: type,
                    parent_id: id,
                    child_id: cId
                })
                this.getSectionInfo()
            },

            deleteInput(id) {
                axios.delete('/admin/section-content/' + id)
                this.getSectionInfo()
            },

            async getSectionInfo() {
                let data = await axios.get('/admin/section-content/' + this.sectionId)
                this.inputs = data.data.slice()
                this.inputs = this.inputs.sort(sortByPos)

                $.each(this.inputs, function (k, v) {

                    if (v.type == 'files') {
                        v.content = v.content.sort(sortByPos)
                    }
                })
            },

            sortByPos(a, b) {
                return ((a.position < b.position) ? -1 : ((a.position > b.position) ? 1 : 0));
            },

            async sendForm() {
                let formData = new FormData();
                formData.append('inputs', JSON.stringify(this.inputs));
                $.each(this.inputs, function (key, value) {
                    if (value.type === 'files') {
                        $.each(value.content, function (k, v) {
                            formData.append(v.vmodel, v.content);
                        })
                    }
                })
                await axios.post('/admin/section-content', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                this.getSectionInfo()
            },

            addFileGroup() {
                this.input.section_id = this.sectionId;
                this.input.type = 'files';
                this.input.position = this.inputs.length;
                this.input.vmodel = '';
                this.inputs.push(this.input);
                this.clearCurrentInput()
            },


            addTextField() {
                this.input.section_id = this.sectionId;
                this.input.type = 'text';
                this.input.position = this.inputs.length;
                this.inputs.push(this.input);
                this.clearCurrentInput()
            },

            addDocField(i) {
                !this.inputs[i].content ? this.inputs[i].content = [] : null
                this.input.type = 'file'
                this.input.vmodel = (Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)).toString();
                this.input.position = this.inputs[i].content.length
                this.inputs[i].content.push(this.input)
                this.clearCurrentInput()
            },


            clearCurrentInput() {
                this.input = {...this.currentInput}
            }
        }
    }
</script>

<style scoped>
</style>
