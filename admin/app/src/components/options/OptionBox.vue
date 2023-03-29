<script setup>
import HelpTip from "@components/core/HelpTip.vue";
import ControlMaster from "@components/options/ControlMaster.vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	optionBox: {
		type: Object,
		required: false,
	},
});

//console.log(props.optionBox);
</script>
<template>
	<div class="adfy-option-boxes">
		<div
			class="adfy-option-box"
			:class="field.className ? field.className : ''"
			:data_width="field.width ? field.width : 'default'"
			v-for="(field, fieldKey) in props.optionBox.sub_sections"
		>
			<div class="column column-left">
				<p class="option-label">
					{{ field.label ? field.label : "?????" }}
					<HelpTip
						v-if="field.hasOwnProperty('description')"
						:content="field.description"
					/>
				</p>
			</div>
			<div class="column column-right">
				<div class="adfy-option">
					<ControlMaster :field="field" :fieldKey="fieldKey" />
				</div>
			</div>
		</div>
	</div>
</template>
