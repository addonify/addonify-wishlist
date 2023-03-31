<script setup>
import Icon from "@components/core/Icon.vue";
import { textdomain } from "@helpers/global";

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

	disableDocs: {
		type: Boolean,
		default: false,
		required: false,
	},

	docLabel: {
		type: String,
		required: false,
	},

	docLink: {
		type: String,
		default: "https://docs.addonify.com/",
		required: false,
	},
});

const { __ } = wp.i18n;
</script>
<template>
	<div class="box-title">
		<div class="column title">
			<h3 class="x-heading">{{ props.title }}</h3>
		</div>
		<div class="column action">
			<a
				v-if="props.disableDoc !== true"
				:href="props.docLink"
				target="_blank"
				rel="noopener noreferrer"
				class="adfy-button fake-button link-external"
			>
				{{
					props.docLabel
						? props.docLabel
						: __("Check docs", textdomain)
				}}
				<Icon name="arrow-right" size="16px" />
			</a>
		</div>
	</div>
</template>
