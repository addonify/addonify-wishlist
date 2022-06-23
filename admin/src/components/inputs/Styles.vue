<script setup>
	import { onMounted } from "vue";
	import Loading from "../layouts/Loading.vue";
	import { Check, Close } from "@element-plus/icons-vue";
	import { useOptionsStore } from "../../stores/options";
	let store = useOptionsStore();
	let { __, _x, _n, _nx } = wp.i18n;

	onMounted(() => {
		store.fetchOptions();
	});
</script>
<template>
	<Loading v-if="store.isLoading" />
	<form v-else id="adfy-styles-form" class="adfy-form" @submit.prevent>
		<h3 class="option-box-title">
			{{ __("General", "addonify-wishlist") }}
		</h3>
		<div class="adfy-options">
			<div class="adfy-option-columns option-box">
				<div class="adfy-col left">
					<div class="label">
						<p class="option-label">
							{{
								__("Enable plugin styles", "addonify-wishlist")
							}}
							<span class="badge">
								{{ __("Optional", "addonify-wishlist") }}
							</span>
						</p>
						<p class="option-description">
							{{
								__(
									"If enabled, the colors selected below will be applied to the quick view modal & elements.",
									"addonify-wishlist"
								)
							}}
						</p>
					</div>
				</div>
				<div class="adfy-col right">
					<div class="input">
						<el-switch
							v-model="store.options.load_styles_from_plugin"
							class="enable-addonify-wishlist"
							size="large"
							inline-prompt
							:active-icon="Check"
							:inactive-icon="Close"
						/>
					</div>
				</div>
			</div>
		</div>
		<!-- // adfy-options -->
	</form>
</template>
<style lang="css">
	.adfy-options .tooltip-base-box {
		width: 400px;
	}
	.adfy-options .el-textarea__inner {
		display: block;
		width: 100%;
		font-family: monospace;
		min-height: 200px;
	}

	.adfy-options .el-color-picker__trigger,
	.adfy-options .el-color-picker__color,
	.adfy-options .el-color-picker__color-inner {
		border-radius: 100%;
	}

	.adfy-options .el-color-picker__color {
		border: none;
	}

	.adfy-options .el-color-picker__trigger {
		height: 36px;
		width: 36px;
		padding: 5px;
		border: 2px dotted #bbbbbb;
	}

	.adfy-options .seperator {
		display: block;
		height: 1px;
		margin: 20px 0;
		background-color: #ededed;
	}
</style>
