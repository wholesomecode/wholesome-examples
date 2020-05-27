/**
 * Attributes.
 *
 * Add extra attributes to a block, so that additional
 * controls are able to save their state.
 *
 * @param object settings The existing block settings.
 */
export default ( settings ) => {
	const { attributes } = settings;
	return {
		...settings,
		attributes: {
			...attributes,
			loginRequired: {
				default: false,
				type: 'boolean',
			},
			logoutRequired: {
				default: false,
				type: 'boolean',
			},
		},
	};
};
