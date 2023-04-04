import { defineStore } from "pinia"; // @ts-ignore
import { saleEndpoint } from "@helpers/endpoint";

/**
 *
 * Define store for upsell.
 *
 * @since 2.0.0
 */

export const useUpsellStore = defineStore({
	id: "upsell",

	state: () => ({
		data: {},
		status: {
			isChecking: true,
		},
	}),

	getters: {
		hasSale: (state: any) => {
			if (Object.keys(state.data).length !== 0) {
				return state.data.addonify.live === true ? true : false;
			} else {
				return false;
			}
		},

		hasCaption: (state: any) => {
			if (Object.keys(state.data).length !== 0) {
				return state.data.addonify.caption !== "" ? true : false;
			} else {
				return false;
			}
		},
	},

	actions: {
		/**
		 *
		 * Fetch sale information from the api endpoint.
		 *
		 * @returns {void} void
		 * @since 2.0.0
		 */

		async checkSale(): Promise<void> {
			try {
				const res = await fetch(saleEndpoint, {
					method: "GET",
				});

				const data = await res.json();

				if (res.status === 200) {
					/**
					 *
					 * Case: Success!
					 * Connected with the api endpoint.
					 */

					//console.log(data);
					this.data = data.data;
				}
			} catch (err) {
				// Do nothing. We don't want to show any error message.
				// Silence is golden.
			}
		},
	},
});
