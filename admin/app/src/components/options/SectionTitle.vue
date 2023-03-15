<script setup>
import Icon from "@components/core/Icon.vue";

/**
 *
 * Define props.
 */
const props = defineProps({
	title: {
		type: String,
		default: "....",
		required: true,
	},

	docLabel: {
		type: String,
		default: "Check docs",
		required: false,
	},

	docLink: {
		type: String,
		default: "https://docs.addonify.com/",
		required: false,
	},
});
</script>
<template>
	<div class="box-title">
		<div class="column title">
			<h3 class="x-heading">{{ props.title }}</h3>
		</div>
		<div class="column action">
			<a
				:href="props.docLink"
				target="_blank"
				rel="noopener noreferrer"
				class="adfy-button fake-button link-external"
			>
				{{ props.docLabel }}
				<Icon name="arrow-right" size="16px" />
			</a>
		</div>
	</div>
</template>
