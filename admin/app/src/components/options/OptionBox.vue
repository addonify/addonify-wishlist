<script setup>
import { useSettingsStore } from "@stores/settings";
import JumboBox from "@layouts/JumboBox.vue";
import ColorControl from "@components/controls/ColorControl.vue";
import BorderRadiusControl from "@components/controls/BorderRadiusControl.vue";
import TypographyControl from "@components/controls/TypographyControl.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const store = useSettingsStore();
</script>
<template>
	<div class="adfy-option-boxes">
		<div class="adfy-option-box" data_width="default">
			<div class="column column-left">
				<p class="option-label">Color add to wishlist button</p>
			</div>
			<div class="column column-right">
				<div class="adfy-option">
					<ColorControl v-model="store.settings.color" />
				</div>
			</div>
		</div>

		<div class="adfy-option-box" data_width="default">
			<div class="column column-left">
				<p class="option-label">Wishlist page button color</p>
			</div>
			<div class="column column-right">
				<div class="adfy-option">
					<ColorControl v-model="store.settings.color" />
				</div>
			</div>
		</div>

		<div class="adfy-option-box" data_width="default">
			<div class="column column-left">
				<p class="option-label">Add to wishlist button border radius</p>
			</div>
			<div class="column column-right">
				<div class="adfy-option">
					<BorderRadiusControl
						v-model="store.settings.border_radius"
					/>
				</div>
			</div>
		</div>

		<div class="adfy-option-box" data_width="full">
			<div class="column column-left">
				<p class="option-label">Add to wishlist button typography</p>
			</div>
			<div class="column column-right">
				<div class="adfy-option">
					<TypographyControl />
				</div>
			</div>
		</div>
	</div>
</template>
