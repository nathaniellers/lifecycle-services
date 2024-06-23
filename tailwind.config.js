const plugin = require('tailwindcss/plugin');

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./*.{php,html,js}",
		"./*/*/*/*.{php,html,js}"
	],
	theme: {
		extend: {},
	},
	plugins: [
		plugin(function ({
			addVariant
		}) {
			addVariant('current', '&.active');
		})
	],
}