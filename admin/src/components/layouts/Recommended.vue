<script setup>
	import { ref, onMounted } from "vue";
	import { ElButton, ElSkeleton, ElSkeletonItem } from "element-plus";
	import { Loading } from "@element-plus/icons-vue";

	const props = defineProps({
		slug: [String, Object, Array],
	});

	const { slug } = props;

	let addonName;
	let isFetchingAddonInfo = ref(true);
	let isWaitingForInstallationSignal = ref(false);

	/**
	 *
	 * WordPress.org/plugins get plugin thumbnail.
	 */

	const getWpPluginThumbnail = (slug) => {
		let thumb = `https://ps.w.org/${slug}/assets/icon-256x256.png`;
		return thumb;
	};

	/**
	 *
	 * WordPress.org/plugins api get plugin info.
	 */

	const fetchPluginName = async (slug) => {
		let pluginApi = `https://api.wordpress.org/plugins/info/1.0/${slug}.json`;

		try {
			const res = await fetch(pluginApi);
			let data = await res.json();
			addonName = data.name; // Set the name.
			//console.log(data);
			isFetchingAddonInfo.value = false;

			if (res.status !== 200) {
				console.log("Couldn't fetch WordPress plugin repo " + res);
			}
		} catch (err) {
			console.log(err);
		}
	};

	/*
	 *
	 * Handle install/activate button click action.
	 * Called from Recommended.vue child component.
	 * Wait for the signal from the backend.
	 * @param {string} slug
	 */

	const handleActivation = (slug) => {
		console.log(slug);
	};

	onMounted(() => {
		fetchPluginName(slug);
	});
</script>

<template>
	<div v-show="isFetchingAddonInfo == true" id="adfy-skelaton">
		<el-skeleton style="--el-skeleton-circle-size: 82px" animated>
			<template #template>
				<el-skeleton-item variant="circle" />
			</template>
		</el-skeleton>
		<br />
		<el-skeleton :rows="1" animated />
	</div>

	<div v-show="isFetchingAddonInfo == false" class="adfy-product-card">
		<div class="adfy-product-box">
			<figure class="adfy-product-thumb">
				<img :src="getWpPluginThumbnail(slug)" :alt="slug" />
			</figure>
			<div class="content">
				<h3 class="adfy-product-title" v-html="addonName"></h3>
				<div class="adfy-product-actions">
					<el-button type="primary" plain round> Activate </el-button>
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
