<script setup>
import { useSettingsStore } from "@stores/settings";
import ColorControl from "@components/controls/ColorControl.vue";
import BorderRadiusControl from "@components/controls/BorderRadiusControl.vue";
import TypographyControl from "@components/controls/TypographyControl.vue";
import Switch from "@components/controls/Switch.vue";
import Select from "@components/controls/Select.vue";

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
		v-if="props.field.type == 'switch'"
		v-model="reactiveState[props.fieldKey]"
	/>
</template>
