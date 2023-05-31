<template>
    <div class="row">
        <div class="col">
            <h1>Дома</h1>
        </div>
        <div v-if="user?.permissions?.some(p => p.name === 'house.create')" class="col text-end">
            <router-link class="btn btn-primary" :to="{ name: 'houses.create' }">
                Добавить
            </router-link>
        </div>
    </div>
    <div class="row mt-2">
        <div class="w-auto">
            <form @submit.prevent="search($event.target)" action="" class="row row-cols-lg-auto g-3">
                <div class="col w-25">
                    <input :value="params.name"
                           type="text"
                           class="form-control"
                           name="name"
                           placeholder="Поиск по названию">
                </div>

                <div v-if="prices.min !== null && prices.max !== null"
                     class="d-flex col-6 col-lg-2 align-items-center">
                    <span class="me-3">Цена:</span>
                    <vue-slider v-model="prices.values"
                                :min="prices.min"
                                :max="prices.max"
                                :interval="1000"
                                class="flex-grow-1 me-2"></vue-slider>
                </div>

                <div class="d-flex col-6 col-lg-3 col-xl-2 gap-2">
                    <label for="inputCurrency" class="col-form-label text-nowrap">Валюта:</label>
                    <select name="currency" id="inputCurrency" class="form-select">
                        <option value="" :selected="false">Любая</option>
                        <option v-for="currency in currencies"
                                :value="currency?.id"
                                :selected="currency.id === +params.currency">
                            {{ currency.name }}
                        </option>
                    </select>
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputFloors" class="col-form-label">Этажность:</label>
                    <input :value="params.floors"
                           type="number"
                           name="floors"
                           id="inputFloors"
                           value=""
                           class="form-control"
                           aria-describedby="floorsHelpInline">
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputBedrooms" class="col-form-label">Спальни:</label>
                    <input :value="params.bedrooms"
                            type="number"
                           name="bedrooms"
                           id="inputBedrooms"
                           class="form-control"
                           aria-describedby="bedroomsHelpInline">
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputSquare" class="col-form-label">Площадь:</label>
                    <input :value="params.square"
                           type="number"
                           name="square"
                           id="inputSqare"
                           class="form-control"
                           aria-describedby="squareHelpInline">
                </div>

                <div class="d-flex col-6 col-lg-3 col-xxl-2 gap-2">
                    <label for="inputEstateType" class="col-form-label text-nowrap">Тип объекта:</label>
                    <select name="estate_type" id="inputEstateType" class="form-select">
                        <option value="">Любой</option>
                        <option v-for="estateType in estateTypes"
                                :value="estateType.id"
                                :selected="estateType.id === +params.estate_type">
                            {{ estateType.name }}
                        </option>
                    </select>
                </div>

                <div class="d-flex col-6 col-lg-3 gap-2">
                    <label for="inputVillage" class="col-form-label">Посёлок:</label>
                    <select name="village" id="inputVillage" class="form-select">
                        <option value="">Любой</option>
                        <option v-for="village in villages"
                                :value="village.id"
                                :selected="village.id === +params.village">
                            {{ village.name }}
                        </option>
                    </select>
                </div>

                <div class="col">
                    <input type="submit" class="btn btn-primary" value="Найти">
                </div>
            </form>
        </div>
    </div>
    <div v-if="loading"  class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <div v-else class="row mt-4">
        <div class="col overflow-auto mb-3">
            <table v-if="houses.length" class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="w-20">Фото</th>
                        <th>Название</th>
                        <th>
                            <a v-if="params.currency"
                               @click.prevent="sort('price')"
                               :class="(params.order_by === 'price') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Цена
                            </a>
                            <span v-else>Цена</span>
                        </th>
                        <th>
                            <a @click.prevent="sort('floors')"
                               :class="(params.order_by === 'floors') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Этажность
                            </a>
                        </th>
                        <th>
                            <a @click.prevent="sort('bedrooms')"
                               :class="(params.order_by === 'bedrooms') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Спальни
                            </a>
                        </th>
                        <th>
                            <a @click.prevent="sort('square')"
                               :class="(params.order_by === 'square') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Площадь
                            </a>
                        </th>
                        <th>
                            <a @click.prevent="sort('estate_type')"
                               :class="(params.order_by === 'estate_type') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Тип объекта
                            </a>
                        </th>
                        <th>
                            <a @click.prevent="sort('village')"
                               :class="(params.order_by === 'village') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Посёлок
                            </a>
                        </th>
                        <th v-if="user?.roles?.some(r => r.name === 'admin')">Управление</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="house in houses" class="align-middle position-relative">
                        <td>
                            <div class="house-image show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    <img v-if="house.photos?.length"
                                         :src="VITE_APP_URL + house.photos[0].path"
                                         alt=""
                                         height="100">
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.name }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.default_price.val }} {{ house.default_price.currency_name }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.floors }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.bedrooms }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.square }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.estate_type.name }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'houses.show', params: { house: house.id } }">
                                    {{ house.village.name }}
                                </router-link>
                            </div>
                        </td>
                        <td v-if="user?.roles?.some(r => r.name === 'admin')">
                            <div class="p-2 d-flex gap-2">
                                <router-link class="btn btn-primary"
                                             :to="{ name: 'houses.edit', params: { house: house.id } }">
                                    <i class="fa-solid fa-pencil"></i>
                                </router-link>
                                <a @click.prevent="deleteHouse(house.id)" class="btn btn-danger" href="">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="fw-bold">Не найдено.</p>
        </div>

        <pagination @paginate="paginate" :info="pagination"></pagination>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import HouseService from "@/services/HouseService";
