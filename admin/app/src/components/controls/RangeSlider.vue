<script setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

let props = defineProps({
	modelValue: {
		type: [Number, String],
		required: true,
	},
	minVal: {
		type: Number,
		required: false,
	},
	maxVal: {
		type: Number,
		required: false,
	},
	step: {
		type: Number,
		required: false,
	},
	toolTipText: {
		type: String,
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
		return parseInt(props.modelValue);
	},
	set(newValue) {
		emit("update:modelValue", newValue);
	},
});

/**
 *
 * Function that appends tooltip text to the value.
 *
 * @param {string} val
 * @returns {string} string
 * @since: 2.0.0
 */

let appendToolTipText = (val) => val + " " + props.toolTipText;
</script>
<template>
	<el-slider
		v-model="value"
		:step="props.step ? props.step : 1"
		:min="props.minVal ? props.minVal : 0"
		:max="props.maxVal ? props.maxVal : 1000"
		:format-tooltip="props.toolTipText ? appendToolTipText : false"
	/>
</template>
<style lang="scss">
.adfy-options {
	.el-slider {
		flex: 0 0 100%;
	}
}
</style>
