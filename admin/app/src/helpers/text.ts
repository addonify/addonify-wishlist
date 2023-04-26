/**
 *
 * Function that trims the text to a certain number of characters.
 *
 * @param {string} text
 * @since 2.0.0
 */

export const trimText = (text: string, length: number = 30): string => {
	/**
	 *
	 * If the text is longer than the length, trim it and add an ellipsis.
	 */

	return text.length > length
		? (text = text.substring(0, length) + "...")
		: text;
};
