<template>
    <router-link class="text-decoration-none d-flex align-items-center gap-1"
                 :to="{ name: 'houses.index' }">
        <i class="fa-solid fa-chevron-left"></i> Назад
    </router-link>
    <div class="row mt-4">
        <div class="col">
            <h1>Добавление дома</h1>
        </div>
    </div>
    <div v-if="villages && estateTypes && currencies" class="row mt-3">
        <div class="col-md-7">
            <form @submit.prevent="storeHouse($event.target)"
                  method="post"
                  action=""
                  class="row g-3"
                  enctype="multipart/form-data">

                <div class="form-group">
                    <label for="house-name">Название:</label>
                    <input type="text"
                           class="form-control"
                           id="house-name"
                           required
                           name="name"
                           placeholder="Колотушкина">
                </div>

                <div class="form-group d-flex gap-3 col-md-7">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="house-address">Цена:</label>
                            <input type="number"
                                   class="form-control"
                                   id="house-address"
                                   min="0"
                                   required
                                   name="price"
                                   placeholder="5000000">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label for="house-currency">Валюта:</label>
                            <select name="currency" id="house-currency" class="form-select">
                                <option v-for="currency in currencies" :value="currency.id">
                                    {{ currency.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="house-name">Этажность:</label>
                    <input type="number"
                           class="form-control"
                           id="house-floors"
                           min="0"
                           required
                           name="floors"
                           placeholder="10">
                </div>

                <div class="form-group">
                    <label for="house-name">Спальни:</label>
                    <input type="number"
                           class="form-control"
                           id="house-bedrooms"
                           min="0"
                           required
                           name="bedrooms"
                           placeholder="3">
                </div>

                <div class="form-group">
                    <label for="house-square" class="form-label">Площадь:</label>
                    <input type="number"
                           class="form-control"
                           id="house-square"
                           name="square"
                           placeholder="50">
                </div>

                <div class="form-group">
                    <label for="house-currency">Тип объекта:</label>
                    <select name="estate_type" id="house-estate-type" class="form-select">
                        <option v-for="estateType in estateTypes" :value="estateType.id">
                            {{ estateType.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="house-village">Посёлок:</label>
                    <select name="village" id="house-village" class="form-select">
                        <option v-for="village in villages" :value="village.id">
                            {{ village.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="house-photo">Фотографии:</label>
                    <input type="file"
                           class="form-control"
                           id="house-photo"
                           name="photos[]"
                           multiple accept=".jpg,.jpeg,.png">
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
    <p v-else class="mt-5 text-danger">Произошла ошибка. Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import HouseService from "@/services/HouseService";
import loader from 'vue-spinner/src/MoonLoader.vue';

export default {
    name: "HousesCreate",
    data() {
        return {
            loading: true,
            villages: null,
            estateTypes:  null,
            currencies: null,
        }
    },
    components: {
        loader
    },
    async created() {
        let res = await HouseService.createHouse()
        this.villages = res.villages
        this.estateTypes = res.estate_types
        this.currencies = res.currencies
        this.loading = false
    },
    methods: {
        async storeHouse(form) {
            await HouseService.storeHouse(new FormData(form))
            form.reset()
            this.$router.push({ name: 'houses.index' })
        }
    }
}
</script>

<style scoped>

</style>
