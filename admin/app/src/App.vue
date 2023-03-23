<script setup>
import { onMounted } from "vue";
import Header from "@layouts/Header.vue";
import Footer from "@layouts/Footer.vue";
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
