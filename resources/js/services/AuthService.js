import axios from 'axios';
import { store } from '@/store';

export default {
    login(params) {
        return axios
            .post(store.state.Main.backendRoutes['login'], params)
            .then(response => response.data)
            .catch(error => console.log(error));
    },
    logout() {
        return axios
            .post(store.state.Main.backendRoutes['logout'])
            .then(response => response.data)
            .catch(error => console.log(error));
    },
};
