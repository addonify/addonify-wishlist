<script setup>
	import { ref } from "vue";
	import { ElUpload, ElIcon, ElMessage, ElSkeleton } from "element-plus";
	import { UploadFilled, Loading } from "@element-plus/icons-vue";
	import { useOptionsStore } from "../../stores/options";

	const props = defineProps({
		caption: String,
		note: String,
	});

	const { __ } = wp.i18n;

	const store = useOptionsStore();

	let fileList = ref();

	const handleBeforeUpload = (rawFile) => {
		//console.log(rawFile);

		if (rawFile.type == "application/json") {
			handleFileUpload(rawFile);

			fileList.value = []; // Clear the upload list.
		} else {
			ElMessage.error({
				message: __(
					"Only JSON file is permitted.",
					"addonify-wishlist"
				),
				offset: 50,
				duration: 5000,
			});
		}

		fileList.value = []; // Clear the upload list.
	};

	const handleFileUpload = (file) => {
		//console.log(file);
		//console.log(file.value.files[0]);

		let blob = new Blob([file], {
			type: "application/json",
		});

		let formData = new FormData();

		formData.append(
			"addonify_wishlist_import_file",
			blob,
			"addonify_wishlist_import_file.json"
		);

		//console.log(formData);

		store.importOptions(formData); // Send to store.

		fileList.value = []; // Clear the upload list.
	};
</script>
<template>
	<div v-show="store.isImportingFile == true" id="loading-skelaton">
		<el-skeleton :rows="3" animated />
	</div>
	<div
		v-show="store.isImportingFile !== true"
		id="upload-adfy-wishlist-options-input"
	>
		<el-upload
			v-model:file-list="fileList"
			drag
			method="post"
			accept=".json"
			:auto-upload="true"
			:multiple="false"
			:before-upload="handleBeforeUpload"
		>
			<el-icon class="el-icon--upload"><upload-filled /></el-icon>
			<div class="el-upload__text">
				{{ props.caption }}
			</div>
			<template #tip>
				<div class="el-upload__tip">
					{{ props.note }}
				</div>
			</template>
		</el-upload>
	</div>
</template>
