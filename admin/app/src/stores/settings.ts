import { defineStore } from "pinia";
import { ElMessage } from "element-plus";

// @ts-ignore
const { apiFetch } = wp;
// @ts-ignore
const { isEqual, cloneDeep } = lodash;

/**
 *
 * Let's define settings store.
 *
 */

export const useSettingsStore = defineStore({
	id: "settings",

	state: () => ({
		settings: [], // Store all settings fetched from the api.
		status: {
			isLoading: true, // Flag if something is loading.
			isSaving: false, // Flag if something is saving.
			needSaving: false, // Flag if settings needs saving.
			isDoingReset: false, // Flag if we are resetting settings.
			isImporting: false, // Flag if we are importing settings.
			isExporting: false, // Flag if we are exporting settings.
		},
	}),

	getters: {
		settingChanged: (state: any): boolean => {
			return true;
		},
	},

	actions: {},
});
