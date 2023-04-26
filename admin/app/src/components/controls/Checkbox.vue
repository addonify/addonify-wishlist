<script lang="ts" setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

let props = defineProps({
	modelValue: {
		type: Boolean,
		default: false,
		required: true,
	},
	label: {
		type: String,
		default: "",
		required: false,
	},
	style: {
		type: String,
		default: "default",
		required: false,
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
	<template v-if="props.style === 'default'">
		<el-checkbox v-model="value" label="{{props.label}}" size="large" />
	</template>
	<template v-if="props.style === 'checkbox-button'"></template>
</template>
