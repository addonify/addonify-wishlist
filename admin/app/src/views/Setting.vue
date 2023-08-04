<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import JumboBoxContainer from "@layouts/JumboBoxContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
import { useSettingsStore } from "@stores/settings";
import { useProductStore } from "@stores/products";
import { advertiseUpsell } from "@helpers/global";

const store = useSettingsStore();
const proStore = useProductStore();

onMounted(() => {
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
	 * Fetch the recommded & installed addons in background.
	 * Doing this we can avoid the loading when user navigate to the recommended products page.
	 * Wait till 20 seconds.
	 *
	 * @since: 2.0.6
	 */
	let operation = null;
	const delay = 20000; // 20 seconds.

	if (typeof proStore.allAddons === "object") {
		if (Object.keys(proStore.allAddons).length === 0) {
			// set a timeout to fetch the product list.
			operation = setTimeout(() => {
				if (typeof proStore.allAddons === "object") {
					if (Object.keys(proStore.allAddons).length === 0) {
						proStore.fetchProductList().then((res) => {
							if (res.status === 200) {
								proStore.fetchInstalledAddons();
							}
						});
					}
				}

				clearTimeout(operation);
			}, delay);
		}
	}
});
</script>
<template>
	<section
		id="app-divider"
		class="app-divider"
		:data_loading="store.status.isLoading"
	>
		<template v-if="store.status.isLoading">
			<el-skeleton :rows="30" animated />
		</template>
		<template v-else>
			<RouteLinks />
			<JumboBoxContainer
				:section="store.data"
				:reactiveState="store.settings"
			/>
		</template>
		<Sidebar />
	</section>
</template>
