<script setup>
import { onMounted, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import Recommended from "@layouts/Recommended.vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
import Form from "@components/core/Form.vue";
import JumboBoxTitle from "@layouts/JumboBoxTitle.vue";
import { useProductStore } from "@stores/products";
import { useSettingsStore } from "@stores/settings";

const { __ } = wp.i18n;

const store = useSettingsStore();
const proStore = useProductStore();

const disableDocsLink = true; // Disable docs link next to the jumbo box title.
const boxTitle = __("Recommended products", "addonify-wishlist");

/**
 *
 * Scroll to the top of the page.
 *
 * @since: 2.0.0
 */

const scrollToTop = () => {
	window.scrollTo({
		top: 0,
		behavior: "smooth",
	});
};

onBeforeMount(() => {
	/**
	 *
	 * Fetch the installed addons if we don't have it's state set.
	 * Use cache method.
	 *
	 * @since: 2.0.0
	 */

	if (typeof proStore.installedAddons === "object") {
		if (Object.keys(proStore.installedAddons).length === 0) {
			proStore.fetchInstalledAddons();
		}
	} else {
		console.log("Bailing. Couldn't identify the type of installedAddons.");
	}
});

onMounted(() => {
	scrollToTop();

	/**
	 *
	 * Check state of options in memory.
	 * If we have state in memory, we can use it.
	 * If not, we need to fetch it from the server.
	 *
	 * @since: 2.0.3
	 */

	if (!store.haveSettingsStateInMemory) {
		store.fetchSettings();
	}

	/**
	 *
	 * Fetch the recommdended addons if we don't have it's state set.
	 * Use cache method.
	 *
	 * @since: 2.0.0
	 */
	if (typeof proStore.allAddons === "object") {
		if (Object.keys(proStore.allAddons).length === 0) {
			proStore.fetchProductList();
		}
	} else {
		console.log("Bailing. Couldn't identify the type of allAddons.");
	}
});
</script>
<template>
	<section
		id="app-divider"
		class="app-divider"
		:data_loading="proStore.isLoading"
	>
		<template v-if="proStore.isLoading">
			<el-skeleton :rows="30" animated />
		</template>
		<template v-else>
			<RouteLinks />
			<main id="app-main app-primary" class="app-primary">
				<Form id="recommended-products">
					<div class="adfy-jumbo-boxes">
						<div class="adfy-jumbo-box">
							<JumboBoxTitle
								:title="boxTitle"
								:disableDocs="disableDocsLink"
							/>
							<div id="recommended-product-list">
								<Recommended
									v-for="(addon, key) in proStore.hotAddons"
									:slug="key"
									:name="addon.name"
									:description="addon.description"
									:thumb="addon.thumbnail"
									:category="addon.category"
									:status="proStore.allProductSlugStatus[key]"
								/>
							</div>
						</div>
					</div>
				</Form>
			</main>
		</template>
		<Sidebar />
	</section>
</template>
