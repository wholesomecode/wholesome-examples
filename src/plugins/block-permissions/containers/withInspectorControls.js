/**
 * Inspector Controls.
 *
 * Inspector Controls adds additional controls in the block
 * sidebar, under a custom section.
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
 * - InspectorControls
 *   Adds inspector controls into a custom section of the block sidebar.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#InspectorControls
 *
 * - PanelBody
 *   The PanelBody creates a collapsible container that can be toggled open or closed.
 *   @see https://developer.wordpress.org/block-editor/components/panel/#panelbody
 *
 * - ToggleControl
 *   ToggleControl is used to generate a toggle user interface.
 *   @see https://developer.wordpress.org/block-editor/components/toggle-control/
 *
 * - createHigherOrderComponent
 *   Returns the enhanced component augmented with a generated displayName.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-compose/#createHigherOrderComponent
 *
 * - Fragment
 *   A component which renders its children without any wrapping element.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-element/#Fragment
 *
 * - __
 *   Internationalization - multilingual translation support.
 *   @see https://developer.wordpress.org/block-editor/developers/internationalization/
 */
import { InspectorControls } from '@wordpress/block-editor';
import { Disabled, PanelBody, ToggleControl } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment }	from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Inspector Controls.
 *
 * Create a Higher-Order Component to add additional Inspector Controls
 * to the block.
 *
 * BlockEdit loads in the original block edit function, so this
 * component essentially wraps the original. Hence it is Higher-Order.
 */
export default createHigherOrderComponent( ( BlockEdit ) => {
	const withInspectorControls = ( props ) => {
		// Extract props.
		const {
			attributes,
			setAttributes,
		} = props;

		// Extract attributes.
		const {
			loginRequired,
			logoutRequired,
		} = attributes;

		// Add the inspector control, and the original component (BlockEdit).
		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ __( 'Permissions', 'wholesome-examples' ) }
						initialOpen={ false }
						icon="lock"
					>
						{
						// Use conditional logic to disable either of the
						// toggles if the other toggle is on.
						// TODO: Make this DRY.
						}
						{ logoutRequired ? (
							<Disabled>
								<ToggleControl
									label={ __( 'Require Login' ) }
									checked={ loginRequired }
									onChange={ ( loginRequired ) => setAttributes( { loginRequired } ) }
									help={ __( 'User must be logged-in in to view this block.', 'wholesome-examples' ) }
								/>
							</Disabled>
						) : (
							<ToggleControl
								label={ __( 'Require Login' ) }
								checked={ loginRequired }
								onChange={ ( loginRequired ) => setAttributes( { loginRequired } ) }
								help={ __( 'User must be logged-in in to view this block.', 'wholesome-examples' ) }
							/>
						) }
						{ loginRequired ? (
							<Disabled>
								<ToggleControl
									label={ __( 'Require Logout' ) }
									checked={ logoutRequired }
									onChange={ ( logoutRequired ) => setAttributes( { logoutRequired } ) }
									help={ __( 'User must be logged-out in to view this block.',
										'wholesome-examples' ) }
								/>
							</Disabled>
						) : (
							<ToggleControl
								label={ __( 'Require Logout' ) }
								checked={ logoutRequired }
								onChange={ ( logoutRequired ) => setAttributes( { logoutRequired } ) }
								help={ __( 'User must be logged-out in to view this block.', 'wholesome-examples' ) }
							/>
						) }
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};

	// Component Typechecking.
	withInspectorControls.propTypes = {
		attributes: PropTypes.shape( {
			loginRequired: PropTypes.bool,
			logoutRequired: PropTypes.bool,
		} ).isRequired,
		setAttributes: PropTypes.func.isRequired,
	};

	// Return the Higher-Order Component.
	return withInspectorControls;
}, 'withInspectorControls' );
