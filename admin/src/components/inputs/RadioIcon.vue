<script setup>
	import { computed } from "vue";
	let props = defineProps({
		modelValue: String,
		choices: [Object, Array],
	});

	// Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
	let emit = defineEmits(["update:modelValue"]);
	let bindModel = computed({
		get() {
			return props.modelValue;
		},
		set(value) {
			emit("update:modelValue", value);
		},
	});
</script>
<template>
	<el-radio-group v-model="bindModel" v-for="(value, key) in props.choices">
		<el-radio :label="key" size="large" border>
			<span v-html="value"></span>
		</el-radio>
	</el-radio-group>
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
