<script setup>
	import Color from "../../inputs/Color.vue";
	import Text from "../../inputs/Text.vue";
	import Switch from "../../inputs/Switch.vue";
	import { useOptionsStore } from "../../../stores/options";
	let { __, _x, _n, _nx } = wp.i18n;
	let store = useOptionsStore();
	let props = defineProps({
		section: Object,
		sectionId: String,
		reactiveState: Object,
	});
</script>
<template>
	<div class="adfy-options">
		<div class="adfy-option-columns option-box fullwidth">
			<div class="adfy-col left">
				<div class="label">
					<p class="option-label" v-if="props.section.title !== ''">
						{{ props.section.title }}
					</p>
					<p
						class="option-description"
						v-if="props.section.description !== ''"
					>
						{{ props.section.description }}
					</p>
				</div>
			</div>
			<div class="adfy-col right">
				<div class="input-group">
					<div
						class="input"
						v-for="(field, fieldKey) in props.section.fields"
					>
						<Color
							v-if="field.type == 'color'"
							v-model:colorVal="props.reactiveState[fieldKey]"
							:showAlpha="field.isAlphaPicker"
							:label="field.label"
						/>
						<span v-else class="unsupported-control-text">
							❌
							{{
								__(
									"Input is not supported.",
									"addonify-wishist"
								)
							}}
							<a
								href="https://docs.addonify.com/kb/woocommerce-wishlist/developer/add-setting-fields/"
								class="adfy-button fake-button has-underline forward-to-doc-link"
								target="_blank"
							>
								{{ __("Check docs", "addonify-wishist") }}
							</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
