<script setup>
import OptionBox from "@components/options/OptionBox.vue";
import JumboBoxTitle from "@layouts/JumboBoxTitle.vue";
import { useRoute } from "vue-router";

/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

const props = defineProps({
	section: {
		type: Object,
		required: true,
	},
	sectionTitle: {
		type: String,
		required: false,
	},
	reactiveState: {
		type: Object,
		required: true,
	},
});

const route = useRoute();
const docLink = "https://docs.addonify.com/";
const mockTitle = "Mock section";

console.log(props.section);
</script>
<template>
	<div class="adfy-jumbo-boxes">
		<div class="adfy-jumbo-box">
			<JumboBoxTitle :title="props.sectionTitle" :doc-link="docLink" />
			<pre>{{ props.section }}</pre>
			<!--<pre> {{ box }} </pre>-->
			<!--<OptionBox />-->
		</div>
	</div>
</template>
