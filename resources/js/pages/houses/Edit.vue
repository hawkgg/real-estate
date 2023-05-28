<template>
    <a class="text-decoration-none d-flex align-items-center gap-1 mt-3"
       href=""
       @click.prevent="$router.go(-1)">
        <i class="fa-solid fa-chevron-left"></i> Назад
    </a>
    <div class="row mt-4">
        <div class="col">
            <h1>Редактирование дома</h1>
        </div>
    </div>
    <div v-if="house" class="row mt-3">
        <div class="col-md-7">
            <form @submit.prevent="updateHouse($event.target)" method="post" action="" class="row g-3" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="house-name">Название:</label>
                    <input type="text" class="form-control" id="house-name" required name="name" :value="house.name" placeholder="Колотушкина">
                </div>

                <div class="form-group d-flex gap-3 col-md-7">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="house-price">Цена:</label>
                            <input type="number" class="form-control" min="0" id="house-price" required name="price" :value="house.default_price">
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="form-group">
                            <label for="house-currency">Валюта:</label>
                            <select name="currency" id="house-currency" class="form-select">
                                <option v-for="currency in currencies" :value="currency.id" :selected="false">
                                    {{ currency.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="house-floors">Этажность:</label>
                    <input type="number" class="form-control" id="house-floors" min="0" required name="floors" :value="house.floors" placeholder="10">
                </div>

                <div class="form-group">
                    <label for="house-bedrooms">Спальни:</label>
                    <input type="number" class="form-control" id="house-bedrooms" min="0" required name="bedrooms" :value="house.bedrooms" placeholder="3">
                </div>

                <div class="form-group">
                    <label for="house-square" class="form-label">Площадь: {{ squareVal }}</label>
                    <input type="range" class="form-range" id="house-square" name="square" v-model="squareVal">
                </div>

                <div class="form-group">
                    <label for="house-estate-type">Тип объекта:</label>
                    <select name="estate_type" id="house-estate-type" class="form-select">
                        <option v-for="estateType in estateTypes" :value="estateType.id" :selected="false">
                            {{ estateType.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="house-village">Посёлок:</label>
                    <select name="village" id="house-village" class="form-select">
                        <option v-for="village in villages" :value="village.id" :selected="false">
                            {{ village.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="house-photos">Фотографии:</label>
                    <input type="file" class="form-control" id="house-photos" name="photos[]" multiple accept=".jpg,.jpeg,.png">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
    <div v-else-if="loading" class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-else class="text-danger">Произошла ошибка! Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import HouseService from "@/services/HouseService";
import loader from 'vue-spinner/src/MoonLoader.vue';
export default {
    name: "HousesEdit",
    components: {
        loader,
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            house: null,
            squareVal: 50,
            loading: true,
            villages: null,
            estateTypes:  null,
            currencies: null,
        }
    },
    async mounted() {
        let response = await HouseService.editHouse(this.$route.params.house)
        this.villages = response.villages
        this.estateTypes = response.estate_types
        this.currencies = response.currencies
        this.house = response.house
        this.squareVal = this.house.square
        this.loading = false
    },
    methods: {
        async updateHouse(form) {
            await HouseService.updateHouse(this.house.id, new FormData(form))
            this.$router.push({ name: 'houses.index' })
        }
    }
}
</script>

<style scoped>

</style>
