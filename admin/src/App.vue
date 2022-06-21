<template>
	<Header />
	<router-view></router-view>
	<Footer />
</template>
<script setup>
	import Header from "./components/layouts/Header.vue";
	import Footer from "./components/layouts/Footer.vue";
</script>
