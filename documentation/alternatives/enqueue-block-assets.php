<?php
/**
 * Alternative: Enqueue Block Assets
 *
 * Method to enqueue block assets using php `register_block_type`.
 *
 * Method not used because the `register_block_type` method of enqueueing
 * requires a namespace for a single block, therefore assuming that we do
 * not have multiple blocks in the plugin.
 *
 * Original location: /inc/namespace.php.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples; // @codingStandardsIgnoreLine

/**
 * Hook
 *
 * Originally WholesomeCode\WholesomeExamples//setup();
 */
add_action( 'init', __NAMESPACE__ . '\\enqueue_block_assets', 10, 2 );

/**
 * Enqueue Block Assets.
 *
 * - Load dependencies.
 * - Register block editor scripts.
 * - Register block editor styles.
 * - Register block editor scripts.
 * - Enqueue using `register_block_type` with block namespace.
 *
 * @return void
 */
function enqueue_block_assets() : void {

	$block_editor_asset_path = ROOT_DIR . '/build/block-editor.asset.php';

	if ( ! file_exists( $block_editor_asset_path ) ) {
		throw new Error(
			esc_html__( 'You need to run `npm start` or `npm run build` in the root of the plugin "wholesomecode/wholesome-examples" first.', 'wholesome-examples' )
		);
	}

	$block_editor_asset   = include $block_editor_asset_path;
	$block_editor_scripts = 'build/block-editor.js';
	$block_editor_styles  = 'build/block-editor.css';
	$block_styles         = 'build/block-styles.css';

	wp_register_script(
		PLUGIN_SLUG . '-block-editor',
		plugins_url( $block_editor_scripts, ROOT_FILE ),
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);

	wp_register_style(
		PLUGIN_SLUG . '-block-editor',
		plugins_url( $block_editor_styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . '/' . $block_editor_styles )
	);

	wp_register_style(
		PLUGIN_SLUG . '-block-styles',
		plugins_url( $block_styles, ROOT_FILE ),
		[],
		filemtime( ROOT_DIR . '/' . $block_styles )
	);

	register_block_type(
		'wholesomecode/wholesome-examples',
		[
			'editor_script' => PLUGIN_SLUG . '-block-editor',
			'editor_style'  => PLUGIN_SLUG . '-block-editor',
			'style'         => PLUGIN_SLUG . '-block-styles',
		]
	);
}
