<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: String,
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
	<el-input type="number" v-model="value" />
</template>
