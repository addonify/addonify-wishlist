import { createRouter, createWebHashHistory } from 'vue-router'
import Settings from '../views/Settings.vue'
import Styles from '../views/Styles.vue'
import Products from '../views/Products.vue'
import PageNotFound from '../views/404.vue'

const routes = [

    {
        path: "/",
        name: "Settings",
        component: Settings,
    },
    {
        path: "/styles",
        name: "Styles",
        component: Styles,
    },
    {
        path: "/products",
        name: "Products",
        component: Products,
    },
    {
        path: '/:catchAll(.*)*',
        name: "404",
        component: PageNotFound,
    },
]

const router = createRouter({

    history: createWebHashHistory(),
    routes
})

export default router