import loader from 'vue-spinner/src/MoonLoader.vue';
import Pagination from "@/components/Pagination.vue";
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';
export default {
    name: "HousesIndex",
    components: {
        loader,
        Pagination,
        VueSlider,
    },
    computed: {
        ...mapState('Main', ['user']),
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            houses: [],
            villages: [],
            estateTypes: [],
            currencies: [],
            prices: {
                max: null,
                min: null,
                values: [],
            },
            params: {
                name: null,
                currency: null,
                price_min: null,
                price_max: null,
                floors: null,
                bedrooms: null,
                square: null,
                estate_type: null,
                village: null,
                order_by: null,
                order_dir: null,
                page: null,
            },
            pagination: [],
            loading: true,
        }
    },
    async created() {
        const urlParams = new URLSearchParams(window.location.search)
        this.params = {
            name: urlParams.get('name'),
            price_min: urlParams.get('price_min'),
            price_max: urlParams.get('price_max'),
            currency: urlParams.get('currency'),
            floors: urlParams.get('floors'),
            bedrooms: urlParams.get('bedrooms'),
            square: urlParams.get('square'),
            estate_type: urlParams.get('estate_type'),
            village: urlParams.get('village'),
            order_by: urlParams.get('order_by'),
            order_dir: urlParams.get('order_dir'),
            page: urlParams.get('page'),
        }
        this.prices.values = [this.params.price_min, this.params.price_max]
        let res = await HouseService.getFilterAdditionalResources()
        this.villages = res.villages
        this.estateTypes = res.estate_types
        this.currencies = res.currencies
        this.prices.min = Math.floor(res.prices[0] / 1000) * 1000
        this.prices.max = Math.ceil(res.prices[1] / 1000) * 1000
        if (!this.prices.values[0]) {
            this.prices.values[0] = this.prices.min
        }
        if (!this.prices.values[1]) {
            this.prices.values[1] = this.prices.max
        }
        this.filter()
    },
    methods: {
        search(form) {
            this.params = {
                name: form.name.value,
                currency: form.currency.value,
                floors: form.floors.value,
                bedrooms: form.bedrooms.value,
                square: form.square.value,
                estate_type: form.estate_type.value,
                village: form.village.value,
                price_min: this.prices.values[0],
                price_max: this.prices.values[1],
            }
            this.filter()
        },
        sort(field) {
            if (this.params.order_by !== field) {
                this.params.order_by = field
                this.params.order_dir = 'asc'
            } else {
                if (this.params.order_dir === 'asc') {
                    this.params.order_dir = 'desc'
                } else {
                    this.params.order_dir = 'asc'
                }
            }
            this.filter()
        },
        paginate(page) {
            this.params.page = page
            this.filter()
        },
        async deleteHouse(id) {
            await HouseService.deleteHouse(id)
            this.filter()
        },
        async filter() {
            this.loading = true
            let filledParams = Object.fromEntries(
                Object.entries(this.params).filter(([_, v]) => v !== null && v !== '')
            )
            if (filledParams.price_min === this.prices.min && filledParams.price_max === this.prices.max) {
                delete filledParams.price_min;
                delete filledParams.price_max;
            }
            this.$router.push({ query: { ...filledParams } })

            let res = await HouseService.filterHouses(filledParams)
            this.houses = res.data
            this.pagination = res.meta
            this.loading = false
        },
    },

}
</script>

<style scoped>

</style>
