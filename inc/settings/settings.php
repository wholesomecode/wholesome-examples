<?php
/**
 * Settings.
 *
 * Settings for the plugin, using Gutenberg Components.
 *
 * Original example taken from Code In WP.
 * @see https://www.codeinwp.com/blog/plugin-options-page-gutenberg/
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\Settings; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\PLUGIN_PREFIX;
use const WholesomeCode\WholesomeExamples\ROOT_DIR;

const SETTING_ANALYTICS           = 'wholesome_examples_settings';
const SETTING_ANALYTICS_KEY       = 'wholesome_examples_analytics_key';
const SETTING_ANALYTICS_STATUS    = 'wholesome_examples_analytics_status';
const SETTING_LOGGED_OUT          = 'wholesome_examples_logged_out';
const SETTING_LOGGED_OUT_TEMPLATE = 'wholesome_examples_logged_out_template';

/**
 * Setup
 *
 * - Register Settings.
 * - Add Settings Page.
 * - Add Page Templates to settings.
 *
 * @return void
 */
function setup() : void {
	add_action( 'init', __NAMESPACE__ . '\\register_settings' );
	add_action( 'admin_menu', __NAMESPACE__ . '\\add_settings_page' );
	add_filter( PLUGIN_PREFIX . '_block_settings', __NAMESPACE__ . '\\block_settings' );

	/**
	 * Classic Settings.
	 *
	 * Provide fallback for classic editor users.
	 */
	require_once ROOT_DIR . '/inc/settings/classic-settings.php';
	ClassicSettings\setup();
}

/**
 * Register Settings.
 *
 * Register the settings so they can be used via the WordPress API.
 *
 * @return void
 */
function register_settings() : void {
	register_setting(
		SETTING_ANALYTICS,
		SETTING_ANALYTICS_KEY,
		array(
			'default'      => '',
			'show_in_rest' => true,
			'type'         => 'string',
		)
	);

	register_setting(
		SETTING_ANALYTICS,
		SETTING_ANALYTICS_STATUS,
		array(
			'default'      => false,
			'show_in_rest' => true,
			'type'         => 'boolean',
		)
	);

	register_setting(
		SETTING_LOGGED_OUT,
		SETTING_LOGGED_OUT_TEMPLATE,
		array(
			'default'      => '',
			'show_in_rest' => true,
			'type'         => 'string',
		)
	);
}

/**
 * Add Settings Page.
 *
 * Add a settings page to the settings menu item.
 *
 * @return void
 */
function add_settings_page() : void {
	$page_hook_suffix = add_options_page(
		__( 'Wholesome Examples Settings', 'wholesome-examples' ),
		__( 'Wholesome Examples Settings', 'wholesome-examples' ),
		'manage_options',
		'wholesome_examples',
		__NAMESPACE__ . '\\render_html'
	);
}

/**
 * Render HTML.
 *
 * Renders the settings page html. In this instance a placeholder for React.
 *
 * @return void
 */
function render_html() : void {
	?>
	<div id="wholesome-examples-settings"></div>
	<?php
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
	$page_templates         = get_page_templates();
	$page_templates_options = [];

	foreach ( $page_templates as $key => $value ) {
		$page_templates_options[] = [
			'label' => $key,
			'value' => $value,
		];
	}

	$settings['pageTemplates'] = $page_templates_options;

	return $settings;
}
