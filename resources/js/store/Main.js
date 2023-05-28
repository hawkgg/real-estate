import { router } from "@/router";
import AuthService from "@/services/AuthService";

export const Main = {
    namespaced: true,
    state: {
        user: {
            data: null,
            roles: null,
            permissions: null,
        },
        backendRoutes: null,
    },
    mutations: {
        SET_USER(state, user) {
            state.user = user;
        },
        SET_BACKEND_ROUTES(state, routes) {
            state.backendRoutes = routes;
        }
    },
    actions: {
        async logout({ state, commit }) {
            await AuthService.logout()
            commit('SET_USER', null)
            router.push('login')
        },
        async login({ state, commit }, form) {
            let response = await AuthService.login(new FormData(form))
            // console.log(response)
            commit('SET_USER', response)
            router.push({name: 'home'})
        }
    }
}
