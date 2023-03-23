<script setup>
import RouteLinks from "@layouts/RouteLinks.vue";
import JumboBoxContainer from "@layouts/JumboBoxContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";
import { useSettingsStore } from "@stores/settings";
</script>
<template>
	<section id="app-divider" class="app-divider">
		<RouteLinks />
		<JumboBoxContainer />
		<Sidebar />
	</section>
</template>
