import { toRaw } from 'vue';
import { defineStore } from 'pinia'
import { ElMessage } from 'element-plus'

let { isEqual, cloneDeep } = lodash;
let { apiFetch } = wp;
let BASE_API_URL = ADDONIFY_WISHLIST_LOCOLIZER.rest_namespace;
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
        errors: "",
    }),
    getters: {

        // ⚡️ Check if we need to save the options.
        needSave: (state) => {

            return !isEqual(state.options, oldOptions) ? true : false;
        },

        // ⚡️ Get state based on supplied arg.
        getState: (state) => (arg) => {

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
        async fetchOptions() {

            apiFetch({
                path: BASE_API_URL + '/get_options',
                method: 'GET',
            }).then((res) => {
                this.options = res.settings_values;
                this.data = res.tabs;
                oldOptions = cloneDeep(res.settings_values);
                //console.log(oldOptions);
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
        async updateOptions(payload) {

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
    },
});
