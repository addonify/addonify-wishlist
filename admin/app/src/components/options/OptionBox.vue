<script setup>
import { useRoute } from "vue-router";
import SectionTitle from "@components/options/SectionTitle.vue";
const docLink = "https://docs.addonify.com/";
const route = useRoute();
</script>
<template>
	<div class="adfy-jumbo-boxes">
		<div class="adfy-jumbo-box">
			<SectionTitle title="General settings" :docLink="docLink" />
			<slot></slot>
			<em>Route: {{ $route.params }}</em>
		</div>
	</div>
</template>
