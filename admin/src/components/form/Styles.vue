<script setup>
	import { onMounted } from "vue";
	import Loading from "../Loading.vue";
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
			{{ __("General", "addonify-quick-view") }}
		</h3>
		<div class="adfy-options">
			<div class="adfy-option-columns option-box">
				<div class="adfy-col left">
					<div class="label">
						<p class="option-label">
							{{
								__(
									"Enable plugin styles",
									"addonify-quick-view"
								)
							}}
							<span class="badge">
								{{ __("Optional", "addonify-quick-view") }}
							</span>
						</p>
						<p class="option-description">
							{{
								__(
									"If enabled, the colors selected below will be applied to the quick view modal & elements.",
									"addonify-quick-view"
								)
							}}
						</p>
					</div>
				</div>
				<div class="adfy-col right">
					<div class="input">
						<el-switch
							v-model="store.options.enable_plugin_styles"
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
			class="adfy-color-options"
			v-if="store.options.enable_plugin_styles"
		>
			<div class="adfy-options">
				<div class="adfy-option-columns option-box fullwidth">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Modal Box Colors",
										"addonify-quick-view"
									)
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Change the look & feel of modal box & overlay mask.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input-group">
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_box_overlay_background_color
									"
									show-alpha
									@active-change="changedColor"
								/>
								<span>
									{{
										__(
											"Modal overlay background",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options.modal_box_background_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Modal inner background",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<div class="adfy-options">
				<div class="adfy-option-columns option-box fullwidth">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Product Info Colors",
										"addonify-quick-view"
									)
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Tweak how product elements like title, meta, excerpt, price etc looks on modal.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input-group">
							<div class="input">
								<el-color-picker
									v-model="store.options.product_title_color"
									show-alpha
								/>
								<span>
									{{
										__("Title text", "addonify-quick-view")
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options.product_excerpt_text_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Excerpt text",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.product_rating_star_filled_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Rating star filled",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.product_rating_star_empty_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Rating stars empty",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>

							<div class="input">
								<el-color-picker
									v-model="store.options.product_price_color"
									show-alpha
								/>
								<span>
									{{
										__(
											"Regular price",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.product_on_sale_price_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"On-sale price",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options.product_meta_text_color
									"
									show-alpha
								/>
								<span>
									{{ __("Meta", "addonify-quick-view") }}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.product_meta_text_hover_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Meta on hover",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
						</div>
						<!-- // input-groups -->
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<div class="adfy-options">
				<div class="adfy-option-columns option-box fullwidth">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Close button color",
										"addonify-quick-view"
									)
								}}
							</p>
							<p class="option-description">
								{{
									__(
										"Change the look & feel of close modal box button.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input-group">
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_close_button_text_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Default text",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_close_button_text_hover_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Text color on mouse hover",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_close_button_background_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Default background",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_close_button_background_hover_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Background color on mouse hover",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<div class="adfy-options">
				<div class="adfy-option-columns option-box fullwidth">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{
									__(
										"Miscellaneous buttons color",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input-group">
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_misc_buttons_text_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Default text",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_misc_buttons_text_hover_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Text on mouse hover",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_misc_buttons_background_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Default background",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
							<div class="input">
								<el-color-picker
									v-model="
										store.options
											.modal_misc_buttons_background_hover_color
									"
									show-alpha
								/>
								<span>
									{{
										__(
											"Background color on mouse hover",
											"addonify-quick-view"
										)
									}}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
			<h3 class="option-box-title">
				{{ __("Developer", "addonify-quick-view") }}
			</h3>
			<div class="adfy-options">
				<div class="adfy-option-columns option-box fullwidth">
					<div class="adfy-col left">
						<div class="label">
							<p class="option-label">
								{{ __("Custom CSS", "addonify-quick-view") }}
							</p>
							<p class="option-description">
								{{
									__(
										"If required, you may add your own custom CSS code here.",
										"addonify-quick-view"
									)
								}}
							</p>
						</div>
					</div>
					<div class="adfy-col right">
						<div class="input">
							<el-input
								v-model="store.options.custom_css"
								class="custom-css-box"
								type="textarea"
								rows="10"
								placeholder="#app { color: blue; }"
								resize="vertical"
								input-style="display:block;width: 100%;"
							/>
						</div>
					</div>
				</div>
			</div>
			<!-- // adfy-options -->
		</div>
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
