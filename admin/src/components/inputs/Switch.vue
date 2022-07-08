<script setup>
	import { computed } from "vue";
	import { ElSwitch } from "element-plus";
	import { Check, Close } from "@element-plus/icons-vue";

	let props = defineProps({
		modelValue: [Boolean, Number, String], // loose strict.
	});

	//console.log(props.state, props.fieldId);

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
	<el-switch
		v-model="value"
		size="large"
		inline-prompt
		:active-icon="Check"
		:inactive-icon="Close"
	/>
</template>
