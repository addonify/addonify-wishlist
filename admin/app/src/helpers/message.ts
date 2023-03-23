import { ElMessage } from "element-plus";
// @ts-ignore
import { textdomain } from "@helpers/global";

/**
 *
 * Get __ funciton from wp.
 */

// @ts-ignore
const { __ } = wp.i18n;

/**
 *
 * Function that fires success/error toast alert messages.
 * This funciton uses element plus ElMessage component.
 *
 * @param {string} type
 * @param {string} message
 * @since 2.0.0
 */

export const dispatchToast = (
	message: string,
	type: string = "success"
): void => {
	/**
	 *
	 * Define default options.
	 */

	const defaults = {
		offset: 50,
	};

	/**
	 *
	 * Check if the type is success or error.
	 */

	if (type === "success") {
		ElMessage.success({
			message: message,
			...defaults,
			duration: 3000,
		});
	} else {
		ElMessage.error({
			message: message,
			...defaults,
			duration: 10000,
		});
	}
};

/**
 *
 * Helper function to handle error while doing a API calls.
 * Fire this function on try block if the response is not 200.
 *
 * @param {Object} error object.
 * @returns {void} void
 * @since 2.0.0
 */

export const unExpectedResponse = (err: any): void => {
	/**
	 *
	 * Handle the error.
	 *
	 */

	let errorMessage = __(
		"Something went wrong, please try again later !!!",
		textdomain
	);

	console.log(err);
	dispatchToast(errorMessage, "error");
};
