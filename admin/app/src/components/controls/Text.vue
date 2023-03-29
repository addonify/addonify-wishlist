<script setup>
import { computed } from "vue";
import { textdomain } from "@helpers/global";

let { __ } = wp.i18n;

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

let props = defineProps({
	modelValue: {
		type: String,
		required: true,
	},
	placeholder: {
		type: String,
		required: false,
	},
	className: {
		type: String,
		required: false,
	},
	type: {
		type: String,
		default: "text",
		required: false,
	},
});

/**
 *
 * Define emits for v-model usage.
 * Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
 *
 * @since: 2.0.0
 */

let emit = defineEmits(["update:modelValue"]);
let value = computed({
	get() {
		return props.modelValue;
	},
	set(newValue) {
		emit("update:modelValue", newValue);
	},
});
</script>
<template>
	<template v-if="props.type === 'text'">
		<el-input
			v-model="value"
			:placeholder="
				props.placeholder
					? props.placeholder
					: __('Enter text...', textdomain)
			"
			size="large"
		/>
	</template>
	<template v-if="props.type === 'textarea'">
		<el-input
			v-model="value"
			:class="className"
			type="textarea"
			rows="10"
			:placeholder="
				props.placeholder
					? props.placeholder
					: __('Enter text here...', textdomain)
			"
			resize="vertical"
		/>
	</template>
</template>
