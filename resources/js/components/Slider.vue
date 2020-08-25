<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <form @submit.prevent="!isSlideUpdate? addSlide() : updateSlide()" class="col-12 p-0"
                      enctype="multipart/form-data" id="slideForm">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><p class="m-0">Создание/редактирование слайда</p></div>
                                <div class="col-6 text-right">
                                    <button type="button" onclick="$('#slideForm').hide()" class="close"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <b-tabs content-class="mt-3">
                                        <b-tab title="Основные" active>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="badge">Название слайда</label>
                                                    <input v-model="slide.name" type="text"
                                                           class="form-control form-control-sm" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="badge">Превью слайда</label>
                                                    <b-form-file v-model="slide.image"
                                                                 accept="image/*"
                                                                 placeholder="Выберите файл изображения"
                                                                 drop-placeholder="Перенесите сюда изображение"
                                                                 browse-text='Oбзор'
                                                                 @change="getPreview"
                                                    ></b-form-file>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="badge">Ссылка</label>
                                                    <input v-model="slide.url" type="text"
                                                           class="form-control form-control-sm">
                                                </div>

                                                <div class="col-6">
                                                    <img :src="previewUrl" width="320"  alt=""
                                                         v-show="previewUrl" class="d-block m-auto">

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="badge">Приоритет</label>
                                                    <input v-model="slide.priority" type="text"
                                                           class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="form-check" id="foreigner">
                                                <input v-model="slide.foreigner" type="checkbox">
                                                <label>Для английской версии</label>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Активность">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="badge">Активность слайда</label>
                                                    <div class="form-check">
                                                        <input v-model="slide.activity" type="checkbox">
                                                        <label>Активность</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="badge">Дата начала активности</label>
                                                        <input class="form-control form-control-sm"
                                                               v-model="slide.activityFrom"
                                                               type="date">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="badge">Дата конца активности</label>
                                                        <input class="form-control form-control-sm"
                                                               v-model="slide.activityTo"
                                                               type="date">
                                                    </div>
                                                </div>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Версия для телефона и планшета">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="badge">Превью слайда для телефона</label>
                                                    <b-form-file v-model="slide.image_mobile"
                                                                 accept="image/*"
                                                                 placeholder="Выберите файл изображения"
                                                                 drop-placeholder="Перенесите сюда изображение"
                                                                 browse-text='Oбзор'
                                                                 @change="getPreview_m"
                                                    ></b-form-file>
                                                    <div class="col-12">
                                                        <img :src="previewUrl_m" width="" height="185" alt=""
                                                             v-show="previewUrl_m" class="d-block m-auto">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="badge">Превью слайда для планшета</label>
                                                    <b-form-file v-model="slide.image_ipad"
                                                                 accept="image/*"
                                                                 placeholder="Выберите файл изображения"
                                                                 drop-placeholder="Перенесите сюда изображение"
                                                                 browse-text='Oбзор'
                                                                 @change="getPreview_i"
                                                    ></b-form-file>
                                                    <div class="col-12">
                                                        <img :src="previewUrl_i" width="320" height="" alt=""
                                                             v-show="previewUrl_i" class="d-block m-auto">
                                                    </div>
                                                </div>

                                            </div>
                                        </b-tab>
                                    </b-tabs>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <button v-show="!isSlideUpdate" class="btn col-12 btn-primary"
                                            type="submit">
                                        Создать
                                    </button>
                                    <button v-show="isSlideUpdate" class="btn col-12 btn-success"
                                            type="submit">
                                        Сохранить изменения
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-light col-12" type="button" @click="clearCurrentSlide">
                                        Очистить
                                        форму
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <p class="m-0">Слайды</p>
                            </div>
                            <div class="col-6">
                                <button class="float-right btn btn-sm btn-info" onclick="$('#slideForm').show()">
                                    Добавить
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-info font-weight-bold mb-2">Для версии на русском языке</div>
                        <div class="row">
                            <div class="col-3 mb-2" v-for="(slide, index) in slides" v-show="!slide.foreigner">
                                <div class="card infoblock-сard-text" >
                                    <div class="card-header">
                                        <p class="m-0"><strong>{{slide.name}}</strong></p>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <label class="badge m-0">Предпросмотр изображения</label>
                                            <img class="w-100"
                                                 :src="'../../../storage/slider/' + slide.image" alt="">
                                        </div>
                                        <div>
                                            <label class="badge m-0">Ссылка</label>
                                            <p class="ml-2 mb-1">{{slide.url}}</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Приоритет</label>
                                            <p class="ml-2 mb-1">{{slide.priority}}</p>
                                        </div>

                                        <div>
                                            <label class="badge m-0">Активность (от / до)</label>
                                            <p class="ml-2 mb-1">
                                                <span class="ml-2 mb-1" v-if="slide.activity">Да </span>
                                                <span class="ml-2 mb-1" v-else>Нет </span>
                                                (
                                                <span v-if="slide.activityFrom">{{slide.activityFrom | formatDate}}</span>
                                                <span v-else>-</span>
                                                /
                                                <span v-if="slide.activityTo">{{slide.activityTo | formatDate}}</span>
                                                <span v-else>-</span>
                                                )
                                            </p>
                                        </div>
                                        <div v-if="slide.foreigner">
                                            <span class="m-0">Для английской версии</span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-sm btn-dark col-12"
                                                        @click="changeSlide(slide)">
                                                    Изменить
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class='btn btn-sm col-12'
                                                        @click="removeSlide(slide.id,slide)">Удалить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-info font-weight-bold mb-2 mt-3">Для версии на английском языке</div>
                        <div class="row">
                            <div class="col-3 mb-2" v-for="(slide, index) in slides" v-show="slide.foreigner">
                                <div class="card infoblock-сard-text " >
                                    <div class="card-header">
                                        <p class="m-0"><strong>{{slide.name}}</strong></p>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <label class="badge m-0">Предпросмотр изображения</label>
                                            <img class="w-100"
                                                 :src="'../../../storage/slider/' + slide.image" alt="">
                                        </div>
                                        <div>
                                            <label class="badge m-0">Ссылка</label>
                                            <p class="ml-2 mb-1">{{slide.url}}</p>
                                        </div>
                                        <div>
                                            <label class="badge m-0">Приоритет</label>
                                            <p class="ml-2 mb-1">{{slide.priority}}</p>
                                        </div>

                                        <div>
                                            <label class="badge m-0">Активность (от / до)</label>
                                            <p class="ml-2 mb-1">
                                                <span class="ml-2 mb-1" v-if="slide.activity">Да </span>
                                                <span class="ml-2 mb-1" v-else>Нет </span>
                                                (
                                                <span v-if="slide.activityFrom">{{slide.activityFrom | formatDate}}</span>
                                                <span v-else>-</span>
                                                /
                                                <span v-if="slide.activityTo">{{slide.activityTo | formatDate}}</span>
                                                <span v-else>-</span>
                                                )
                                            </p>
                                        </div>
                                        <div v-if="slide.foreigner">
                                            <span class="badge m-0">Для английской версии</span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-sm btn-dark col-12"
                                                        @click="changeSlide(slide)">
                                                    Изменить
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class='btn btn-sm col-12'
                                                        @click="removeSlide(slide.id,slide)">Удалить
                                                </button>
                                            </div>
                                        </div>
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
        name: 'Slide',
        data() {
            return {
                slide: {
                    name: null,
                    url: null,
                    priority: 500,
                    activity: true,
                    activityFrom: '',
                    activityTo: '',
                    image: null,
                    image_mobile: null,
                    image_ipad: null,
                    foreigner: false
                },
                isSlideUpdate: false,
                currentSlide: {},
                errorImage: '',
                previewUrl: '../../storage/slider/default.jpg',
                previewUrl_m: '../../storage/slider/default_mobile.jpg',
                previewUrl_i: '../../storage/slider/default_ipad.jpg',
                formStatus: false
            }
        },


        mounted() {
            this.currentSlide = {...this.slide}
            this.$store.dispatch('GET_SLIDES')
            $('#slideForm').hide()
        },

        computed: {

            slides() {
                return this.$store.getters.SLIDES
            }

        },

        methods: {

            //

            checkForm(e) {
                if (this.slide.name && this.slide.priority) {
                    this.formStatus = 'Не все обязательные поля заполнены'
                } else {
                    !this.isBlockUpdate ? this.addSlide() : this.updateSlide()
                }
            },

            getPreview(e) {
                let file = e.target.files[0];
                this.previewUrl = URL.createObjectURL(file)
            },
            getPreview_m(e) {
                let file1 = e.target.files[0];
                this.previewUrl_m = URL.createObjectURL(file1)
            },
            getPreview_i(e) {
                let file2 = e.target.files[0];
                this.previewUrl_i= URL.createObjectURL(file2)
            },


            addSlide() {
                this.isSlideUpdate = false;
                this.$store.dispatch('SAVE_SLIDE', this.slide);
                this.clearCurrentSlide();

            },

            changeSlide(slide) {
                this.slide = slide
                this.previewUrl = '../../storage/slider/' + this.slide.image
                this.previewUrl_m = '../../storage/slider/' + this.slide.image_mobile
                this.previewUrl_i= '../../storage/slider/' + this.slide.image_ipad
                this.isSlideUpdate = true
                $('#slideForm').show()
            },

            updateSlide() {
                this.$store.dispatch('UPDATE_SLIDE', this.slide);
                this.isSlideUpdate = false
                this.clearCurrentSlide()

            },

            removeSlide(id, index) {
                this.$store.dispatch('DELETE_SLIDE', id, index)
            },

            clearCurrentSlide() {
                this.isSlideUpdate = false
                this.slide = {...this.currentSlide}
                this.previewUrl = '../../storage/slider/default.jpg'
                this.previewUrl_m = '../../storage/slider/default_mobile.jpg'
                this.previewUrl_i= '../../storage/slider/default_ipad.jpg'
            }

        }
    }
</script>

<style scoped>
    .badge {
        color: gray;
        margin: 0;
    }

    .slide-сard-text p > span {
        font-size: 14px;
    }
</style>
