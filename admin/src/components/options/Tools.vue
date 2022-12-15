<script setup>
	import Field from "./design/Field.vue";

	let props = defineProps({
		section: Object,
		reactiveState: Object,
	});
</script>
<template>
	<div v-for="field in props.section" class="adfy-options-item">
		<Field :section="field" :reactiveState="props.reactiveState" />
	</div>
	<!-- // adfy-options-item -->
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
