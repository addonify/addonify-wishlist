<script setup>
import { useSettingsStore } from "@stores/settings";
import Switch from "@components/controls/Switch.vue";
import Radio from "@components/controls/Radio.vue";
import Select from "@components/controls/Select.vue";
import Text from "@components/controls/Text.vue";
import Number from "@components/controls/Number.vue";
import ColorControl from "@components/controls/ColorControl.vue";
import BorderRadiusControl from "@components/controls/BorderRadiusControl.vue";
import TypographyControl from "@components/controls/TypographyControl.vue";
import ImportOptions from "@components/controls/ImportOptions.vue";
import ExportOptions from "@components/controls/ExportOptions.vue";
import ResetOptions from "@components/controls/ResetOptions.vue";
import InvalidControl from "@components/controls/InvalidControl.vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	field: {
		type: [Object, String],
		required: true,
	},
	fieldKey: {
		type: String,
		required: true,
	},
	label: {
		type: String,
		required: false,
	},
});

/**
 *
 * Get settings store
 * @since: 2.0.0
 */

const store = useSettingsStore();
const reactiveState = store.settings;
</script>
<template>
	<Switch
		v-if="props.field.type === 'switch'"
		v-model="reactiveState[props.fieldKey]"
	/>
	<Radio
		v-else-if="props.field.type === 'radio'"
		v-model="reactiveState[props.fieldKey]"
		:design="props.field.design"
		:choices="props.field.choices"
	/>
	<Text
		v-else-if="
			props.field.type === 'text' || props.field.type === 'textarea'
		"
		v-model="reactiveState[props.fieldKey]"
		:type="props.field.type"
		:placeholder="props.field.placeholder"
	/>
	<Number
		v-else-if="props.field.type === 'number'"
		v-model="reactiveState[props.fieldKey]"
		:design="props.field.design"
		:min="props.field.min"
		:max="props.field.max"
		:step="props.field.step"
		:precision="props.field.precision"
		:placeholder="props.field.placeholder"
		:sliderTipText="props.field.sliderTipText"
		:sliderInput="props.field.sliderInput"
	/>
	<Select
		v-else-if="props.field.type === 'select'"
		v-model="reactiveState[props.fieldKey]"
		:choices="props.field.choices"
		:placeholder="props.field.placeholder"
	/>
	<ColorControl
		v-else-if="props.field.type === 'color'"
		v-model="reactiveState[props.fieldKey]"
		:size="props.field.size"
		:title="props.field.title"
	/>
	<InvalidControl v-else />
</template>
