<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import Form from "@components/core/Form.vue";
import JumboBox from "@layouts/JumboBox.vue";

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

/**
 *
 * Return the slug from the route params.
 *
 * @since: 2.0.0
 * @return {String} slug
 */

const route = useRoute();
const getRouterSlug = computed(() => "adfy-form-" + route.params.slug);
//console.log(route.params);

/**
 *
 * Match the route slug with the section object key.
 * Pass the section object to the JumboBox component.
 *
 * @return {Boolean} true/false
 * @since: 2.0.0
 */

const getSectionBasedOnRoute = computed(() => {
	let section = false;
	if (props.section) {
		Object.keys(props.section).forEach((key) => {
			if (key === route.params.slug) {
				/**
				 *
				 * Case: Success. Route slug matched.
				 *
				 */
				section = props.section[key];
			}
		});
	}
	return section;
});
</script>
<template>
	<main id="app-main app-primary" class="app-primary">
		<Form :id="getRouterSlug">
			<JumboBox
				:section="getSectionBasedOnRoute"
				:route="route.params.slug"
				:reactiveState="props.reactiveState"
			/>
		</Form>
	</main>
</template>
