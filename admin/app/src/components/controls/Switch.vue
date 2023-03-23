<script setup>
import { computed } from "vue";
import { Check, Close } from "@element-plus/icons-vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	modelValue: {
		type: [Boolean, Number],
		required: true,
	},
});

/**
 *
 * Define emits for v-model usage.
 * Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
 *
 * @since: 2.0.0
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
