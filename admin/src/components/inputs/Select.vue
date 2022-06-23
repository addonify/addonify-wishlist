<script setup>
	import { computed } from "vue";
	let { __, _x, _n, _nx } = wp.i18n;

	let props = defineProps({
		modelValue: [Number, String],
		choices: [Object, Array],
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
	<el-select
		v-model="value"
		:placeholder="__('Select', 'addonify-wishlist')"
		size="large"
	>
		<el-option
			v-for="(label, key) in props.choices"
			:label="label"
			:value="key"
		/>
	</el-select>
</template>
<style lang="css">
	.el-select-dropdown__item.selected {
		font-weight: normal;
	}
</style>
