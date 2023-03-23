<script setup>
import { Loading } from "@element-plus/icons-vue";
import { useSettingsStore } from "@stores/settings";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

const props = defineProps({
	label: {
		type: String,
		required: true,
	},
});

const store = useSettingsStore();
</script>
<template>
	<el-button
		type="primary"
		@click="store.status.exportAllOptions"
		:loading="store.status.isDoingExport"
	>
		{{ props.label }}
	</el-button>
</template>
