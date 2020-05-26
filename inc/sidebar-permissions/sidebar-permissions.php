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
 * - register_meta_fields - Registers the meta fields.
 *
 * - block_settings - allows us to inject settings so they can be
 *   read by the block editor.
 *
 * - set_header_code - set the header code if the post has login required
 *   and the const is set appropriately.
 *
 * - set_template - set the template if the post has login required
 *   and the const is set appropriately.
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
 * If login is required for a post set the header code.
 *
 * @return void
 */
function set_header_code() : void {
	global $post, $wp_query;

	// If this is not a single post, bail.
	if ( is_admin() || ! is_singular() || ! $post ) {
		return;
	}

	$login_required = get_post_meta( $post->ID, META_LOGIN_REQUIRED, true );

	// If the login is not required, bail.
	if ( ! $login_required ) {
		return;
	}

	/**
	 * Redirect.
	 *
	 * Redirect will always be a 302 in this context, as a 301
	 * would be cached, so we would not be able to visit the page
	 * if the setting was changed.
	 */
	if ( 'Redirect' === ACCESS_TYPE ) {
		wp_safe_redirect( ACCESS_URL, 302 );
		exit;
	}

	/**
	 * 404 Not Found.
	 *
	 * Set the header of the page to 404 Not Found.
	 *
	 * If we are changing the template, we do not want
	 * to set the wp_query 404, as that will load the
	 * 404 template.
	 */
	if ( 404 === ACCESS_CODE ) {
		if ( 'Template' !== ACCESS_TYPE ) {
			$wp_query->set_404();
		}
		status_header( ACCESS_CODE );
	}

	/**
	 * 402 Payment Required.
	 *
	 * The final option is to set the header status to
	 * 402 Payment Required.
	 *
	 * Any other status codes are not supported and a 200
	 * will be returned by default.
	 */
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

	// If this is not a single post, bail.
	if ( is_admin() || ! is_singular() || ! $post ) {
		return $template;
	}

	$login_required = get_post_meta( $post->ID, META_LOGIN_REQUIRED, true );

	// If the login is not required, bail.
	if ( ! $login_required ) {
		return $template;
	}

	$permitted_status_codes    = [ 200, 402, 404 ];
	$has_permitted_status_code = in_array( ACCESS_CODE, $permitted_status_codes, true );

	// If the access type is not Template, or the incorrect status code has been set, bail.
	if ( 'Template' !== ACCESS_TYPE || ! $has_permitted_status_code ) {
		return $template;
	}

	/**
	 * Template File.
	 *
	 * This would usually be within your theme, and contain whatever information or form
	 * you need.
	 *
	 * However in this example it includes a file from the plugin.
	 */
	return ROOT_DIR . '/templates/template.php';
}
