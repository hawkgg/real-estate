<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container gap-3">
            <router-link class="navbar-brand me-4" :to="{ name: 'home' }">RealEstate</router-link>
            <router-link class="nav-link" :to="{ name: 'villages.index' }">Посёлки</router-link>
            <router-link class="nav-link" :to="{ name: 'houses.index' }">Дома</router-link>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Навигация">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li v-if="user?.data" class="nav-item dropdown">
                        <a id="navbarDropdown"
                           class="nav-link dropdown-toggle"
                           href=""
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            {{ user.data.name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" @click.prevent="logout" href="">Выйти</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    name: "Navbar",
    computed: {
        ...mapState('Main', ['user'])
    },
    methods: {
        ...mapActions('Main', ['logout']),
    },
}
</script>

<style scoped>

</style>
