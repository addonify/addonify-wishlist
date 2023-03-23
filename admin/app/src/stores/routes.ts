import { defineStore } from "pinia";

/**
 *
 * Let's define routes store.
 * This store acts as an cache storage for the routes links.
 *
 * @since 2.0.0
 */
export const useRoutesStore = defineStore({
	id: "routes",

	state: () => ({
		data: {}, // An object that has "TAB" & section.
		routes: {}, // Extracted routes from data.
	}),

	getters: {
		extractRoutes: (state) => {},
	},

	actions: {},
});
