<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: [Boolean],
		label: [String],
	});
	// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
	let emit = defineEmits(["update:modelValue"]);
	let value = computed({
		get() {
			return props.modelValue;
		},
		set(value) {
			emit("update:modelValue", value);
		},
	});
</script>
<template>
	<el-checkbox v-model="value" label="{{props.label}}" size="large" />
</template>
