<script setup>
import { computed, watchEffect } from "vue";
import Form from "@components/core/Form.vue";
import JumboBox from "@layouts/JumboBox.vue";
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
	reactiveState: {
		type: Object,
		required: true,
	},
});

//console.log(props.section);

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
 * Pass the json object to the JumboBox component.
 *
 * @return {Boolean} true/false
 * @since: 2.0.0
 */

/**
 *
 * watchEffect: Perform the side effect based on the below condition.
 * -
 *
 * @since: 2.0.0
 */
watchEffect(() => {});
</script>
<template>
	<main id="app-main app-primary" class="app-primary">
		<Form :id="getRouterSlug">
			<JumboBox
				:section="props.section.general"
				:sectionTitle="props.section.general.title"
				:reactiveState="props.reactiveState"
			/>
		</Form>
	</main>
</template>
