<template>
    <div v-if="village" class="container">
        <router-link class="text-decoration-none d-flex align-items-center gap-1"
                     :to="{ name: 'villages.index' }">
            <i class="fa-solid fa-chevron-left"></i> Назад
        </router-link>
        <div class="row mt-4">
            <div class="col">
                <h1>Редактирование посёлка</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-7">
                <form @submit.prevent="updateVillage($event.target)" method="post" action="" class="row g-3" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="village-name">Название:</label>
                        <input type="text" class="form-control" id="village-name" required name="name" :value="village.name" placeholder="Вятское">
                    </div>

                    <div class="form-group">
                        <label for="village-address">Адрес:</label>
                        <input type="text" class="form-control" id="village-address" required name="address" :value="village.address" placeholder="Ярославская обл.">
                    </div>

                    <div class="form-group">
                        <label for="village-square" class="form-label">Площадь поселка (гектар): {{ squareVal }}</label>
                        <input type="range" class="form-range" id="village-square" name="square" v-model="squareVal">
                    </div>

                    <div class="form-group">
                        <label for="village-phone">Горячая линия (телефон):</label>
                        <input type="tel" class="form-control" pattern="[0-9]+" id="village-phone" name="phone" :value="village.phone" placeholder="79999999999">
                    </div>

                    <div class="form-group">
                        <label for="village-youtube">YouTube видео:</label>
                        <input type="tel" class="form-control" id="village-youtube" name="youtube_link" :value="village.youtube_link" placeholder="Ссылка на видео">
                    </div>

                    <div class="form-group">
                        <label for="village-photo">Фотография:</label>
                        <input type="file" class="form-control" id="village-photo" name="photo" accept=".jpg,.jpeg,.png">
                    </div>

                    <div class="form-group">
                        <label for="village-presentation">Файл презентации (pdf):</label>
                        <input type="file" class="form-control" id="village-presentation" name="presentation" accept=".pdf">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div v-else class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-if="!loading && !village" class="text-danger">Произошла ошибка! Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import VillageService from "@/services/VillageService";
import loader from 'vue-spinner/src/MoonLoader.vue'
export default {
    name: "VillagesEdit",
    components: {
        loader,
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            village: null,
            squareVal: null,
            loading: true,
        }
    },
    async mounted() {
        this.village = await VillageService.editVillage(this.$route.params.village)
        this.squareVal = this.village.square
        this.loading = false
    },
    methods: {
        async updateVillage(form) {
            await VillageService.updateVillage(this.village.id, new FormData(form))
            this.$router.push({ name: 'villages.index' })
        }
    }
}
</script>

<style scoped>

</style>
