<template>
    <div v-if="village" class="container">
        <div class="row">
            <div class="col d-flex justify-content-between flex-nowrap">
                <router-link class="text-decoration-none d-flex align-items-center gap-1"
                             :to="{ name: 'villages.index' }">
                    <i class="fa-solid fa-chevron-left"></i> Назад
                </router-link>
                <td>
                    <div class="p-2 d-flex gap-2">
                        <router-link  v-if="user?.permissions.some(p => p.name === 'village.edit')"
                                     :to="{ name: 'villages.edit', params: { village: village.id } }"
                                      class="btn btn-primary">
                            <i class="fa-solid fa-pencil me-1"></i> Редактировать
                        </router-link>

                        <a v-if="user?.permissions.some(p => p.name === 'village.delete')"
                           @click.prevent="deleteVillage(village.id)"
                           class="btn btn-danger"
                           href="">
                            <i class="fa-solid fa-trash"></i> Удалить
                        </a>
                    </div>
                </td>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-4">
                <img v-if="village.photo" class="w-100" :src="VITE_APP_URL + village.photo.path" alt="">
                <h3 v-else>Фото отсутствует</h3>
            </div>
            <div class="col-xl-8 px-xl-3">
                <p class="mb-2"><b>Название</b>: {{ village.name }}</p>
                <p class="my-2"><b>Адрес</b>: {{ village.address }}</p>
                <p class="my-2"><b>Площадь поселка (гектар)</b>: {{ village.square ?? '–' }}</p>
                <p class="my-2"><b>Горячая линия (телефон)</b>: {{ village.phone ?? '–' }}</p>
                <p class="my-2"><b>YouTube видео</b>:
                    <a v-if="village.youtube_link" target="_blank" :href="village.youtube_link">
                        {{ village.youtube_link }}
                    </a>
                    <span v-else>–</span>
                </p>

                <p v-if="village.presentation" class="my-2">
                    <b>Файл презентации (pdf)</b>:
                    <a :href="village.presentation.path"
                       target="_blank"
                       class="text-decoration-none">
                        {{ village.presentation.path }}
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div v-else class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-if="!loading && !village" class="text-danger">Произошла ошибка! Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import { mapState } from 'vuex';
import VillageService from "@/services/VillageService";
import loader from 'vue-spinner/src/MoonLoader.vue'
export default {
    name: "VillagesShow",
    components: {
        loader
    },
    computed: {
        ...mapState('Main', ['user']),
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            village: null,
            loading: true,
        }
    },
    async created() {
        this.village = await VillageService.getVillage(this.$route.params.village)
        this.loading = false
    },
    methods: {
        async deleteVillage(id) {
            await VillageService.deleteVillage(id)
            this.$router.push({ name: 'villages.index' })
        }
    },

}
</script>

<style scoped>

</style>
