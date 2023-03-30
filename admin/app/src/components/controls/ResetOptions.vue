<script setup>
import { useSettingsStore } from "@stores/settings";
import { textdomain } from "@helpers/global";
import { InfoFilled } from "@element-plus/icons-vue";
import Icon from "@components/core/Icon.vue";

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

const { __ } = wp.i18n;
const store = useSettingsStore();
const isDoingResetText = __("Processing...", textdomain);

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
	 * Let store handle the reset request.
	 */
	store.resetAllSettings();
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
			<button
				type="submit"
				class="adfy-button danger"
				:data_loading="store.status.isDoingReset"
				:disabled="store.status.isDoingReset"
			>
				{{ store.status.isDoingReset ? isDoingResetText : props.label }}
				<Icon
					v-if="!store.status.isDoingReset"
					name="reset"
					size="18px"
				/>
				<Icon
					v-if="store.status.isDoingReset"
					name="loading"
					size="18px"
				/>
			</button>
		</template>
	</el-popconfirm>
</template>
