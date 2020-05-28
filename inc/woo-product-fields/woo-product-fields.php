<?php
/**
 * Woo Additional Product Fields.
 *
 * Example additional product fields for WooCommerce.
 * Examples based on https://pluginrepublic.com/add-custom-cart-item-data-in-woocommerce/
 *
 * @package wholesomecode/wholesome_examples
 */

 namespace WholesomeCode\WholesomeExamples\WooProductFields; // @codingStandardsIgnoreLine

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
	add_filter( 'woocommerce_add_to_cart_validation',  __NAMESPACE__ . '\\validate_product_fields', 10, 4 );

	// Add custom cart item data.
	add_filter( 'woocommerce_add_cart_item_data', __NAMESPACE__ . '\\add_cart_item_data', 10, 3 );

	// Display custom item data in the cart.
	add_filter( 'woocommerce_get_item_data', __NAMESPACE__ . '\\render_cart_item_data', 10, 2 );

	// Add custom meta to order.
	add_action( 'woocommerce_checkout_create_order_line_item', __NAMESPACE__ . '\\add_product_data_to_order', 10, 4 );

	// On payment, process the order and create the users.
	// TODO.

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

	?>
	<div class="user-email-address-wrap">
		<label for="user-email-address">
			<?php esc_html_e( 'Email Address', 'wholesome-examples' ); ?>
		</label>
		<input type="text" name='user-email-address' id='user-email-address' value='' class="large-text">
	</div>
	<div class="user-site-wrap">
		<label for="user-site">
			<?php esc_html_e( 'Site', 'wholesome-examples' ); ?>
		</label>
		<select name='user-site' id='user-site' class="large-text">
			<option value="<?php esc_attr_e( 'root', 'wholesome-examples' ); ?>"><?php esc_html_e( 'Root', 'wholesome-examples' ); ?></option>
			<option value="<?php esc_attr_e( 'site-1', 'wholesome-examples' ); ?>"><?php esc_html_e( 'Site 1', 'wholesome-examples' ); ?></option>
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

	if ( empty( $_POST['user-email-address'] ) ) {
		$passed = false;
		wc_add_notice( esc_html__( 'Email Address is a required field.', 'wholesome-examples' ), 'error' );
	}
	if ( empty( $_POST['user-site'] ) ) {
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

	if ( isset( $_POST['user-email-address'] ) ) {
		$cart_item_data['user_email_address'] = sanitize_text_field( $_POST['user-email-address'] );
	}
	if ( isset( $_POST['user-site'] ) ) {
		$cart_item_data['user_site'] = sanitize_text_field( $_POST['user-site'] );
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
	if ( isset( $cart_item_data['user_email_address'] ) ) {
		$item_data[] = array(
			'key'   => esc_html__( 'Email Address', 'wholesome-examples' ),
			'value' => wc_clean( $cart_item_data['user_email_address'] ),
		);
	}
	if ( isset( $cart_item_data['user_site'] ) ) {
		$item_data[] = array(
			'key'   => esc_html__( 'Site', 'wholesome-examples' ),
			'value' => wc_clean( $cart_item_data['user_site'] ),
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
	if ( isset( $values['user_email_address'] ) ) {
		$item->add_meta_data( esc_html__( 'Email Address', 'wholesome-examples' ), $values['user_email_address'], true );
	}
	if ( isset( $values['user_site'] ) ) {
		$item->add_meta_data( esc_html__( 'Site', 'wholesome-examples' ), $values['user_site'], true );
	}
}
