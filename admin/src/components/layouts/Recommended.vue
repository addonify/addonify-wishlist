<script setup>
	import { onMounted } from "vue";
	import { ElButton, ElSkeleton, ElSkeletonItem } from "element-plus";
	import { Loading } from "@element-plus/icons-vue";
	import { useProductStore } from "../../stores/product";

	const props = defineProps({
		slug: String,
		name: String,
		description: String,
		thumb: String,
	});

	const proStore = useProductStore();
	const { slug, name, thumb, description } = props;

	let status = "inactive";

	const installAddon = (slug) => {
		alert("Installing addon: " + slug);
	};

	console.log("=> Child component loaded & status is: " + status);

	onMounted(() => {});
</script>

<template>
	<div v-if="proStore.isCheckingAddonStatus" id="adfy-skelaton">
		<el-skeleton style="--el-skeleton-circle-size: 82px" animated>
			<template #template>
				<el-skeleton-item variant="circle" />
			</template>
		</el-skeleton>
		<br />
		<el-skeleton :rows="3" animated />
	</div>

	<div v-else class="adfy-product-card">
		<div class="adfy-product-box">
			<figure class="adfy-product-thumb">
				<img :src="thumb" :alt="name" />
			</figure>
			<div class="content">
				<h3 class="adfy-product-title" v-html="name"></h3>
				<p class="adfy-product-description" v-html="description"></p>
				<div class="adfy-product-actions">
					<el-button size="large" plain disabled> Active </el-button>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
	#recommended-hot-products .el-skeleton.is-animated .el-skeleton__item {
		background: linear-gradient(
			90deg,
			#e1e1e1 25%,
			#d8d8d8 37%,
			#c7c7c7 63%
		);
		background-size: 400% 100%;
	}
</style>
