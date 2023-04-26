<script setup>
import { ref } from "vue";
import UpsellArrow from "@components/core/UpsellArrow.vue";
import UpsellBanner from "@components/partials/UpsellBanner.vue";
import QuickLinks from "@components/partials/QuickLinks.vue";
import { advertiseUpsell } from "@helpers/global";
</script>
<template>
	<aside id="app-sidebar">
		<template v-if="advertiseUpsell">
			<UpsellArrow />
			<UpsellBanner />
		</template>
		<template v-else>
			<QuickLinks />
		</template>
	</aside>
</template>
