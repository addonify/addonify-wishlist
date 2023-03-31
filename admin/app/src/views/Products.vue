<script setup>
import { onMounted, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import Recommended from "@layouts/Recommended.vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
import Hero from "@components/partials/Hero.vue";
import Form from "@components/core/Form.vue";
import JumboBoxTitle from "@layouts/JumboBoxTitle.vue";
import { useProductStore } from "@stores/products";
import { useSettingsStore } from "@stores/settings";
import { textdomain } from "@helpers/global";

const { __ } = wp.i18n;

const store = useSettingsStore();
const proStore = useProductStore();

const disableDocsLink = true; // Disable docs link next to the jumbo box title.
const boxTitle = __("Recommended products", textdomain);

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
	proStore.fetchInstalledAddons();
});

onMounted(() => {
	scrollToTop();
	store.fetchSettings(); // For the route links.
	proStore.fetchProductList();
});
</script>
<template>
	<Hero />
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
