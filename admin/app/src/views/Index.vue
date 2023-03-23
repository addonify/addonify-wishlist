<script setup>
//import { onMounted } from "vue";
import RouteLinks from "@layouts/RouteLinks.vue";
import JumboBoxContainer from "@layouts/JumboBoxContainer.vue";
import Sidebar from "@layouts/Sidebar.vue";

//import { useRoute } from "vue-router";
</script>
<template>
	<section id="app-divider" class="app-divider">
		<RouteLinks />
		<JumboBoxContainer />
		<Sidebar />
	</section>
</template>
