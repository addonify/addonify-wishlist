<script setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */
const props = defineProps({
	modelValue: {
		type: [Boolean, String],
		required: true,
	},
	choices: {
		type: [Array, Object],
		required: true,
	},
	design: {
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
let vModalValue = computed({
	get() {
		return props.modelValue;
	},
	set(newValue) {
		emit("update:modelValue", newValue);
	},
});
</script>
<template>
	<template v-if="props.design === 'default'">
		<el-radio-group
			v-model="vModalValue"
			v-for="(value, key) in props.choices"
		>
			<el-radio :label="key">{{ value }}</el-radio>
		</el-radio-group>
	</template>
	<template v-if="props.design === 'radioIcons'">
		<el-radio-group v-model="vModalValue">
			<el-radio
				v-for="(value, key) in props.choices"
				:label="key"
				size="large"
				border
			>
				<span v-html="value"></span>
			</el-radio>
		</el-radio-group>
	</template>
</template>
