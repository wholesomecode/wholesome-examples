<?php
/**
 * Woo Additional Product Fields.
 *
 * Example additional product fields for WooCommerce.
 * Examples based on https://pluginrepublic.com/add-custom-cart-item-data-in-woocommerce/
 *
 * TODO:
 * - Ensure that when payment is complete the order status is changed to complete.
 * - Implement code to rollback subscribers that have a cancelled or failed order.
 * - Add subscribe date meta data to users to tie them to subscriptions.
 * - Add order number meta data to users to tie them to order if cancelled or failed.
 * - What happens if a user already has an account?
 * - Send welcome emails when user added to a site.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\WooProductFields; // @codingStandardsIgnoreLine

const CART_KEY_EMAIL_ADDRESS = 'user_email_address';
const CART_KEY_SITE          = 'user_site';
const META_KEY_EMAIL_ADDRESS = 'user-email-address';
const META_KEY_SITE          = 'user-site';

/**
 * Setup.
 *
 * Run the hooks.
 *
 * - Remove the quantity field from the project.
 * - Add additional product fields.
 * - Validation for those product fields.
 * - Add product field information to the cart.
 * - Render product field information on the cart.
 * - Add custom meta to the order.
 * - Action on payment complete.
 *
 * @return void
 */
function setup() : void {
	// If WooCommerce is not installed, bail.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// If this is not WordPress Multisite, bail.
	if ( ! is_multisite() ) {
		return;
	}

	// Remove the quantity field.
	add_filter( 'woocommerce_is_sold_individually', __NAMESPACE__ . '\\remove_quantity', 10, 2 );

	// Add a custom text input field to the product page.
	add_action( 'woocommerce_before_add_to_cart_button', __NAMESPACE__ . '\\add_product_fields' );

	// Validate our custom text input field value.
	add_filter( 'woocommerce_add_to_cart_validation', __NAMESPACE__ . '\\validate_product_fields', 10, 4 );

	// Add custom cart item data.
	add_filter( 'woocommerce_add_cart_item_data', __NAMESPACE__ . '\\add_cart_item_data', 10, 3 );

	// Display custom item data in the cart.
	add_filter( 'woocommerce_get_item_data', __NAMESPACE__ . '\\render_cart_item_data', 10, 2 );

	// Add custom meta to order.
	add_action( 'woocommerce_checkout_create_order_line_item', __NAMESPACE__ . '\\add_product_data_to_order', 10, 4 );

	// On payment, process the order and create the users.
	add_action( 'woocommerce_order_status_completed', __NAMESPACE__ . '\\on_order_complete', 10, 1 );

}

/**
 * Do product fields.
 *
 * Check that we are applying the fields to the correct product.
 * This helps us keep the code DRY.
 *
 * @param int $product_id The product ID.
 * @return boolean
 */
function do_product_fields( $product_id ) : bool {

	/**
	 * Example only.
	 *
	 * Usually we would check for a setting or meta.
	 */
	if ( 66 === (int) $product_id ) {
		return true;
	}

	return false;
}

/**
 * Remove Quantity Field.
 *
 * Remove the quantity field of an object.
 *
 * @param bool $return Remove the quantity field.
 * @param object $product The product object.
 * @return boolean
 */
function remove_quantity( $return, $product ) : bool {

	if ( ! do_product_fields( $product->get_id() ) ) {
		return false;
	}

	return true;
}

/**
 * Add Product Fields.
 *
 * Add additional fields to a product on the front end.
 *
 * @return void
 */
function add_product_fields() : void {
	global $post;

	if ( ! do_product_fields( $post->ID ) ) {
		return;
	}

	$sites = get_sites();

	?>
	<div class="<?php echo esc_attr( META_KEY_EMAIL_ADDRESS ); ?>-wrap">
		<label for="<?php echo esc_attr( META_KEY_EMAIL_ADDRESS ); ?>">
			<?php esc_html_e( 'Email Address', 'wholesome-examples' ); ?>
		</label>
		<input type="text" name='<?php echo esc_attr( META_KEY_EMAIL_ADDRESS ); ?>' id='<?php echo esc_attr( META_KEY_EMAIL_ADDRESS ); ?>' value='' class="large-text">
	</div>
	<div class="<?php echo esc_attr( META_KEY_SITE ); ?>-wrap">
		<label for="<?php echo esc_attr( META_KEY_SITE ); ?>">
			<?php esc_html_e( 'Site', 'wholesome-examples' ); ?>
		</label>
		<select name='<?php echo esc_attr( META_KEY_SITE ); ?>' id='<?php echo esc_attr( META_KEY_SITE ); ?>' class="large-text">
			<?php
			foreach ( $sites as $site ) {
				$details = get_blog_details( $site->blog_id );
				$value   = $details->blogname;
				?>
				<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $value ); ?></option>
				<?php
			}
			?>
		</select>
	</div>
	<?php
}

/**
 * Validate Product Fields.
 *
 * @param bool $passed If validation has passed.
 * @param int $product_id The product ID.
 * @param int $quantity The amount ordered.
 * @param int $variation_id Variation ID.
 * @return boolean
 */
function validate_product_fields( $passed, $product_id, $quantity, $variation_id = null ) : bool {

	if ( ! do_product_fields( $product_id ) ) {
		return $passed;
	}

	$email_address = sanitize_email( $_POST[ META_KEY_EMAIL_ADDRESS ] ); // @codingStandardsIgnoreLine
	$site          = sanitize_text_field( $_POST[ META_KEY_SITE ] );    // @codingStandardsIgnoreLine

	if ( empty( $email_address ) ) {
		$passed = false;
		wc_add_notice( esc_html__( 'Email Address is a required field.', 'wholesome-examples' ), 'error' );
	}

	if ( ! is_email( $email_address ) ) {
		$passed = false;
		wc_add_notice( esc_html__( 'Email Address is not valid.', 'wholesome-examples' ), 'error' );
	}

	if ( empty( $site ) ) {
		$passed = false;
		wc_add_notice( esc_html__( 'Site is a required field.', 'wholesome-examples' ), 'error' );
	}

	return $passed;
}

