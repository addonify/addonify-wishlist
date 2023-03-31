<script setup>
import Icon from "@components/core/Icon.vue";
import { textdomain } from "@helpers/global";
const { __ } = wp.i18n;
</script>
<template>
	<section id="adfy-hero">
		<div class="content">
			<h3 class="hero-title">
				👋
				{{ __("Hello!", textdomain) }}
			</h3>
			<p class="hero-description">
				{{
					__(
						"Sell more with Addonify Wishlist. We hope you love using it.",
						textdomain
					)
				}}
			</p>
		</div>
		<div class="action">
			<a
				class="adfy-button review-link"
				href="https://wordpress.org/support/plugin/addonify-wishlist/reviews/#new-post"
				target="_blank"
			>
				{{ __("Drop a review", textdomain) }}
				<Icon name="comment" size="18px" />
			</a>
		</div>
	</section>
</template>
