<?php
/**
 * Sidebar Permissions.
 *
 * Load the PHP methods that support the block editor plugin within
 * /src/plugins/sidebar-permissions.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\Editor\SidebarPermissions; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\PLUGIN_PREFIX;

const META_LOGIN_REQUIRED = PLUGIN_PREFIX . '_login_required';

/**
 * Setup
 *
 * @return void
 */
function setup() : void {
	add_action( 'init', __NAMESPACE__ . '\\register_meta_fields', 999 );
	add_filter( PLUGIN_PREFIX . '_block_settings', __NAMESPACE__ . '\\block_settings' );
}

/**
 * Register Meta Fields.
 *
 * Meta Fields need to be registered to allow access to them via the REST API
 * and subsequently the WordPress block editor.
 *
 * @return void
 */
function register_meta_fields() : void {

	$post_types = get_post_types(
		[
			'public' => true,
		],
		'names'
	);

	// Register meta for all public post types.
	foreach ( $post_types as $post_type ) {
		register_post_meta(
			$post_type,
			META_LOGIN_REQUIRED,
			[
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'boolean',
			]
		);
	}
}

/**
 * Block Settings.
 *
 * Pass the meta key into the block settings so that it can be accessed via
 * the settings import via /src/settings.js.
 *
 * @param array $settings Existing block settings.
 * @return array
 */
function block_settings( $settings ) : array {
	$settings['metaKeyLoginRequired'] = META_LOGIN_REQUIRED;

	return $settings;
}