/**
 * Add Cart Item Data.
 *
 * @param array $cart_item_data Cart Item data.
 * @param int $product_id The product ID.
 * @param int $variation_id The variation ID.
 * @return array
 */
function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) : array {

	if ( ! do_product_fields( $product_id ) ) {
		return $cart_item_data;
	}

	$email_address = sanitize_email( $_POST[ META_KEY_EMAIL_ADDRESS ] ); // @codingStandardsIgnoreLine
	$site          = sanitize_text_field( $_POST[ META_KEY_SITE ] );    // @codingStandardsIgnoreLine

	if ( isset( $email_address ) ) {
		$cart_item_data[ CART_KEY_EMAIL_ADDRESS ] = $email_address;
	}
	if ( isset( $site ) ) {
		$cart_item_data[ CART_KEY_SITE ] = $site;
	}
	return $cart_item_data;
}

/**
 * Render Cart Item Data.
 *
 * @param array $item_data Item data.
 * @param array $cart_item_data Cart item data.
 * @return array
 */
function render_cart_item_data( $item_data, $cart_item_data ) : array {

	if ( isset( $cart_item_data[ CART_KEY_EMAIL_ADDRESS ] ) ) {
		$item_data[] = array(
			'key'   => esc_html__( 'Email Address', 'wholesome-examples' ),
			'value' => wc_clean( $cart_item_data[ CART_KEY_EMAIL_ADDRESS ] ),
		);
	}

	if ( isset( $cart_item_data[ CART_KEY_SITE ] ) ) {
		$item_data[] = array(
			'key'   => esc_html__( 'Site', 'wholesome-examples' ),
			'value' => wc_clean( $cart_item_data[ CART_KEY_SITE ] ),
		);
	}
	return $item_data;
}

/**
 * Add Product Data to Order.
 *
 * @param object $item Order item.
 * @param string $cart_item_key Cart Item Key.
 * @param array $values Cart Values.
 * @param int $order The Order.
 * @return void
 */
function add_product_data_to_order( $item, $cart_item_key, $values, $order ) {

	if ( isset( $values[ CART_KEY_EMAIL_ADDRESS ] ) ) {
		$item->add_meta_data( esc_attr__( 'Email Address', 'wholesome-examples' ), $values[ CART_KEY_EMAIL_ADDRESS ], true );
	}

	if ( isset( $values[ CART_KEY_SITE ] ) ) {
		$item->add_meta_data( esc_attr__( 'Site', 'wholesome-examples' ), $values[ CART_KEY_SITE ], true );
	}
}

/**
 * On order complete.
 *
 * On order complete, check that we have a valid email address and site,
 * if so create a subscriber to that site.
 *
 * @param int $order_id The order ID.
 * @return void
 */
function on_order_complete( $order_id ) : void {
	$order      = wc_get_order( $order_id );
	$order_data = $order->get_data();

	foreach ( $order->get_items() as $item_id => $item ) {
		$email_address = $item->get_meta( esc_attr__( 'Email Address', 'wholesome-examples' ) );
		$site          = $item->get_meta( esc_attr__( 'Site', 'wholesome-examples' ) );
		if ( $email_address && is_email( $email_address ) && $site ) {
			create_subscriber( $email_address, $site );
		}
	}
}

/**
 * Create Subscriber.
 *
 * Create the subscriber from the email address and the site blog name.
 *
 * @param string $email_address User email address.
 * @param string $site The site blog name.
 * @return void
 */
function create_subscriber( $email_address, $site ) : void {
	// If not a valid email address, bail.
	if ( ! is_email( $email_address ) ) {
		return;
	}

	$site_details = get_site_by_blogname( $site );

	// If we cannot retrieve the site, bail.
	if ( ! $site_details ) {
		return;
	}

	$user_id = null;

	// If user already exists.
	if ( email_exists( $email_address ) ) {
		$user    = get_user_by( 'email', $email_address );
		$user_id = $user->ID;

		// If user is already a member of the blog, bail.
		if ( is_user_member_of_blog( $user_id, $site_details->blog_id ) ) {
			return;
		}
	} else {
		// User does not already exist.
		$user_id = wp_insert_user(
			[
				'display_name'  => $email_address,
				'nickname'      => $email_address,
				'role'          => '',
				'user_email'    => $email_address,
				'user_login'    => $email_address,
				'user_nicename' => $email_address,
				'user_pass'     => wp_generate_password(),
			]
		);

		// We do not want the user in the current site, we want them in the chosen site.
		remove_user_from_blog( $user_id, get_current_blog_id() );
	}

	// If User ID not valid, bail.
	if ( ! $user_id || is_wp_error( $user_id ) ) {
		return;
	}

	// Add the user to blog.
	add_user_to_blog( $site_details->blog_id, $user_id, 'subscriber' );
}

/**
 * Get Site by Blogname.
 *
 * Small helper function to get the site details by the blogname.
 *
 * @param string $blogname The blogname of the site.
 * @return void
 */
function get_site_by_blogname( $blogname ) {
	$sites = get_sites();
	foreach ( $sites as $site ) {
		$details = get_blog_details( $site->blog_id );
		$value   = $details->blogname;

		if ( $value === $blogname ) {
			return $details;
		}
	}

	return false;
}
