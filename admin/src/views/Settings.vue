<script setup>
	import { onMounted } from "vue";
	import Loading from "../components/layouts/Loading.vue";
	import Navigation from "../components/layouts/Navigation.vue";
	import Section from "../components/options/Section.vue";
	import Form from "../components/layouts/Form.vue";
	import { useOptionsStore } from "../stores/options";
	let store = useOptionsStore();

	onMounted(() => {
		store.fetchOptions();
	});
</script>

<template>
	<section class="adfy-container">
		<main class="adfy-columns main-content">
			<aside class="adfy-col start site-secondary">
				<Navigation />
			</aside>
			<section class="adfy-col end site-primary">
				<Loading v-if="store.isLoading" />
				<Form id="adfy-settings-form" class="adfy-form" v-else>
					<section
						class="options-section"
						v-for="(section, sectionId) in store.data.settings
							.sections"
					>
						<Section
							:section="section"
							:reactiveState="store.options"
							:sectionId="sectionId"
						/>
					</section>
				</Form>
			</section>
		</main>
	</section>
</template>
