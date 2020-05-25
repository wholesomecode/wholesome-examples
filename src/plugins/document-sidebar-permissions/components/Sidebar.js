/**
 * Sidebar Component.
 *
 * The Sidebar Component, some props are inherited from Higher-Order Component(s)
 * HOC. These are contained within their own components folder ../containers.
 *
 * Note that post metadata is used within this component. This is registered via
 * PHP within /inc/sidebar-permissions.
 *
 * This example also contains a link button that will automatically open the
 * permissions sidebar when clicked.
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
 * - Button
 *   Button control.
 *   @see https://developer.wordpress.org/block-editor/components/button/#link-button
 *
 * - ToggleControl
 *   ToggleControl is used to generate a toggle user interface.
 *   @see https://developer.wordpress.org/block-editor/components/toggle-control/
 *
 * - dispatch
 *   Alter the state within the application.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-data/#withDispatch
 *
 * - PluginDocumentSettingPanel
 *   This SlotFill allows registering a UI to edit Document settings.
 *   @see https://developer.wordpress.org/block-editor/developers/slotfills/plugin-document-setting-panel/
 *
 * - Component
 *   A base class to create WordPress Components (Refs, state and lifecycle hooks).
 *   @see https://developer.wordpress.org/block-editor/packages/packages-element/#Component
 *
 * - Fragment
 *   A component which renders its children without any wrapping element.
 *   @see https://developer.wordpress.org/block-editor/packages/packages-element/#Fragment
 *
 * - __
 *   Internationalization - multilingual translation support.
 *   @see https://developer.wordpress.org/block-editor/developers/internationalization/
 */
import { Button, ToggleControl } from '@wordpress/components';
import { dispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { Component, Fragment } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Plugin Imports.
 *
 * - settings
 *   Localized settings from the PHP part of the application.
 *   - Used here to retrieve the meta key for the Login Required
 *      meta field, while at the same time allowing a JS friendly
 *      name.
 *
 * - sidebarPermissionsName
 *   Used to reference the sidebar-permissions sidebar, so that it
 *   can be dynamically opened.
 */
import settings from '../../../settings';
import { sidebarName as sidebarPermissionsName } from '../../sidebar-permissions/components/Sidebar';

// The prefix for our CSS classes.
const baseClassName = 'document-sidebar-permissions';

// The name and title of the plugin, so that it can be registered and if
// needed accessed within a filter.
// Could just set to baseClassName, but keeping full for example.
export const sidebarName = 'document-sidebar-permissions';
export const sidebarTitle = __( 'Permissions', 'wholesome-examples' );

/**
 * Sidebar Permissions.
 *
 * Basic sidebar with one slide toggle that updates a post meta value.
 */
class SidebarPermissions extends Component {
	render() {
		// Props populated via Higher-Order Component.
		const {
			editPost,
			postMeta,
		} = this.props;

		// Retrieve the PHP meta key from the settings, and then access the
		// value from the postMeta object.
		const { metaKeyLoginRequired } = settings;
		const loginRequired = postMeta[ metaKeyLoginRequired ];

		return (
			<Fragment>
				<PluginDocumentSettingPanel
					className={ baseClassName }
					name={ sidebarName }
					title={ sidebarTitle }
				>
					<ToggleControl
						checked={ loginRequired }
						help={ __( 'User must be logged-in in to view this post.', 'wholesome-examples' ) }
						label={ __( 'Require Login', 'wholesome-examples' ) }
						onChange={ ( value ) => {
							// On change use editPost to dispatch the updated
							// postMeta object.
							editPost( {
								...postMeta,
								meta: {
									[ metaKeyLoginRequired ]: value,
								},
							} );
						} }
					/>

					<Button
						isLink
						onClick={ () => {
							/**
							 * It is very simple to open a custom sidebar dynamically with `openGeneralSidebar`.
							 */
							dispatch( 'core/edit-post' )
								.openGeneralSidebar( `${ sidebarPermissionsName }/${ sidebarPermissionsName }` );

							// TODO:
							// - If there were many divs within the toolbar, we would be able to scroll to one of
							//   them using the following command.
							//   document.querySelector( '.editor-page-attributes__template' )
							//       .scrollIntoView( { behavior: 'smooth', block: 'end', inline: 'nearest' } );
							//   Try commenting out the above dispatch to see it working on the document sidebar
							//   (scrolls to template section).
						} }
					>
						{ __( 'Open Permissions Sidebar', 'wholesome-examples' ) }
					</Button>
				</PluginDocumentSettingPanel>
			</Fragment>
		);
	}
}

// Export the Sidebar.
export default SidebarPermissions;

// Typechecking the Component props.
SidebarPermissions.propTypes = {
	editPost: PropTypes.func.isRequired,
	postMeta: PropTypes.func.isRequired,
};
