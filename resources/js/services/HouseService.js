import axios from 'axios';
import { store } from '@/store';

export default {
    async getHouses(page) {
        return await axios.get(`/messages/?page=${page}`);
    },
    storeHouse(payload) {
        return axios.post("/messages", payload);
    },
    updateHouse(payload) {
        return axios.post("/messages", payload);
    },
    paginateHouses(link) {
        return axios.get(link);
    },
};
