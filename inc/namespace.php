<?php
/**
 * Media tools main plugin file.
 *
 * @package media-tools
 */

namespace WholesomeCode\WholesomeExamples; // @codingStandardsIgnoreLine

/**
 * Functions and Consts always need to be prefixed with their namespace.
 *
 * @see https://engineering.hmn.md/standards/style/php/#namespace-and-class-naming
 */

function setup() : void {

	// Load Text Domain.
	load_plugin_textdomain( 'wholesome-examples', false, ROOT_DIR . '\languages' );

	// Load Assets.
	load_assets();

	// /**
	//  * Setup Block Categories
	//  *
	//  * If you would like an additional category for your block (in addition to common,
	//  * layout, widget etc... ). This is the hook to set it.
	//  */
	// add_action( 'block_categories', array( $this, 'block_categories' ), 10, 2 );
}

/**
 * Load Assets.
 *
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function load_assets() {

	// block.scss
	// block-editor.scss
	// block-editor.js
	// plugin.scss
	// plugin.js
	// plugin-admin.scss
	// plugin-admin.js
	// plugin-classic-editor.scss
	// plugin-customizer.scss
	// plugin-customizer.js

	// Load Block Front and Back End Assets (can use a conditional to restrict load).
	add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\load_block_assets', 10 );

	// Load Block Editor Assets.
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\load_editor_assets', 10 );

	// Load Front End Assets.
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\load_front_end_assets', 10 );

	// Load WordPress Global Admin Assets.
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\load_back_end_assets', 10 );

	// Load Customizer Assets.
	add_action( 'customize_preview_init', __NAMESPACE__ . '\\load_customizer_assets', 10 );

	// Classic Editor Styles.
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\load_classic_editor_assets', 10 );

	// $dir = ROOT_DIR;

	// $script_asset_path = "$dir/build/index.asset.php";
	// if ( ! file_exists( $script_asset_path ) ) {
	// 	throw new Error(
	// 		'You need to run `npm start` or `npm run build` for the "wholesomecode/wholesome-examples" block first.'
	// 	);
	// }
	// $index_js     = 'build/index.js';
	// $script_asset = require( $script_asset_path );

	// wp_register_script(
	// 	'wholesomecode-wholesome-examples-block-editor',
	// 	plugins_url( $index_js, ROOT_FILE ),
	// 	$script_asset['dependencies'],
	// 	$script_asset['version']
	// );

	// $editor_css = 'editor.css';
	// wp_register_style(
	// 	'wholesomecode-wholesome-examples-block-editor',
	// 	plugins_url( $editor_css, ROOT_FILE ),
	// 	[],
	// 	filemtime( "$dir/$editor_css" )
	// );

	// $style_css = 'style.css';
	// wp_register_style(
	// 	'wholesomecode-wholesome-examples-block',
	// 	plugins_url( $style_css, ROOT_FILE ),
	// 	[],
	// 	filemtime( "$dir/$style_css" )
	// );

	register_block_type(
		'wholesomecode/wholesome-examples',
		[
			'editor_script' => 'wholesomecode-wholesome-examples-block-editor',
			'editor_style'  => 'wholesomecode-wholesome-examples-block-editor',
			'style'         => 'wholesomecode-wholesome-examples-block',
		]
	);
}

/**
 * Block Assets.
 *
 * Assets that load on on the Gutenberg 'Save' and Admin view. If you want
 * certain assets to only load on the front end, wrap them in a `is_admin` conditional.
 *
 * @since 1.0.0
 */
function load_block_assets() {

	$styles = '/style.css';

	// Enqueue Styles.
	wp_enqueue_style(
		'plugin-name-block',
		plugins_url( $styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . $styles )
	);
}

/**
 * Block Editor Assets.
 *
 * Assets that load on on the Gutenberg 'Edit' interface. Use the styles to
 * add styles that only impact the 'edit' view.
 *
 * The `editor.js` file is the combined React for your Gutenberg Block
 *
 * @since 1.0.0
 */
function load_editor_assets() {

	$scripts = '/build/index.js';
	$styles  = '/editor.css';

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

/**
 * Front end Assets.
 *
 * Assets that load on on the Front End of WordPress.
 *
 * @since 1.0.0
 */
function load_front_end_assets() {

	$scripts = '/test/fe.js';
	$styles  = '/test/fe.css';

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

/**
 * Enqueue Admin Styles.
 *
 * Assets to alter the editor (IE InspectorControls), does not impact front end block styles.
 *
 * @since 1.0.0
 */
function load_back_end_assets() {

	$styles  = '/test/be.css';
	$scripts = '/test/be.js';

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

/**
 * Customizer Assets.
 *
 * Assets that load on on the Customizer.
 *
 * @since 1.0.0
 */
function load_customizer_assets() {

	$styles  = '/test/c.css';
	$scripts = '/test/c.js';

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

/**
 * Classic Edtior Assets.
 *
 * CSS that loads in the classic editor only.
 *
 * @since 1.0.0
 */
function load_classic_editor_assets() {

	$styles = '/test/ce.css';

	add_editor_style(
		plugins_url( $styles, ROOT_FILE ) .
		'?v=' . filemtime( ROOT_DIR . $styles )
	);
}
