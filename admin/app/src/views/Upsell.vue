<script setup>
import { onMounted } from "vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
import Hero from "@components/partials/Hero.vue";
import { useSettingsStore } from "@stores/settings";
import { textdomain } from "@helpers/global";

const { __ } = wp.i18n;

const store = useSettingsStore();

onMounted(() => {
	store.fetchSettings(); // For the route links.
});
</script>
<template>
	<Hero />
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
										textdomain
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
