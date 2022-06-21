<script setup>
	let { __, _x, _n, _nx } = wp.i18n;
</script>
<template>
	<div class="error-404">
		<h3>{{ __("404", "addonify-quick-view") }}</h3>
		<p>{{ __("Oops, page not found!", "addonify-quick-view") }}</p>
		<router-link to="/" class="adfy-button">
			{{ __("Go Back", "addonify-quick-view") }}
		</router-link>
	</div>
</template>
