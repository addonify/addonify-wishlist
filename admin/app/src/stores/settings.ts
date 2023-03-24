import { defineStore } from "pinia";
// @ts-ignore
import { useRoutesStore } from "@stores/routes";
// @ts-ignore
import { apiEndpoint } from "@helpers/endpoint";
// @ts-ignore
import { textdomain } from "@helpers/global";
// @ts-ignore
import { dispatchToast, unExpectedResponse } from "@helpers/message";
// @ts-ignore
import { apiEndpoint } from "@helpers/endpoint";

/**
 *
 * Receive global WordPress variables.
 *
 * @since 2.0.0
 */

// @ts-ignore
const { apiFetch } = wp;
// @ts-ignore
const { isEqual, cloneDeep } = lodash;
// @ts-ignore
const { __ } = wp.i18n;

/**
 *
 * Define variable to hold the old settings state.
 *
 * @since 2.0.0
 */

let oldSettings: Object = {};

/**
 *
 * Let's define the settings store.
 * Includes current state, getters & actions.
 *
 * @since 2.0.0
 */

export const useSettingsStore = defineStore({
	id: "settings",

	state: () => ({
		data: {}, // Store object for tabs that includes all settings.
		settings: {}, // Store "settings_values" object from rest api endpoint.
		status: {
			isLoading: true, // Flag if something is loading.
			isSaving: false, // Flag if something is saving.
			needSaving: false, // Flag if settings needs saving.
			isDoingReset: false, // Flag if we are resetting settings.
			isImporting: false, // Flag if we are importing settings.
			isExporting: false, // Flag if we are exporting settings.
			message: "", // Message to show.
		},
	}),

	getters: {
		/**
		 *
		 * Check if there are any changes in the settings.
		 * If any changes is found, then return true so we can show the save button.
		 *
		 * @param {Object} state
		 * @returns {boolean} true/false
		 * @since 2.0.0
		 */
		haveChanges: (state: any): boolean => {
			return !isEqual(state.settings, oldSettings) ? true : false;
		},
	},

	actions: {
		/**
		 *
		 * Get all settings from rest api endpoint.
		 *
		 * @returns {void} void
		 * @since 2.0.0
		 */

		fetchSettings(): void {
			/**
			 *
			 * Let's define a error message that can be displayed in toast alerts.
			 */

			let errorMessage: string = __(
				"Something went wrong. Please reload the page again.",
				textdomain
			);

			apiFetch({
				path: apiEndpoint + "/get_options",
				method: "GET",
			})
				.then((res: any) => {
					/**
					 *
					 * Case: Success.
					 * We have the data, lets hydrate the state.
					 */
					//console.log(res);
					const routeStore = useRoutesStore();
					this.settings = res.settings_values;
					this.data = res.tabs;
					oldSettings = cloneDeep(res.setting_values);
					routeStore.data = res;
				})
				.catch((err: any) => {
					/**
					 *
					 * Case: Error.
					 * We have to handle the error here.
					 */
					console.log(err);
					dispatchToast(errorMessage, "error");
				})
				.finally(() => {
					this.status.isLoading = false;
				});
		},

		/**
		 *
		 * Save options, make api call and update the state.
		 *
		 * @param {Object} payload
		 * @returns {string} success/failed
		 * @since 2.0.0
		 */

		async saveSettings(payload: []): Promise<void> {
			/**
			 *
			 * Let's send the payload to the rest api endpoint.
			 */

			try {
				const res = await apiFetch({
					path: apiEndpoint + "/update_options",
					method: "POST",
					data: {
						settings_values: payload,
					},
				});

				this.status.message = res.message;

				if (res.status === 200) {
					/**
					 *
					 * We have the data, lets handle the mutations and other side effects.
					 */

					oldSettings = cloneDeep(res.setting_values);
					dispatchToast(this.status.message, "success");
					this.status.isSaving = false;
					this.fetchSettings();
				} else {
					/**
					 *
					 * Let unExpectedResponse function do the rest.
					 */

					unExpectedResponse(res);
					this.status.isSaving = false;
				}
			} catch (err: any) {
				/**
				 *
				 * Handle the error here.
				 */

				console.log(err);

				dispatchToast(this.status.message, "error");

				this.status.isSaving = false;
			}
		},

		/**
		 *
		 * Reset all settings and set the default values.
		 *
		 * @returns {string} success/failed
		 * @since 2.0.0
		 */

		async resetAllSettings(): Promise<void> {
			/**
			 *
			 * Let api know we are resetting the settings.
			 */

			this.status.isDoingReset = true;

			try {
				const res = await apiFetch({
					path: apiEndpoint + "/reset_options",
					method: "POST",
				});

				this.status.message = res.message; // Get the message.

				if (res.status === 200) {
					/**
					 *
					 * We have the data, lets handle the mutations and other side effects.
					 */

					dispatchToast(this.status.message, "success");
					this.status.isDoingReset = false;
					this.fetchSettings();
				} else {
					/**
					 *
					 * Let unExpectedResponse function do the rest.
					 */

					unExpectedResponse(res);
					this.status.isDoingReset = false;
				}
			} catch (err: any) {
				/**
				 *
				 * Handle the error here.
				 */

				console.log(err);

				dispatchToast(this.status.message, "error");

				this.status.isDoingReset = false;
			}
		},

		/**
		 *
		 * Export all settings as json file.
		 * Make api call and download the file.
		 *
		 * @returns {void} void
		 * @since 2.0.0
		 */

		async exportSettings(): Promise<void> {
			/**
			 *
			 * Begin the export process.
			 */

			this.status.isExporting = true;

			try {
				const res = await apiFetch({
					path: apiEndpoint + "/export_options",
					method: "GET",
				});

				this.status.message = res.message; // Get the message.

				if (res.status === 200) {
					/**
					 *
					 * Allow the user to download the JSON file.
					 */

					let date = new Date().getTime();
					let link = document.createElement("a");
					link.href = res.url;
					link.setAttribute(
						"download",
						`${textdomain}-all-settings-${date}.json`
					);
					document.body.appendChild(link);
					link.click(); // Simulate the click event.
					this.status.isExporting = false; // Stop the export process.
				} else {
					/**
					 *
					 * Let unExpectedResponse function do the rest.
					 */

					unExpectedResponse(res);
					this.status.isExporting = false; // Bail out.
				}
			} catch (err: any) {
				/**
				 *
				 * Handle the error here.
				 */

				console.log(err);
				dispatchToast(this.status.message, "error");
				this.status.isExporting = false; // Bail out.
			}
		},

		/**
		 *
		 * Import json file and send the file to the rest api endpoint.
		 * This json files contains all the settings and their values.
		 *
		 * @param {Object} payload
		 * @returns {string} success/failed
		 * @since 2.0.0
		 */

		async importSettings(payload: any): Promise<void> {
			/**
			 *
			 * Begin the import process.
			 */

			this.status.isImporting = true;

			try {
				const res = await apiFetch({
					path: apiEndpoint + "/import_options",
					method: "POST",
					body: payload,
				});

				this.status.message = res.message; // Get the message.

				if (res.status === 200) {
					/**
					 *
					 * File has been imported successfully.
					 */

					dispatchToast(this.status.message, "success");
					this.status.isImporting = false; // Stop the export process.
				} else {
					/**
					 *
					 * Let unExpectedResponse function do the rest.
					 */

					unExpectedResponse(res);
					this.status.isImporting = false; // Bail out.
				}
			} catch (err: any) {
				/**
				 *
				 * Handle the error here.
				 */

				console.log(err);
				dispatchToast(this.status.message, "error");
				this.status.isImporting = false; // Bail out.
			}
		},
	},
});
