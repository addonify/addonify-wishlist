<script setup>
import { onMounted } from "vue";
import Header from "@layouts/Header.vue";
import Footer from "@layouts/Footer.vue";
</script>
<template>
	<Header />
	<section id="addonify-container">
		<router-view></router-view>
	</section>
	<Footer />
</template>
