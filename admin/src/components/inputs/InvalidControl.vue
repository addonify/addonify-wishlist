<script setup>
	const { __ } = wp.i18n;
</script>
<template>
	<span class="unsupported-control-text">
		❌
		{{ __("Input is not supported.", "addonify-wishlist") }}
		<a
			href="https://docs.addonify.com/kb/woocommerce-wishlist/developer/"
			target="_blank"
			rel="documentation"
			class="adfy-button fake-button has-underline forward-to-doc-link"
		>
			{{ __("Check docs", "addonify-wishlist") }}
		</a>
	</span>
</template>
<style lang="scss">
	.unsupported-control-text {
		font-size: 14px;
	}
	.adfy-button.fake-button.forward-to-doc-link {
		font-size: 14px;
		fill: var(--addonify_primary_color);
		color: var(--addonify_primary_color);

		&::after,
		&::before {
			content: "";
			bottom: -5px;
			height: 2px;
		}
		&::after {
			content: "";
			background-color: var(--addonify_primary_color);
		}
		&:hover {
			fill: var(--addonify_base_text_color);
			color: var(--addonify_base_text_color);

			&::after,
			&::before {
				content: "";
				background-color: var(--addonify_base_text_color);
			}
		}
	}
</style>
