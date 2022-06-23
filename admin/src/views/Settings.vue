<script setup>
	import Settings from "../components/Settings.vue";
	import Navigation from "../components/layouts/Navigation.vue";
</script>

<template>
	<section class="adfy-container">
		<main class="adfy-columns main-content">
			<aside class="adfy-col start site-secondary">
				<Navigation />
			</aside>
			<section class="adfy-col end site-primary">
				<Settings />
			</section>
		</main>
	</section>
</template>
