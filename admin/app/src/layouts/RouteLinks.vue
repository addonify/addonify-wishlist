<script setup>
import { advertiseUpsell } from "@helpers/global";
import { useSettingsStore } from "@stores/settings";
const store = useSettingsStore();

/**
 *
 * Return the route link attaching "/s/" to the route.
 *
 * @param {string} route
 * @return {string} string
 * @since 1.0.0
 */

const buildDynamicRouteLink = (route) => "/s/" + route;
</script>
<template>
	<aside id="app-routes">
		<nav id="adfy-navigation">
			<ul class="route-lists">
				<li v-for="(route, key) in store.data" class="list">
					<router-link :to="buildDynamicRouteLink(key)">
						<template v-if="route.icon !== ''">
							<span class="icon" v-html="route.icon"></span>
						</template>
						<template v-else>
							<span class="icon">
								<svg
									xmlns="http://www.w3.org/2000/svg"
									viewBox="0 0 24 24"
									width="20"
									height="20"
								>
									<path
										d="M1,4.75H3.736a3.728,3.728,0,0,0,7.195,0H23a1,1,0,0,0,0-2H10.931a3.728,3.728,0,0,0-7.195,0H1a1,1,0,0,0,0,2ZM7.333,2a1.75,1.75,0,1,1-1.75,1.75A1.752,1.752,0,0,1,7.333,2Z"
									/>
									<path
										d="M23,11H20.264a3.727,3.727,0,0,0-7.194,0H1a1,1,0,0,0,0,2H13.07a3.727,3.727,0,0,0,7.194,0H23a1,1,0,0,0,0-2Zm-6.333,2.75A1.75,1.75,0,1,1,18.417,12,1.752,1.752,0,0,1,16.667,13.75Z"
									/>
									<path
										d="M23,19.25H10.931a3.728,3.728,0,0,0-7.195,0H1a1,1,0,0,0,0,2H3.736a3.728,3.728,0,0,0,7.195,0H23a1,1,0,0,0,0-2ZM7.333,22a1.75,1.75,0,1,1,1.75-1.75A1.753,1.753,0,0,1,7.333,22Z"
									/>
								</svg>
							</span>
						</template>
						<span class="label">
							{{ route.title ? route.title : "No title ???" }}
						</span>
					</router-link>
				</li>
				<li v-if="advertiseUpsell" class="list">
					<router-link to="/upsell" class="upsell-link">
						<span class="icon">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 24 24"
								width="20"
								height="20"
							>
								<path
									d="M23.147,9.471,22.36,8.4A5.885,5.885,0,0,0,17.632,6H6.383A5.892,5.892,0,0,0,1.721,8.309L.9,9.383a4.418,4.418,0,0,0,.548,5.937l7.99,7.707a3.82,3.82,0,0,0,2.55.969,3.9,3.9,0,0,0,2.6-1l7.936-7.633A4.39,4.39,0,0,0,23.147,9.471Zm-2.4.107.787,1.074a2.388,2.388,0,0,1,.208.348H16.951a6.616,6.616,0,0,0-.372-1.4L15.939,8h1.693A3.878,3.878,0,0,1,20.747,9.578ZM11.99,20.088l-2.769-6.27A4.642,4.642,0,0,1,8.995,13h5.952a4.354,4.354,0,0,1-.176.647ZM9.1,11a4.652,4.652,0,0,1,.157-.529L10.241,8h3.544l.937,2.343a4.8,4.8,0,0,1,.2.657ZM3.311,9.521A3.884,3.884,0,0,1,6.383,8h1.7L7.4,9.729A6.57,6.57,0,0,0,7.033,11H2.245a2.322,2.322,0,0,1,.247-.4Zm-.5,4.333a2.374,2.374,0,0,1-.6-.854H6.983a6.874,6.874,0,0,0,.387,1.576l2.827,6.4Zm10.96,7.16L16.625,14.4a6.573,6.573,0,0,0,.344-1.4H21.8a2.5,2.5,0,0,1-.633.9Z"
								/>
								<path
									d="M12,4a1,1,0,0,0,1-1V1a1,1,0,0,0-2,0V3A1,1,0,0,0,12,4Z"
								/>
								<path
									d="M16.553,3.9A1,1,0,0,0,17.9,3.447l1-2a1,1,0,1,0-1.79-.894l-1,2A1,1,0,0,0,16.553,3.9Z"
								/>
								<path
									d="M6.105,3.447A1,1,0,0,0,7.9,2.553l-1-2a1,1,0,1,0-1.79.894Z"
								/>
							</svg>
						</span>
						<span class="label">Premium</span>
					</router-link>
				</li>
				<li class="list">
					<router-link to="/products">
						<span class="icon">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 24 24"
								width="20"
								height="20"
							>
								<path
									d="M19.5,10H19V9a3,3,0,0,0-3-3H4A3,3,0,0,0,1,9V19a5.006,5.006,0,0,0,5,5h8a5.009,5.009,0,0,0,4.9-4A3.6,3.6,0,0,0,23,16.5v-3A3.5,3.5,0,0,0,19.5,10ZM14,22H6a3,3,0,0,1-3-3V9A1,1,0,0,1,4,8H16a1,1,0,0,1,1,1V19A3,3,0,0,1,14,22Zm7-5.5A1.621,1.621,0,0,1,19,18V12a1.621,1.621,0,0,1,2,1.5ZM9,3V1a1,1,0,0,1,2,0V3A1,1,0,0,1,9,3Zm4,0V1a1,1,0,0,1,2,0V3A1,1,0,0,1,13,3ZM5,3V1A1,1,0,0,1,7,1V3A1,1,0,0,1,5,3Z"
								/>
							</svg>
						</span>
						<span class="label">Products</span>
					</router-link>
				</li>
			</ul>
		</nav>
	</aside>
</template>
