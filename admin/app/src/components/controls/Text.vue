<script setup>
import { computed } from "vue";
import { textdomain } from "@helpers/global";

let { __ } = wp.i18n;

let props = defineProps({
	modelValue: String,
	placeholder: String,
});
// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
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
