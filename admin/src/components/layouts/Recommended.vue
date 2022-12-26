<script setup>
	import { ElButton, ElSkeleton, ElSkeletonItem } from "element-plus";
	import { Loading } from "@element-plus/icons-vue";
	import { useProductStore } from "../../stores/product";

	const props = defineProps({
		slug: String,
		name: String,
		description: String,
		thumb: String,
		status: String,
	});

	const { __ } = wp.i18n;
	const proStore = useProductStore();
	const { slug, name, thumb, description, status } = props;

	const activate = __("Activate now", "addonify-wishlist");
	const activiting = __("Activating...", "addonify-wishlist");
	const install = __("Install now", "addonify-wishlist");
	const installing = __("Installing...", "addonify-wishlist");
</script>

<template>
	<!--<div v-if="proStore.isSettingAddonStatus" id="adfy-skelaton">
		<el-skeleton style="--el-skeleton-circle-size: 82px" animated>
			<template #template>
				<el-skeleton-item variant="circle" />
			</template>
		</el-skeleton>
		<br />
		<el-skeleton :rows="3" animated />
	</div>-->

	<div class="adfy-product-card">
		<div class="adfy-product-box">
			<figure class="adfy-product-thumb">
				<img :src="thumb" :alt="slug" />
			</figure>
			<div class="content">
				<h3 class="adfy-product-title" v-html="name"></h3>
				<p class="adfy-product-description" v-html="description"></p>
				<div class="adfy-product-actions">
					<el-button
						v-if="status == 'active'"
						size="large"
						plain
						disabled
					>
						Installed
					</el-button>
					<el-button
						v-else-if="status == 'inactive'"
						type="success"
						size="large"
						plain
						:loading="proStore.isWaitingForInstallation === true"
						@click="proStore.updateAddonStatus(slug)"
					>
						{{
							proStore.isWaitingForInstallation
								? activiting
								: activate
						}}
					</el-button>
					<el-button
						v-else
						type="primary"
						size="large"
						plain
						:loading="proStore.isWaitingForInstallation === true"
						@click="proStore.handleAddonInstallation(slug)"
					>
						{{
							proStore.isWaitingForInstallation
								? installing
								: install
						}}
					</el-button>
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
