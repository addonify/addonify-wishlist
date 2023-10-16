/**
 *
 * Return date and time in the format of: 2021-01-01-13:05:49
 *
 * @param {null} null
 * @return {string} date and time
 * @since 2.0.3
 */
const generateDateTime = (): string => {
	let date = new Date();
	let y = date.getFullYear();
	let m = date.getMonth() + 1; // 0-11
	let d = date.getDate();
	let h = date.getHours();
	let min = date.getMinutes();
	let s = date.getSeconds();

	return y + "-" + m + "-" + d + "-" + h + ":" + min + ":" + s;
};

export const getCurrentDateTime = generateDateTime();

/**
 *
 * First letter transform to uppercase.
 *
 * @param {string} string
 * @return {string} string.
 * @since 2.0.6
 */
export const ucFirst = (string: string): string =>
	string.charAt(0).toUpperCase() + string.slice(1);
