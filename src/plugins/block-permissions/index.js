/**
 * Block Permissions.
 *
 * A plugin to create a custom sidebar that contains permission options.
 */

/**
 * WordPress Imports.
 *
 * - addFilter
 *   WordPress block editor (Gutenberg) filter hook.
 *   @see https://developer.wordpress.org/block-editor/developers/filters/block-filters/
 */
import { addFilter } from '@wordpress/hooks';

/**
 * Plugin Imports.
 *
 * - attributes
 *   Add additional attributes so that control settings can be saved.
 *
 * - withInspectorAdvancedControls
 *   Example: Add a Higher-Order Component (HOC) to provide additional Inspector
 *   Controls within the 'Advanced' section of the sidebar.
 *
 * - withInspectorControls
 *   Add a Higher-Order Component (HOC) to provide additional Inspector
 *   Controls within a custom section of the sidebar.
 */
import attributes from './settings/attributes';
// import withInspectorAdvancedControls from './containers/withInspectorAdvancedControls';
import withInspectorControls from './containers/withInspectorControls';

/**
 * Attributes.
 *
 * Add extra attributes to a block, so that additional
 * controls are able to save their state.
 *
 * @param object settings The existing block settings.
 */
addFilter(
	'blocks.registerBlockType',
	'wholesome-examples/block-permissions-attributes',
	( settings ) => {
		// Restrict block types.
		// if ( settings.name !== 'core/image' ) {
		// 	return settings;
		// }

		return attributes( settings );
	}
);

/**
 * Inspector Advanced Controls.
 *
 * Inspector Advanced Controls adds additional controls in the block
 * sidebar, under the 'Advanced' section.
 *
 * Note that if we wanted to add multiple higher order components we
 * could do so with `compose`.
 *
 * @param object settings The existing block settings.
 */
addFilter(
	'editor.BlockEdit',
	'wholesome-examples/block-permissions-inspector',
	// withInspectorAdvancedControls
	withInspectorControls
);
