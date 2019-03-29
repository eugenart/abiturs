<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="!isBlockUpdate? addInfoblock() : updateInfoblock()">
                <input v-model="infoblock.name" type="text" placeholder="Название инфоблока">
                <input v-model="infoblock.url" type="text" placeholder="Ссылка на инфоблок">
                <label><input v-model="infoblock.menu" type="checkbox">Отображать в меню</label>
                <label><input v-model="infoblock.menuPriority" type="number">Приоритет в меню</label>
                <label><input v-model="infoblock.startPage" type="checkbox">Отображать на главной странице</label>
                <label><input v-model="infoblock.startPagePriority" type="number">Приоритет на главной странице</label>
                <label><input v-model="infoblock.activity" type="checkbox">Активность</label>
                <input v-model="infoblock.activityFrom" type="date">
                <input v-model="infoblock.activityTo" type="date">
                <button v-show="!isBlockUpdate" type="submit">Создать</button>
                <button v-show="isBlockUpdate" type="submit">Сохранить изменения</button>
            </form>
        </div>

        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>В меню</th>
                    <th>Приоритет в меню</th>
                    <th>На главной</th>
                    <th>Приоритет на главной</th>
                    <th>Активность</th>
                    <th>От</th>
                    <th>До</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(block, index) in blocks">
                    <td>{{block.name}}</td>
                    <td>{{block.url}}</td>
                    <td>{{block.menu}}</td>
                    <td>{{block.menuPriority}}</td>
                    <td>{{block.startPage}}</td>
                    <td>{{block.startPagePriority}}</td>
                    <td>{{block.activity}}</td>
                    <td>{{block.activityFrom}}</td>
                    <td>{{block.activityTo}}</td>
                    <td>
                        <button @click="changeInfoblock(block)">Редактировать</button>
                        <button @click="removeInfoblock(block.id,index)">Удалить</button>
                    </td>
                </tr>
                </tbody>
            </table>
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
                    activityFrom: null,
                    activityTo: null,
                },
                isBlockUpdate: false,
                currentInfoblock: {}
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
                console.log('up')
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
