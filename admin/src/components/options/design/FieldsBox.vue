<script setup>
	import Color from "../../inputs/Color.vue";
	import InvalidControl from "../../inputs/InvalidControl.vue";

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
						<InvalidControl v-else />
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
