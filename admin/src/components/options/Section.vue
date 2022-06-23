<script setup>
	import Switch from "../inputs/Switch.vue"; // Regular switch.
	import Text from "../inputs/Text.vue"; // Input type text.
	import Number from "../inputs/Number.vue"; // Input type number.
	import NumberInputButton from "../inputs/NumberInputButton.vue"; // Input type number with + & - buttons.
	import Textarea from "../inputs/Textarea.vue"; // Input type textarea.
	import Select from "../inputs/Select.vue"; // Input type select.
	import Radio from "../inputs/Radio.vue"; // Input type radio.
	import RadioIcon from "../inputs/RadioIcon.vue"; // Input type radio with icons.
	let { __, _x, _n, _nx } = wp.i18n;
	let props = defineProps({
		section: Object,
		reactiveState: Object,
	});
</script>
<template>
	<h3 class="option-box-title" v-if="props.section.title !== ''">
		{{ props.section.title }}
	</h3>
	<div class="adfy-options" v-for="(field, fieldId) in props.section.fields">
		<div class="adfy-option-columns option-box" :class="field.className">
			<div class="adfy-col left">
				<div class="label">
					<p class="option-label" v-if="field.label !== ''">
						{{ field.label }}
					</p>
					<p
						class="option-description"
						v-if="field.description !== ''"
					>
						{{ field.description }}
					</p>
				</div>
			</div>
			<div class="adfy-col right">
				<div class="input">
					<Switch
						v-if="field.type == 'switch'"
						v-model="props.reactiveState[fieldId]"
					/>
					<Text
						v-else-if="field.type == 'text'"
						v-model="props.reactiveState[fieldId]"
					/>
					<NumberInputButton
						v-else-if="
							field.type == 'number' &&
							field.type_style == 'toggle'
						"
						v-model="props.reactiveState[fieldId]"
					/>
					<Number
						v-else-if="field.type == 'number'"
						v-model="props.reactiveState[fieldId]"
					/>
					<Select
						v-else-if="field.type == 'select'"
						v-model="props.reactiveState[fieldId]"
						:choices="field.choices"
					/>
					<RadioIcon
						v-else-if="
							field.type == 'radio' &&
							field.type_style == 'radio_icon'
						"
						v-model="props.reactiveState[fieldId]"
						:choices="field.choices"
					/>
					<Radio
						v-else-if="field.type == 'radio'"
						v-model="props.reactiveState[fieldId]"
						:choices="field.choices"
					/>
					<Textarea
						v-else-if="field.type == 'textarea'"
						v-model="props.reactiveState[fieldId]"
						:className="field.inputClassName"
					/>
					<p v-else class="unsupported-control-text">
						❌
						{{ __("Input is not supported.", "addonify-wishist") }}
						<a
							href="https://docs.addonify.com/kb/woocommerce-wishlist/developer/adding-field/"
							class="adfy-button fake-button has-underline forward-to-doc-link"
							target="_blank"
						>
							{{ __("Check docs", "addonify-wishist") }}
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- // adfy-options -->
</template>
<style lang="scss">
	.unsupported-control-text {
		font-size: 14px;
	}
	.adfy-button.fake-button.forward-to-doc-link {
		font-size: 14px;
		fill: var(--addonify_primary_color);
		color: var(--addonify_primary_color);

		&::after,
		&::before {
			content: "";
			bottom: -5px;
			height: 2px;
		}
		&::after {
			content: "";
			background-color: var(--addonify_primary_color);
		}
		&:hover {
			fill: var(--addonify_base_text_color);
			color: var(--addonify_base_text_color);

			&::after,
			&::before {
				content: "";
				background-color: var(--addonify_base_text_color);
			}
		}
	}
</style>
