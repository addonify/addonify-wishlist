<script setup>
	let { __ } = wp.i18n;
</script>
<template>
	<div class="error-404">
		<h3>{{ __("404", "addonify-wishlist") }}</h3>
		<p>{{ __("Oops, page not found!", "addonify-wishlist") }}</p>
		<router-link to="/" class="adfy-button">
			{{ __("Go Back", "addonify-wishlist") }}
		</router-link>
	</div>
</template>
