<script lang="ts" setup>
import { computed } from "vue";

/**
 *
 * Define props.
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

let emit = defineEmits(["update:modelValue"]); // Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
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
