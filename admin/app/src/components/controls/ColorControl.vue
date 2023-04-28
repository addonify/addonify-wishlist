<script lang="ts" setup>
import { computed } from "vue"; // @ts-ignore
import { rgbaToHex } from "@helpers/color";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */
const props = defineProps({
	modelValue: {
		type: String,
		required: false, // Fix: issue #321
	},
	size: {
		type: String,
		default: "normal",
		required: false,
	},
	title: {
		type: String,
		required: false,
	},
});

/**
 *
 * Define emits for v-model usage.
 * Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
 *
 */

let emit = defineEmits(["update:modelValue"]);
let value = computed({
	get() {
		return props.modelValue;
	},
	set(newValue) {
		emit("update:modelValue", newValue);
	},
});

/**
 *
 * Emit the color value immediately so we do not need to click "ok" button on color picker.
 *
 * @param {string} color
 * @returns {void} void
 */

const colorChangedHandler = (color: any) => {
	emit("update:modelValue", color);
};

/**
 *
 * watchEffect for debugging.
 *
 * @since: 2.0.0
 */

//watchEffect(() => {
//	console.log(value.value);
//	console.log(typeof value.value);
//});
</script>
<template>
	<div
		v-if="props.size === 'minimal'"
		class="adfy-control"
		data_type="color-picker"
		data_size="minimal"
	>
		<div class="input adfy-flex">
			<el-color-picker
				v-model="value"
				show-alpha
				@active-change="colorChangedHandler"
			/>
		</div>
	</div>
	<div
		v-else
		class="adfy-control"
		data_type="color-picker"
		data_size="default"
	>
		<span v-if="props.title" class="control-title">{{ props.title }}</span>
		<div class="input adfy-flex">
			<el-color-picker
				v-model="value"
				show-alpha
				@active-change="colorChangedHandler"
			/>
			<span class="color-code">
				{{ rgbaToHex(value).toUpperCase() }}
			</span>
		</div>
	</div>
</template>
