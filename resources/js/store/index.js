import { createStore } from 'vuex';
import { Main } from './Main';

export const store = new createStore({
    modules: {
        Main,
    }
});
