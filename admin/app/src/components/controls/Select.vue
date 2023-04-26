<script setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	modelValue: {
		type: [Array, String, Number, Object],
		required: true,
	},
	choices: {
		type: [Array, Object],
		required: false,
	},
	placeholder: {
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
		return props.modelValue.toString();
	},
	set(newValue) {
		emit("update:modelValue", newValue);
	},
});

const { __ } = wp.i18n;

const defPlaceholder = __("Select", "addonify-wishlist");
</script>
<template>
	<el-select
		v-model="value"
		size="large"
		filterable
		clearable
		:placeholder="props.placeholder ? props.placeholder : defPlaceholder"
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
