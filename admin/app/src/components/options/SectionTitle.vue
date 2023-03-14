<script setup>
import Icon from "@components/Icon.vue";
import { textdomain } from "@helpers/global";

const { __ } = wp.i18n;
const defDocLinkLabel = __("Check docs", textdomain);

/**
 *
 * Define props.
 */
const props = defineProps({
	secTitle: {
		type: String,
		default: "?",
		required: true,
	},

	docLabel: {
		type: String,
		default: defDocLinkLabel,
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
	<div class="option-box-section-title">
		<div class="adfy-flex">
			<div class="column title">
				<h3 class="x-heading">{{ props.secTitle }}</h3>
			</div>
			<div class="column action">
				<a :href="props.docLink" target="_blank" rel="noopener noreferrer">
					{{ props.docLabel }}
					<Icon name="arrow-right" size="16px" />
				</a>
			</div>
		</div>
	</div>
</template>
