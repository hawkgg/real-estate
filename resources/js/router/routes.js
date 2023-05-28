import { auth } from '@/middlewares/auth';
import VillagesIndex from '@/pages/villages/Index.vue';
import VillagesShow from '@/pages/villages/Show.vue';
import VillagesCreate from '@/pages/villages/Create.vue';
import VillagesEdit from '@/pages/villages/Edit.vue';
import Houses from '@/pages/houses/Index.vue';
import Login from '@/pages/auth/Login.vue';

const routes = [
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
            title: 'Посёлки',
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
        component: Houses,
        name: 'houses.index',
        meta: {
            title: 'Дома',
            middleware: [
                auth,
            ],
        }
    },
]

export { routes };
