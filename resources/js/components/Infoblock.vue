<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="addInfoblock">
                <input v-model="infoblock.name" type="text" placeholder="Название инфоблока">
                <input v-model="infoblock.url" type="text" placeholder="Ссылка на инфоблок">
                <label><input v-model="infoblock.menu" type="checkbox">Отображать в меню</label>
                <label><input v-model="infoblock.menuPriority" type="number">Приоритет в меню</label>
                <label><input v-model="infoblock.startPage" type="checkbox">Отображать на главной странице</label>
                <label><input v-model="infoblock.startPagePriority" type="number">Приоритет на главной странице</label>
                <input v-model="infoblock.activity.from" type="date">
                <input v-model="infoblock.activity.to" type="date">
                <button type="submit">Создать</button>
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
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(infoblock, index) in infoblockList">
                    <td>{{infoblock.name}}</td>
                    <td>{{infoblock.url}}</td>
                    <td>{{infoblock.menu}}</td>
                    <td>{{infoblock.menuPriority}}</td>
                    <td>{{infoblock.startPage}}</td>
                    <td>{{infoblock.startPagePriority}}</td>
                    <td>
                        <button @click="changeInfoblock(infoblock)">Редактировать</button>
                        <button @click="removeInfoblock(index)">Удалить</button>
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
                    activity: {
                        from: null,
                        to: null,
                    }
                },

                newInfoblock: {},

                infoblockList: []
            }
        },

        methods: {

            changeInfoblock(block) {
                this.infoblock.name = block.name
                this.infoblock.url = block.url
                this.infoblock.menu = block.menu
                this.infoblock.menuPriority = block.menuPriority
                this.infoblock.startPage = block.startPage
                this.infoblock.startPagePriority = block.startPagePriority
                this.infoblock.activity.from = block.activity.from
                this.infoblock.activity.to = block.activity.to
            },

            addInfoblock() {
                this.infoblockList.push(this.infoblock)
                this.infoblock.name = ''
                this.infoblock.url = ''
                this.infoblock.menu = ''
                this.infoblock.menuPriority = ''
                this.infoblock.startPage = ''
                this.infoblock.startPagePriority = ''
                this.infoblock.activity.from = ''
                this.infoblock.activity.to = ''
            },

            removeInfoblock(index) {
                this.infoblockList.splice(index, 1)
            }

        }
    }
</script>
