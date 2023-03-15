<script setup>
import { onMounted } from "vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import OptionsContainer from "@layouts/OptionsContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";

import { useRoute } from "vue-router";

//const router = useRouter();
//const route = useRoute();

onMounted(() => {
	// Push to /s/general route immediately.
	//router.push({ name: "setting", params: { section: "general" } });
});
</script>
<template>
	<section id="app-divider" class="app-divider">
		<RouteLinks />
		<OptionsContainer />
		<Sidebar />
	</section>
</template>
