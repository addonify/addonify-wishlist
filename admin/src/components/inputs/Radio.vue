<script setup>
	import { computed } from "vue";
	import { ElRadioGroup, ElRadio } from "element-plus";

	let props = defineProps({
		modelValue: String,
		choices: [Object, Array],
	});

	// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
	let emit = defineEmits(["update:modelValue"]);
	let vModalValue = computed({
		get() {
			return props.modelValue;
		},
		set(newValue) {
			emit("update:modelValue", newValue);
		},
	});
</script>
<template>
	<el-radio-group v-model="vModalValue" v-for="(value, key) in props.choices">
		<el-radio :label="key">{{ value }}</el-radio>
	</el-radio-group>
</template>
