import { createRouter, createWebHistory } from 'vue-router';
import { routes } from './routes';
import { middlewarePipeline } from './middlewarePipeline';
import { store } from '@/store/index';
import { nextTick } from 'vue';

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const middleware = to.meta.middleware;
    const context = { to, from, next, store };

    if (!middleware) {
        return next();
    }

    middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1),
    });
});

router.afterEach((to, from) => {
    nextTick(() => {
        document.title = to.meta.title || import.meta.env.VITE_APP_NAME;
    });
});

export { router };
