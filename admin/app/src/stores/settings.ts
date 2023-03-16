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
		settings: {
			color: "rgba(92, 22, 255, 1)",
			border_radius: 30,
			font: "",
			font_weight: 400,
			font_size: 16,
			letter_spacing: 0.5,
			line_height: 1.5,
			text_traform: ["default", "Uppercase", "Lowercase", "Capitalize"],
		},
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
