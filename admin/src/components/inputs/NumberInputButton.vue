<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: [String, Number],
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
	<el-input-number v-model="value" size="large" />
</template>
<style lang="scss">
	.adfy-options {
		.el-input-number--large {
			width: 140px;
		}
	}
</style>
