<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: [String],
		className: String,
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
		:class="className"
		type="textarea"
		rows="10"
		placeholder="#app { color: blue; }"
		resize="vertical"
		input-style="display:block;width: 100%;"
	/>
</template>
