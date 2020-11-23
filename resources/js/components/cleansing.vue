<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header  font-weight-bold">Очищение данных</div>
                            <div class="card-body cleansing">
                                <div class="card border-success" style="width:fit-content;">
                                    <div class="card-body">
                                        Даная страница нужна для полного удаления данных в связи с окончанием приемной кампании данного года.
                                    </div>
                                </div>
<!--_---------------------------Удаление файлов статистики-->
                                <h4 class="mb-3">Статистика приема</h4>
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-success w-100"
                                                @click="this.cleanStats">Удалить все файлы статистики приема
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <div v-if="loadingStats" class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p v-else class="m-0">{{ statusStats }}</p>
                                    </div>
                                </div>
<!------------------------------Удаление файлов приказов-->
                                <h4 class="mb-3 mt-3">Приказы</h4>
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-success w-100"
                                                @click="this.cleanOrders">Удалить все файлы приказов
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <div v-if="loadingOrders" class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p v-else class="m-0">{{ statusOrders }}</p>
                                    </div>
                                </div>
<!------------------------------Очищение таблиц бд со статистикой (бэкап бд делается каждую полночь;)-->
                                <h4 class="mb-3 mt-3">Списки поступающих</h4>
<!--------------------------------Бакалавриат-->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-success w-100"
                                                @click="this.cleanStatsBach">Бакалавриат
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <div v-if="loadingStatsBach" class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p v-else class="m-0">{{ statusStatsBach }}</p>
                                    </div>
                                </div>
<!--------------------------------Магистратура-->
                                <div class="row  mb-2">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-success w-100"
                                                @click="this.cleanStatsMaster">Магистратура
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <div v-if="loadingStatsMaster" class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p v-else class="m-0">{{ statusStatsMaster }}</p>
                                    </div>
                                </div>
<!--------------------------------Аспирантура/Ординатура-->
                                <div class="row  mb-2">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-success w-100"
                                                @click="this.cleanStatsAsp">Аспирантура/Ординатура
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <div v-if="loadingStatsAsp" class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p v-else class="m-0">{{ statusStatsAsp }}</p>
                                    </div>
                                </div>
<!--------------------------------СПО-->
                                <div class="row  mb-2">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-success w-100"
                                                @click="this.cleanStatsSpo">СПО
                                        </button>
                                    </div>
                                    <div class="col-8">
                                        <div v-if="loadingStatsSpo" class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p v-else class="m-0">{{ statusStatsSpo }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "cleansing",
    data() {
        return {
            statusStats: null,
            statusOrders: null,
            statusStatsBach: null,
            statusStatsMaster: null,
            statusStatsAsp: null,
            statusStatsSpo: null,


            loadingStats: null,
            loadingOrders: null,
            loadingStatsBach: null,
            loadingStatsMaster: null,
            loadingStatsAsp: null,
            loadingStatsSpo: null,

        }
    },
    computed: {},
    methods: {
        err_define: function(err_code){
            let ans ='';
            switch(err_code) {
                case '404':
                    ans = '. Не найден route к функции.'
                    break;
                case '405':
                    ans = '. Неверный метод обращения.'
                    break;
                case '419':
                    ans = '. Время авторизованной сессии истекло. Обновите страницу и нажмите кнопку снова.'
                    break;
                case '500':
                    ans = '. Ошибка сервера.'
                    break;
            }
            return ans;
        },
// ------- Удаление файлов статистики
        cleanStats: function () {
            this.loadingStats = true;
            let data = axios.post('/admin/cleansing-stats')
                .then(response => {
                    this.loadingStats = false;
                    this.statusStats = response.data;
                    console.log(response);
                })
                .catch(response => {
                    this.loadingStats = false;
                    let err_code = ' '+response
                    err_code = err_code.substr(-3)
                    let err = this.err_define(err_code)
                    this.statusStats = response + err;
                    console.log(response);
                });
        },
// ------- Удаление файлов приказов
        cleanOrders: function () {
            this.loadingOrders = true;
            let data = axios.post('/admin/cleansing-orders')
                .then(response => {
                    this.loadingOrders = false;
                    this.statusOrders = response.data;
                    console.log(response);
                })
                .catch(response => {
                    this.loadingOrders = false;
                    let err_code = ' '+response
                    err_code = err_code.substr(-3)
                    let err = this.err_define(err_code)
                    this.statusOrders = response + err;
                    console.log(response);
                });
        },
// Очищение таблиц бд со статистикой
// -----Бакалавры
        cleanStatsBach: function () {
            this.loadingStatsBach = true;
            let data = axios.post('/admin/cleansing-statBach')
                .then(response => {
                    this.loadingStatsBach = false;
                    this.statusStatsBach = response.data;
                    console.log(response);
                })
                .catch(response => {
                    this.loadingStatsBach = false;
                    let err_code = ' '+response
                    err_code = err_code.substr(-3)
                    let err = this.err_define(err_code)
                    this.statusStatsBach = response + err;
                    console.log(response);
                });
        },
// -----Магистратура
        cleanStatsMaster: function () {
            this.loadingStatsMaster = true;
            let data = axios.post('/admin/cleansing-statMaster')
                .then(response => {
                    this.loadingStatsMaster = false;
                    this.statusStatsMaster = response.data;
                    console.log(response);
                })
                .catch(response => {
                    this.loadingStatsMaster = false;
                    let err_code = ' '+response
                    err_code = err_code.substr(-3)
                    let err = this.err_define(err_code)
                    this.statusStatsMaster = response + err;
                    console.log(response);
                });
        },
// -----Аспирантура
        cleanStatsAsp: function () {
            this.loadingStatsAsp = true;
            let data = axios.post('/admin/cleansing-statAsp')
                .then(response => {
                    this.loadingStatsAsp = false;
                    this.statusStatsAsp = response.data;
                    console.log(response);
                })
                .catch(response => {
                    this.loadingStatsAsp = false;
                    let err_code = ' '+response
                    err_code = err_code.substr(-3)
                    let err = this.err_define(err_code)
                    this.statusStatsAsp = response + err;
                    console.log(response);
                });
        },
// -----Аспирантура
        cleanStatsSpo: function () {
            this.loadingStatsSpo = true;
            let data = axios.post('/admin/cleansing-statSpo')
                .then(response => {
                    this.loadingStatsSpo = false;
                    this.statusStatsSpo = response.data;
                    console.log(response);
                })
                .catch(response => {
                    this.loadingStatsSpo = false;
                    let err_code = ' '+response
                    err_code = err_code.substr(-3)
                    let err = this.err_define(err_code)
                    this.statusStatsSpo = response + err;
                    console.log(response);
                });
        },
    },
}
</script>
