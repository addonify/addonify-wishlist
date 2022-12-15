<script setup>
	import { ElButton, ElPopconfirm } from "element-plus";
	import { Loading, InfoFilled } from "@element-plus/icons-vue";
	import { useOptionsStore } from "../../stores/options";

	const props = defineProps({
		label: String,
		confirmText: String,
		confirmYesText: String,
		confirmNoText: String,
	});

	const store = useOptionsStore();

	// ⚡️ Handle initial reset request.
	const confirmResetOptions = () => {
		// Clicked yes, reset all options.
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
			<el-button type="danger" :loading="store.isDoingReset">
				{{ props.label }}
			</el-button>
		</template>
	</el-popconfirm>
</template>
