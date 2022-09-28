<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php esc_html_e( 'Product', 'farmart' ); ?></th>
			<th class="product-price hidden-xs"><?php esc_html_e( 'Price', 'farmart' ); ?></th>
			<th class="product-quantity hidden-xs"><?php esc_html_e( 'Quantity', 'farmart' ); ?></th>
			<th class="product-subtotal hidden-xs"><?php esc_html_e( 'Total', 'farmart' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo ! empty( $thumbnail ) ? $thumbnail : ''; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
					</td>

					<td class="product-name hidden-xs" data-title="<?php esc_attr_e( 'Product', 'farmart' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
						} else {
							echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						$unit_text = maybe_unserialize( get_post_meta( $product_id, 'custom_unit_price', true ) );

						if ( $unit_text ) {
							echo '<div class="unit-text">' . $unit_text . '</div>';
						}

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'farmart' ) . '</p>', $product_id );
						}
						?>

					</td>

					<td class="product-price hidden-xs" data-title="<?php esc_attr_e( 'Price', 'farmart' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'farmart' ); ?>">
						<div class="product-name hidden-lg hidden-md hidden-sm">
							<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							$unit_text = maybe_unserialize( get_post_meta( $product_id, 'custom_unit_price', true ) );

							if ( $unit_text ) {
								echo '<div class="unit-text">' . $unit_text . '</div>';
							}

							// Meta data.
							echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'farmart' ) . '</p>', $product_id );
							}
							?>
						</div>

						<div class="price hidden-lg hidden-md hidden-sm">
							<?php
							echo '<label>' . esc_html__( 'Price: ', 'farmart' ) . '</label>';
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</div>

						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $_product->get_max_purchase_quantity(),
										'min_value'    => '0',
										'product_name' => $_product->get_name(),
									),
									$_product,
									false
								);
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>

						<div class="price-total hidden-lg hidden-md hidden-sm">
							<?php
							echo '<label>' . esc_html__( 'Total: ', 'farmart' ) . '</label>';
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</div>
					</td>

					<td class="product-subtotal hidden-xs" data-title="<?php esc_attr_e( 'Total', 'farmart' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?>
					</td>
					<td class="product-remove">
						<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_html__( 'Remove this item', 'farmart' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() ),
									Farmart\Icon::get_svg( 'trash', '', 'shop' )
								),
								$cart_item_key
							);
						?>
					</td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_contents' ); ?>

		<tr>
			<td colspan="6" class="actions">
				<div class="actions__button-wrapper">
					<div class="actions__left">
						<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>"
						class="btn-shop"><?php echo Farmart\Icon::get_svg( 'arrow-left' ) ?> <?php esc_html_e( 'Continue Shopping', 'farmart' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						class="btn-home"><?php echo Farmart\Icon::get_svg( 'home' ) ?> <?php esc_html_e( 'Back to Home', 'farmart' ); ?>
						</a>
					</div>

					<div class="actions__right">
						<?php
						$hidden = '';
						if ( intval( farmart_get_option( 'quantity_ajax' ) ) ) {
							$hidden = 'hidden';
						}
						?>

						<?php if ( intval( farmart_get_option( 'clear_cart_button' ) ) ) : ?>
							<button type="submit" class="button empty-cart-button" name="empty_cart"
									value="<?php esc_attr_e( 'Clear all items', 'farmart' ); ?>">
								<?php esc_html_e( 'Clear all items', 'farmart' ); ?>
							</button>
						<?php endif; ?>

						<button type="submit" class="button update_cart <?php echo esc_attr( $hidden ) ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'farmart' ); ?>">
							<?php echo Farmart\Icon::get_svg( 'sync', '', 'shop' ); ?>
							<?php esc_html_e( 'Update cart', 'farmart' ); ?>
						</button>
					</div>
					<div class="clear"></div>
				</div>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
	<?php if ( wc_coupons_enabled() ) { ?>
		<div class="row">
			<div class="col-md-4 col-sm-12 col-coupon">
				<div class="coupon">
					<label for="coupon_code"><?php echo apply_filters( 'farmart_cart_coupon_text', esc_html__( 'Using A Promo Code?', 'farmart' ) ); ?></label>
					<div class="coupon-input">
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'farmart' ); ?>" />
					<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'farmart' ); ?>"><?php esc_html_e( 'Apply', 'farmart' ); ?></button>
					</div>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			</div>
		</div>
	<?php } ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<div class="row">
		<div class="col-md-4 col-sm-12 col-colla">

		</div>

		<?php
		$cart_class = 'col-md-8 col-sm-12 col-cart-total';
		if ( 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
			$cart_class = 'col-md-4 col-sm-12 col-cart-total';
			?>
			<div class="col-md-4 col-sm-12 col-calculator">
				<?php woocommerce_shipping_calculator(); ?>
			</div>
		<?php } ?>
		<div class="<?php echo esc_attr( $cart_class ); ?>">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>
	</div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
