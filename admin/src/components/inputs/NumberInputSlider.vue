<script setup>
	import { computed } from "vue";

	let props = defineProps({
		modelValue: [String, Number], // loose strict checking.
		minVal: Number,
		maxVal: Number,
		step: Number,
		toolTipText: String,
	});

	// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
	let emit = defineEmits(["update:modelValue"]);
	let value = computed({
		get() {
			return parseInt(props.modelValue);
		},
		set(newValue) {
			emit("update:modelValue", newValue);
		},
	});

	let appendToolTipText = (val) => {
		return val + " " + props.toolTipText;
	};
</script>
<template>
	<el-slider
		v-model="value"
		:step="props.step ? props.step : 1"
		:min="props.minVal ? props.minVal : 0"
		:max="props.maxVal ? props.maxVal : 1000"
		:format-tooltip="props.toolTipText ? appendToolTipText : null"
	/>
</template>
<style lang="scss">
	.adfy-options {
		.el-slider {
			flex: 0 0 100%;
		}
	}
</style>
