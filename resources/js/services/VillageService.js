import axios from 'axios';
import { store } from '@/store';
import transformUrl from 'transform-url';

export default {
    filterVillages(payload) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            store.state.Main.backendRoutes['villages.filter']

        return axios
            .post(apiUrl, payload)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    getVillage(id) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['villages.show'], { village: id })

        return axios
            .get(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    storeVillage(payload) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['villages.store'])

        return axios
            .post(apiUrl, payload)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    editVillage(id) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['villages.edit'], { village: id })

        return axios
            .get(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    updateVillage(id, payload) {
        payload.append('_method', 'PATCH')
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['villages.update'], { village: id })

        return axios
            .post(apiUrl, payload,{headers: { "Content-Type": "multipart/form-data"}})
            .then(response => response.data)
            .catch(error => console.log(error))
    },

    deleteVillage(id) {
        let apiUrl = import.meta.env.VITE_APP_URL +
            transformUrl(store.state.Main.backendRoutes['villages.destroy'], { village: id })

        return axios
            .delete(apiUrl)
            .then(response => response.data)
            .catch(error => console.log(error))
    },
};
