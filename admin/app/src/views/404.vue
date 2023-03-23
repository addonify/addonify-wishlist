<script setup>
import { textdomain } from "@helpers/global";
let { __ } = wp.i18n;
</script>
<template>
	<div class="error-404">
		<h3>{{ __("404", textdomain) }}</h3>
		<p>{{ __("Oops, page not found!", textdomain) }}</p>
		<router-link to="/" class="adfy-button">
			{{ __("Go Back", textdomain) }}
		</router-link>
	</div>
</template>
