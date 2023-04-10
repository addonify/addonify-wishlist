<script setup>
import Icon from "@/components/core/Icon.vue";
const { __ } = wp.i18n;
</script>
<template>
	<div id="quick-links">
		<div class="title-holder">
			<h3 class="box-title">
				{{ __("Quick links", "addonify-wishlist") }}
			</h3>
		</div>
		<div class="list-holder">
			<ul class="lists">
				<li class="review">
					<span class="icon-holder">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path
								d="M20,0H4A4,4,0,0,0,0,4V16a4,4,0,0,0,4,4H6.9l4.451,3.763a1,1,0,0,0,1.292,0L17.1,20H20a4,4,0,0,0,4-4V4A4,4,0,0,0,20,0Zm2,16a2,2,0,0,1-2,2H17.1a2,2,0,0,0-1.291.473L12,21.69,8.193,18.473h0A2,2,0,0,0,6.9,18H4a2,2,0,0,1-2-2V4A2,2,0,0,1,4,2H20a2,2,0,0,1,2,2Z"
							/>
							<path d="M7,7h5a1,1,0,0,0,0-2H7A1,1,0,0,0,7,7Z" />
							<path d="M17,9H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2Z" />
							<path
								d="M17,13H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2Z"
							/>
						</svg>
					</span>
					<a
						href="https://wordpress.org/support/plugin/addonify-wishlist/reviews/#new-post"
						target="_blank"
						rel="noopener noreferrer"
						class="elink"
					>
						{{ __("Drop a feedback", "addonify-wishlist") }}
						<Icon name="arrow-up-right" />
					</a>
				</li>
				<li class="support">
					<span class="icon-holder">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path
								d="M21,12.424V11A9,9,0,0,0,3,11v1.424A5,5,0,0,0,5,22a2,2,0,0,0,2-2V14a2,2,0,0,0-2-2V11a7,7,0,0,1,14,0v1a2,2,0,0,0-2,2v6a2,2,0,0,0,2,2,5,5,0,0,0,2-9.576ZM5,20H5a3,3,0,0,1,0-6Zm14,0V14a3,3,0,0,1,0,6Z"
							/>
						</svg>
					</span>
					<a
						href="https://wordpress.org/support/plugin/addonify-wishlist/"
						target="_blank"
						rel="noopener noreferrer"
						class="elink"
					>
						{{ __("Support", "addonify-wishlist") }}
						<Icon name="arrow-up-right" />
					</a>
				</li>
				<li class="report-issue">
					<span class="icon-holder">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path
								d="M22,7a2,2,0,0,0,2-2V1a1,1,0,0,0-2,0V5H18c-.018,0-.032.009-.05.01a6.411,6.411,0,0,0-11.89,0C6.039,5.011,6.021,5,6,5H2V1A1,1,0,0,0,0,1V5A2,2,0,0,0,2,7H5.485L4.472,11H1a1,1,0,0,0,0,2H3.965l-.145.573L3.8,13.7a8.37,8.37,0,0,0-.07,1.032A8.2,8.2,0,0,0,4.053,17H2a2,2,0,0,0-2,2v4a1,1,0,0,0,2,0V19H4.93a8.248,8.248,0,0,0,14.14,0H22v4a1,1,0,0,0,2,0V19a2,2,0,0,0-2-2H19.947a8.2,8.2,0,0,0,.325-2.273A8.37,8.37,0,0,0,20.2,13.7l-.175-.7H23a1,1,0,0,0,0-2H19.522L18.513,7ZM12,21a6.279,6.279,0,0,1-6.272-6.273A6.188,6.188,0,0,1,5.775,14L7.805,5.97a4.448,4.448,0,0,1,8.376-.041L18.225,14a6.188,6.188,0,0,1,.047.725A6.279,6.279,0,0,1,12,21Z"
							/>
						</svg>
					</span>
					<a
						href="https://github.com/addonify/addonify-wishlist/issues/"
						target="_blank"
						rel="noopener noreferrer"
						class="elink"
					>
						{{ __("Report an issue", "addonify-wishlist") }}
						<Icon name="arrow-up-right" />
					</a>
				</li>
				<li class="docs">
					<span class="icon-holder">
						<svg
							viewBox="0 0 24 24"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								d="m17 14a1 1 0 0 1 -1 1h-8a1 1 0 0 1 0-2h8a1 1 0 0 1 1 1zm-4 3h-5a1 1 0 0 0 0 2h5a1 1 0 0 0 0-2zm9-6.515v8.515a5.006 5.006 0 0 1 -5 5h-10a5.006 5.006 0 0 1 -5-5v-14a5.006 5.006 0 0 1 5-5h4.515a6.958 6.958 0 0 1 4.95 2.05l3.484 3.486a6.951 6.951 0 0 1 2.051 4.949zm-6.949-7.021a5.01 5.01 0 0 0 -1.051-.78v4.316a1 1 0 0 0 1 1h4.316a4.983 4.983 0 0 0 -.781-1.05zm4.949 7.021c0-.165-.032-.323-.047-.485h-4.953a3 3 0 0 1 -3-3v-4.953c-.162-.015-.321-.047-.485-.047h-4.515a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3z"
							/>
						</svg>
					</span>
					<a
						href="https://docs.addonify.com/kb/woocommerce-wishlist/"
						target="_blank"
						rel="noopener noreferrer"
						class="elink"
					>
						{{ __("Documentation", "addonify-wishlist") }}
						<Icon name="arrow-up-right" />
					</a>
				</li>
				<li class="translate">
					<span class="icon-holder">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path
								d="m5.986,9.4c-.038,0-.071.026-.079.063l-.811,3.437h1.757l-.787-3.437c-.009-.037-.041-.063-.079-.063Z"
							/>
							<path
								d="m11,4H3C1.343,4,0,5.343,0,7v13h11V4Zm-3.827,10.3h-2.409l-.401,1.7h-1.437l1.616-6.853c.201-.866,1.137-1.406,2.056-1.021.439.184.734.606.842,1.07l1.559,6.804h-1.437l-.389-1.7Z"
							/>
							<path
								d="m21,4h-8v16h11V7c0-1.654-1.346-3-3-3Zm1,6.253h-.932c-.121,1.275-.617,2.731-1.607,3.866.663.403,1.49.665,2.539.665v1.253c-1.456,0-2.595-.418-3.488-1.053-.896.64-2.049,1.053-3.512,1.053v-1.253c1.049,0,1.881-.258,2.545-.661-.554-.636-.957-1.372-1.223-2.123h1.336c.204.468.487.92.847,1.325.818-.92,1.192-2.108,1.303-3.071h-4.808v-1.253h2.873v-1h1.253v1h2.873v1.253Z"
							/>
						</svg>
					</span>
					<a
						href="https://translate.wordpress.org/projects/wp-plugins/addonify-wishlist/"
						target="_blank"
						rel="noopener noreferrer"
						class="elink"
					>
						{{ __("Translate", "addonify-wishlist") }}
						<Icon name="arrow-up-right" />
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>
