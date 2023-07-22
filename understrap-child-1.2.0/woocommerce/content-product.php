<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;

?>

<?php
// Get the product data
$product = wc_get_product(get_the_ID());
$product_name = $product->get_name();
// $product_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' );
// $product_price = $product->get_price();
// $regular_price = $product->get_regular_price();
$product_category = get_the_terms($product->get_id(), 'product_cat');
// $product_discount = $product->get_sale_price();
// $product = wc_get_product( get_the_ID() ); 
// $product_name = $product->get_name(); 

$product_type = $product->get_type();
$product_id = $product->get_id();
$single_custom_product_link = get_permalink($product_id);
?>

<?php
// Calculate discount percentage
$discount_percentage = 0;

// Check if the product is a variable product
if ($product->is_type('variable')) {
	// Get all available variations
	$variations = $product->get_available_variations();

	// Initialize minimum prices to the first variation's prices
	$min_variation_regular_price = $variations[0]['display_regular_price'];
	$min_variation_sale_price = $variations[0]['display_price'];

	// Loop through each variation
	foreach ($variations as $variation) {
		// Get variation data
		$variation_obj = new WC_Product_Variation($variation['variation_id']);
		$variation_regular_price = $variation['display_regular_price'];
		$variation_sale_price = $variation['display_price'];

		// Update minimum prices if the current variation's prices are lower
		if ($variation_regular_price < $min_variation_regular_price) {
			$min_variation_regular_price = $variation_regular_price;
		}
		if ($variation_sale_price < $min_variation_sale_price) {
			$min_variation_sale_price = $variation_sale_price;
		}
	}

	// Calculate discount percentage
	if ($min_variation_sale_price && $min_variation_regular_price) {
		$discount_percentage = round((($min_variation_regular_price - $min_variation_sale_price) / $min_variation_regular_price) * 100);
	}
} else {
	// Get prices for simple product
	$product_price_discount = $product->get_price();
	$regular_price_discount = $product->get_regular_price();
	$product_discount = $product->get_sale_price();

	// Calculate discount percentage
	if ($product_discount && $regular_price_discount) {
		$discount_percentage = round((($regular_price_discount - $product_discount) / $regular_price_discount) * 100);
	}
}
?>

<li class=" col-md-4">
	<div class="product-card" onclick="location.href='<?php echo $single_custom_product_link; ?>'">
		<div class="product-card-stock-discont-wrapper">
			<div class="product-card-stock-status">
				<?php if ($product->is_in_stock()) : ?>
					<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/in-stock-img.svg'); ?>" alt="In Stock">
					<span class="in-stock-text"><?php echo __('In Stock', 'understrap-child'); ?></span>
				<?php else : ?>
					<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/out-of-stock-img.svg'); ?>" alt="Out of Stock">
					<span class="out-of-stock-text"><?php echo __('Out of Stock', 'understrap-child'); ?></span>
				<?php endif; ?>
			</div>
			<?php if ($discount_percentage > 0) : ?>
				<div class="discount-percents">-<?php echo $discount_percentage; ?>%</div>
			<?php endif; ?>
		</div>
		<div class="product-card-image">
			<?php if (has_post_thumbnail()) : ?>
				<a href="<?php echo esc_url(get_permalink()); ?>">
					<?php
					$image_id = get_post_thumbnail_id();
					$image_url = wp_get_attachment_image_url($image_id, 'shop_product_image');
					?>
					<div class="product-card-image">
						<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product_name); ?>">
					</div>
				</a>
			<?php endif; ?>
		</div>
		<div class="product-card-category">
			<?php
			$product_id = $product->get_id();
			$taxonomy = 'pa_brand';
			$terms = wc_get_product_terms($product_id, $taxonomy, array('orderby' => 'name'));
			if (!empty($terms)) {
				$brand_links = array();
				foreach ($terms as $term) {
					$brand_links[] = '<a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . $term->name . '</a>';
				}
				echo implode(', ', $brand_links);
			}
			?>
		</div>
		<div class="product-card-name">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<?php echo esc_html($product->get_name()); ?>
			</a>
		</div>
		<div class="product-card-details">
			<?php
			if ($product->is_type('variable')) {
				// Get all available variations
				$variations = $product->get_available_variations();

				// Initialize minimum prices to the first variation's prices
				$min_variation_regular_price = $variations[0]['display_regular_price'];
				$min_variation_sale_price = $variations[0]['display_price'];

				// Loop through each variation
				foreach ($variations as $variation) {
					// Get variation data
					$variation_obj = new WC_Product_Variation($variation['variation_id']);
					$variation_regular_price = $variation['display_regular_price'];
					$variation_sale_price = $variation['display_price'];

					// Update minimum prices if the current variation's prices are lower
					if ($variation_regular_price < $min_variation_regular_price) {
						$min_variation_regular_price = $variation_regular_price;
					}
					if ($variation_sale_price < $min_variation_sale_price) {
						$min_variation_sale_price = $variation_sale_price;
					}
				}

				// Display minimum variation prices
			?>
				<div class="product-card-prices">
					<?php if ($min_variation_sale_price != $min_variation_regular_price) : ?>
						<div class="product-card-discount-price">
							<?php echo wc_price($min_variation_regular_price); ?>
						</div>
						<div class="product-card-regular-price">
							<?php echo wc_price($min_variation_sale_price); ?>
						</div>
					<?php else : ?>
						<div class="product-card-regular-price"><?php echo wc_price($min_variation_regular_price); ?></div>
					<?php endif; ?>
				</div>
			<?php
			} else {
				// Get prices for simple product
				$product_price = $product->get_price();
				$regular_price = $product->get_regular_price();
				$product_discount = $product->get_sale_price();
			?>
				<div class="product-card-prices">
					<?php if ($product_discount) : ?>
						<div class="product-card-discount-price">
							<?php echo wc_price($regular_price); ?>
						</div>
						<div class="product-card-regular-price">
							<?php echo wc_price($product_discount); ?>
						</div>
					<?php else : ?>
						<div class="product-card-regular-price"><?php echo wc_price($product_price); ?></div>
					<?php endif; ?>
				</div>
			<?php
			}
			?>

			<div class="product-card-add-to-cart">
				<?php
				if ($product->is_type('variable')) {
					// Get all available variations
					$variations = $product->get_available_variations();

					// Initialize the variables to hold the minimum prices
					$min_variation_regular_price = null;
					$min_variation_sale_price = null;

					// Loop through each variation to find the minimum prices
					foreach ($variations as $variation) {
						$regular_price = $variation['display_regular_price'];
						$sale_price = $variation['display_price'];

						// Check if the variation has a sale price
						if ($sale_price && $sale_price < $regular_price) {
							// Update the minimum prices if necessary
							if (is_null($min_variation_regular_price) || $regular_price < $min_variation_regular_price) {
								$min_variation_regular_price = $regular_price;
							}

							if (is_null($min_variation_sale_price) || $sale_price < $min_variation_sale_price) {
								$min_variation_sale_price = $sale_price;
							}
						}
					}

					// Check if any variation has a sale price
					if ($min_variation_sale_price && $min_variation_sale_price < $min_variation_regular_price) {
						// Display the "Sale" text
						echo '<div class="prodcut-card-sale">' . __('Sale', 'understrap-child') . '</div>';
					}
				} else {
					// Handle simple products
					if ($product_discount) {
						// Display the "Sale" text
						echo '<div class="prodcut-card-sale">' . __('Sale', 'understrap-child') . '</div>';
					}
				}
				?>
			</div>
		</div>

	</div>
</li>