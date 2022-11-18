<script setup>
	import Navigation from "../components/layouts/Navigation.vue";
	let { __ } = wp.i18n;
</script>

<template>
	<section class="adfy-container">
		<main class="adfy-columns main-content">
			<aside class="adfy-col start aside secondary">
				<Navigation />
			</aside>
			<section class="adfy-col end site-primary">
				<p>{{ __("Coming soon.....", "addonify-wishlist") }}</p>
			</section>
		</main>
	</section>
</template>
