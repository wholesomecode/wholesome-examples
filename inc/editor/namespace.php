<?php
/**
 * Editor.
 *
 * Functionality relating to the Gutenberg Editor.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\Editor; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\ROOT_DIR;

/**
 * Setup
 *
 * @return void
 */
function setup() : void {

	/**
	 * Sidebar Permissions.
	 *
	 * Load the PHP methods that support the block editor plugin within
	 * /src/plugins/sidebar-permissions.
	 */
	require_once ROOT_DIR . '/inc/editor/sidebar-permissions/namespace.php';
	SidebarPermissions\setup();
}
