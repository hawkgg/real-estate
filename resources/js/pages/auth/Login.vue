<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Вход</div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="login($event.target)">
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email"
                                           type="email"
                                           class="form-control"
                                           name="email"
                                           required
                                           autocomplete="email"
                                           autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>

                                <div class="col-md-6">
                                    <input id="password"
                                           type="password"
                                           class="form-control"
                                           name="password"
                                           required
                                           autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="remember"
                                               id="remember">

                                        <label class="form-check-label" for="remember">
                                            Запомнить меня
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Войти
                                    </button>

<!--                                    <a class="btn btn-link" :href="routes['password.request']">-->
<!--                                        Забыли пароль?-->
<!--                                    </a>-->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 offset-3">
                <div class="row">
                    <div class="col-lg-6 d-flex justify-content-center my-4">
                        <div class="flex-grow-0">
                            <p class="h4">Администратор</p>
                            <p class="my-0"><code class="fs-6 text-dark">Логин: admin@gmail.com</code></p>
                            <p class="my-0"><code class="fs-6 text-dark">Пароль: password</code></p>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center my-4">
                        <div class="flex-grow-0">
                            <p class="h4">Менеджер</p>
                            <p class="my-0"><code class="fs-6 text-dark">Логин: manager@gmail.com</code></p>
                            <p class="my-0"><code class="fs-6 text-dark">Пароль: password</code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: "Login",
    methods: {
        ...mapActions('Main', ['login'])
    },
}
</script>

<style scoped>

</style>
