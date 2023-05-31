import axios from 'axios';
import { store } from '@/store';
import transformUrl from 'transform-url';

export default {
    getFilterAdditionalResources() {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.getFilterAdditionalResources'])

        return axios
            .get(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    filterHouses(payload) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.filter'])

        return axios
            .post(apiUrl, payload)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    getHouse(id) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.show'], { house: id })

        return axios
            .get(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    createHouse() {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.create'])

        return axios
            .get(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    storeHouse(payload) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.store'])

        return axios
            .post(apiUrl, payload)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    editHouse(id) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.edit'], { house: id })

        return axios
            .get(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    updateHouse(id, payload) {
        payload.append('_method', 'PATCH')
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.update'], { house: id })

        return axios
            .post(apiUrl, payload,{headers: { "Content-Type": "multipart/form-data"}})
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    deleteHouse(id) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['houses.destroy'], { house: id })

        return axios
            .delete(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },
};
