<script setup>
import Logo from "@components/core/Logo.vue";
import { currentVersion } from "@helpers/global";
import Icon from "@components/core/Icon.vue";
import { useSettingsStore } from "@stores/settings";

const store = useSettingsStore();
const { __ } = wp.i18n;

/**
 *
 * Function to return the text for the save button.
 *
 * @since: 2.0.0
 * @return {string} string
 */

const saveButtonText = () => {
	let saving = __("Saving ...", "addonify-wishlist");
	let save = __("Save Options", "addonify-wishlist");
	return store.status.isSaving ? saving : save;
};
</script>
<template>
	<header id="adfy-header">
		<div class="inner adfy-grid">
			<div class="column branding">
				<Logo />
				<span class="version">v{{ currentVersion }}</span>
			</div>
			<div class="column actions">
				<button
					type="submit"
					class="adfy-button"
					:data_loading="store.status.isSaving"
					:disabled="!store.haveChanges || store.status.isSaving"
					@click="store.saveSettings()"
				>
					{{ saveButtonText() }}

					<Icon
						v-if="store.status.isSaving"
						name="loading"
						size="18px"
					/>
				</button>
			</div>
		</div>
	</header>
</template>
