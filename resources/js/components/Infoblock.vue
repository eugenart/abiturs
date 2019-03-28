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
                <label><input v-model="infoblock.activity" type="checkbox">Активность</label>
                <input v-model="infoblock.activityFrom" type="date">
                <input v-model="infoblock.activityTo" type="date">
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
                    <th>Активность</th>
                    <th>От</th>
                    <th>До</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(block, index) in infoblockList">
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
                    activity: null,
                    activityFrom: null,
                    activityTo: null,
                },

                infoblockList: []
            }
        },

        methods: {

            getInfoblockList() {
                axios.get('/infoblocks')
                    .then(response => (this.infoblockList = response.data, console.log(this.infoblockList)))
            },

            changeInfoblock(block) {
            },

            addInfoblock() {
                axios.post('/infoblock', {
                    name: this.infoblock.name,
                    url: this.infoblock.url,
                    menu: this.infoblock.menu,
                    menuPriority: this.infoblock.menuPriority,
                    startPage: this.infoblock.startPage,
                    startPagePriority: this.infoblock.startPagePriority,
                    activityFrom: this.infoblock.activityFrom,
                    activityTo: this.infoblock.activityTo,
                    activity: this.infoblock.activity,
                }).then((response) => {
                    console.log(response);
                    this.infoblockList.push(response.data.infoblock)
                    this.infoblock.name = '';
                    this.infoblock.url = '';
                    this.infoblock.menu = '';
                    this.infoblock.menuPriority = 500;
                    this.infoblock.startPage = '';
                    this.infoblock.startPagePriority = 500;
                    this.infoblock.activityFrom = '';
                    this.infoblock.activityTo = '';
                    this.infoblock.activity = '';

                })
            },

            removeInfoblock(id,index) {
                axios.delete('/infoblock/' + id)
                    .then((response) => {
                        this.infoblockList.splice(index,1)
                    })
            }

        },

        created() {
            this.getInfoblockList();
        }
    }
</script>
