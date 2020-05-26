<?php
/**
 * Classic Meta Boxes.
 *
 * Meta box based fallback for the classic editor.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\SidebarPermissions\ClassicMetaBoxes; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\PLUGIN_PREFIX;
use const WholesomeCode\WholesomeExamples\SidebarPermissions\META_KEY_LOGIN_REQUIRED;

const META_BOX_LOGIN_REQUIRED     = PLUGIN_PREFIX . '_meta_box_login_required';
const NONCE_LOGIN_REQUIRED        = 'nonce_login_required';
const NONCE_ACTION_LOGIN_REQUIRED = 'nonce_action_login_required';

/**
 * Setup
 *
 * - Check for classic editor.
 * - Add meta box fallback.
 * - Save meta data.
 *
 * @return void
 */
function setup() : void {

	// If classic editor not installed, bail.
	if ( ! class_exists( 'Classic_Editor' ) ) {
		return;
	}

	add_action( 'add_meta_boxes', __NAMESPACE__ . '\\register_meta_boxes' );
	add_action( 'save_post', __NAMESPACE__ . '\\meta_box_login_required_save' );
}

function register_meta_boxes() : void {

	$post_types = get_post_types(
		[
			'public' => true,
		],
		'names'
	);

	// Register meta box for all public post types.
	foreach ( $post_types as $post_type ) {
		add_meta_box(
			META_BOX_LOGIN_REQUIRED,
			__( 'Permissions', 'wholesome-examples' ),
			__NAMESPACE__ . '\\meta_box_login_required_html',
			$post_type
		);
	}
}

/**
 * Meta Box Login Required HTML.
 *
 * Render the HTML for the meta box, along with populating default values.
 *
 * @return void
 */
function meta_box_login_required_html() : void {
	global $post;

	// Get the meta data.
	$login_required = get_post_meta( $post->ID, META_KEY_LOGIN_REQUIRED, true );
	?>
	<p>
		<label for="<?php echo esc_attr( META_KEY_LOGIN_REQUIRED ); ?>">
			<input
				id="<?php echo esc_attr( META_KEY_LOGIN_REQUIRED ); ?>"
				name="<?php echo esc_attr( META_KEY_LOGIN_REQUIRED ); ?>"
				type="checkbox"
				value="on"
				<?php checked( $login_required ); // Value is a bool, so no need for a comparison. ?>
			>
			<?php esc_html_e( 'Require Login', 'wholesome-examples' ); ?>
		</label>
	</p>
	<p class="howto"><?php esc_html_e( 'User must be logged-in in to view this post.', 'wholesome-examples' ); ?></p>
	<?php
	// NONCE for security.
	wp_nonce_field( NONCE_ACTION_LOGIN_REQUIRED, NONCE_LOGIN_REQUIRED );
}

/**
 * Meta Box Login Required Save.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function meta_box_login_required_save( $post_id ) : void {

	// If doing autosave, bail.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// If doing nonce not correct, bail.
	if (
		! isset( $_POST[ NONCE_LOGIN_REQUIRED ] ) ||
		! wp_verify_nonce( $_POST[ NONCE_LOGIN_REQUIRED ], NONCE_ACTION_LOGIN_REQUIRED )
	) {
		return;
	}

	// If user cannot edit the post, bail.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// If the key exists, then the checkbox was checked
	if ( isset( $_POST[ META_KEY_LOGIN_REQUIRED ] ) ) {
		update_post_meta( $post_id, META_KEY_LOGIN_REQUIRED, true );
	} else {
		// Box was unchecked.
		update_post_meta( $post_id, META_KEY_LOGIN_REQUIRED, false );
	}
}
