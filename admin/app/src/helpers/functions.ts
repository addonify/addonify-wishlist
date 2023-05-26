/**
 *
 * Return date and time in the format of: 2021-01-01-13:05:49
 *
 * @return {string} date and time
 * @since 2.0.3
 */

const generateDateTime = (): string => {
	let date = new Date();

	let year = date.getFullYear();
	let month = date.getMonth() + 1; // 0-11
	let day = date.getDate();
	let hour = date.getHours();
	let minute = date.getMinutes();
	let second = date.getSeconds();

	return `${year}-${month}-${day}-${hour}:${minute}:${second}`;
};

export const getCurrentDateTime = generateDateTime();
