<template>
    <div class="d-flex flex-grow-1 mb-5 align-items-center justify-content-center flex-column">
        <h1 class="fs-1 fw-bold mb-2">Ошибка</h1>
        <p class="fs-4 mb-4">Страница не найдена</p>
        <div class="d-flex gap-5">
            <router-link class="btn btn-primary" :to="{ name: 'home' }">Вернуться на главную</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Error404"
}
</script>

<style scoped>

</style>
