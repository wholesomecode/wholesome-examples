<?php
/**
 * Sidebar Permissions.
 *
 * Load the PHP methods that support the block editor plugin within
 * /src/plugins/sidebar-permissions.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\SidebarPermissions; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\PLUGIN_PREFIX;
use const WholesomeCode\WholesomeExamples\ROOT_DIR;

// The Meta Key for the Login Required Meta Field.
const META_LOGIN_REQUIRED = PLUGIN_PREFIX . '_login_required';

/**
 * Access.
 *
 * Examples only, these settings would ideally be configured in a settings
 * area of the plugin.
 *
 * Types:
 * - None
 *   Load the post as-is. Can support:
 *   - 200 - Status OK.
 *   - 402 - Payment Required.
 *   - 404 - Page Not Found.
 *
 * - Redirect
 *   Redirect the post, supports 302 only. 301 not appropriate for paywall.
 *
 * - Template
 *   Load an alternative Template. Can support:
 *   - 200 - Status OK.
 *   - 402 - Payment Required.
 *   - 404 - Page Not Found.
 */
const ACCESS_TYPE = 'Template';
const ACCESS_CODE = 402;
const ACCESS_URL  = 'https://wholesome-examples.test/'; // Example only, homepage of test site.

/**
 * Setup
 *
 * @return void
 */
function setup() : void {
	add_action( 'init', __NAMESPACE__ . '\\register_meta_fields', 999 );
	add_filter( PLUGIN_PREFIX . '_block_settings', __NAMESPACE__ . '\\block_settings' );
	add_action( 'wp', __NAMESPACE__ . '\\set_header_code' );
	add_filter( 'template_include', __NAMESPACE__ . '\\set_template' );
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

/**
 * Set Header Code.
 *
 * @return void
 */
function set_header_code() : void {
	global $post, $wp_query;

	if ( is_admin() || ! is_singular() || ! $post ) {
		return;
	}

	$login_required = get_post_meta( $post->ID, META_LOGIN_REQUIRED, true );

	if ( ! $login_required ) {
		return;
	}

	if ( 'Redirect' === ACCESS_TYPE ) {
		// Do a redirect.
		wp_safe_redirect( ACCESS_URL, 302 ); // Hardcoded status code.
		exit;
	}

	if ( 404 === ACCESS_CODE ) {
		// Do a 404.
		if ( 'Template' !== ACCESS_TYPE ) {
			$wp_query->set_404();
		}
		status_header( ACCESS_CODE );
	}

	if ( 402 === ACCESS_CODE ) {
		status_header( ACCESS_CODE );
	}
}

/**
 * Set Template.
 *
 * @param [type] $template
 * @return void
 */
function set_template( $template ) {
	global $post;

	if ( is_admin() || ! is_singular() || ! $post ) {
		return $template;
	}

	$login_required = get_post_meta( $post->ID, META_LOGIN_REQUIRED, true );

	if ( ! $login_required ) {
		return $template;
	}

	$permitted_status_codes    = [ 200, 402, 404 ];
	$has_permitted_status_code = in_array( ACCESS_CODE, $permitted_status_codes, true );

	if ( 'Template' !== ACCESS_TYPE || ! $has_permitted_status_code ) {
		return $template;
	}

	return ROOT_DIR . '/templates/template.php';
}
