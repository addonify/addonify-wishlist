<script setup>
	import { ref, computed } from "vue";
	import { ElButton, ElMessage } from "element-plus";
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
	const { slug, name, thumb, description } = props;

	const isLoading = ref(false);
	const isDisabled = ref(false);
	const isActiviting = ref(false);
	const isInstalling = ref(false);

	const activateText = __("Activate now", "addonify-wishlist");
	const activitingText = __("Activating...", "addonify-wishlist");
	const installText = __("Install now", "addonify-wishlist");
	const installingText = __("Installing...", "addonify-wishlist");
	const installedText = __("Installed", "addonify-wishlist");

	const activeAddonHandler = (slug) => {
		isLoading.value = true;
		isActiviting.value = true;

		try {
			const res = proStore.updateAddonStatus(slug);

			if (res.status == "active") {
				isLoading.value = false;
				isActiviting.value = false;
				isDisabled.value = true;
			}
		} catch (error) {
			isLoading.value = false;
			isActiviting.value = false;
			isDisabled.value = false;
		}
	};

	const installAddonHandler = async (slug) => {
		isLoading.value = true;
		isInstalling.value = true;

		try {
			const res = await proStore.handleAddonInstallation(slug);

			if (res.status == "active") {
				isLoading.value = false;
				isInstalling.value = false;
				isDisabled.value = true;
			}
		} catch (error) {
			isLoading.value = false;
			isInstalling.value = false;
			isDisabled.value = false;
		}
	};
</script>

<template>
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
						v-if="
							props.status == 'active' ||
							props.status == 'network-active'
						"
						size="large"
						:id="slug"
						plain
						disabled
					>
						{{ installedText }}
					</el-button>
					<el-button
						v-else-if="props.status == 'inactive'"
						type="success"
						size="large"
						:id="slug"
						plain
						:loading="isLoading"
						:disabled="isDisabled"
						@click="activeAddonHandler(slug)"
					>
						{{ isActiviting ? activitingText : activateText }}
					</el-button>
					<el-button
						v-else
						type="primary"
						size="large"
						:id="slug"
						plain
						:loading="isLoading"
						:disabled="isDisabled"
						@click="installAddonHandler(slug)"
					>
						{{ isInstalling ? installingText : installText }}
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
