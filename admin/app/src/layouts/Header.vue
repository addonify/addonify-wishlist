<script lang="ts" setup>
// @ts-ignore
import Logo from "@components/core/Logo.vue";
// @ts-ignore
import { currentVersion } from "@helpers/global";
// @ts-ignore
import Icon from "@components/core/Icon.vue";
// @ts-ignore
import { useSettingsStore } from "@stores/settings";
// @ts-ignore
import { textdomain } from "@helpers/global";

const store = useSettingsStore();
// @ts-ignore
const { __ } = wp.i18n;
/**
 *
 * Function to return the text for the save button.
 *
 * @return {string} string
 */

const saveButtonText = (): string => {
	let saving = __("Saving ...", textdomain);
	let save = __("Save Options", textdomain);
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
