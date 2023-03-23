<script setup>
import { ref } from "vue";
import { UploadFilled, Loading } from "@element-plus/icons-vue";
import { useSettingsStore } from "@stores/settings";
import { textdomain, jsonFileName } from "@helpers/global";
import { dispatchToast } from "@helpers/message";

/**
 *
 * Define props that we will use in this component.
 *
 * @since: 2.0.0
 */

const props = defineProps({
	caption: {
		type: String,
		required: false,
	},
	note: {
		type: String,
		required: false,
	},
});

const { __ } = wp.i18n;
const store = useSettingsStore();
let fileList = ref();

/**
 *
 * Handle the file upload.
 * Check if the file is a JSON file.
 *
 * @param {file} rawFile
 * @return {void} void
 * @since: 2.0.0
 */

const handleBeforeUpload = (rawFile) => {
	//console.log(rawFile);

	let errorMessage = __("Only JSON file is permitted.", textdomain);

	if (rawFile.type == "application/json") {
		/**
		 *
		 * Case: True | File is JSON.
		 * Handle the file upload.
		 */
		handleFileUpload(rawFile);
		fileList.value = []; // Clear the upload list.
	} else {
		/**
		 *
		 * Case: False | File is NOT a JSON.
		 * Show error message.
		 */
		dispatchToast(errorMessage, "error");
	}

	fileList.value = []; // Clear the upload list.
};

/**
 *
 * Function that process the file.
 * Once the file is processed, it will be sent to the store.
 *
 * @param {file} rawFile
 * @return {void} void
 * @since: 2.0.0
 */

const handleFileUpload = (file) => {
	/**
	 *
	 * Process the file that was received before sending to the store.
	 *
	 */

	//console.log(file);
	//console.log(file.value.files[0]);

	let blob = new Blob([file], {
		type: "application/json",
	});

	let formData = new FormData();

	formData.append(
		jsonFileName + "_import_file",
		blob,
		jsonFileName + "_import_file.json"
	);

	//console.log(formData);

	store.importOptions(formData); // Send to store.

	fileList.value = []; // Clear the upload list.
};
</script>
<template>
	<div v-show="store.status.isImportingFile === true" id="loading-skelaton">
		<el-skeleton :rows="3" animated />
	</div>
	<div v-show="store.status.isImportingFile !== true" id="input-type-upload">
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
