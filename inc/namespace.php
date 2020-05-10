<?php
/**
 * Main plugin file.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples; // @codingStandardsIgnoreLine

/**
 * TODO:
 *
 * - Finish inline comments
 * - Ensure correct PREFIX, ASSETS, ETC...
 */

/**
 * Setup
 *
 * - Load text domain.
 * - Enqueue assets.
 * - Create custom block category.
 *
 * @return void
 */
function setup() : void {

	// Load text domain.
	load_plugin_textdomain( 'wholesome-examples', false, ROOT_DIR . '\languages' );

	/**
	 * Enqueue Assets
	 *
	 * Block assets enqueued with `enqueue_block_assets` and
	 * `enqueue_block_editor_assets`, allowing multiple blocks within the project.
	 *
	 * For the alternate `register_block_type` method (enqueing assets for a singular
	 * block) see /documentation/alternatives/enqueue-block-assets.php
	 */
	enqueue_assets();

	// /**
	//  * Setup Block Categories
	//  *
	//  * If you would like an additional category for your block (in addition to common,
	//  * layout, widget etc... ). This is the hook to set it.
	//  */
	// add_action( 'block_categories', array( $this, 'block_categories' ), 10, 2 );
}

/**
 * Enqueue Assets.
 */
function enqueue_assets() {

	// Load Block Front and Back End Assets (can use a conditional to restrict load).
	add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\enqueue_block_styles', 10 );

	// Load Block Editor Assets.
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets', 10 );

	// Load Front End Assets.
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_plugin_assets', 10 );

	// Load WordPress Global Admin Assets.
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_assets', 10 );

	// Load Customizer Assets.
	add_action( 'customize_preview_init', __NAMESPACE__ . '\\enqueue_customizer_assets', 10 );

	// Classic Editor Styles.
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_classic_editor_styles', 10 );
}

function enqueue_block_styles() {

	$styles = '/build/block-style.css';

	// Enqueue Styles.
	wp_enqueue_style(
		'plugin-name-block',
		plugins_url( $styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $styles )
	);
}

function enqueue_block_editor_assets() {

	$scripts = '/build/block-editor.js';
	$styles  = '/build/block-editor.css';

	// Enqueue editor JS.
	wp_enqueue_script(
		'plugin-name-block-editor',
		plugins_url( $scripts, ROOT_FILE ),
		[ 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-polyfill' ],
		filemtime( ROOT_DIR . $scripts ),
		true
	);

	// Enqueue edtior Styles.
	wp_enqueue_style(
		'plugin-name-block-editor',
		plugins_url( $styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $styles )
	);
}

function enqueue_plugin_assets() {

	$scripts = '/build/scripts.js';
	$styles  = '/build/styles.css';

	// // Example: JavaScript will run on the Front End only.
	// if ( ! is_admin() ) {
		// Enqueue JS.
		wp_enqueue_script(
			'plugin-name',
			plugins_url( $scripts, ROOT_FILE ),
			[], //$this->dependencies,
			filemtime( ROOT_DIR . $scripts ),
			true
		);
	// }

	// Enqueue Styles.
	wp_enqueue_style(
		'plugin-name',
		plugins_url( $styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $styles )
	);
}

function enqueue_admin_assets() {

	$styles  = '/build/admin.css';
	$scripts = '/build/admin.js';

	// Enqueue Styles.
	wp_enqueue_style(
		'plugin-name-admin',
		plugins_url( $styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $styles ),
	);

	// Enqueue edtior JS.
	wp_enqueue_script(
		'plugin-name-admin',
		plugins_url( $scripts, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $scripts ),
		true
	);
}

function enqueue_customizer_assets() {

	$styles  = '/build/customizer.css';
	$scripts = '/build/customizer.js';

	// Enqueue Styles.
	wp_enqueue_style(
		'plugin-name-customizer',
		plugins_url( $styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $styles ),
	);

	// Enqueue edtior JS.
	wp_enqueue_script(
		'plugin-name-customizer',
		plugins_url( $scripts, ROOT_FILE ),
		[], //$this->dependencies,
		filemtime( ROOT_DIR . $scripts ),
		true
	);
}

function enqueue_classic_editor_styles() {

	$styles = '/build/classic-editor.css';

	add_editor_style(
		plugins_url( $styles, ROOT_FILE ) .
		'?v=' . filemtime( ROOT_DIR . $styles )
	);
}
