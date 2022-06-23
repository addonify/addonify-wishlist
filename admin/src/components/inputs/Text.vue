<script setup>
	import { computed } from "vue";
	let { __, _x, _n, _nx } = wp.i18n;

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
	<el-input
		v-model="value"
		:placeholder="__('Please enter...', 'addonify-wishlist')"
	/>
</template>
