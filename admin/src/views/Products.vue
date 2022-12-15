<script setup>
	import { ref, onMounted } from "vue";
	import Loading from "../components/layouts/Loading.vue";
	import Navigation from "../components/layouts/Navigation.vue";
	import Recommended from "../components/layouts/Recommended.vue";

	let allAddons = new Object();
	let hotAddons = new Object();
	let generalAddons = new Object();
	let { __ } = wp.i18n;
	let isFetching = ref(true);
	let isCheckingAddonStatus = ref(true);
	let github =
		"https://raw.githubusercontent.com/addonify/recommended-products/main/products.json";

	/**
	 *
	 * Fetch the product list from the github repo.
	 */

	const fetchGithubRepo = async () => {
		try {
			const res = await fetch(github, {
				// no cache.
				cache: "no-cache",
			});
			let data = await res.json();
			console.log(data);

			if (res.status !== 200) {
				console.log("Couldn't fetch Github repo " + res);
			}

			processRecommendedPluginsList(data);
			isFetching.value = false;
		} catch (err) {
			console.log(err);
		}
	};

	/**
	 *
	 * Get the recommended products.
	 * Used on fetchGithubRepo().
	 * Used for processing hotAddons, generalAddons & allAddons.
	 * @param {object} list
	 */

	const processRecommendedPluginsList = (list) => {
		hotAddons = list.data.hot; // Only hot addons.
		generalAddons = list.data.general; // Only general addons.
		allAddons = { ...hotAddons, ...generalAddons }; // Push all addons to allAddons object.

		if (Array.isArray(allAddons)) {
			allAddons.forEach((addon) => {
				//console.log(addon);
				checkAddonStatusOnBoot(addon);
			});
		}
	};

	/*
	 *
	 * Check plugin if plugin is installed on load.
	 *
	 */

	const checkAddonStatusOnBoot = (slug) => {
		console.log(`Checking ${slug} plugin installed status.`);
		isCheckingAddonStatus.value = false;
	};

	onMounted(() => {
		fetchGithubRepo();
	});
</script>

<template>
	<section class="adfy-container">
		<main class="adfy-columns main-content">
			<aside class="adfy-col start aside secondary">
				<Navigation :addons="allAddons" />
			</aside>
			<section class="adfy-col end site-primary">
				<Loading v-if="isFetching && isCheckingAddonStatus" />
				<section v-else id="recommended-products">
					<div id="recommended-hot-products">
						<div class="adfy-grid">
							<template v-for="(addon, key) in hotAddons">
								<Recommended :slug="addon" />
							</template>
						</div>
					</div>
					<div id="recommended-general-products"></div>
				</section>
			</section>
		</main>
	</section>
</template>
