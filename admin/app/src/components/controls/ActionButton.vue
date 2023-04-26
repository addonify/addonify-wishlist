<script setup>
import { useSettingsStore } from "@stores/settings";
import { InfoFilled } from "@element-plus/icons-vue";
import Icon from "@components/core/Icon.vue";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

const props = defineProps({
	task: {
		type: Object,
		required: true,
	},
});

const { __ } = wp.i18n;
const store = useSettingsStore();
const isProcessingText = __("Processing...", "addonify-wishlist");

/**
 *
 * Function to reset all options.
 *
 * @return {void} void
 * @since: 2.0.0
 */
const handleOperation = () => {
	/**
	 *
	 * Evulate the operation task.
	 */

	if (props.task["type"] === "POST") {
		// Get the endpoint from props.
		// Dispatch the action to the store that sends the request.
		store.dispatchEmptyPostRequest(props.task["endpoint"]);
	} else {
		console.warn("Invalid task type. Only POST is supported.");
	}
};

/**
 *
 * Destructor the props.task object.
 *
 * @since: 2.0.0
 */

const { confirm, buttonLabel, buttonIcon, buttonClass } = props.task;

//console.log(props.task);
</script>
<template>
	<template v-if="confirm.required">
		<el-popconfirm
			:width="confirm.size === '' ? '250px' : confirm.size"
			:confirm-button-text="confirm.confirmBtnLabel"
			:cancel-button-text="confirm.cancelBtnLabel"
			:icon="InfoFilled"
			icon-color="#626AEF"
			:title="confirm.content"
			@confirm="handleOperation()"
		>
			<template #reference>
				<button
					type="submit"
					class="adfy-button"
					:class="buttonClass"
					:data_loading="store.actionEvent.isProcessing"
					:disabled="store.actionEvent.isProcessing"
				>
					{{
						store.actionEvent.isProcessing
							? isProcessingText
							: buttonLabel
					}}
					<span class="icon" v-if="buttonIcon !== ''">
						{{ buttonIcon }}
					</span>
					<Icon
						v-if="store.actionEvent.isProcessing"
						name="loading"
						size="18px"
					/>
				</button>
			</template>
		</el-popconfirm>
	</template>
	<template v-else>
		<button
			type="submit"
			class="adfy-button"
			:class="buttonClass"
			:data_loading="store.actionEvent.isProcessing"
			:disabled="store.actionEvent.isProcessing"
			@click="handleOperation()"
		>
			{{
				store.actionEvent.isProcessing ? isProcessingText : buttonLabel
			}}
			<span class="icon" v-if="buttonIcon !== ''">
				{{ buttonIcon }}
			</span>
			<Icon
				v-if="store.actionEvent.isProcessing"
				name="loading"
				size="18px"
			/>
		</button>
	</template>
</template>
