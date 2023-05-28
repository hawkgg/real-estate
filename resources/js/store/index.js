import { createStore } from 'vuex';
import { Main } from './Main';

const store = new createStore({
    modules: {
        Main,
    }
});

export { store };
