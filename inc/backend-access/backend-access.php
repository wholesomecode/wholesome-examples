<?php
/**
 * Backend Access.
 *
 * Remove the ability to access the backend of the site, or the toolbar
 * for certain users (ie Subscribers).
 *
 * @package wholesomecode/wholesome_examples
 */

 namespace WholesomeCode\WholesomeExamples\BackendAccess; // @codingStandardsIgnoreLine

/**
 * Setup.
 *
 * Run the hooks
 *
 * @return void
 */
function setup() : void {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\remove_admin_bar' );
	add_action( 'admin_init', __NAMESPACE__ . '\\prevent_backend_access' );
}

/**
 * Remove Admin Bar
 *
 * Remove admin bar for anyone except administrators.
 *
 * @return void
 */
function remove_admin_bar() : void {

	// If the user is an administrator, bail.
	if ( current_user_can( 'administrator' ) || is_super_admin() || is_admin() ) {
		return;
	}

	show_admin_bar( false );
}

/**
 * Prevent Backend Access.
 *
 * Prevent backend access for anyone but administrators.
 * Redirect to site root page.
 *
 * @return void
 */
function prevent_backend_access() : void {

	// If the user is an administrator, bail.
	if ( current_user_can( 'administrator' ) || is_super_admin() || ! is_admin() ) {
		return;
	}

	$redirect_url = get_home_url();

	wp_safe_redirect( $redirect_url, 302 );
	exit;
}