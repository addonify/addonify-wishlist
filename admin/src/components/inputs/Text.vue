<script setup>
	import { computed } from "vue";
	let { __, _x, _n, _nx } = wp.i18n;

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
				: __('Enter text here...', 'addonify_wishlist')
		"
		size="large"
	/>
</template>
