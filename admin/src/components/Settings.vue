<script setup>
	import { onMounted } from "vue";
	import Loading from "./layouts/Loading.vue";
	import Section from "./options/Section.vue";
	import { useOptionsStore } from "../stores/options";
	let store = useOptionsStore();

	onMounted(() => {
		store.fetchOptions();
	});
</script>
<template>
	<Loading v-if="store.isLoading" />
	<form v-else id="adfy-settings-form" class="adfy-form" @submit.prevent>
		<section
			class="options-section"
			v-for="(section, sectionId) in store.data.settings.sections"
		>
			<Section
				:section="section"
				:reactiveState="store.options"
				:sectionId="sectionId"
			/>
		</section>
	</form>
</template>
