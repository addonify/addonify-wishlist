<script setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	modelValue: {
		type: Number,
		required: true,
	},
	type: {
		type: String,
		default: "default",
		required: false,
	},
	min: {
		type: [String, Number],
		required: false,
	},
	max: {
		type: [String, Number],
		required: false,
	},
	step: {
		type: [String, Number],
		required: false,
	},
	precision: {
		type: [String, Number],
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
		return parseInt(props.modelValue);
	},
	set(newValue) {
		emit("update:modelValue", newValue);
	},
});
</script>
<template>
	<el-input-number
		v-if="props.type === 'default'"
		size="large"
		controls-position="right"
		v-model="value"
		:min="props.min"
		:max="props.max"
		:step="props.steps"
		:precision="props.precision"
	/>
	<el-input-number
		v-else
		size="large"
		v-model="value"
		:min="props.min"
		:max="props.max"
		:step="props.steps"
		:precision="props.precision"
	/>
</template>
