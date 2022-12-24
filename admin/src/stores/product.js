import { defineStore } from 'pinia'
import { ElMessage } from 'element-plus'

const { apiFetch } = wp;

export const useProductStore = defineStore({

    id: 'Product',

    state: () => ({

        allAddons: {},
        allAddonsSlug: [], // Storing all addons slug.
        hotAddons: {},
        generalAddons: {},
        installedAddons: [],

        isFetching: true, // Fetching recommended plugins list from github.
        isFetchingAllInstalledAddons: true, // Fetched all installed plugins.
        isCheckingAddonStatus: true, // Checking plugin status on backend.
        isWaitingForInstallation: false, // Waiting for plugin installation.
    }),

    actions: {

        /**
         * Action: Fetch github repo data.
         * Get addons slug from github repo.
         * @param slug
         */

        async fetchGithubRepo() {

            try {

                const res = await fetch("https://raw.githubusercontent.com/addonify/recommended-products/main/products.json");
                const data = await res.json();

                //console.log(data);

                if (res.status == 200) {

                    console.log("💥 Github repo fetched successfully.");
                    this.processRecommendedPluginsList(data);
                    this.isFetching = false;

                } else {

                    console.error("Couldn't fetch Github repo " + res);

                    ElMessage.error(({
                        message: __('Error: couldn\'t fetch recommended plugins list.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));
                }

            } catch (err) {

                console.error(err);
                this.isFetching = false;
            }
        },

        /**
        * Action: Process the recommended plugins list.
        * Create three arrays [hot, general & all]
        * Called on fetchGithubRepo() action.
        * @param {object} list
        */

        processRecommendedPluginsList(list) {

            console.log("=> Processing the list that was retrived....");

            this.hotAddons = list.data.hot;
            this.generalAddons = list.data.general;
            this.allAddons = { ...this.hotAddons, ...this.generalAddons };

            console.log(this.generalAddons);

            if (typeof this.allAddons === 'object') {

                Object.keys(this.allAddons).forEach((key) => {

                    //console.log(key);
                    this.allAddonsSlug.push(key);
                });

            } else {

                console.error("💥 Couldn't process the list plugins list.");

                ElMessage.error(({
                    message: __('Error: couldn\'t process the recommended plugins list.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 10000,
                }));
            }
        },

        /**
         * Action: Check plugin status.
         * Call backend api to check plugin status.
         * @param {Object} addons
         */

        async fetchInstalledAddons() {

            console.log("=> Getting the list of all plugins installed on the site....");

            const res = await apiFetch({

                method: "GET",
                path: `/wp/v2/plugins`,
            });

            console.log(res);
            this.installedAddons = res;
            this.isFetchingAllInstalledAddons = false;
        },

        /**
        * Action: Get plugin installed/active status via slug.
        * Returns 'active' or 'inactive' or 'not-installed'.
        * 
        * @param {String} slug
        */


        getAddonStatus(slug) {

            if (typeof this.installedAddons == 'object' && this.installedAddons.length > 0) {

                console.log("=> Checking the status of the addon " + slug);

                let installed = this.installedAddons;

                installed.forEach((item) => {

                    //console.log(item.textdomain);

                    if (item.textdomain == slug) {

                        return item.status == 'active' ? 'active' : 'inactive';

                    } else {

                        return 'not-installed';
                    }

                });

            } else {

                console.log("=> Bailing!!! Installed addons list is not ready yet...");
            }

            //this.isCheckingAddonStatus = false;
        },

        /*
        *
        * Action: Handle plugin activation.
        * Call REST API to activate plugin.
        * Wait for the signal from the backend.
        * @param slug
        */

        async handleAddonInstallation(slug) {

            try {

                const res = await apiFetch({

                    method: "POST",
                    path: "/wp/v2/plugins",

                    // Args to send to the endpoint.
                    data: {
                        slug: slug,
                        status: "active",
                    },
                });

                const data = await res.json();

                if (data.status === 200) {

                    console.log("Plugin activated successfully.");

                    ElMessage.success(({
                        message: __('Plugin activated successfully.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));

                    this.isWaitingForInstallation = false;

                } else {

                    console.log("Couldn't activate plugin.");

                    ElMessage.error(({
                        message: __('Error: couldn\'t activate plugin.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));
                }

            } catch (err) {

                console.log(err);

                ElMessage.error(({
                    message: __('Error: couldn\'t activate plugin.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 10000,
                }));

                this.isWaitingForInstallation = false;
            }
        },
    }
});