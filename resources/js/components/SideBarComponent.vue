<template>
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span data-feather="home"></span>
                        Настройки сайта <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/infoblocks">
                        <span data-feather="file"></span>
                        Инфоблоки
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sections">
                        <span data-feather="shopping-cart"></span>
                        Разделы
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="users"></span>
                        Документы
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="bar-chart-2"></span>
                        Мультимедиа
                    </a>
                </li>
            </ul>

            <!--<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">-->
                <!--<span>Saved reports</span>-->
                <!--<a class="d-flex align-items-center text-muted" href="#">-->
                    <!--<span data-feather="plus-circle"></span>-->
                <!--</a>-->
            <!--</h6>-->
            <!--<ul class="nav flex-column mb-2">-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="#">-->
                        <!--<span data-feather="file-text"></span>-->
                        <!--Current month-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="#">-->
                        <!--<span data-feather="file-text"></span>-->
                        <!--Last quarter-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="#">-->
                        <!--<span data-feather="file-text"></span>-->
                        <!--Social engagement-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="#">-->
                        <!--<span data-feather="file-text"></span>-->
                        <!--Year-end sale-->
                    <!--</a>-->
                <!--</li>-->
            <!--</ul>-->
        </div>
    </nav>
    <!--<div class="col-12 sidebar">-->
        <!--<ul class="sidebar-list pt-2">-->
            <!--<li class="pb-2">-->
                <!--<a href="">Настройки сайта</a>-->
            <!--</li>-->
            <!--<li class="pb-2">-->
                <!--<a href="" class="w-100 d-flex justify-content-between align-items-center align-content-center">-->
                    <!--Главная-->
                    <!--страница-->
                <!--</a>-->
            <!--</li>-->
            <!--<li class="pb-2">-->
                <!--<a href="/infoblocks">Инфоблоки</a>-->
            <!--</li>-->
            <!--<li class="pb-2">-->
                <!--<a href="">Разделы</a>-->
            <!--</li>-->
            <!--<li class="pb-2">-->
                <!--<a href="">Документы</a>-->
            <!--</li>-->
            <!--<li class="pb-2">-->
                <!--<a href="">Мультимедиа</a>-->
            <!--</li>-->

            <!--&lt;!&ndash;<li>&ndash;&gt;-->
                <!--&lt;!&ndash;<a data-toggle="collapse" href="#multiCollapseExample1" role="button"&ndash;&gt;-->
                   <!--&lt;!&ndash;aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>&ndash;&gt;-->
            <!--&lt;!&ndash;</li>&ndash;&gt;-->
            <!--&lt;!&ndash;<div class="col">&ndash;&gt;-->
                <!--&lt;!&ndash;<div class="collapse multi-collapse" id="multiCollapseExample1">&ndash;&gt;-->
                    <!--&lt;!&ndash;<li><a href="">sub</a></li>&ndash;&gt;-->
                <!--&lt;!&ndash;</div>&ndash;&gt;-->
            <!--&lt;!&ndash;</div>&ndash;&gt;-->
        <!--</ul>-->
    <!--</div>-->
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
