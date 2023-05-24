<script setup>
import { onMounted } from "vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
//import Hero from "@components/partials/Hero.vue";
import { useSettingsStore } from "@stores/settings";

const { __ } = wp.i18n;

const store = useSettingsStore();

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
});
</script>
<template>
	<!--<Hero />-->
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
			<main id="app-main app-primary" class="app-primary">
				<div id="upsell-pro">
					<div class="adfy-jumbo-boxes">
						<div class="adfy-jumbo-box">
							<p class="upsell-description">
								{{
									__(
										"We are currently working on premium version. Stay tuned....",
										"addonify-wishlist"
									)
								}}
							</p>
						</div>
					</div>
				</div>
			</main>
		</template>
		<Sidebar />
	</section>
</template>
