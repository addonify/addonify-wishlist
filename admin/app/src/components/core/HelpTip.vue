<script setup>
import Icon from "@components/core/Icon.vue";
import { textdomain } from "@helpers/global";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	content: {
		type: String,
		required: true,
	},
});
</script>
<template>
	<el-tooltip
		class="box-item"
		popper-class="tooltip"
		effect="dark"
		placement="top"
		:content="props.content ? props.content : __('No content', textdomain)"
	>
		<span class="icon">
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="currentColor"
				width="14px"
				height="14px"
			>
				<path
					d="M24,12A12,12,0,1,1,12,0,12.013,12.013,0,0,1,24,12ZM14,12a2,2,0,0,0-2-2H10v2h2v7h2ZM12,5a1.5,1.5,0,1,0,1.5,1.5A1.5,1.5,0,0,0,12,5Z"
				/>
			</svg>
		</span>
	</el-tooltip>
</template>
