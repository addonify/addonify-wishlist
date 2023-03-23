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
		type: String,
		required: true,
	},
	choices: {
		type: [Array, Object],
		required: true,
	},
	type: {
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
	<template v-if="props.type === 'default'">
		<el-radio-group
			v-model="vModalValue"
			v-for="(value, key) in props.choices"
		>
			<el-radio :label="key">{{ value }}</el-radio>
		</el-radio-group>
	</template>
	<template v-if="props.type === 'radio-icons'">
		<el-radio-group
			v-model="vModalVal"
			v-for="(value, key) in props.choices"
		>
			<el-radio :label="key" size="large" border>
				<span v-html="value"></span>
			</el-radio>
		</el-radio-group>
	</template>
</template>
<style lang="scss">
.radio-input-group {
	.el-radio-group {
		.el-radio {
			align-items: center;

			.adfy-wishlist-icon {
				font-size: 14px;
			}
		}
	}
}
</style>
