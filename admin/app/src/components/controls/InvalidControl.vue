<script setup>
import { textdomain } from "@helpers/global";
const { __ } = wp.i18n;
</script>
<template>
	<span class="unsupported-control-text">
		❌
		{{ __("Input control is not supported.", textdomain) }}
	</span>
</template>
