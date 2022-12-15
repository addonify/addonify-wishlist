<script setup>
	import { onMounted } from "vue";
	import Loading from "../components/layouts/Loading.vue";
	import Navigation from "../components/layouts/Navigation.vue";
	import Tools from "../components/options/Tools.vue";
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
			<aside class="adfy-col start aside site-secondary">
				<Navigation />
			</aside>
			<section class="adfy-col end site-primary">
				<Loading v-if="store.isLoading" />
				<Form v-else id="adfy-tools-form" class="adfy-form">
					<section
						class="options-section"
						v-for="section in store.data.tools"
					>
						<Tools
							:section="section"
							:reactiveState="store.options"
						/>
					</section>
				</Form>
			</section>
		</main>
	</section>
</template>
