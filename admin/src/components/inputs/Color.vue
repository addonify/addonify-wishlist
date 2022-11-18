<script setup>
	import { computed } from "vue";
	import { ElColorPicker } from "element-plus";

	let props = defineProps({
		colorVal: String,
		isAlpha: [Boolean, String],
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

	let handleColorChanged = (color) => {
		// Emit the color immediately. Don't wait till the "ok" button is clicked.
		emit("update:colorVal", color);
	};
</script>
<template>
	<el-color-picker
		v-model="value"
		:show-alpha="props.isAlpha ? props.isAlpha : true"
		@active-change="handleColorChanged"
	/>
	<span class="label" v-if="props.label">{{ props.label }}</span>
</template>
<style>
	.adfy-options .el-color-picker__trigger,
	.adfy-options .el-color-picker__color,
	.adfy-options .el-color-picker__color-inner {
		border-radius: 100%;
		border: none;
	}

	.adfy-options .el-color-picker__trigger {
		height: 42px;
		width: 42px;
		padding: 3px;
		border: 2px solid white;
		box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
	}

	.adfy-options .el-color-picker .el-color-picker__icon {
		font-size: 16px;
		color: white;
		line-height: 1;
	}

	.adfy-options .el-color-picker .el-color-picker__empty {
		font-size: 20px;
		color: red;
		line-height: 1;
	}
</style>
