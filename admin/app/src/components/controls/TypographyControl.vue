<script setup>
import { computed } from "vue";
import Select from "@components/controls/Select.vue";
import Text from "@components/controls/Text.vue";
import Number from "@components/controls/Number.vue";
import { useSettingsStore } from "@stores/settings";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */
//const props = defineProps({
//	modelValue: {
//		type: [Array, String, Number, Object],
//		required: true,
//	},
//	title: {
//		type: String,
//		required: true,
//	},
//});

/**
 *
 * Define emits for v-model usage.
 * Ref: https://vuejs.org/guide/components/events.html#usage-with-v-model
 *
 */

//let emit = defineEmits(["update:modelValue"]);
//let value = computed({
//	get() {
//		return props.modelValue;
//	},
//	set(newValue) {
//		emit("update:modelValue", newValue);
//	},
//});

const store = useSettingsStore();
</script>
<template>
	<div class="adfy-control" data_type="typography">
		<div class="input">
			<p class="control-title">Font family</p>
			<Select v-model="store.settings.font" placeholder="Select font" />
		</div>
		<div class="input">
			<p class="control-title">Font weight</p>
			<Select
				v-model="store.settings.font_weight"
				placeholder="Select font"
			/>
		</div>
		<div class="input">
			<p class="control-title">Font size</p>
			<Number v-model="store.settings.font_size" />
		</div>
		<div class="input">
			<p class="control-title">Letter spacing</p>
			<Number
				v-model="store.settings.letter_spacing"
				steps="0.5"
				min="0"
				max="5"
			/>
		</div>
		<div class="input">
			<p class="control-title">Line height</p>
			<Number
				v-model="store.settings.line_height"
				steps="0.1"
				min="0"
				max="5"
			/>
		</div>
		<div class="input">
			<p class="control-title">Text transform</p>
			<Select v-model="store.settings.text_transform" />
		</div>
	</div>
</template>
