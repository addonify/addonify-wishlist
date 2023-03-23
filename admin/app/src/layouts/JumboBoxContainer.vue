<script setup>
import JumboBox from "@layouts/JumboBox.vue";

let props = defineProps({
	section: [Object, Array],
});

console.log(props.section);
</script>
<template>
	<main id="app-main app-primary" class="app-primary">
		<JumboBox />
	</main>
</template>
