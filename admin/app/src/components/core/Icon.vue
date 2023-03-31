<script setup>
/**
 *
 * Define props.
 */
const props = defineProps({
	name: {
		type: String,
		required: true,
	},
	size: {
		type: String,
		default: "16px",
		required: false,
	},
	class: {
		type: String,
		default: "",
		required: false,
	},
});
</script>
<template>
	<span v-if="props.name === 'arrow-down'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<path
				d="M18.71,8.21a1,1,0,0,0-1.42,0l-4.58,4.58a1,1,0,0,1-1.42,0L6.71,8.21a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l4.59,4.59a3,3,0,0,0,4.24,0l4.59-4.59A1,1,0,0,0,18.71,8.21Z"
			/>
		</svg>
	</span>

	<span v-if="props.name === 'arrow-right'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<path
				d="M15.4,9.88,10.81,5.29a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L14,11.29a1,1,0,0,1,0,1.42L9.4,17.29a1,1,0,0,0,1.41,1.42l4.59-4.59A3,3,0,0,0,15.4,9.88Z"
			/>
		</svg>
	</span>

	<span v-if="props.name === 'comment'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<g id="_01_align_center" data-name="01 align center">
				<path
					d="M21,0H3A3,3,0,0,0,0,3V20H6.9l3.808,3.218a2,2,0,0,0,2.582,0L17.1,20H24V3A3,3,0,0,0,21,0Zm1,18H16.366L12,21.69,7.634,18H2V3A1,1,0,0,1,3,2H21a1,1,0,0,1,1,1Z"
				/>
				<rect x="6" y="5" width="6" height="2" />
				<rect x="6" y="9" width="12" height="2" />
				<rect x="6" y="13" width="12" height="2" />
			</g>
		</svg>
	</span>

	<span v-if="props.name === 'check'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<path
				d="M22.319,4.431,8.5,18.249a1,1,0,0,1-1.417,0L1.739,12.9a1,1,0,0,0-1.417,0h0a1,1,0,0,0,0,1.417l5.346,5.345a3.008,3.008,0,0,0,4.25,0L23.736,5.847a1,1,0,0,0,0-1.416h0A1,1,0,0,0,22.319,4.431Z"
			/>
		</svg>
	</span>

	<span
		v-if="props.name === 'check-circle'"
		class="icon"
		:class="props.class"
	>
		<svg
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<path
				d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"
			/>
			<path
				d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"
			/>
		</svg>
	</span>

	<span v-if="props.name === 'diamond'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<path
				d="M23.147,9.471,22.36,8.4A5.885,5.885,0,0,0,17.632,6H6.383A5.892,5.892,0,0,0,1.721,8.309L.9,9.383a4.418,4.418,0,0,0,.548,5.937l7.99,7.707a3.82,3.82,0,0,0,2.55.969,3.9,3.9,0,0,0,2.6-1l7.936-7.633A4.39,4.39,0,0,0,23.147,9.471Zm-2.4.107.787,1.074a2.388,2.388,0,0,1,.208.348H16.951a6.616,6.616,0,0,0-.372-1.4L15.939,8h1.693A3.878,3.878,0,0,1,20.747,9.578ZM11.99,20.088l-2.769-6.27A4.642,4.642,0,0,1,8.995,13h5.952a4.354,4.354,0,0,1-.176.647ZM9.1,11a4.652,4.652,0,0,1,.157-.529L10.241,8h3.544l.937,2.343a4.8,4.8,0,0,1,.2.657ZM3.311,9.521A3.884,3.884,0,0,1,6.383,8h1.7L7.4,9.729A6.57,6.57,0,0,0,7.033,11H2.245a2.322,2.322,0,0,1,.247-.4Zm-.5,4.333a2.374,2.374,0,0,1-.6-.854H6.983a6.874,6.874,0,0,0,.387,1.576l2.827,6.4Zm10.96,7.16L16.625,14.4a6.573,6.573,0,0,0,.344-1.4H21.8a2.5,2.5,0,0,1-.633.9Z"
			/>
			<path d="M12,4a1,1,0,0,0,1-1V1a1,1,0,0,0-2,0V3A1,1,0,0,0,12,4Z" />
			<path
				d="M16.553,3.9A1,1,0,0,0,17.9,3.447l1-2a1,1,0,1,0-1.79-.894l-1,2A1,1,0,0,0,16.553,3.9Z"
			/>
			<path
				d="M6.105,3.447A1,1,0,0,0,7.9,2.553l-1-2a1,1,0,1,0-1.79.894Z"
			/>
		</svg>
	</span>
	<span v-if="props.name === 'loading'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			:width="props.size"
			:height="props.size"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
		>
			<line x1="12" y1="2" x2="12" y2="6"></line>
			<line x1="12" y1="18" x2="12" y2="22"></line>
			<line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
			<line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
			<line x1="2" y1="12" x2="6" y2="12"></line>
			<line x1="18" y1="12" x2="22" y2="12"></line>
			<line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
			<line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
		</svg>
	</span>
	<span v-if="props.name === 'spinner'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:height="props.size"
			:width="props.size"
		>
			<path
				d="m12 4a1 1 0 0 1 -1-1v-2a1 1 0 0 1 2 0v2a1 1 0 0 1 -1 1zm1 19v-2a1 1 0 0 0 -2 0v2a1 1 0 0 0 2 0zm-9-11a1 1 0 0 0 -1-1h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1zm20 0a1 1 0 0 0 -1-1h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1zm-6.621-7.285 1-1.731a1 1 0 0 0 -1.731-1l-1 1.731a1 1 0 0 0 .365 1.366.987.987 0 0 0 .5.135 1 1 0 0 0 .866-.501zm-10.03 17.3 1-1.731a1 1 0 0 0 -1.731-1l-1 1.731a1 1 0 0 0 .364 1.366.989.989 0 0 0 .5.135 1 1 0 0 0 .867-.498zm-2.27-14.028a1 1 0 0 0 -.364-1.366l-1.731-1a1 1 0 0 0 -1 1.731l1.731 1a1 1 0 0 0 1.366-.365zm17.3 10.031a1 1 0 0 0 -.364-1.367l-1.731-1a1 1 0 0 0 -1 1.731l1.731 1a.987.987 0 0 0 .5.135 1 1 0 0 0 .867-.499zm-14.392-12.939a1 1 0 0 0 .365-1.366l-1-1.731a1 1 0 0 0 -1.731 1l1 1.731a1 1 0 0 0 .866.5.987.987 0 0 0 .5-.134zm10.031 17.3a1 1 0 0 0 .364-1.366l-1-1.731a1 1 0 0 0 -1.731 1l1 1.731a1 1 0 0 0 1.367.364zm2.269-14.03 1.731-1a1 1 0 0 0 -1-1.731l-1.731 1a1 1 0 0 0 1 1.731zm-17.3 10.03 1.731-1a1 1 0 0 0 -1-1.731l-1.731 1a1 1 0 0 0 .5 1.866.987.987 0 0 0 .497-.132z"
			/>
		</svg>
	</span>

	<span v-if="props.name === 'info'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="currentColor"
			:width="props.size"
			:height="props.size"
		>
			<path
				d="M24,12A12,12,0,1,1,12,0,12.013,12.013,0,0,1,24,12ZM14,12a2,2,0,0,0-2-2H10v2h2v7h2ZM12,5a1.5,1.5,0,1,0,1.5,1.5A1.5,1.5,0,0,0,12,5Z"
			/>
		</svg>
	</span>
	<span v-if="props.name === 'download'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			:width="props.size"
			:height="props.size"
			fill="currentColor"
			viewBox="0 0 16 16"
		>
			<path
				d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"
			/>
			<path
				d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"
			/>
		</svg>
	</span>
	<span v-if="props.name === 'reset'" class="icon" :class="props.class">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			:width="props.size"
			:height="props.size"
			fill="currentColor"
		>
			<path
				d="M12,0A11.972,11.972,0,0,0,4,3.073V1A1,1,0,0,0,2,1V4A3,3,0,0,0,5,7H8A1,1,0,0,0,8,5H5a.854.854,0,0,1-.1-.021A9.987,9.987,0,1,1,2,12a1,1,0,0,0-2,0A12,12,0,1,0,12,0Z"
			/>
			<path
				d="M12,6a1,1,0,0,0-1,1v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414L13,11.586V7A1,1,0,0,0,12,6Z"
			/>
		</svg>
	</span>
</template>
