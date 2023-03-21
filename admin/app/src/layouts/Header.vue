<script lang="ts" setup>
// @ts-ignore
import Logo from "@components/core/Logo.vue";
// @ts-ignore
import { currentVersion } from "@helpers/global";
// @ts-ignore
import Icon from "@components/core/Icon.vue";
// @ts-ignore
import { useSettingsStore } from "@stores/settings";

const store = useSettingsStore();
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
					:data_loading="store.status.isLoading"
					:disabled="store.status.isLoading"
				>
					Save Options

					<Icon
						v-if="store.status.isLoading"
						name="loading"
						size="18px"
					/>
				</button>
			</div>
		</div>
	</header>
</template>
