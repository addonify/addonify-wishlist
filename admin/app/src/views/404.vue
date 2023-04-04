<script setup>
import { onMounted } from "vue";
let { __ } = wp.i18n;

/**
 *
 * Scroll to the top of the page.
 *
 * @since: 2.0.0
 */

const scrollToTop = () => {
	window.scrollTo({
		top: 0,
		behavior: "smooth",
	});
};

onMounted(() => {
	scrollToTop();
});
</script>
<template>
	<section id="dead-end">
		<h3 class="adfy-heading">{{ __("404", "addonify-wishlist") }}</h3>
		<p class="adfy-description">
			{{
				__(
					"Oops, something seems broken. We can't find the page you're looking for.",
					"addonify-wishlist"
				)
			}}
		</p>
		<router-link to="/" class="adfy-button">
			<span class="icon">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					width="18"
					height="18"
				>
					<path
						d="M23.707,22.293L3.482,2.068c.165-.044,.339-.068,.518-.068H13c.552,0,1-.448,1-1s-.448-1-1-1H4C1.794,0,0,1.794,0,4V13c0,.552,.448,1,1,1s1-.448,1-1V4c0-.179,.024-.352,.068-.518L22.293,23.707c.195,.195,.451,.293,.707,.293s.512-.098,.707-.293c.391-.391,.391-1.023,0-1.414Z"
					/>
				</svg>
			</span>
			{{ __("Go to home", "addonify-wishlist") }}
		</router-link>
	</section>
</template>
