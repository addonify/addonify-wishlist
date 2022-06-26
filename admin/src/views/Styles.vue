<script setup>
	import { onMounted } from "vue";
	import Loading from "../components/layouts/Loading.vue";
	import Navigation from "../components/layouts/Navigation.vue";
	import Styles from "../components/options/Styles.vue";
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
				<Form id="adfy-styles-form" class="adfy-form" v-else>
					<section
						class="options-section"
						v-for="section in store.data.styles"
					>
						<Styles
							:section="section"
							:reactiveState="store.options"
						/>
					</section>
				</Form>
			</section>
		</main>
	</section>
</template>
