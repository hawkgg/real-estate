<template>
    <div class="row">
        <div class="col">
            <h1>Посёлки</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <form @submit.prevent="search($event.target)" action="" class="row row-cols-lg-auto g-2">
                <div class="col w-25">
                    <input type="text" class="form-control" name="q" placeholder="Поиск по названию">
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-primary" value="Найти">
                </div>
            </form>
        </div>

        <div v-if="user?.permissions?.some(p => p.name === 'village.create')" class="col text-end">
            <router-link class="btn btn-primary" :to="{ name: 'villages.create' }">
                Добавить
            </router-link>
        </div>
    </div>
    <div v-if="villagesToShow" class="row mt-3">
        <div class="col overflow-auto mb-3">
            <table v-if="villagesToShow.length" class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="w-20">Фото</th>
                        <th>Название</th>
                        <th>Адрес</th>
                        <th>
                            <a @click.prevent="sortBy('square', !sort.direction)"
                               href=""
                               class="sortable"
                               :class="getDirectionClassName">
                                Площадь посёлка (гектар)
                            </a>
                        </th>
                        <th v-if="user?.roles?.some(r => r.name === 'admin')">Управление</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="village in villagesToShow" class="align-middle position-relative">
                        <td>
                            <div class="village-image show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'villages.show', params: { village: village.id } }">
                                    <img v-if="village.photo" height="100" :src="VITE_APP_URL + village.photo.path" alt="">
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'villages.show', params: { village: village.id } }">
                                    {{ village.name }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'villages.show', params: { village: village.id } }">
                                    {{ village.address }}
                                </router-link>
                            </div>
                        </td>
                        <td>
                            <div class="show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'villages.show', params: { village: village.id } }">
                                    {{ village.square }}
                                </router-link>
                            </div>
                        </td>
                        <td v-if="user?.roles?.some(r => r.name === 'admin')">
                            <div class="p-2 d-flex gap-2">
                                <router-link class="btn btn-primary"
                                             :to="{ name: 'villages.edit', params: { village: village.id } }">
                                    <i class="fa-solid fa-pencil"></i>
                                </router-link>
                                <a @click.prevent="deleteVillage(village.id)" class="btn btn-danger" href="">
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
    <div v-else class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-if="!loading && !villages" class="text-danger">Произошла ошибка! Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import { mapState } from 'vuex';
import VillageService from "@/services/VillageService";
import loader from 'vue-spinner/src/MoonLoader.vue';
export default {
    name: "VillagesIndex",
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
            villages: null,
            villagesToShow: null,
            sort: {
                direction: null,
                param: null,
            },
            loading: true,
        }
    },
    async created() {
        this.villagesToShow = this.villages = await VillageService.getVillages()
        this.loading = false
    },
    methods: {
        sortBy(param, direction) {
            this.villagesToShow.sort((cur, next) => {
                return direction ? (cur[param] > next[param]) : (cur[param] < next[param])
            })
            this.sort.direction = direction
        },
        search(form) {
            this.villagesToShow = this.villages.filter((item) => {
                return item.name.toLowerCase().includes(form.q.value.toLowerCase())
            })
        },
        async deleteVillage(id) {
            await VillageService.deleteVillage(id)
            this.villagesToShow = this.villages = this.villages.filter((item) => item.id !== id)
        }
    },

}
</script>

<style scoped>

</style>
