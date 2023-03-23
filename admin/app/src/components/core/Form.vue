<script setup>
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
