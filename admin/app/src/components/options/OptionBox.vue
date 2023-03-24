<script setup>
import { useSettingsStore } from "@stores/settings";
import ColorControl from "@components/controls/ColorControl.vue";
import BorderRadiusControl from "@components/controls/BorderRadiusControl.vue";
import TypographyControl from "@components/controls/TypographyControl.vue";
</script>
<template>
	<div class="adfy-option-boxes">
		<div class="adfy-option-box" data_width="default">
			<div class="column column-left">
				<p class="option-label">Color add to wishlist button</p>
			</div>
			<div class="column column-right">
				<div class="adfy-option">
					<!--<ColorControl v-model="store.settings.color" />-->
				</div>
			</div>
		</div>
	</div>
</template>
