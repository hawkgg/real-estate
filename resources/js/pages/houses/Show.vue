<template>
    <template v-if="house">
        <div class="row">
            <div class="col d-flex justify-content-between flex-nowrap">
                <router-link class="text-decoration-none d-flex align-items-center gap-1 py-3"
                             :to="{ name: 'houses.index' }">
                    <i class="fa-solid fa-chevron-left"></i> Назад
                </router-link>
                <div class="d-flex gap-2 align-items-center">
                    <router-link  v-if="user?.permissions.some(p => p.name === 'house.edit')"
                                 :to="{ name: 'houses.edit', params: { house: house.id } }"
                                  class="btn btn-primary">
                        <i class="fa-solid fa-pencil me-1"></i> Редактировать
                    </router-link>

                    <a v-if="user?.permissions.some(p => p.name === 'house.delete')"
                       @click.prevent="deleteHouse(house.id)"
                       class="btn btn-danger"
                       href="">
                        <i class="fa-solid fa-trash"></i> Удалить
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <swiper v-if="house?.photos?.length"
                    :modules="modules"
                    :slides-per-view="1"
                    :space-between="10"
                    :pagination="{ clickable: true }">
                    <swiper-slide v-for="photo in house.photos">
                        <img class="w-100" :src="VITE_APP_URL + photo.path">
                    </swiper-slide>
                </swiper>
                <h3 v-else>Фото отсутствует</h3>
            </div>
            <div class="col-xl-8 px-xl-3">
                <p class="mb-2"><b>Название</b>: {{ house.name }}</p>
                <p class="my-2">
                    <b>Цена</b>: {{ house.default_price.val }} {{ house.default_price.currency_name }}
                    <span v-if="house.other_prices.length">
                        ({{ house.other_prices.map(p => Math.floor(p.val / 10) * 10 + ' ' + p.currency_name).join(', ') }})
                    </span>
                </p>
                <p class="my-2"><b>Этажность</b>: {{ house.floors ?? '–' }}</p>
                <p class="my-2"><b>Спальни</b>: {{ house.bedrooms ?? '–' }}</p>
                <p class="my-2"><b>Площадь</b>: {{ house.square ?? '–' }}</p>
                <p class="my-2"><b>Тип объекта</b>: {{ house.estate_type.name.toLowerCase() }}</p>
                <p class="my-2"><b>Посёлок</b>: {{ house.village.name }}</p>
            </div>
        </div>
    </template>
    <div v-else class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-if="!loading && !house" class="mt-5 text-danger">Произошла ошибка. Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import { mapState } from 'vuex';
import HouseService from "@/services/HouseService";
import loader from 'vue-spinner/src/MoonLoader.vue';
import { Pagination } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/scss';
import 'swiper/scss/pagination';

export default {
    name: "HousesShow",
    components: {
        loader,
        Swiper,
        SwiperSlide,
    },
    computed: {
        ...mapState('Main', ['user']),
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            house: null,
            loading: true,
        }
    },
    async created() {
        let res = await HouseService.getHouse(this.$route.params.house)
        this.house = res.data
        this.loading = false
        if (!this.house) {
            this.$router.push({ name: 'NotFound' })
        }
    },
    methods: {
        async deleteHouse(id) {
            await HouseService.deleteHouse(id)
            this.$router.push({ name: 'houses.index' })
        }
    },
    setup() {
        return {
            modules: [Pagination],
        };
    },
}
</script>

<style scoped>

</style>
