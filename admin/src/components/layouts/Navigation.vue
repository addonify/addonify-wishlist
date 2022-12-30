<script setup>
	let { __ } = wp.i18n;
</script>
<template>
	<nav class="adfy-navigation">
		<ul class="navigation">
			<li>
				<router-link to="/">
					<span class="icon">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path fill="none" d="M0 0h24v24H0z" />
							<path
								d="M2.132 13.63a9.942 9.942 0 0 1 0-3.26c1.102.026 2.092-.502 2.477-1.431.385-.93.058-2.004-.74-2.763a9.942 9.942 0 0 1 2.306-2.307c.76.798 1.834 1.125 2.764.74.93-.385 1.457-1.376 1.43-2.477a9.942 9.942 0 0 1 3.262 0c-.027 1.102.501 2.092 1.43 2.477.93.385 2.004.058 2.763-.74a9.942 9.942 0 0 1 2.307 2.306c-.798.76-1.125 1.834-.74 2.764.385.93 1.376 1.457 2.477 1.43a9.942 9.942 0 0 1 0 3.262c-1.102-.027-2.092.501-2.477 1.43-.385.93-.058 2.004.74 2.763a9.942 9.942 0 0 1-2.306 2.307c-.76-.798-1.834-1.125-2.764-.74-.93.385-1.457 1.376-1.43 2.477a9.942 9.942 0 0 1-3.262 0c.027-1.102-.501-2.092-1.43-2.477-.93-.385-2.004-.058-2.763.74a9.942 9.942 0 0 1-2.307-2.306c.798-.76 1.125-1.834.74-2.764-.385-.93-1.376-1.457-2.477-1.43zM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"
							/>
						</svg>
					</span>
					{{ __("Settings", "addonify-wishlist") }}
				</router-link>
			</li>
			<li>
				<router-link to="/styles">
					<span class="icon">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path fill="none" d="M0 0h24v24H0z" />
							<path
								d="M4 3h16a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm2 9h6a1 1 0 0 1 1 1v3h1v6h-4v-6h1v-2H5a1 1 0 0 1-1-1v-2h2v1zm11.732 1.732l1.768-1.768 1.768 1.768a2.5 2.5 0 1 1-3.536 0z"
							/>
						</svg>
					</span>
					{{ __("Styles", "addonify-wishlist") }}
				</router-link>
			</li>
			<li>
				<router-link to="/tools">
					<span class="icon">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path fill="none" d="M0 0h24v24H0z" />
							<path
								d="M5.33 3.271a3.5 3.5 0 0 1 4.472 4.474L20.647 18.59l-2.122 2.121L7.68 9.867a3.5 3.5 0 0 1-4.472-4.474L5.444 7.63a1.5 1.5 0 1 0 2.121-2.121L5.329 3.27zm10.367 1.884l3.182-1.768 1.414 1.414-1.768 3.182-1.768.354-2.12 2.121-1.415-1.414 2.121-2.121.354-1.768zm-7.071 7.778l2.121 2.122-4.95 4.95A1.5 1.5 0 0 1 3.58 17.99l.097-.107 4.95-4.95z"
							/>
						</svg>
					</span>
					{{ __("Tools", "addonify-wishlist") }}
				</router-link>
			</li>
			<li>
				<router-link to="/products">
					<span class="icon">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
						>
							<path fill="none" d="M0 0h24v24H0z" />
							<path
								d="M13 16.938V19h5v2H6v-2h5v-2.062A8.001 8.001 0 0 1 4 9V3h16v6a8.001 8.001 0 0 1-7 7.938zM1 5h2v4H1V5zm20 0h2v4h-2V5z"
							/>
						</svg>
					</span>
					{{ __("Products", "addonify-wishlist") }}
				</router-link>
			</li>
		</ul>
	</nav>
</template>
