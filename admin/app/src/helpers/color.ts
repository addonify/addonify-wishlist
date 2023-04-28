/**
 *
 * Convert rgba to hex.
 *
 * @param {string} color
 * @return {string} hex
 */

export const rgbaToHex = (color: string): string => {
	/**
	 *
	 * If 'color' is not hex and not rgba, return it immediately.
	 */

	if (typeof color === null || typeof color === "object") {
		return "NaN";
	}

	if (color.substring(0, 1) !== "#" && color.substring(0, 4) !== "rgba") {
		return "NaN";
	}

	if (color.substring(0, 1) === "#") {
		return color;
	}

	let rgba = color
			.substring(color.indexOf("(") + 1, color.lastIndexOf(")"))
			.split(","),
		r = parseInt(rgba[0], 10),
		g = parseInt(rgba[1], 10),
		b = parseInt(rgba[2], 10),
		a = parseFloat(rgba[3]) || 1;

	let hex = ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);

	if (a === 1) {
		return "#" + hex;
	} else {
		let alphaHex = Math.round(a * 255).toString(16);
		if (alphaHex.length === 1) {
			alphaHex = "0" + alphaHex;
		}
		return "#" + hex + alphaHex;
	}
};
