<script setup>
	import { computed } from "vue";
	import { ElInput } from "element-plus";

	let props = defineProps({
		modelValue: String,
		className: String,
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
		:class="className"
		type="textarea"
		rows="10"
		:placeholder="
			props.placeholder
				? props.placeholder
				: __('Enter text here...', 'addonify-wishlist')
		"
		resize="vertical"
		input-style="display:block;width: 100%;"
	/>
</template>
<style>
	.adfy-options .el-textarea__inner {
		display: block;
		width: 100%;
		font-family: monospace;
		min-height: 200px;
	}
</style>
