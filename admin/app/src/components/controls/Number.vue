<script setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	modelValue: {
		type: [Number, String],
		required: true,
	},
	design: {
		type: String,
		default: "arrow",
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
	sliderTipText: {
		type: String,
		required: false,
	},
	sliderInput: {
		type: Boolean,
		default: true,
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

/**
 *
 * Append slider tooltip text.
 *
 * @param {string} val
 * @returns {string} val
 * @since: 2.0.0
 */

const appendSliderToolTip = (val) => val + " " + props.sliderTipText;
</script>
<template>
	<el-input-number
		v-if="props.design === 'plus-minus'"
		size="large"
		v-model="value"
		:min="props.min"
		:max="props.max"
		:step="props.steps"
		:precision="props.precision"
	/>
	<el-slider
		v-else-if="props.design === 'slider'"
		v-model="value"
		:min="props.min ? props.min : 0"
		:max="props.max ? props.max : 1000"
		:step="props.step ? props.step : 1"
		:show-input="props.sliderInput ? true : false"
		:format-tooltip="props.sliderTipText ? appendSliderToolTip : null"
		size="large"
	/>
	<el-input-number
		v-else
		size="large"
		controls-position="right"
		v-model="value"
		:min="props.min"
		:max="props.max"
		:step="props.steps"
		:precision="props.precision"
	/>
</template>
