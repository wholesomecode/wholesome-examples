<?php
/**
 * Block Permissions.
 *
 * Load the PHP methods that support the block editor plugin within
 * /src/plugins/block-permissions.
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\BlockPermissions; // @codingStandardsIgnoreLine

/**
 * Setup
 *
 * - Remove blocks on pre-render if a login is required.
 *
 * @return void
 */
function setup() : void {
	add_filter( 'pre_render_block',  __NAMESPACE__ . '\\remove_blocks', 0, 2 );
}

function remove_blocks( $pre_render, $block ) {

	// If we are in the admin interface, bail.
	if ( is_admin() ) {
		return $pre_render;
	}

	// If the user is logged in, bail.
	if ( is_user_logged_in() ) {
		return $pre_render;
	}

	// If the block requires a login, do not render.
	if (
		isset( $block['attrs'] ) &&
		isset( $block['attrs']['loginRequired'] ) &&
		$block['attrs']['loginRequired']
	) {
		return false;
	}

	// Otherwise, render the block.
	return $pre_render;
}
