<script setup>
	import { ElTag } from "element-plus";
	import Text from "../../inputs/Text.vue";
	import Switch from "../../inputs/Switch.vue";
	import Color from "../../inputs/Color.vue";
	import Textarea from "../../inputs/Textarea.vue";
	import ResetOptions from "../../inputs/ResetOptions.vue";
	import ExportOptions from "../../inputs/ExportOptions.vue";
	import ImportOptions from "../../inputs/ImportOptions.vue";
	import InvalidControl from "../../inputs/InvalidControl.vue";

	let props = defineProps({
		section: Object,
		sectionId: String,
		reactiveState: Object,
	});

	//console.log(props.section);
</script>
<template>
	<h3 class="option-box-title" v-if="props.section.title !== ''">
		{{ props.section.title }}
	</h3>
	<div v-for="(field, fieldKey) in props.section.fields" class="adfy-options">
		<div class="adfy-option-columns option-box" :class="field.className">
			<div class="adfy-col left">
				<div class="label">
					<p class="option-label" v-if="field.label !== ''">
						{{ field.label }}
						<el-tag
							v-if="
								field.hasOwnProperty('badge') &&
								field.badge !== ''
							"
							type="success"
							effect="light"
							round
						>
							{{ field.badge }}
						</el-tag>
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
						v-model="props.reactiveState[fieldKey]"
					/>
					<Text
						v-else-if="field.type == 'text'"
						v-model="props.reactiveState[fieldKey]"
						:placeholder="field.placeholder"
					/>
					<Textarea
						v-else-if="field.type == 'textarea'"
						v-model="props.reactiveState[fieldKey]"
						:className="field.inputClassName"
						:placeholder="field.placeholder"
					/>
					<Color
						v-else-if="field.type == 'color'"
						v-model="props.reactiveState[fieldKey]"
						:isAlpha="field.isAlphaPicker"
					/>
					<ResetOptions
						v-else-if="field.type == 'reset-option'"
						:label="field.label"
						:confirmText="field.confirmText"
						:confirmYesText="field.confirmYesText"
						:confirmNoText="field.confirmNoText"
					/>
					<ExportOptions
						v-else-if="field.type == 'export-option'"
						:label="field.label"
					/>
					<ImportOptions
						v-else-if="field.type == 'import-option'"
						:caption="field.caption"
						:note="field.note"
					/>
					<InvalidControl v-else />
				</div>
			</div>
		</div>
	</div>
</template>
