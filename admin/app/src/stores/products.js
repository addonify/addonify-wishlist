import { defineStore } from "pinia";
import { dispatchToast } from "@helpers/message";
import { productsList } from "@helpers/endpoint";
import { textdomain } from "@helpers/global";

/**
 *
 * Receive global WordPress variables.
 */

const { apiFetch } = wp;
const { __ } = wp.i18n;

/**
 *
 * Let's define products store.
 * 
 */
export const useProductStore = defineStore({

	id: 'Product',

	state: () => ({

		allAddons: {}, // Store all recommended plugins.
		allProductSlugStatus: {}, // Store all recommended plugins slug with status.
		hotAddons: {}, // Store hot recommended plugins.
		generalAddons: {}, // Store general recommended plugins.
		installedAddons: {}, // Store all installed plugins.

		status: {
			isFetching: true, // Fetching recommended plugins list from github.
			isFetchingAllInstalledAddons: true, // Fetched all installed plugins.
			isSettingAddonStatus: true, // Checking plugin status on backend.
		}
	}),

	actions: {

		/**
		 * Action: Fetch github repo data.
		 * Get addons slug from github repo.
		 *
		 * @return {void} void
		 */

		async fetchProductList() {

			let errMessage = __('Error: couldn\'t fetch recommended plugins list.', textdomain);

			try {

				const res = await fetch(productsList, {

					method: 'GET',
				});

				const data = await res.json();

				//console.log(data);

				if (res.status == 200) {

					/**
					*
					* Case: Success!
					* We have the list of recommended plugins.
					*/
					console.log("💥 Github repo fetched successfully.");
					this.processRecommendedPluginsList(data);
					this.status.isFetching = false;

				} else {

					/**
					*
					* Case: Error!
					* Something went wrong while fetching the list.
					*/

					console.error("Couldn't fetch Github repo " + res);
					dispatchToast(errMessage, 'error');
				}

			} catch (err) {

				/**
				*
				* Case: Error!
				* Something went wrong while fetching the list.
				*/
				console.error(err);
				dispatchToast(message, 'error');
				this.status.isFetching = false;
			}
		},

		/**
		* Action: Process the recommended plugins list.
		* Create three arrays [hot, general & all]
		* Called on fetchProductList() action.
		*
		* @param {object} list
		* @return {void} void
		*/

		processRecommendedPluginsList(list) {

			let errMessage = __('Error: couldn\'t process the recommended plugins list.', textdomain);

			console.log("=> Processing the list that was retrived....");

			this.hotAddons = list.data.hot;
			this.generalAddons = list.data.general;
			this.allAddons = { ...this.hotAddons, ...this.generalAddons };

			//console.log(this.generalAddons);

			if (typeof this.allAddons === 'object') {

				Object.keys(this.allAddons).forEach((key) => {

					//console.log(key);
					// Let's add the slug to object with status null for now.
					// i.e: { 'addonify-wishlist': 'status' }
					this.allProductSlugStatus[key] = 'null';
				});

			} else {

				/**
				*
				* Case: Error!
				* We couldn't process the list.
				*/

				console.error("💥 Couldn't process the list plugins list.");
				dispatchToast(errMessage, 'error');
			}
		},

		/**
		 * Action: Check plugin status.
		 * Call backend api to check plugin status.
		 *
		 * @return {void} void
		 */

		async fetchInstalledAddons() {

			let errMessage = __('Error: couldn\'t fetch installed plugins list.', textdomain);

			console.log("=> Getting the list of all plugins installed on the site....");

			try {

				const res = await apiFetch({

					method: "GET",
					path: `/wp/v2/plugins`,
				});

				//console.log(res);
				console.log("=> Received the list of all installed plugins....");
				this.installedAddons = res;
				// Just send the slug array.
				this.setAddonStatusFlag(Object.keys(this.allProductSlugStatus));
				this.status.isFetchingAllInstalledAddons = false;

			} catch (err) {

				/**
				*
				* Case: Error!
				* We couldn't fetch the list of installed addons.
				*/

				console.log(err);
				dispatchToast(errMessage, 'error');
				this.status.isFetchingAllInstalledAddons = false;
			}
		},

		/**
		* Action: Get plugin installed/active status via slug.
		* Returns 'active' or 'inactive' or 'not-installed'.
		* 
		* @param {Object} slug
		* @return {void} void
		*/

		setAddonStatusFlag(slugs) {

			if (typeof this.installedAddons == 'object' && this.installedAddons.length > 0) {

				console.log("=> Setting the status of the addon.");
				//console.log(slugs);

				slugs.forEach((slug) => {

					// Find the status in installed addons. 
					let tryFind = this.installedAddons.find((plugin) => plugin.textdomain == slug);

					if (tryFind) {

						this.allProductSlugStatus[slug] = tryFind.status;

					} else {

						this.allProductSlugStatus[slug] = 'not-installed';
					}
				});

			} else {

				console.log("=> Bailing!!! The installed addons list is empty.");
			}

			console.log("💥 Done setting the status of the addon.");
			// Done setting the status till here. Let's set the flag to false.
			this.status.isSettingAddonStatus = false;
		},

		/**
		*
		* Action: Handle plugin activation.
		* Call REST API to activate plugin.
		* Wait for the signal from the backend.
		* 
		* @param {string} slug
		* @return {Promise<Object>} res
		*/

		async handleAddonInstallation(slug) {

			let successMessage = __('Plugin installed successfully.', textdomain);
			let errorMessage = __('Error: couldn\'t install the plugin.', textdomain);

			try {

				console.log(`=> Trying to install plugin ${slug}...`);

				const res = await apiFetch({

					method: "POST",
					path: "/wp/v2/plugins",

					data: {
						slug: slug,
						status: "active",
					},
				});

				//console.log(res);

				if (res.status === 'active') {

					/**
					*
					* Case: Success.
					* Plugin was successfully installed.
					*/
					console.log(`=> Plugin ${slug} installed successfully.`);
					dispatchToast(successMessage, 'success');
					this.allProductSlugStatus[slug] = 'active'; // Update the status of the plugin.
					return await res;
				}

			} catch (err) {

				/**
				*
				* Case: Error!
				* We couldn't install the plugin.
				*/
				console.error(err);
				dispatchToast(errorMessage, 'error');
				this.status.isWaitingForInstallation = false;
				return await err;
			}
		},

		/**
		 *
		 * Update the plugin status.
		 * If the plugin is installed but not active, then activate it. 
		 *
		 * @param {String} slug
		 * @return {Promise<Object>} res
		 */

		async updateAddonStatus(slug) {

			let successMessage = __('Plugin activated successfully.', textdomain);
			let errorMessage = __('Error: couldn\'t activate the plugin.', textdomain);

			try {

				console.log(`=> Trying to set the status of plugin ${slug}...`);

				const res = await apiFetch({

					method: "POST",
					path: `/wp/v2/plugins/${slug}`,
					data: {
						status: "active",
						plugin: `${slug}/${slug}`,
					},
				});

				//console.log(res);

				if (res.status == 'active') {

					/**
					*
					* Case: Success.
					* Plugin was successfully activated.
					*/

					console.log(`=> Plugin ${slug} activated successfully.`);

					dispatchToast(successMessage, 'success');
					this.allProductSlugStatus[slug] = 'active'; // Update the status of the plugin.
					return await res;
				}

			} catch (err) {

				/**
				*
				* Case: Error.
				* Plugin was not activated for some reason.
				*/

				console.log(err);
				dispatchToast(errorMessage, 'error');
				return await err;
			}
		}
	}
});