<script setup>
import SectionTitle from "@components/options/SectionTitle.vue";
const docLink = "https://docs.addonify.com/";
</script>
<template>
	<div class="adfy-jumbo-boxes">
		<div class="adfy-jumbo-box">
			<SectionTitle title="Wishlist button" :docLink="docLink" />
			<slot></slot>
		</div>
	</div>
</template>
