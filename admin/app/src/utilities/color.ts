/**
 *
 * Function that converts rgba, rgb, hex, hsl, hsla to hex.
 *
 * @param {string} color - Color to convert.
 * @return {string} - Converted color.
 * @since 2.0.0
 */
export const convertColorToHex = (color: string): string => {
	// If color is null or undefined, return string.
	if (color === null || color === undefined) {
		return "default";
	}

	// If color is already in hex format.
	if (color.startsWith("#")) {
		return color;
	}

	// If color is in rgb or rgba format.
	if (color.startsWith("rgb")) {
		const [r, g, b, a = 1] = color.match(/\d+/g)!.map(Number); // extract rgb values and alpha if exists
		const hex = ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1); // convert rgb to hex
		const alpha = Math.round(a * 255)
			.toString(16)
			.padStart(2, "0"); // convert alpha to hex
		return `#${hex}${alpha}`;
	}

	// If color is in hsl or hsla format
	if (color.startsWith("hsl")) {
		const [h, s, l, a = 1] = color.match(/\d+(\.\d+)?/g)!.map(Number); // extract hsl values and alpha if exists
		const c = (1 - Math.abs(2 * l - 1)) * s; // chroma
		const x = c * (1 - Math.abs(((h / 60) % 2) - 1)); // second largest component
		const m = l - c / 2; // lightness minus half chroma
		let r, g, b;
		if (h < 60) {
			r = c;
			g = x;
			b = 0;
		} else if (h < 120) {
			r = x;
			g = c;
			b = 0;
		} else if (h < 180) {
			r = 0;
			g = c;
			b = x;
		} else if (h < 240) {
			r = 0;
			g = x;
			b = c;
		} else if (h < 300) {
			r = x;
			g = 0;
			b = c;
		} else {
			r = c;
			g = 0;
			b = x;
		}
		const hex = ((1 << 24) + ((r + m) << 16) + ((g + m) << 8) + (b + m))
			.toString(16)
			.slice(1); // convert rgb to hex
		const alpha = Math.round(a * 255)
			.toString(16)
			.padStart(2, "0"); // convert alpha to hex
		return `#${hex}${alpha}`;
	}

	return color; // Return original color if it's not in any of the supported formats
};
