<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import JumboBoxContainer from "@layouts/JumboBoxContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";
import RouteLinks from "@layouts/RouteLinks.vue";

const route = useRoute();

onMounted(() => {
	// Get params from vue route.
	console.log(route.params);
});
</script>
<template>
	<section id="app-divider" class="app-divider">
		<RouteLinks />
		<JumboBoxContainer />
		<Sidebar />
	</section>
</template>