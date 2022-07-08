<script setup>
	let props = defineProps({
		id: String,
		class: String,
	});
</script>
<template>
	<form :id="props.id" :class="props.class" @submit.prevent>
		<slot></slot>
	</form>
</template>
