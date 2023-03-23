<script setup>
/**
 *
 * Define props that we will use in this component.
 * @since: 2.0.0
 */

let props = defineProps({
	id: {
		type: String,
		required: false,
	},
	class: {
		type: String,
		required: false,
	},
});
</script>
<template>
	<form :id="props.id" :class="props.class" @submit.prevent>
		<slot></slot>
	</form>
</template>
