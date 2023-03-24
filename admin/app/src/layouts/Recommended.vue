<script setup>
import { ref } from "vue";
import { Loading } from "@element-plus/icons-vue";
import { useProductStore } from "@stores/products";
import { textdomain } from "@helpers/global";

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
const { slug, name, thumb, description } = props;

const isLoading = ref(false);
const isDisabled = ref(false);
const isActiviting = ref(false);
const isInstalling = ref(false);

const activateText = __("Activate now", textdomain);
const activitingText = __("Activating...", textdomain);
const installText = __("Install now", textdomain);
const installingText = __("Installing...", textdomain);
const installedText = __("Installed", textdomain);

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
