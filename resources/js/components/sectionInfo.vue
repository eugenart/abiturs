<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div id="comps">
                                    <form @submit.prevent="sendForm" enctype="multipart/form-data">
                                        <input type="submit">
                                        <div v-for="(input,index) in inputs">
                                            <vue-editor v-if="input.type === 'text'" v-model="input.content">
                                            </vue-editor>
                                            <div v-if="input.type === 'files'">
                                                <input type="text" v-model="input.name">
                                                <button type="button" @click="addDocField(index)">Add file</button>
                                                <div v-for="(file,i) in input.content">
                                                    <input type="text" :v-model="file.name">
                                                    <b-form-file v-model="file.content"
                                                                 accept="image/*"
                                                                 placeholder="Выберите файл изображения"
                                                                 drop-placeholder="Перенесите сюда изображение"
                                                                 browse-text='Oбзор'
                                                    ></b-form-file>
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
                                <button @click="addTextField">Text</button>
                                <button @click="addFileGroup">Files</button>
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
                    vmodel: null,
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
                console.log(this.inputs)
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
                this.input.vmodel = this.input.type + '-' + this.input.position.toString()
                this.inputs.push(this.input)
                this.clearCurrentInput()
            },

            addDocField(i) {
                !this.inputs[i].content ? this.inputs[i].content = [] : null
                this.input.type = 'file'
                this.input.position = this.inputs[i].content.length
                this.input.vmodel = this.input.type + '-' + this.input.position.toString()
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
