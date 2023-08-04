<script setup>
import { ref } from "vue";
import UpsellArrow from "@components/core/UpsellArrow.vue";
import UpsellBanner from "@components/partials/UpsellBanner.vue";
import QuickLinks from "@components/partials/QuickLinks.vue";
import Hero from "@components/partials/Hero.vue";

import { advertiseUpsell } from "@helpers/global";
</script>
<template>
	<aside id="app-sidebar">
		<slot name="top" />
		<template v-if="advertiseUpsell">
			<UpsellArrow />
			<UpsellBanner />
		</template>
		<slot name="middle" />
		<QuickLinks />
		<Hero />
		<slot name="bottom" />
	</aside>
</template>
