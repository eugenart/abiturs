<template>
    <div class="col-12 sidebar">
        <ul class="sidebar-list pt-2">
            <li class="pb-2">
                <a href="">Настройки сайта</a>
            </li>
            <!--<li class="pb-2">-->
                <!--<a href="" class="w-100 d-flex justify-content-between align-items-center align-content-center">-->
                    <!--Главная-->
                    <!--страница-->
                <!--</a>-->
            <!--</li>-->
            <li class="pb-2">
                <a href="/infoblock">Инфоблоки</a>
            </li>
            <li class="pb-2">
                <a href="">Разделы</a>
            </li>
            <li class="pb-2">
                <a href="">Документы</a>
            </li>
            <li class="pb-2">
                <a href="">Мультимедиа</a>
            </li>

            <!--<li>-->
                <!--<a data-toggle="collapse" href="#multiCollapseExample1" role="button"-->
                   <!--aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>-->
            <!--</li>-->
            <!--<div class="col">-->
                <!--<div class="collapse multi-collapse" id="multiCollapseExample1">-->
                    <!--<li><a href="">sub</a></li>-->
                <!--</div>-->
            <!--</div>-->
        </ul>
    </div>
</template>

<script>
    export default {
        name: "SideBarComponent",

        methods: {}
    }
</script>

<style scoped>

    .sidebar {
        height: 100vh;
        background-color: rgba(4,30,66,1);
    }

    .sidebar-list {
        list-style: none;
    }

    .sidebar-list a {
        color: white;
    }
</style>
