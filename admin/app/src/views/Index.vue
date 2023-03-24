<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import JumboBoxContainer from "@layouts/JumboBoxContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import Loading from "@components/core/Loading.vue";
import { useSettingsStore } from "@stores/settings";

const route = useRoute();
const store = useSettingsStore();

//watchEffect(() => {
//	console.log(route.params);
//});

onMounted(() => {
	store.fetchSettings();
});
</script>
<template>
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
				:section="store.data.tabs"
				:reactiveState="store.settings"
			/>
		</template>
		<Sidebar />
	</section>
</template>
