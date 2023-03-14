<script setup>
import Icon from "@components/core/Icon.vue";
import { textdomain } from "@helpers/global";
const { __ } = wp.i18n;
</script>
<template>
	<section id="adfy-hero">
		<div class="content">
			<h3 class="hero-title">
				<Icon name="hand-wave" size="32px" />
				{{ __("Hello", textdomain) }}
			</h3>
			<p class="hero-description">
				{{
					__(
						"Welcome to the Addonify Wishlist For WooCommerce admin setting page.",
						textdomain
					)
				}}
			</p>
			<div class="action">
				<a
					class="adfy-button doc-link"
					href="https://docs.addonify.com"
					target="_blank"
				>
					{{ __("Documentation", textdomain) }}
				</a>
				<a
					class="adfy-button review-link"
					href="https://wordpress.org/support/plugin/addonify-wishlist/reviews/#new-post"
					target="_blank"
				>
					{{ __("Drop a review", textdomain) }}
					<Icon name="comment" size="18px" />
				</a>
			</div>
		</div>
	</section>
</template>
