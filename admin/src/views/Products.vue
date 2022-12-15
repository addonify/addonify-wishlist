<script setup>
	import { ref, onMounted } from "vue";
	import Loading from "../components/layouts/Loading.vue";
	import Navigation from "../components/layouts/Navigation.vue";
	import Recommended from "../components/layouts/Recommended.vue";

	let data = {};
	let { __ } = wp.i18n;
	let isLoading = ref(true);
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
			data = await res.json();
			console.log(data);

			if (res.status !== 200) {
				console.log("Couldn't fetch Github repo " + res);
			}

			processRecommendedPluginsList(data);
		} catch (err) {
			console.log(err);
		}
	};

	/**
	 *
	 * Get the recommended products.
	 */

	const processRecommendedPluginsList = (data) => {
		let hotProducts = data.data.hot;

		if (Array.isArray(hotProducts)) {
			hotProducts.forEach((slug) => {
				//console.log(addon);
				checkPluginInstalled(slug);
				fetchWpPluginInfo(slug);
			});
		}
	};

	/*
	 *
	 * Check plugin if plugin is installed on load.
	 *
	 */

	const checkPluginInstalled = (slug) => {
		console.log(`Checking ${slug} addon installed status.`);
	};

	/**
	 *
	 * WordPress.org/plugins get plugin thumbnail.
	 */

	const getThumbnailWordPress = (slug) => {
		let thumbURL = `https://ps.w.org/${slug}/assets/icon-256x256.png`;
		return thumbURL;
	};

	/**
	 *
	 * WordPress.org/plugins api get plugin info.
	 */

	const fetchWpPluginInfo = async (slug) => {
		let wpApi = `https://api.wordpress.org/plugins/info/1.0/${slug}.json`;

		try {
			const res = await fetch(wpApi);
			let data = await res.json();
			console.log(data);

			if (res.status !== 200) {
				console.log("Couldn't fetch WordPress plugin repo " + res);
			}
		} catch (err) {
			console.log(err);
		}
	};

	/*
	 *
	 * Handle install/activate button click action.
	 * Called from Recommended.vue child component.
	 */

	const handleActivation = (slug) => {
		console.log(slug);
	};

	onMounted(() => {
		fetchGithubRepo();
	});
</script>

<template>
	<section class="adfy-container">
		<main class="adfy-columns main-content">
			<aside class="adfy-col start aside secondary">
				<Navigation />
			</aside>
			<section class="adfy-col end site-primary">
				<!--<Loading v-if="isLoading" />-->
				<section id="recommended-products">
					<div id="recommended-hot-products">
						<div class="adfy-grid">
							<!--<Recommended />-->
						</div>
					</div>
					<div id="recommended-general-products"></div>
				</section>
			</section>
		</main>
	</section>
</template>
