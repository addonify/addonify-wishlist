import { defineStore } from "pinia";
import { ElMessage } from "element-plus"; // @ts-ignore
import { apiEndpoint } from "@helpers/endpoint"; // @ts-ignore
import { jsonFileName } from "@helpers/global"; // @ts-ignore
import { commonHeader } from "@helpers/api"; // @ts-ignore
import { getCurrentDateTime } from "@helpers/functions"; // @ts-ignore

/**
 *
 * Receive global WordPress variables.
 *
 * @since 2.0.0
 */

// @ts-ignore
const { apiFetch } = wp; // @ts-ignore
const { isEqual, cloneDeep } = lodash; // @ts-ignore
const { __ } = wp.i18n;

/**
 *
 * Define variable to hold the old settings state.
 *
 * @since 2.0.0
 */

let oldSettings: any = [];

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
			isDoingReset: false, // Flag if we are resetting settings.
			isImporting: false, // Flag if we are importing settings.
			isExporting: false, // Flag if we are exporting settings.
			message: "", // Message to show.
		},

		/**
		 *
		 * Special state for tools/action button setting page.
		 */

		actionEvent: {
			endpoint: "",
			isProcessing: false,
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
		haveChanges: (state: any): boolean =>
			!isEqual(state.settings, oldSettings) ? true : false,

		/**
		 *
		 * Check if we do have state of settings in the memory.
		 * If we do have, then return true.
		 *
		 * @param {Object} state
		 * @returns {boolean} true/false
		 * @since 2.0.3
		 */

		haveSettingsStateInMemory: (state: any): boolean =>
			Object.keys(state.settings).length === 0 ? false : true,
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

			let errMessage: string = __(
				"Couldn't fetch settings. Please reload the page again.",
				"addonify-wishlist"
			);

			apiFetch({
				path: apiEndpoint + "/get_options",
				method: "GET",
				headers: commonHeader,
			})
				.then((res: any) => {
					/**
					 *
					 * Case: Success.
					 * We have the data, lets hydrate the state.
					 */

					//console.log(res);
					this.settings = res.settings_values;
					this.data = res.tabs;
					oldSettings = cloneDeep(this.settings);
				})
				.catch((err: any) => {
					/**
					 *
					 * Case: Error.
					 * We have to handle the error here.
					 */
					console.log(err);

					ElMessage.error({
						message: errMessage,
						offset: 50,
						duration: 10000,
					});
				})
				.finally(() => {
					this.status.isLoading = false;
				});
		},

		/**
		 *
		 * Send's an empty POST request to the rest api endpoint without any payload.
		 * Used for tools and action buttons.
		 * Check doc here: ?
		 *
		 * @returns {string} success/failed
		 * @since 2.0.0
		 */
		dispatchEmptyPostRequest(endpoint: string): void {
			/**
			 *
			 * Let api know we are resetting the settings.
			 */
			const errMessage = __(
				"Error something went wrong. Please try again.",
				"addonify-wishlist"
			);

			this.actionEvent.isProcessing = true;

			apiFetch({
				path: `${apiEndpoint}/${endpoint}`,
				method: "POST",
				headers: commonHeader,
			})
				.then((res: any) => {
					/**
					 *
					 * Case: Success.
					 * Resetting successfully done.
					 */

					this.status.message = res.message;

					if (res.success === true) {
						ElMessage.success({
							message: this.status.message,
							offset: 50,
							duration: 3000,
						});
					} else {
						ElMessage.error({
							message: this.status.message,
							offset: 50,
							duration: 10000,
						});
					}
				})
				.catch((err: any) => {
					/**
					 *
					 * Case: Error.
					 * Couldn't reset.
					 */

					console.log(err);

					ElMessage.error({
						message: errMessage,
						offset: 50,
						duration: 10000,
					});
				})
				.finally(() => {
					this.fetchSettings();
					this.actionEvent.isProcessing = false;
				});
		},

		/**
		 *
		 * Save options, make api call and update the state.
		 *
		 * @returns {string} success/failed
		 * @since 2.0.0
		 */

		saveSettings(): void {
			/**
			 *
			 * Handle the payload.
			 */

			let payload: any = new Object();
			let reactiveSettings: any = this.settings;

			Object.keys(reactiveSettings).map((key) => {
				if (!isEqual(reactiveSettings[key], oldSettings[key])) {
					payload[key] = reactiveSettings[key];
				}
			});

			/**
			 *
			 * Pass payload to the api.
			 */

			this.status.isSaving = true;

			let errMessage: string = __(
				"Error saving settings. Please try again.",
				"addonify-wishlist"
			);

			apiFetch({
				path: apiEndpoint + "/update_options",
				method: "POST",
				headers: commonHeader,
				data: {
					settings_values: payload,
				},
			})
				.then((res: any) => {
					/**
					 *
					 * Case: Success.
					 * Saving successfully done.
					 */

					this.status.message = res.message;

					//console.log(res);

					if (res.success === true) {
						ElMessage.success({
							message: res.message,
							offset: 50,
							duration: 3000,
						});

						let tempOptionsState = cloneDeep(this.settings);
						this.settings = {};
						this.settings = cloneDeep(tempOptionsState);
						oldSettings = cloneDeep(this.settings);
					} else {
						ElMessage.error({
							message: res.message,
							offset: 50,
							duration: 10000,
						});

						setTimeout(() => {
							window.location.reload();
						}, 2000);
					}
				})
				.catch((err: any) => {
					/**
					 *
					 * Case: Error.
					 * Couldn't save.
					 */

					console.log(err);
					ElMessage.error({
						message: errMessage,
						offset: 50,
						duration: 10000,
					});

					let tempOptionsState = cloneDeep(oldSettings);
					this.settings = {};
					this.settings = cloneDeep(tempOptionsState);
				})
				.finally(() => {
					//this.fetchSettings();
					this.status.isSaving = false;
				});
		},

		/**
		 *
		 * Export all settings as json file.
		 * Make api call and download the file.
		 *
		 * @returns {void} void
		 * @since 2.0.0
		 */

		exportSettings(): void {
			/**
			 *
			 * Begin the export process.
			 */
			const errMessage = __(
				"Error couldn't export settings.",
				"addonify-wishlist"
			);
			this.status.isExporting = true;

			apiFetch({
				path: apiEndpoint + "/export_options",
				method: "GET",
				headers: commonHeader,
			})
				.then((res: any) => {
					/**
					 *
					 * Case: Success.
					 * Export is successful.
					 */

					this.status.message = res.message; // Get the message.

					if (res.success === true) {
						let link = document.createElement("a");
						link.href = res.url;
						link.setAttribute(
							"download",
							`${jsonFileName}-all-settings-${getCurrentDateTime}.json`
						);
						document.body.appendChild(link);
						link.click();
					} else {
						ElMessage.error({
							message: errMessage,
							offset: 50,
							duration: 10000,
						});
						return;
					}
				})
				.catch((err: any) => {
					/**
					 *
					 * Case: Error.
					 * Export was un-successful.
					 */

					console.log(err);

					ElMessage.error({
						message: errMessage,
						offset: 50,
						duration: 10000,
					});
				})
				.finally(() => {
					this.status.isExporting = false;
				});
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

		importSettings(payload: any): void {
			/**
			 *
			 * Begin the import process.
			 */
			const errMessage = __(
				"Error couldn't import settings.",
				"addonify-wishlist"
			);

			this.status.isImporting = true;

			apiFetch({
				path: apiEndpoint + "/import_options",
				method: "POST",
				headers: commonHeader,
				body: payload,
			})
				.then((res: any) => {
					/**
					 *
					 * Case: Success.
					 * Import is successful.
					 */
					this.status.message = res.message;

					if (res.success === true) {
						ElMessage.success({
							message: this.status.message,
							offset: 50,
							duration: 3000,
						});

						setTimeout(() => {
							window.location.reload();
						}, 2000);
					} else {
						ElMessage.error({
							message: this.status.message,
							offset: 50,
							duration: 10000,
						});
					}
				})
				.catch((err: any) => {
					/**
					 *
					 * Case: Error.
					 * Import was un-successful.
					 */

					console.log(err);

					ElMessage.error({
						message: errMessage,
						offset: 50,
						duration: 10000,
					});
				})
				.finally(() => {
					//this.fetchSettings();
					this.status.isImporting = false;
				});
		},
	},
});
