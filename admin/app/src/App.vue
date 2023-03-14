<script lang="ts" setup>
// @ts-ignore
import Header from "@layouts/Header.vue";
// @ts-ignore
import Footer from "@layouts/Footer.vue";
// @ts-ignore
import Hero from "@components/partials/Hero.vue";
</script>
<template>
	<Header />
	<section id="addonify-container">
		<Hero />
		<router-view></router-view>
	</section>
	<Footer />
</template>
