import { createRouter, createWebHashHistory } from "vue-router"; // @ts-ignore
import Index from "@views/Index.vue"; // @ts-ignore
import Setting from "@views/Setting.vue"; // @ts-ignore
import Upsell from "@views/Upsell.vue"; // @ts-ignore
import Products from "@views/Products.vue"; // @ts-ignore
import Error404 from "@views/404.vue";

/**
 *
 * Define constant isProActive to manipulate routes.
 * If premium addon is active, then isProActive will be true.
 *
 * @since 2.0.0
 */

const isProActive: boolean = false;
const isLicenceActive: boolean = false;

/**
 *
 * Default routes.
 *
 * @param {Array} defaultRoutes
 * @since 2.0.0
 */

const defaultRoutes: any = [
	{
		path: "/",
		name: "Index",
		component: Index,
		redirect: "/s/general", // Let's have this static entry point.
	},
	{
		path: "/s/:slug",
		name: "Setting",
		component: Setting,
	},
];

/**
 *
 * Upsell routes.
 *
 * @param {Array} upsellRoutes
 * @since 2.0.0
 */

const upsellRoutes: any = [
	{
		path: "/upsell",
		name: "Upsell",
		component: Upsell,
	},
];

/**
 *
 * Routes for products listing addon.
 *
 * @param {Array} productRoutes
 * @since 2.0.0
 */

const productRoutes: any = [
	{
		path: "/products",
		name: "Products",
		component: Products,
	},
];

/**
 *
 * Catch all routes.
 *
 * @param {Array} catchAllRoutes
 * @since 2.0.0
 */

const catchAllRoutes: any = [
	{
		path: "/:catchAll(.*)*",
		name: "404",
		component: Error404,
	},
];

/**
 *
 * Define all routes for our app.
 *
 * @param {Array} routes
 * @since 2.0.0
 */

const routes: any = [
	...defaultRoutes,
	...upsellRoutes,
	...productRoutes,
	...catchAllRoutes,
];

const router = createRouter({
	history: createWebHashHistory(),
	routes,
});

export default router;
