<template>
    <a @click.prevent="$router.go(-1)"
       class="text-decoration-none d-flex align-items-center gap-1 mt-3"
       href="">
        <i class="fa-solid fa-chevron-left"></i> Назад
    </a>
    <div class="row mt-3">
        <div class="col">
            <h1>Редактирование посёлка</h1>
        </div>
    </div>
    <div v-if="village" class="row mt-3">
        <div class="col-md-7">
            <form @submit.prevent="updateVillage($event.target)"
                  method="post"
                  action=""
                  class="row g-3"
                  enctype="multipart/form-data">

                <div class="form-group">
                    <label for="village-name">Название:</label>
                    <input :value="village.name"
                           type="text"
                           class="form-control"
                           id="village-name"
                           required
                           name="name"
                           placeholder="Вятское">
                </div>

                <div class="form-group">
                    <label for="village-address">Адрес:</label>
                    <input :value="village.address"
                           type="text"
                           class="form-control"
                           id="village-address"
                           required name="address"
                           placeholder="Ярославская обл.">
                </div>

                <div class="form-group">
                    <label for="village-square" class="form-label">Площадь поселка (гектар):</label>
                    <input :value="village.square"
                           type="number"
                           class="form-control"
                           id="village-square"
                           name="square"
                           placeholder="50">
                </div>

                <div class="form-group">
                    <label for="village-phone">Горячая линия (телефон):</label>
                    <input :value="village.phone"
                           type="tel"
                           class="form-control"
                           pattern="[0-9]+"
                           id="village-phone"
                           name="phone"
                           placeholder="79999999999">
                </div>

                <div class="form-group">
                    <label for="village-youtube">YouTube видео:</label>
                    <input :value="village.youtube_link"
                           type="tel"
                           class="form-control"
                           id="village-youtube"
                           name="youtube_link"
                           placeholder="Ссылка на видео">
                </div>

                <div class="form-group">
                    <label for="village-photo">Фотография:</label>
                    <input type="file"
                           class="form-control"
                           id="village-photo"
                           name="photo"
                           accept=".jpg,.jpeg,.png">
                </div>

                <div class="form-group">
                    <label for="village-presentation">Файл презентации (pdf):</label>
                    <input type="file"
                           class="form-control"
                           id="village-presentation"
                           name="presentation"
                           accept=".pdf">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Сохранить</button>
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
import VillageService from "@/services/VillageService";
import loader from 'vue-spinner/src/MoonLoader.vue';
export default {
    name: "VillagesEdit",
    components: {
        loader,
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            village: null,
            loading: true,
        }
    },
    async mounted() {
        let res = await VillageService.editVillage(this.$route.params.village)
        this.village = res.data
        this.loading = false
    },
    methods: {
        async updateVillage(form) {
            await VillageService.updateVillage(this.village.id, new FormData(form))
            form.reset()
            this.$router.push({ name: 'villages.index' })
        }
    }
}
</script>

<style scoped>

</style>
