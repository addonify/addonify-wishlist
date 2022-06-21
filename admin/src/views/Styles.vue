<script setup>
	import Navigation from "../components/layouts/Navigation.vue";
	import StyleForm from "../components/form/Styles.vue";
</script>

<template>
	<section class="adfy-container">
		<main class="adfy-columns main-content">
			<aside class="adfy-col start aside site-secondary">
				<Navigation />
			</aside>
			<section class="adfy-col end site-primary">
				<StyleForm />
			</section>
		</main>
	</section>
</template>
