<script setup>
import Icon from "@components/core/Icon.vue";
import { upgradeLanding } from "@helpers/endpoint";
import { textdomain } from "@helpers/global";
const { __ } = wp.i18n;
</script>
<template>
	<div id="upsell-banner">
		<div class="inner">
			<div class="block-title">
				<h3 class="upsell-heading">
					{{ __("Get Addonify Wishlist premium version.", textdomain) }}
				</h3>
			</div>
			<div class="features">
				<ul class="list">
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Unlock multi wishlist", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Back in stock email", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Low in stock email", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Enable cost estimation", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Allow sharing wishlists in social media", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Additional color options", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">
							{{ __("Additional typography options", textdomain) }}
						</span>
					</li>
					<li>
						<Icon name="check" size="14px" />
						<span class="text">{{ __("...& many more.", textdomain) }}</span>
					</li>
				</ul>
			</div>
			<div class="action">
				<a :href="upgradeLanding" class="adfy-button">
					<Icon name="diamond" size="18px" />
					{{ __("Upgrade to pro", textdomain) }}
				</a>
			</div>
		</div>
	</div>
</template>
