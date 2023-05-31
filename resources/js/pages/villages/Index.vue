<template>
    <div class="row">
        <div class="col">
            <h1>Посёлки</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-auto col-md-10">
            <form @submit.prevent="search($event.target)" action="" class="row g-2">
                <div class="col-8 col-md-6 col-lg-4">
                    <input type="text"
                           class="form-control"
                           name="name"
                           placeholder="Поиск по названию"
                           :value="params.name">
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

    <div v-if="loading" class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <div v-else class="row mt-3">
        <div v-if="villages.length" class="col overflow-auto mb-3">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="w-20">Фото</th>
                        <th>Название</th>
                        <th>Адрес</th>
                        <th>
                            <a @click.prevent="sort('square')"
                               :class="(params.order_by === 'square') ? params.order_dir : null"
                               href=""
                               class="sortable">
                                Площадь посёлка (гектар)
                            </a>
                        </th>
                        <th v-if="user?.roles?.some(r => r.name === 'admin')">Управление</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="village in villages" class="align-middle position-relative">
                        <td>
                            <div class="village-image show-link-wrapper">
                                <router-link class="show-link"
                                             :to="{ name: 'villages.show', params: { village: village.id } }">
                                    <img v-if="village.photo"
                                         :src="VITE_APP_URL + village.photo.path"
                                         height="100"
                                         alt="">
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
            <pagination @paginate="paginate" :info="pagination"></pagination>
        </div>
        <p v-else class="fw-bold">Не найдено.</p>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import VillageService from "@/services/VillageService";
import loader from 'vue-spinner/src/MoonLoader.vue';
import Pagination from "@/components/Pagination.vue";
export default {
    name: "VillagesIndex",
    components: {
        loader,
        Pagination,
    },
    computed: {
        ...mapState('Main', ['user']),
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            villages: [],
            params: {
                name: null,
                order_by: null,
                order_dir: null,
                page: null,
            },
            pagination: [],
            loading: true,
        }
    },
    created() {
        const urlParams = new URLSearchParams(window.location.search)
        this.params.name = urlParams.get('name')
        this.params.order_by = urlParams.get('order_by')
        this.params.order_dir = urlParams.get('order_dir')
        this.params.page = urlParams.get('page')
        this.filter()
    },
    methods: {
        search(form) {
            if (!this.params.name && !form.name.value) {
                return;
            }
            this.params.name = form.name.value
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
        async deleteVillage(id) {
            await VillageService.deleteVillage(id)
            this.filter()
        },
        async filter() {
            this.loading = true
            let filledParams = Object.fromEntries(
                Object.entries(this.params).filter(([_, v]) => v !== null && v !== '')
            )
            this.$router.push({ query: { ...filledParams } })

            let res = await VillageService.filterVillages(filledParams)
            this.villages = res.data
            this.pagination = res.meta
            this.loading = false
        },
    },
}
</script>

<style scoped>

</style>
