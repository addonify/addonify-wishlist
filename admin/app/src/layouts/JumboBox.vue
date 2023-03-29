<script setup>
import { watchEffect } from "vue";
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
		required: false,
	},
	route: {
		type: String,
		required: false,
	},
});

const docLink = "https://docs.addonify.com/";
const mockTitle = "Mock section";

console.log(props.section);
</script>
<template>
	<div class="adfy-jumbo-boxes">
		<div class="adfy-jumbo-box">
			<JumboBoxTitle :title="mockTitle" :doc-link="docLink" />
			<p>
				Page to render: <span class="red">{{ props.route }}</span>
			</p>
			<pre>
				{{ props.section }}
			</pre
			>
			<!--<OptionBox />-->
		</div>
	</div>
</template>
<style scoped>
.red {
	color: red;
}

pre {
	word-wrap: break-word;
	white-space: pre-wrap;
}
</style>
