<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: [String, Number], // loose strict checking.
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
</script>
<template>
	<el-input type="number" v-model="value" :min="0" />
</template>
