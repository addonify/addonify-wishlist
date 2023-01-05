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
                        duration: 20000,
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
                    message: __('Error: Couldn\'t retrive the list of installed plugins.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 20000,
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

                console.log(`=> Trying to install plugin ${slug}...`);

                const res = await apiFetch({

                    method: "POST",
                    path: "/wp/v2/plugins",

                    data: {
                        slug: slug,
                        status: "active",
                    },
                });

                console.log(res);

                if (res.status === 'active') {

                    console.log(`=> Plugin ${slug} installed successfully.`);

                    ElMessage.success(({
                        message: __('Plugin installed successfully.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 5000,
                    }));

                    this.allProductSlugStatus[slug] = 'active'; // Update the status of the plugin.
                    return await res;
                }

            } catch (err) {

                console.error(err);

                ElMessage.error(({
                    message: __('Error: couldn\'t install plugin.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 20000,
                }));

                this.isWaitingForInstallation = false;
                return await err;
            }
        },

        /**
         * Update plugin status. (active/inactive)
         * @param {String} slug
         * @args {slug, status} status
         */

        async updateAddonStatus(slug) {

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

                console.log(res);

                if (res.status == 'active') {

                    console.log(`=> Plugin ${slug} activated successfully.`);

                    ElMessage.success(({
                        message: __('Plugin activated successfully.', 'addonify-wishlist'),
                        offset: 50,
                        duration: 5000,
                    }));

                    this.allProductSlugStatus[slug] = 'active'; // Update the status of the plugin.
                    return await res;
                }

            } catch (err) {

                console.log(err);

                ElMessage.error(({
                    message: __('Error: Couldn\'t activate the plugin.', 'addonify-wishlist'),
                    offset: 50,
                    duration: 20000,
                }));

                return await err;
            }
        }
    }
});