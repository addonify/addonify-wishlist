<script setup>
import { ref } from "vue";
import { useProductStore } from "@stores/products";
import { Loading } from "@element-plus/icons-vue";
import { trimText } from "@helpers/text";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	slug: {
		type: String,
		required: true,
	},
	name: {
		type: String,
		required: false,
	},
	description: {
		type: String,
		required: false,
	},
	category: {
		type: String,
		required: false,
	},
	thumb: {
		type: String,
		required: false,
	},
	status: {
		type: String,
		required: false,
	},
});

const { __ } = wp.i18n;
const proStore = useProductStore();
const { slug, name, thumb, description, category } = props;

const isLoading = ref(false);
const isDisabled = ref(false);
const isActiviting = ref(false);
const isInstalling = ref(false);

const activateText = __("Activate now", "addonify-wishlist");
const activitingText = __("Activating...", "addonify-wishlist");
const installText = __("Install now", "addonify-wishlist");
const installingText = __("Installing...", "addonify-wishlist");
const installedText = __("Already installed", "addonify-wishlist");

/**
 *
 * Function that handles request to activate the plugin.
 * This function pass request to the store.
 *
 * @param {string} slug
 * @return {void} void
 */

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

/**
 *
 * Function that handles request to install the plugin.
 * This function pass request to the store.
 *
 * @param {string} slug
 * @return {void} void
 */

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
		<span class="adfy-category">{{ category }}</span>
		<div class="adfy-product-box">
			<figure class="adfy-product-thumb">
				<img :src="thumb" :alt="slug" />
			</figure>
			<div class="content">
				<h3 class="adfy-product-title" v-html="trimText(name, 65)"></h3>
				<p
					class="adfy-product-description"
					v-html="trimText(description, 100)"
				></p>
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
