<script setup>
	//import {ref, onMounted} from vue;
	import { ElButton } from "element-plus";
	import { Loading } from "@element-plus/icons-vue";

	const props = defineProps({
		slug: [Object, String],
	});

	const { slug } = props;
	let title, description, buttonLabel;
</script>

<template>
	<!--<div class="adfy-product-card">
		<div class="adfy-product-box">
			<figure class="adfy-product-thumb">
				<img :src="getThumbnailWordPress(slug)" :alt="slug" />
			</figure>
			<div class="content">
				<h3 class="adfy-product-title">{{ title }}</h3>
				<p class="adfy-product-description" v-html="description"></p>
				<div class="adfy-product-actions">
					<el-button type="primary">
						{{ buttonLabel !== "" ? buttonLabel : "Install" }}
					</el-button>
				</div>
			</div>
		</div>
	</div>-->
</template>
