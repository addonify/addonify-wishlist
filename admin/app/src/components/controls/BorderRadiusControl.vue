<script lang="ts" setup>
import { computed } from "vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */
const props = defineProps({
	modelValue: {
		type: Number,
		required: true,
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
</script>
<template>
	<div class="adfy-control" data_type="border-radius">
		<div class="input">
			<input v-model="value" type="number" min="0" max="100" />
			<span class="direction">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					fill="currentColor"
					width="18"
					height="18"
				>
					<path fill="none" d="M0 0h24v24H0z" />
					<path
						d="M12.36 10.947l5.658 5.656-1.415 1.415-5.656-5.657-4.95 4.95V5.997H17.31z"
					/>
				</svg>
			</span>
		</div>
		<div class="input">
			<input v-model="value" type="number" min="0" max="100" />
			<span class="direction">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					fill="currentColor"
					width="18"
					height="18"
				>
					<path fill="none" d="M0 0h24v24H0z" />
					<path
						d="M13.05 12.36l-5.656 5.658-1.414-1.415 5.657-5.656-4.95-4.95H18V17.31z"
					/>
				</svg>
			</span>
		</div>
		<div class="input">
			<input v-model="value" type="number" min="0" max="100" />
			<span class="direction">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					fill="currentColor"
					width="18"
					height="18"
				>
					<path fill="none" d="M0 0h24v24H0z" />
					<path
						d="M11.637 13.05L5.98 7.395 7.394 5.98l5.657 5.657L18 6.687V18H6.687z"
					/>
				</svg>
			</span>
		</div>
		<div class="input">
			<input v-model="value" type="number" min="0" max="100" />
			<span class="direction">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 24 24"
					fill="currentColor"
					width="18"
					height="18"
				>
					<path fill="none" d="M0 0h24v24H0z" />
					<path
						d="M12.36 13.05L17.31 18H5.998V6.688l4.95 4.95 5.656-5.657 1.415 1.414z"
					/>
				</svg>
			</span>
		</div>
	</div>
</template>
