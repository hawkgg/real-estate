<template>
    <router-link class="text-decoration-none d-flex align-items-center gap-1"
                 :to="{ name: 'villages.index' }">
        <i class="fa-solid fa-chevron-left"></i> Назад
    </router-link>
    <div class="row mt-4">
        <div class="col">
            <h1>Добавление посёлка</h1>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-7">
            <form @submit.prevent="storeVillage($event.target)"
                  method="post"
                  action=""
                  class="row g-3"
                  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="village-name">Название:</label>
                    <input type="text"
                           class="form-control"
                           id="village-name"
                           required
                           name="name"
                           placeholder="Вятское">
                </div>

                <div class="form-group">
                    <label for="village-address">Адрес:</label>
                    <input type="text"
                           class="form-control"
                           id="village-address"
                           required
                           name="address"
                           placeholder="Ярославская обл.">
                </div>

                <div class="form-group">
                    <label for="village-square" class="form-label">Площадь поселка (гектар):</label>
                    <input type="number"
                           class="form-control"
                           id="village-square"
                           name="square"
                           placeholder="50">
                </div>

                <div class="form-group">
                    <label for="village-phone">Горячая линия (телефон):</label>
                    <input type="tel"
                           class="form-control"
                           pattern="[0-9]+"
                           id="village-phone"
                           name="phone"
                           placeholder="79999999999">
                </div>

                <div class="form-group">
                    <label for="village-youtube">YouTube видео:</label>
                    <input type="tel"
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
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import VillageService from "@/services/VillageService";

export default {
    name: "VillagesCreate",
    methods: {
        async storeVillage(form) {
            await VillageService.storeVillage(new FormData(form))
            form.reset()
            this.$router.push({ name: 'villages.index' })
        }
    }
}
</script>

<style scoped>

</style>
