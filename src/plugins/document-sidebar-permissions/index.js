/**
 * Sidebar Permissions: Alternative Example.
 *
 * A version of the /src/plugins/sidebar-permissions, but using
 * a custom panel in the Document sidebar.
 *
 * Usually this would be DRY (https://en.wikipedia.org/wiki/Don%27t_repeat_yourself),
 * however for the purpose of this example we will repeat the code so it is easier
 * to understand and copy.
 */

/**
 * WordPress Imports.
 *
 * RegisterPlugin
 * Registers a plugin for the WordPress block editor (Gutenberg).
 * @see https://developer.wordpress.org/block-editor/packages/packages-plugins/#registerPlugin
 */
import { registerPlugin } from '@wordpress/plugins';

/**
 * Plugin Imports.
 *
 * Note that we are importing the render method of the sidebar from a container.
 * This container allows us to apply Higher-Order Component(s) (HOC) to our component
 * which allow us to inject properties into the component.
 *
 * In this scenario the component is 'wrapped' in components that give access to
 * various select and dispatch methods.
 *
 * The name is imported from the component itself.
 */
import render from './containers/Sidebar';
import { sidebarName as name } from './components/Sidebar';

/**
 * Settings.
 *
 * Note that the icon is a dashicon: https://developer.wordpress.org/resource/dashicons/
 * which drops the `dashicons` prefix when used in this context.
 */
const settings = {
	icon: 'lock',
	render,
};

// Register the Plugin.
registerPlugin( name, settings );
