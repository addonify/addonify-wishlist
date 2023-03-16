<script setup>
import { computed } from "vue";
import { textdomain } from "@helpers/global";
const { __ } = wp.i18n;

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	modelValue: {
		type: [Array, String, Number, Object],
		required: true,
	},
	placeholder: {
		type: String,
		required: false,
	},
});

/**
 *
 * Define emits for v-model usage.
 * Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
 *
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
	<el-select
		v-model="value"
		size="large"
		filterable
		clearable
		:placeholder="
			props.placeholder
				? props.placeholder
				: __('Enter text here...', textdomain)
		"
	>
		<el-option />
	</el-select>
</template>
<style lang="css">
.el-select-dropdown__item.selected {
	font-weight: normal;
}
</style>
