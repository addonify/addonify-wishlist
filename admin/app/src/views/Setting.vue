<script setup>
import { ref, onMounted } from "vue";
import SectionTitle from "@components/options/SectionTitle.vue";

const docLink = "https://docs.addonify.com/";
const param = ref("");

// On mounted.

onMounted(() => {
	// Get params from vue route.
	console.log($route.params);
});
</script>
<template>
	<section id="app-divider" class="app-divider">
		<RouteLinks />
		<OptionsContainer>
			<SectionTitle title="Wishlist button" :docLink="docLink" />
		</OptionsContainer>
		<Sidebar />
	</section>
</template>
