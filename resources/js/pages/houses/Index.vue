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
                    <input type="text" class="form-control" name="q" placeholder="Поиск по названию">
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputCurrency" class="col-form-label text-nowrap">Валюта:</label>
                    <select name="currency" id="inputCurrency" class="form-select">
                        <option value="" :selected="false">Любая</option>
                        <option v-for="currency in currencies" :value="currency?.id" :selected="false">
                            {{ currency.name }}
                        </option>
                    </select>
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputFloors" class="col-form-label">Этажность:</label>
                    <input type="number" name="floors" id="inputFloors" value="" class="form-control" aria-describedby="floorsHelpInline">
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputBedrooms" class="col-form-label">Спальни:</label>
                    <input type="number" name="bedrooms" id="inputBedrooms" value="" class="form-control" aria-describedby="bedroomsHelpInline">
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputSquare" class="col-form-label">Площадь:</label>
                    <input type="number" name="square" id="inputSqare" value="" class="form-control" aria-describedby="squareHelpInline">
                </div>

                <div class="d-flex col-6 col-lg-2 gap-2">
                    <label for="inputEstateType" class="col-form-label text-nowrap">Тип объекта:</label>
                    <select name="estate_type" id="inputEstateType" class="form-select">
                        <option value="" :selected="false">Любой</option>
                        <option v-for="estateType in estateTypes" :value="estateType.id" :selected="false">
                            {{ estateType.name }}
                        </option>
                    </select>
                </div>

                <div class="d-flex col-6 col-lg-3 gap-2">
                    <label for="inputVillage" class="col-form-label">Посёлок:</label>
                    <select name="village" id="inputVillage" class="form-select">
                        <option value="" :selected="false">Любой</option>
                        <option v-for="village in villages" :value="village.id" :selected="false">
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
    <div v-if="housesToShow" class="row mt-4">
        <div class="col overflow-auto mb-3">
            <table v-if="housesToShow.length" class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="w-20">Фото</th>
                        <th>Название</th>
                        <th>
                            <a v-if="currency" href=""
                               class="sortable">
                                Цена
                            </a>
                            <span v-else>Цена</span>
                        </th>
                        <th>
                            <a href=""
                               class="sortable">
                                Этажность
                            </a>
                        </th>
                        <th>
                            <a href=""
                               class="sortable">
                                Спальни
                            </a>
                        </th>
                        <th>
                            <a href=""
                               class="sortable">
                                Площадь
                            </a>
                        </th>
                        <th>
                            <a href=""
                               class="sortable">
                                Тип объекта
                            </a>
                        </th>
                        <th>
                            <a href=""
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
                                    <img v-if="house.photos?.length" height="100" :src="VITE_APP_URL + house.photos[0].path" alt="">
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
                                    {{ house.default_price }} {{ house.default_currency.name }}
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
<!--    TODO: PAGINATION    -->
<!--        <div class="d-flex justify-content-center">-->
<!--            pagination-->
<!--        </div>-->
    </div>
    <div v-else-if="loading" class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-else class="text-danger">Произошла ошибка! Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import { mapState } from 'vuex';
import HouseService from "@/services/HouseService";
import loader from 'vue-spinner/src/MoonLoader.vue';
export default {
    name: "HousesIndex",
    components: {
        loader
    },
    computed: {
        ...mapState('Main', ['user']),
        getDirectionClassName(){
            if (this.sort.direction === null) {
                return '';
            }
            return this.sort.direction ? 'asc' : 'desc'
        },
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            houses: null,
            housesToShow: null,
            villages: null,
            estateTypes: null,
            currencies: null,
            sort: {
                direction: null,
                param: null,
            },
            loading: true,
        }
    },
    async created() {
        let response = await HouseService.getHouses()
        this.villages = response.villages
        this.estateTypes = response.estate_types
        this.currencies = response.currencies
        this.housesToShow = this.houses = response.houses
        this.loading = false
    },
    methods: {
        sortBy(param, direction) {
            this.housesToShow.sort((cur, next) => {
                return direction ? (cur[param] > next[param]) : (cur[param] < next[param])
            })
            this.sort.direction = direction
        },
        search(form) {
            this.housesToShow = this.houses.filter((item) => {
                return item.name.toLowerCase().includes(form.q.value.toLowerCase())
            })
        },
        async deleteHouse(id) {
            await HouseService.deleteHouse(id)
            this.housesToShow = this.houses = this.houses.filter((item) => item.id !== id)
        }
    },

}
</script>

<style scoped>

</style>
