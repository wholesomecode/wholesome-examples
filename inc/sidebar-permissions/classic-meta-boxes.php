<?php
/**
 * Classic Meta Boxes.
 *
 * Meta box based fallback for the classic editor.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\SidebarPermissions\ClassicMetaBoxes; // @codingStandardsIgnoreLine

/**
 * Setup
 *
 * - Check for classic editor.
 * - Add meta box fallback.
 *
 * @return void
 */
function setup() : void {

	// If classic editor not installed, bail.
	if ( ! class_exists( 'Classic_Editor' ) ) {
		return;
	}

	wp_die( 'CLASSIC EDITOR INSTALLED' );
}
