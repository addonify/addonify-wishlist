<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: String,
		choices: [Object, Array],
	});

	// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
	let emit = defineEmits(["update:modelValue"]);
	let bindModel = computed({
		get() {
			return props.modelValue;
		},
		set(value) {
			emit("update:modelValue", value);
		},
	});
</script>
<template>
	<el-radio-group v-model="bindModel" v-for="(value, key) in props.choices">
		<el-radio :label="key">{{ value }}</el-radio>
	</el-radio-group>
</template>
