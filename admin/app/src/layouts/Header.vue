<script lang="ts" setup>
// @ts-ignore
import Logo from "@components/core/Logo.vue";

/**
 *
 * Get the current version of addonify wishlist base plugin.
 */
const version: string = "2.0.0";
</script>
<template>
	<header id="adfy-header">
		<div class="inner adfy-grid">
			<div class="column branding">
				<Logo />
				<span class="version">v{{ version }}</span>
			</div>
			<div class="column actions">
				<button type="submit" class="adfy-button" loading="false">
					Save Options
				</button>
			</div>
		</div>
	</header>
</template>
