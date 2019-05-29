<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div id="comps">
                                    <form @submit.prevent="sendForm" enctype="multipart/form-data" id="inputsForm">
                                        <input type="submit" class="btn btn-sm btn-success col-4">
                                        <div v-for="(input,index) in inputs">
                                            <vue-editor class="mt-3" v-if="input.type === 'text'"
                                                        v-model="input.content">
                                            </vue-editor>
                                            <div v-if="input.type === 'files'" class="card mt-3">
                                                <div class="card-header">
                                                    <div class="row mb-3 mb-0" style="margin-bottom: 0 !important;">
                                                        <div class="col-4">
                                                            <p class="m-0">Название блока</p>
                                                        </div>
                                                        <div class="col-8"><input type="text"
                                                                                  class="form-control form-control-sm"
                                                                                  v-model="input.name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-4">
                                                        <button type="button" class="btn btn-sm btn-primary col-12"
                                                                @click="addDocField(index)">Add file
                                                        </button>
                                                    </div>
                                                    <div v-for="(file,i) in input.content">
                                                        <div class="row mt-3">
                                                            <div class="col-6">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       :v-model="file.name"
                                                                       placeholder="Название файла">
                                                            </div>
                                                            <div class="col-6">
                                                                <b-form-file v-model="file.content"
                                                                             placeholder="Выберите файл"
                                                                             drop-placeholder="Перенесите сюда файл"
                                                                             browse-text='Oбзор'
                                                                             name="file-group"
                                                                ></b-form-file>
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
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-sm btn-primary col-12 mb-2" @click="addTextField">Text</button>
                                <button class="btn btn-sm btn-primary col-12" @click="addFileGroup">Files</button>
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

    export default {
        components: {
            VueEditor
        },
        name: "sectionInfo",
        data() {
            return {
                inputs: [],
                input: {
                    type: null,
                    id: null,
                    position: null,
                    content: null,
                    name: null
                },

                currentInput: {}
            }
        },

        mounted() {
            this.currentInput = {...this.input}
        },

        methods: {

            sendForm() {
                let formData = new FormData();
                formData.append('inputs', JSON.stringify(this.inputs));
                axios.post('/section-content', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        console.log(response.data);
                    })
            },

            addFileGroup() {
                this.input.type = 'files'
                this.input.position = this.inputs.length
                this.input.vmodel = this.input.type + '-' + this.input.position.toString()
                this.inputs.push(this.input)
                this.clearCurrentInput()
            },


            addTextField() {
                this.input.type = 'text'
                this.input.position = this.inputs.length
                this.inputs.push(this.input)
                this.clearCurrentInput()
            },

            addDocField(i) {
                !this.inputs[i].content ? this.inputs[i].content = [] : null
                this.input.type = 'file'
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
