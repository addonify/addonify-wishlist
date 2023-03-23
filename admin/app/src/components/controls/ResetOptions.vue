<script setup>
import { useSettingsStore } from "@stores/options";
import { Loading, InfoFilled } from "@element-plus/icons-vue";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

const props = defineProps({
	label: {
		type: String,
		required: false,
	},
	confirmText: {
		type: String,
		required: false,
	},
	confirmYesText: {
		type: String,
		required: false,
	},
	confirmNoText: {
		type: String,
		required: false,
	},
});

const store = useSettingsStore();

/**
 *
 * Function to reset all options.
 *
 * @return {void} void
 * @since: 2.0.0
 */
const confirmResetOptions = () => {
	/**
	 *
	 * Ask before reset.
	 */
	store.resetAllOptions();
};
</script>
<template>
	<el-popconfirm
		width="200"
		:confirm-button-text="props.confirmYesText"
		:cancel-button-text="props.confirmNoText"
		:icon="InfoFilled"
		icon-color="#626AEF"
		:title="props.confirmText"
		@confirm="confirmResetOptions()"
	>
		<template #reference>
			<el-button type="danger" :loading="store.status.isDoingReset">
				{{ props.label }}
			</el-button>
		</template>
	</el-popconfirm>
</template>
