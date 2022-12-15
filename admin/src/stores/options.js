import { defineStore } from 'pinia'
import { ElMessage } from 'element-plus'

// For using Wordpress lodash.
const { isEqual, cloneDeep } = lodash;

// For using Wordpress apiFetch.
const { apiFetch } = wp;

// Wordpress localize data.
const BASE_API_URL = ADDONIFY_WISHLIST_LOCOLIZER.rest_namespace;

// Store old options & values.
let oldOptions = {};

export const useOptionsStore = defineStore({

    id: 'Options',

    state: () => ({
        data: {},   // Holds all datas like options, section, tab & fields.
        options: {}, // Holds the old options to compare with the new ones.
        message: "", // Holds the message to be displayed to the user.
        isLoading: true,
        isSaving: false,
        needSave: false,
        isDoingReset: false,
        isImportingFile: false,
        isDoingExport: false,
        errors: "",
    }),
    getters: {

        // ⚡️ Check if we need to save the options.
        needSaving: (state) => {

            return !isEqual(state.options, oldOptions) ? true : false;
        },

        // ⚡️ Hide/Show option fields based on dependent field value.
        optionBoxVisibility: (state) => (arg) => {

            let returnVal = true;

            if (arg.hasOwnProperty('dependent')) {

                let dependent = arg.dependent;

                dependent.map((id) => {

                    if (returnVal == false && state.options[id] == true) {

                        returnVal = false;

                    } else if (returnVal == false && state.options[id] == false) {

                        returnVal = false;

                    } else if (returnVal == true && state.options[id] == true) {

                        returnVal = true;

                    } else {

                        returnVal = false;
                    }
                });
            }

            return returnVal;
        },
    },
    actions: {

        // ⚡️ Use Axios to get options from api.
        fetchOptions() {

            apiFetch({
                path: BASE_API_URL + '/get_options',
                method: 'GET',
            }).then((res) => {
                this.options = res.settings_values;
                this.data = res.tabs;
                oldOptions = cloneDeep(res.settings_values);
                //console.log(res);
                this.isLoading = false;
            });
        },

        // ⚡️ Handle update options & map the values to the options object.
        handleUpdateOptions() {

            let payload = {};
            let changedOptions = this.options;

            Object.keys(changedOptions).map(key => {

                if (!isEqual(changedOptions[key], oldOptions[key])) {
                    payload[key] = changedOptions[key];
                }
            });

            this.updateOptions(payload);
            //console.log(payload);
        },

        // ⚡️ Update options using Axios.
        updateOptions(payload) {

            this.isSaving = true; // Set saving to true.

            apiFetch({
                path: BASE_API_URL + '/update_options',
                method: 'POST',
                data: {
                    settings_values: payload
                }
            }).then((res) => {

                this.isSaving = false; // Saving is completed here.
                this.message = res.message; // Set the message to be displayed to the user.

                if (res.success === true) {
                    ElMessage.success(({
                        message: this.message,
                        offset: 50,
                        duration: 3000,
                    }));
                } else {

                    ElMessage.error(({
                        message: this.message,
                        offset: 50,
                        duration: 3000,
                    }));
                }

                this.fetchOptions(); // Fetch options again.
            });
        },

        // ⚡️ Reset all options.
        // @param payload: empty
        resetAllOptions() {

            this.isDoingReset = true; // Set saving to true.

            apiFetch({
                path: BASE_API_URL + '/reset_options',
                method: 'POST',
            }).then((res) => {

                this.isDoingReset = false; // Saving is compconsted here.
                this.message = res.message; // Set the message to be displayed to the user.
                //console.log(res);

                if (res.success === true) {
                    ElMessage.success(({
                        message: this.message,
                        offset: 50,
                        duration: 3000,
                    }));

                } else {
                    ElMessage.error(({
                        message: this.message,
                        offset: 50,
                        duration: 5000,
                    }));
                }

                this.fetchOptions(); // Fetch options again.
            });
        },

        // ⚡️ Export all options.
        // @param payload: empty
        exportAllOptions() {

            this.isDoingExport = true;

            apiFetch({
                path: BASE_API_URL + '/export_options',
                method: 'GET',
            }).then((res) => {

                this.isDoingExport = false;
                //console.log(res);

                if (res.success == true) {

                    // File has been created, Let's download it.
                    let date = new Date().getTime();
                    let link = document.createElement('a');
                    link.href = res.url;
                    link.setAttribute('download', `addonify-wishlist-all-settings-${date}.json`);
                    document.body.appendChild(link);
                    link.click(); // Simulate the click event.

                } else {

                    ElMessage.error(({
                        message: res.message,
                        offset: 50,
                        duration: 5000,
                    }));
                }

            });
        },

        // ⚡️ Import options.
        // @param payload: file
        importOptions(paylaod) {

            this.isImportingFile = true;

            apiFetch({

                path: BASE_API_URL + '/import_options',
                method: 'POST',
                body: paylaod,

            }).then((res) => {

                this.isImportingFile = false;

                //console.log(res);

                if (res.success == true) {

                    ElMessage.success(({
                        message: res.message,
                        offset: 50,
                        duration: 10000,
                    }));

                    // Fetch options again.
                    this.fetchOptions();

                } else {

                    ElMessage.error(({
                        message: res.message,
                        offset: 50,
                        duration: 5000,
                    }));
                }
            });
        },
    },
});
