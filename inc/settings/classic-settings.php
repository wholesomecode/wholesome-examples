<?php
/**
 * Classic Settings.
 *
 * Provide fallback for classic editor users.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\Settings\ClassicSettings; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\PLUGIN_PREFIX;
use const WholesomeCode\WholesomeExamples\Settings\SETTING_ANALYTICS;
use const WholesomeCode\WholesomeExamples\Settings\SETTING_ANALYTICS_KEY;
use const WholesomeCode\WholesomeExamples\Settings\SETTING_ANALYTICS_STATUS;
use const WholesomeCode\WholesomeExamples\Settings\SETTING_LOGGED_OUT;
use const WholesomeCode\WholesomeExamples\Settings\SETTING_LOGGED_OUT_TEMPLATE;

const SETTING_ANALYTICS_SECTION  = 'wholesome_examples_settings_section';
const SETTING_LOGGED_OUT_SECTION = 'wholesome_examples_logged_out_section';

/**
 * Setup
 *
 * - Register settings fields.
 * - Remove Settings React Render.
 * - Implement WP Settings API Render.
 *
 * @return void
 */
function setup() : void {

	// If classic editor not installed, bail.
	if ( ! class_exists( 'Classic_Editor' ) ) {
		return;
	}

	add_action( 'admin_init', __NAMESPACE__ . '\\register_setting_fields' );
	remove_action( 'admin_menu', 'WholesomeCode\WholesomeExamples\Settings\\add_settings_page' );
	add_action( 'admin_menu', __NAMESPACE__ . '\\add_settings_page' );
}

/**
 * Register Settings Fields.
 *
 * The fields are already registered in the namespace WholesomeCode\WholesomeExamples\Settings,
 * this outputs their html using the WP Settings API.
 *
 * @return void
 */
function register_setting_fields() : void {

	// Add Section.
	add_settings_section(
		SETTING_LOGGED_OUT_SECTION,
		__( 'Template Settings', 'wholesome-examples' ),
		function() {
			?>
			<p>
				<?php esc_html_e( 'Template Settings.', 'wholesome-examples' ); ?>
			</p>
			<?php
		},
		SETTING_LOGGED_OUT
	);

	// Add field.
	add_settings_field(
		SETTING_LOGGED_OUT_TEMPLATE,
		__( 'Template', 'wholesome-examples' ),
		function() {
			$value    = get_option( SETTING_LOGGED_OUT_TEMPLATE, '' );
			$settings = apply_filters( PLUGIN_PREFIX . '_block_settings', [] );
			?>
			<select
				class="regular-text"
				name="<?php echo esc_attr( SETTING_LOGGED_OUT_TEMPLATE ); ?>"
			>
				<option
					<?php selected( $value, '' ); ?>
					value=""
				>
					<?php esc_html_e( 'Please Select...', 'wholesome-examples' ); ?>
				</option>
				<?php
				foreach ( $settings['pageTemplates'] as $page_template ) {
					?>
					<option
						<?php selected( $value, $page_template['value'] ); ?>
						value="<?php echo esc_attr( $page_template['value'] ); ?>"
					>
						<?php echo esc_attr( $page_template['label'] ); ?>
					</option>
					<?php
				}
				?>
			</select>
			<p class="description">
				<?php esc_html_e( 'Choose the template you wish to display instead of a membership post if a user is not logged in.', 'wholesome-examples' ); ?>
			</p>
			<?php
		},
		SETTING_LOGGED_OUT,
		SETTING_LOGGED_OUT_SECTION
	);

	// Add Section.
	add_settings_section(
		SETTING_ANALYTICS_SECTION,
		__( 'Google Analytics Settings', 'wholesome-examples' ),
		function() {
			?>
			<p>
				<?php esc_html_e( 'Google Analytics Settings.', 'wholesome-examples' ); ?>
			</p>
			<?php
		},
		SETTING_ANALYTICS
	);

	// Add field.
	add_settings_field(
		SETTING_ANALYTICS_KEY,
		__( 'Google Analytics Key', 'wholesome-examples' ),
		function() {
			$value = get_option( SETTING_ANALYTICS_KEY, '' );
			?>
			<input
				class="regular-text"
				name="<?php echo esc_attr( SETTING_ANALYTICS_KEY ); ?>"
				type="text"
				value="<?php echo esc_attr( $value ); ?>"
			/>
			<p class="description">
				<?php esc_html_e( 'In order to use Google Analytics, you need to use an API key.', 'wholesome-examples' ); ?>
			</p>
			<?php
		},
		SETTING_ANALYTICS,
		SETTING_ANALYTICS_SECTION
	);

	// Add field.
	add_settings_field(
		SETTING_ANALYTICS_STATUS,
		__( 'Track Admin Users?', 'wholesome-examples' ),
		function() {
			$value = get_option( SETTING_ANALYTICS_STATUS, '' );
			?>
			<fieldset>
				<legend class="screen-reader-text">
					<span><?php esc_html_e( 'Track Admin Users?', 'wholesome-examples' ); ?></span>
				</legend>
				<label for="blog_public">
					<input
						<?php checked( $value ); ?>
						id="<?php echo esc_attr( SETTING_ANALYTICS_STATUS ); ?>"
						name="<?php echo esc_attr( SETTING_ANALYTICS_STATUS ); ?>"
						type="checkbox"
						value="1"
					>
						<?php esc_html_e( 'Track Admin Users?', 'wholesome-examples' ); ?>
					</label>
					<p class="description">
						<?php esc_html_e( 'Would you like to track views of logged-in admin accounts?', 'wholesome-examples' ); ?>
					</p>
			</fieldset>
			<?php
		},
		SETTING_ANALYTICS,
		SETTING_ANALYTICS_SECTION
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
 * Renders the settings page html. In this instance the WP Settings API fields.
 *
 * @return void
 */
function render_html() : void {
	?>
	<div class="wrap">
		<h2>
			<?php esc_html_e( 'Wholesome Examples Settings', 'wholesome-examples' ); ?>
		</h2>

		<form action="options.php" method="POST">
			<?php settings_fields( SETTING_LOGGED_OUT ); ?>
			<?php do_settings_sections( SETTING_LOGGED_OUT ); ?>
			<?php submit_button(); ?>
		</form>

		<form action="options.php" method="POST">
			<?php settings_fields( SETTING_ANALYTICS ); ?>
			<?php do_settings_sections( SETTING_ANALYTICS ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
