<script setup>
import { docsLanding } from "@helpers/endpoint";
import OptionBox from "@components/options/OptionBox.vue";
import JumboBoxTitle from "@layouts/JumboBoxTitle.vue";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	section: {
		type: Object,
		required: false,
	},
	reactiveState: {
		type: Object,
		required: true,
	},
});

//console.log(props.section);
</script>
<template>
	<div class="adfy-jumbo-boxes">
		<div class="adfy-jumbo-box" v-for="box in props.section.sections">
			<JumboBoxTitle
				:title="box.title"
				:doc-link="box.docs_link ? box.docs_link : docsLanding"
			/>
			<OptionBox :optionBox="box" :reactiveState="props.reactiveState" />
		</div>
	</div>
</template>
