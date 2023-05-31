import { auth } from '@/middlewares/auth';

import VillagesIndex from '@/pages/villages/Index.vue';
import VillagesShow from '@/pages/villages/Show.vue';
import VillagesCreate from '@/pages/villages/Create.vue';
import VillagesEdit from '@/pages/villages/Edit.vue';

import HousesIndex from '@/pages/houses/Index.vue';
import HousesShow from '@/pages/houses/Show.vue';
import HousesCreate from '@/pages/houses/Create.vue';
import HousesEdit from '@/pages/houses/Edit.vue';

import Login from '@/pages/auth/Login.vue';
import NotFound from '@/pages/errors/NotFound.vue';

export const routes = [
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            title: 'Вход'
        }
    },
    {
        path: '/',
        name: 'home',
        redirect: { name: 'villages.index' },
        meta: {
            middleware: [
                auth,
            ],
        },
    },
    {
        path: '/villages',
        meta: {
            middleware: [
                auth,
            ],
        },
        children: [
            {
                path: '',
                component: VillagesIndex,
                name: 'villages.index',
                meta: {
                    title: 'Посёлки',
                }
            },
            {
                path: ':village',
                component: VillagesShow,
                name: 'villages.show',
                meta: {
                    title: 'Посёлок',
                }
            },
            {
                path: 'create',
                component: VillagesCreate,
                name: 'villages.create',
                meta: {
                    title: 'Добавление посёлка',
                }
            },
            {
                path: ':village/edit',
                component: VillagesEdit,
                name: 'villages.edit',
                meta: {
                    title: 'Редактирование посёлка',
                }
            },
        ]
    },
    {
        path: '/houses',
        meta: {
            middleware: [
                auth,
            ],
        },
        children: [
            {
                path: '',
                component: HousesIndex,
                name: 'houses.index',
                meta: {
                    title: 'Дома',
                }
            },
            {
                path: ':house',
                component: HousesShow,
                name: 'houses.show',
                meta: {
                    title: 'Дом',
                }
            },
            {
                path: 'create',
                component: HousesCreate,
                name: 'houses.create',
                meta: {
                    title: 'Добавление дома',
                }
            },
            {
                path: ':house/edit',
                component: HousesEdit,
                name: 'houses.edit',
                meta: {
                    title: 'Редактирование дома',
                }
            },
        ]
    },
    {
        path: '/404',
        component: NotFound,
        name: 'NotFound',
        meta: {
            title: 'Не найдено!',
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: { name: 'NotFound' }
    },
]
