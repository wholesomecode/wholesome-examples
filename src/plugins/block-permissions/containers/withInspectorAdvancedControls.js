/**
 * Inspector Advanced Controls.
 *
 * Inspector Advanced Controls adds additional controls in the block
 * sidebar, under the 'Advanced' section.
 */

/**
 * React Imports.
 *
 * - PropTypes
 *   Typechecking for React components.
 *   @see https://reactjs.org/docs/typechecking-with-proptypes.html
 */
import PropTypes from 'prop-types';

/**
 * WordPress Imports.
 *
 * - ToggleControl
 *   ToggleControl is used to generate a toggle user interface.
 *   @see https://developer.wordpress.org/block-editor/components/toggle-control/
 *
 * - createHigherOrderComponent
 *   Returns the enhanced component augmented with a generated displayName.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-compose/#createHigherOrderComponent
 *
 * - InspectorAdvancedControls
 *   Adds inspector controls into the 'advanced' section of the block sidebar.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#InspectorAdvancedControls
 *
 * - Fragment
 *   A component which renders its children without any wrapping element.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-element/#Fragment
 *
 * - __
 *   Internationalization - multilingual translation support.
 *   @see https://developer.wordpress.org/block-editor/developers/internationalization/
 */
import { ToggleControl } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorAdvancedControls } from '@wordpress/editor';
import { Fragment }	from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Inspector Advanced Controls.
 *
 * Create a Higher-Order Component to add additional Inspector Controls
 * (Advanced in this instance) to the block.
 *
 * BlockEdit loads in the original block edit function, so this
 * component essentially wraps the original. Hence it is Higher-Order.
 */
export default createHigherOrderComponent( ( BlockEdit ) => {
	const withInspectorAdvancedControls = ( props ) => {
		// Extract props.
		const {
			attributes,
			setAttributes,
		} = props;

		// Extract attributes.
		const {
			loginRequired,
		} = attributes;

		// Add the inspector control, and the original component (BlockEdit).
		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorAdvancedControls>
					<ToggleControl
						label={ __( 'Require Login' ) }
						checked={ loginRequired }
						onChange={ ( loginRequired ) => setAttributes( { loginRequired } ) }
						help={ __( 'User must be logged-in in to view this block.', 'wholesome-examples' ) }
					/>
				</InspectorAdvancedControls>
			</Fragment>
		);
	};

	// Component Typechecking.
	withInspectorAdvancedControls.propTypes = {
		attributes: PropTypes.shape( {
			loginRequired: PropTypes.bool,
		} ).isRequired,
		setAttributes: PropTypes.func.isRequired,
	};

	// Return the Higher-Order Component.
	return withInspectorAdvancedControls;
}, 'withInspectorAdvancedControls' );
