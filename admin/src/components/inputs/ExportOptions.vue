<script setup>
	import { ElButton } from "element-plus";
	import { Loading } from "@element-plus/icons-vue";
	import { useOptionsStore } from "../../stores/options";

	const props = defineProps({
		label: String,
	});

	const store = useOptionsStore();
</script>
<template>
	<el-button
		type="primary"
		@click="store.exportAllOptions"
		:loading="store.isDoingExport"
	>
		{{ props.label }}
	</el-button>
</template>
