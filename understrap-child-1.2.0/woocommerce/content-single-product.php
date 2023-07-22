<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

	<div class="single-product-links-wrapper">
		<div class="zuruck-wrapper">
			<a href="<?php echo esc_url(home_url()); ?>/shop">
				<img class="zuruck-img" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/back-to-shop.svg'); ?>">
				<p class="back-to-shop"><?php esc_html_e('Zurück zur Übersicht', 'understrap-child'); ?></p>
			</a>
		</div>
		<div class="single-product-agree">
			<div class="agree-link">
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
		</div>
	</div>

	<div class="product-title-mobile-wrapper">
		<h1><?php the_title(); ?></h1>
	</div>

	<div class="single-page-product-slick-slider">
		<div class="product-slider">
			<div class="single-page-product-slider-for">
				<?php
				// Retrieve the product gallery images
				$gallery_images = $product->get_gallery_image_ids();
				// Get the featured image ID
				$featured_image_id = $product->get_image_id();
				// Prepend the featured image ID to the gallery images array
				array_unshift($gallery_images, $featured_image_id);

				// Display the gallery images as slider slides
				foreach ($gallery_images as $image_id) {
					$image_url = wp_get_attachment_image_url($image_id, array(600, 350));
					$full_image_url = wp_get_attachment_image_url($image_id, 'full');
					echo '<div><a href="' . $full_image_url . '" class="lightbox-image"><img src="' . $image_url . '" alt="" /></a></div>';
				}
				?>
			</div>
			<div class="single-page-product-slider-nav">
				<?php
				// Display thumbnail images for navigation
				foreach ($gallery_images as $image_id) {
					$thumbnail_url = wp_get_attachment_image_url($image_id, array(126, 126));
					echo '<div><img src="' . $thumbnail_url . '" alt="" /></div>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */

		/**
		 * Hook: woocommerce_template_single_add_to_cart.
		 *
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 */
		do_action('woocommerce_single_product_add_to_cart');
		do_action('woocommerce_single_product_summary');
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 */
	do_action('woocommerce_after_single_product_summary');

	?>
</div>

<div class="row product-info-wrapper">
	<div class="col-12 col-sm-6">
		<h3><?php esc_html_e('Ähnliche Produkte', 'understrap-child'); ?></h3>
	</div>
	<div class="col-12 col-sm-6"><a href="<?php echo esc_url(home_url('/shop')); ?>" class="product-info-btn"><?php esc_html_e('Alle Produkte', 'understrap-child'); ?></a></div>
</div>

<div class="vc_row wpb_row vc_row-fluid latest-product-home-wrapper vc_row-o-content-middle vc_row-flex">
	<div class="latest-products-wrapper wpb_column vc_column_container vc_col-sm-12">
		<div class="wpb_wrapper">
			<?php echo do_shortcode('[my_custom_similar_products]'); ?>
		</div>
	</div>
</div>


<?php do_action('woocommerce_after_single_product'); ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
	<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<strong class="me-auto"><?php esc_html_e('Added to Cart', 'understrap-child'); ?></strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			<?php esc_html_e('Product successfully added to your cart.', 'understrap-child'); ?>
		</div>
	</div>
</div>