<script setup>
import Icon from "@components/core/Icon.vue";
const { __ } = wp.i18n;
</script>
<template>
	<section class="adfy-hero">
		<div class="content">
			<h3 class="hero-title">
				{{
					__(
						"Need help? We are just a click away. Create a ticket.",
						"addonify-wishlist"
					)
				}}
			</h3>
		</div>
		<div class="action">
			<a
				class="adfy-button review-link"
				href="https://wordpress.org/support/plugin/addonify-wishlist/"
				target="_blank"
			>
				{{ __("Get Help", "addonify-wishlist") }}
				<Icon name="question" size="20px" />
			</a>
		</div>
	</section>
</template>
