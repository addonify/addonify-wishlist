<script setup>
import { onMounted, onUnmounted } from "vue";
import Icon from "@components/core/Icon.vue";
import { upgradeLanding } from "@helpers/endpoint";
import { useUpsellStore } from "@stores/upsell";

const { __ } = wp.i18n;
const store = useUpsellStore();

/**
 *
 * Fire function that will check sale.
 *
 * @since: 2.0.0
 */

onMounted(() => {
	/**
	 *
	 * Wait for 10 seconds before checking for sale.
	 * Let other API finish their job first.
	 *
	 * @since 1.0.0
	 */
	let sale = null;
	const delay = 10000; // 10 seconds.

	if (typeof store.data === "object") {
		clearTimeout(sale);
		sale = setTimeout(() => {
			Object.keys(store.data).length === 0 ? store.checkSale() : null;
			clearTimeout(sale);
		}, delay);
	}
});

/**
 *
 * Clear timeout on onUnmounted.
 * Prevents memory leak.
 *
 * @since: 2.0.0
 */

onUnmounted(() => {
	clearTimeout();
});
</script>
<template>
	<div id="upsell-banner">
		<div
			v-if="store.hasSale"
			id="sale-badge"
			:class="store.hasCaption ? 'has-caption' : ''"
		>
			<span class="sale-title">
				{{ store.data.addonify.title }}
			</span>
			<span v-if="store.hasCaption" class="sale-caption">
				{{ store.data.addonify.caption }}
			</span>
		</div>
		<div class="inner">
			<div class="block-title">
				<h3 class="upsell-heading">
					{{
						__(
							"Get addonify wishlist premium version",
							"addonify-wishlist"
						)
					}}
				</h3>
			</div>
			<div class="features">
				<ul class="list">
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{
								__("Unlock multi wishlist", "addonify-wishlist")
							}}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Back in stock email", "addonify-wishlist") }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Low in stock email", "addonify-wishlist") }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{
								__(
									"Enable cost estimation",
									"addonify-wishlist"
								)
							}}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{
								__(
									"Allow sharing wishlists in social media",
									"addonify-wishlist"
								)
							}}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{
								__(
									"Additional color options",
									"addonify-wishlist"
								)
							}}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{
								__(
									"Additional typography options",
									"addonify-wishlist"
								)
							}}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("...& many more.", "addonify-wishlist") }}
						</span>
					</li>
				</ul>
			</div>
			<div class="action">
				<a :href="upgradeLanding" class="adfy-button">
					<Icon name="diamond" size="18px" />
					{{ __("Upgrade to pro", "addonify-wishlist") }}
				</a>
			</div>
		</div>
	</div>
</template>
