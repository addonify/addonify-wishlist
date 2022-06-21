<script setup>
	import { onMounted } from "vue";
	import Loading from "../Loading.vue";
	import { Check, Close } from "@element-plus/icons-vue";
	import { useOptionsStore } from "../../stores/options";
	let { __, _x, _n, _nx } = wp.i18n;
	let store = useOptionsStore();

	onMounted(() => {
		store.fetchOptions();
	});
</script>
<template>
	<Loading v-if="store.isLoading" />
	<form v-else id="adfy-settings-form" class="adfy-form" @submit.prevent>
		<h3 class="option-box-title">
			{{ __("General", "addonify-quick-view") }}
		</h3>
		<div class="adfy-options">
			<div class="adfy-option-columns option-box">
				<div class="adfy-col left">
					<div class="label">
						<p class="option-label">
							{{ __("Enable quick view", "addonify-quick-view") }}
						</p>
						<p class="option-description">
							{{
								__(
									"Once enabled, it will be visible in product catalog.",
									"addonify-quick-view"
								)
							}}
						</p>
					</div>
				</div>
				<div class="adfy-col right">
					<div class="input">
						<el-switch
							v-model="store.options.enable_quick_view"
							class="enable-addonify-quick-view"
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
		<div
			class="adfy-setting-options"
			v-if="store.options.enable_quick_view"
		>
			<h3 class="option-box-title">
				{{ __("Button Options", "addonify-quick-view") }}
			</h3>
			<div class="adfy-options">
				<div class="adfy-option-columns option-box">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Quick view button label",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-input
								v-model="store.options.quick_view_btn_label"
								size="large"
								placeholder="Quick view"
							/>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<div class="adfy-options">
				<div class="adfy-option-columns option-box">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__("Button position", "addonify-quick-view")
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Choose where you want to show the quick view button.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-select
								v-model="store.options.quick_view_btn_position"
								placeholder="Select"
								size="large"
							>
								<el-option
									v-for="(label, key) in store.data.settings
										.sections.button.fields
										.quick_view_btn_position.choices"
									:label="label"
									:value="key"
								/>
							</el-select>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<h3 class="option-box-title">
				{{ __("Modal Box Options", "addonify-quick-view") }}
			</h3>
			<div class="adfy-options">
				<div class="adfy-option-columns option-box fullwidth">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Content to display",
										"addonify-quick-view"
									)
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Which content would you like to display on quick view modal.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-checkbox-group
								v-model="store.options.modal_box_content"
								size="large"
							>
								<el-checkbox-button
									v-for="(label, key) in store.data.settings
										.sections.modal.fields.modal_box_content
										.choices"
									:label="key"
								>
									{{ label }}
								</el-checkbox-button>
							</el-checkbox-group>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<div class="adfy-options">
				<div class="adfy-option-columns option-box">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Product thumbnail",
										"addonify-quick-view"
									)
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Choose whether you want to display single product image or gallery in quick view modal.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-select
								v-model="store.options.product_thumbnail"
								placeholder="Select"
								size="large"
							>
								<el-option
									v-for="(label, key) in store.data.settings
										.sections.modal.fields.product_thumbnail
										.choices"
									:label="label"
									:value="key"
								/>
							</el-select>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<div class="adfy-options">
				<div class="adfy-option-columns option-box">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__("Enable lightbox", "addonify-quick-view")
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Enable lightbox for product images in quick view modal.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-switch
								v-model="store.options.enable_lightbox"
								class="enable-addonify-quick-view"
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
			<div class="adfy-options">
				<div class="adfy-option-columns option-box">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Display view detail button",
										"addonify-quick-view"
									)
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Enable display view detail button in modal.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-switch
								v-model="store.options.display_read_more_button"
								class="enable-addonify-quick-view"
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
			<div
				v-if="store.options.display_read_more_button"
				class="adfy-options"
			>
				<div class="adfy-option-columns option-box">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"View detail button label",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-input
								v-model="store.options.read_more_button_label"
								size="large"
								placeholder="View Details"
							/>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
		</div>
		<!-- // adfy-settings-options -->
	</form>
</template>
<style lang="css">
	.el-checkbox {
		--el-checkbox-font-weight: normal;
	}
	.el-select-dropdown__item.selected {
		font-weight: normal;
	}
	.el-message--success {
		-el-message-text-color: #2f8e00;
	}
</style>
