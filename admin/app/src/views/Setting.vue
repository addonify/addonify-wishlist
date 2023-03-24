<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import JumboBoxContainer from "@layouts/JumboBoxContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
import Hero from "@components/partials/Hero.vue";
import { useSettingsStore } from "@stores/settings";

const store = useSettingsStore();

onMounted(() => {
	store.fetchSettings();
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
			<Loading />
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
