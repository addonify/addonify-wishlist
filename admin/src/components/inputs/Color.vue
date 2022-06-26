<script setup>
	import { computed } from "vue";

	let props = defineProps({
		colorVal: String,
		showAlpha: Boolean,
		label: String,
	});

	// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
	let emit = defineEmits(["update:colorVal"]);
	let value = computed({
		get() {
			return props.colorVal;
		},
		set(newValue) {
			emit("update:colorVal", newValue);
		},
	});
</script>
<template>
	<el-color-picker v-model="value" :show-alpha="props.showAlpha" />
	<span class="label" v-if="props.label">{{ props.label }}</span>
</template>
<style>
	.adfy-options .el-color-picker__trigger,
	.adfy-options .el-color-picker__color,
	.adfy-options .el-color-picker__color-inner {
		border-radius: 100%;
	}
	.adfy-options .el-color-picker__color {
		border: none;
	}
	.adfy-options .el-color-picker__trigger {
		height: 36px;
		width: 36px;
		padding: 5px;
		border: 2px dotted #bbbbbb;
	}
</style>
