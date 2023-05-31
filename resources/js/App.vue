<template>
    <Navbar></Navbar>
    <div class="container">
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from './components/Navbar.vue';
import { mapMutations } from 'vuex';

export default {
    name: "App",
    components: {
        Navbar
    },
    props: [
        'user_json',
        'backend_routes_json',
    ],
    methods: {
        ...mapMutations('Main', [
            'SET_USER',
            'SET_BACKEND_ROUTES',
        ])
    },
    created() {
        this.SET_USER(JSON.parse(this.user_json));
        this.SET_BACKEND_ROUTES(JSON.parse(this.backend_routes_json));
    }
}
</script>

<style scoped>

</style>
