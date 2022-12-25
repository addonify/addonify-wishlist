import { defineStore } from 'pinia'
import { ElMessage } from 'element-plus'

const { apiFetch } = wp;
const { __ } = wp.i18n;

export const useProductStore = defineStore({

    id: 'Product',

    state: () => ({

        allAddons: {}, // Storing all addons slugs.
        allProductSlugStatus: {}, // Storing all addons slug & status.
        hotAddons: {},
        generalAddons: {},
        installedAddons: [],

        isFetching: true, // Fetching recommended plugins list from github.
        isFetchingAllInstalledAddons: true, // Fetched all installed plugins.
        isSettingAddonStatus: true, // Checking plugin status on backend.
        isWaitingForInstallation: "", // Waiting for plugin installation.
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

            //console.log(this.generalAddons);

            if (typeof this.allAddons === 'object') {

                Object.keys(this.allAddons).forEach((key) => {

                    //console.log(key);
                    // Let's add the slug to object with status null for now.
                    // i.e: { 'addonify-wishlist': 'status' }
                    this.allProductSlugStatus[key] = 'null';
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

            try {

                const res = await apiFetch({

                    method: "GET",
                    path: `/wp/v2/plugins`,
                });

                //console.log(res);
                console.log("=> Received the list of all installed plugins....");

                this.installedAddons = res;
                this.setAddonStatusFlag(Object.keys(this.allProductSlugStatus)); // Just send the slug array.
                this.isFetchingAllInstalledAddons = false;

            } catch (err) {

                console.error(err);

                ElMessage.error(({
                    message: __('Error: couldn\'t retrive the list of installed plugins.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 10000,
                }));

                this.isFetchingAllInstalledAddons = false;
            }
        },

        /**
        * Action: Get plugin installed/active status via slug.
        * Returns 'active' or 'inactive' or 'not-installed'.
        * 
        * @param {Object} slug
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
            this.isSettingAddonStatus = false; // Done setting the status till here. Let's set the flag to false.
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

                this.isWaitingForInstallation = true;

                console.log(`=> Trying to install plugin ${slug}...`);

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

                if (data.status === 500) {

                    console.log("=> Folder exists. Try deleting the addon first.");
                }

                if (data.status === 200) {

                    console.log(`=> Plugin ${slug} activated successfully.`);

                    ElMessage.success(({
                        message: __('Plugin activated successfully.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));

                    this.isWaitingForInstallation = false;

                } else {

                    console.log(`=> Couldn't activate plugin ${slug}.`);

                    ElMessage.error(({
                        message: __('Error: couldn\'t activate plugin.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));
                }

            } catch (err) {

                console.error(err);

                ElMessage.error(({
                    message: __('Error: couldn\'t activate plugin.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 10000,
                }));

                this.isWaitingForInstallation = false;
            }
        },

        async handleDeleteAddon(slug) {

            try {

                this.isWaitingForInstallation = true;

                console.log(`=> Trying to delete plugin ${slug}...`);

                const res = await apiFetch({

                    method: "DELETE",
                    path: "/wp/v2/plugins",

                    // Args to send to the endpoint.
                    data: {
                        slug: slug,
                    },
                });

                const data = await res.json();

                if (data.status === 200) {

                    console.log(`=> Plugin ${slug} deleted successfully.`);

                    ElMessage.success(({
                        message: __('Plugin deleted successfully.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));

                    this.isWaitingForInstallation = false;

                } else {

                    console.log(`=> Couldn't delete plugin ${slug}.`);

                    ElMessage.error(({
                        message: __('Error: couldn\'t delete plugin.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 10000,
                    }));
                }

            } catch (err) {

                console.log(err);

                ElMessage.error(({
                    message: __('Error: couldn\'t delete plugin.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 10000,
                }));

                this.isWaitingForInstallation = false;
            }
        }
    }
});