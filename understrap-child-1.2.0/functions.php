<?php

/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_template_part('lib/custom_functions');

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts()
{
	wp_dequeue_style('understrap-styles');
	wp_deregister_style('understrap-styles');

	wp_dequeue_script('understrap-scripts');
	wp_deregister_script('understrap-scripts');
}
add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles()
{

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style('child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get('Version'));
	wp_enqueue_script('jquery');
	wp_enqueue_script('child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get('Version'), true);
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain()
{
	load_child_theme_textdomain('understrap-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'add_child_theme_textdomain');



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version()
{
	return 'bootstrap5';
}
add_filter('theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20);

function enqueue_lightbox_scripts()
{
	// Enqueue Magnific Popup JavaScript file
	wp_enqueue_script('magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);

	// Enqueue Magnific Popup CSS file
	wp_enqueue_style('magnific-popup-style', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', array(), '1.1.0');
}

add_action('wp_enqueue_scripts', 'enqueue_lightbox_scripts');

/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js()
{
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array('customize-preview'),
		'20130508',
		true
	);
}
add_action('customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js');

function add_custom_theme_styles()
{
	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/css/custom-css.css', array(), filemtime(get_stylesheet_directory() . '/css/custom-css.css'), 'all');
}

add_action('wp_enqueue_scripts', 'add_custom_theme_styles');

function custom_theme_scripts()
{
	wp_enqueue_script('custom-theme-scripts', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0', true);
	wp_localize_script('custom-theme-scripts', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');


function theme_name_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Footer Widget Bottom', 'understrap-child'),
		'id'            => 'footer-widget-bottom',
		'description'   => __('Add widgets here to appear in your footer.', 'understrap-child'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => __('Footer Widget Bottom 2', 'understrap-child'),
		'id'            => 'footer-widget-bottom-2',
		'description'   => __('Add widgets here to appear in your footer.', 'understrap-child'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __('Header cart', 'understrap-child'),
		'id'            => 'header-cart-widget',
		'description'   => __('Add widgets here to appear in your header.', 'understrap-child'),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	));
}
add_action('widgets_init', 'theme_name_widgets_init');

/* woocommerce image sizes */
add_filter('woocommerce_get_image_size_single', function ($size) {
	return array(
		'width'  => 470,
		'height' => 350,
		'crop'   => 1,
	);
});

add_filter('woocommerce_get_image_size_thumbnail', function ($size) {
	return array(
		'width'  => 216,
		'height' => 130,
		'crop'   => 1,
	);
});


add_filter('woocommerce_get_image_size_single_product_main', function ($size) {
	return array(
		'width'  => 600,
		'height' => 350,
		'crop'   => true,
	);
});

add_filter('woocommerce_get_image_size_gallery_thumbnail', function ($size) {
	return array(
		'width'  => 126,
		'height' => 126,
		'crop'   => true,
	);
});

// add_filter('woocommerce_get_image_size_shop_product_image', function ($size) {
//     return array(
//         'width'  => 232,
//         'height' => 130,
//         'crop'   => true,
//     );
// });

// function custom_add_image_size() {
//     add_image_size( 'custom_product_image', 232, 130, true ); // Specify the desired width, height, and cropping option
// }
// add_action( 'after_setup_theme', 'custom_add_image_size' );


/* custom wpbakery element - latest products */
function my_enqueue_styles()
{
	wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
}
add_action('wp_enqueue_scripts', 'my_enqueue_styles');


function my_enqueue_scripts()
{
	wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');


function my_custom_vc_element()
{
	vc_map(array(
		"name" => __("My Custom Latest Products Element", "understrap-child"),
		"base" => "my_custom_products",
		"category" => __("My Custom Elements", "understrap-child"),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Number of Products", "understrap-child"),
				"param_name" => "num_products",
				"description" => __("Enter the number of latest products to display", "understrap-child"),
				"value" => 8
			)
			// Add other necessary parameters here
		)
	));
}
add_action('vc_before_init', 'my_custom_vc_element');

// Register Custom Taxonomy
// function my_brand_custom_taxonomy_Item()  {
// 	$labels = array(
// 		'name'                       => 'Brands',
// 		'singular_name'              => 'Brand',
// 		'menu_name'                  => 'Brands',
// 		'all_items'                  => 'All Brands',
// 		'parent_item'                => 'Parent Brand',
// 		'parent_item_colon'          => 'Parent Brand:',
// 		'new_item_name'              => 'New Brand Name',
// 		'add_new_item'               => 'Add New Brand',
// 		'edit_item'                  => 'Edit Brand',
// 		'update_item'                => 'Update Brand',
// 		'separate_items_with_commas' => 'Separate Brand with commas',
// 		'search_items'               => 'Search Brands',
// 		'add_or_remove_items'        => 'Add or remove Brands',
// 		'choose_from_most_used'      => 'Choose from the most used Brands',
// 	);
// 	$args = array(
// 		'labels'                     => $labels,
// 		'hierarchical'               => true,
// 		'public'                     => true,
// 		'show_ui'                    => true,
// 		'show_admin_column'          => true,
// 		'show_in_nav_menus'          => true,
// 		'show_tagcloud'              => true,
// 	);
// 	register_taxonomy( 'product_brand', 'product', $args );
// 	}
// 	add_action( 'init', 'my_brand_custom_taxonomy_Item', 0);

function my_custom_products_shortcode($atts)
{
	$atts = shortcode_atts(array(
		// Add your default attributes here
	), $atts);

	ob_start();

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 8,
	);
	$products = new WP_Query($args);
	if ($products->have_posts()) :
?>
		<div class="custom-products">
			<div class="custom-products-slider">

				<?php while ($products->have_posts()) : $products->the_post(); ?>

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

					?>

					<div class="custom-products-item">
						<div class="product-card" onclick="location.href='<?php echo esc_url(get_permalink()); ?>'">
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
									<?php echo esc_html($product_name); ?>
								</a>
							</div>
							<div class="product-card-image">
								<?php $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'woocommerce_thumbnail'); ?>
								<?php if ($product_image) : ?>
									<a href="<?php echo esc_url(get_permalink()); ?>">
										<img src="<?php echo esc_url($product_image[0]); ?>" width="<?php echo esc_attr($product_image[1]); ?>" height="<?php echo esc_attr($product_image[2]); ?>" alt="<?php echo esc_attr($product_name); ?>">
									</a>
								<?php endif; ?>
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
									<?php if ($product->is_type('variable')) : ?>
										<?php $product_variations = $product->get_available_variations(); ?>
										<?php if ($product_variations) : ?>
											<div class="add-to-cart-container vp-add-to-cart-wrapper">
												<a href="<?php echo esc_url($product->get_permalink()); ?>" class="wp-element-button vp-add-to-cart product_type_variable add_to_cart_button" aria-label="<?php esc_attr_e('Select options', 'woocommerce'); ?>">
													<?php esc_html_e('Select', 'woocommerce'); ?>
												</a>
											</div>
										<?php endif; ?>
									<?php else : ?>
										<div class="add-to-cart-container">
											<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>" class="wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart btn btn-outline-primary" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>" rel="nofollow" tabindex="0">
												<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/product-carousel-cart.svg'); ?>" alt="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>">
											</a>
										</div>
									<?php endif; ?>
								</div>

							</div>


						</div>

					</div>

				<?php endwhile; ?>

			</div>
			<div class="product-carousel-navigation">
				<div class="custom-products-dots"></div>
				<div class="custom-products-arrows">
					<!-- <div class="custom-products-prev"><i class="fa fa-chevron-left"></i></div> -->
					<div class="custom-products-prev"></div>
					<div class="custom-products-next"></div>
				</div>
			</div>


		</div>
		<script>
			jQuery(document).ready(function($) {
				$('.custom-products-slider').slick({
					slidesToShow: 4.5,
					infinite: false,
					dots: true,
					arrows: true,
					prevArrow: '.custom-products-prev',
					nextArrow: '.custom-products-next',
					appendDots: '.custom-products-dots',
					variableWidth: true,
					responsive: [{
							breakpoint: 1200,
							settings: {
								slidesToShow: 3.2
							}
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: 2.2
							}
						},
						{
							breakpoint: 576,
							settings: {
								slidesToShow: 1.2
							}
						}
					]
				});
			});
		</script>
	<?php
	endif;
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode('my_custom_products', 'my_custom_products_shortcode');


/* custom wpbakery element - best selling products */

function my_custom_bestselling_vc_element()
{
	vc_map(array(
		"name" => __("My Custom Bestselling Products Element", "understrap-child"),
		"base" => "my_custom_bestselling_products",
		"category" => __("My Custom Elements", "understrap-child"),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Number of Products", "understrap-child"),
				"param_name" => "num_products",
				"description" => __("Enter the number of best-selling products to display", "understrap-child"),
				"value" => 8
			)
			// Add other necessary parameters here
		)
	));
}
add_action('vc_before_init', 'my_custom_bestselling_vc_element');


function my_custom_bestselling_products_shortcode($atts)
{
	$atts = shortcode_atts(array(
		// Add your default attributes here
	), $atts);

	ob_start();

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 8,
		'meta_key' => 'total_sales',
		'orderby' => 'meta_value_num', // sort by numeric value of total_sales
		'order' => 'DESC', // sort in descending order
	);
	$products = new WP_Query($args);
	if ($products->have_posts()) :
	?>
		<div class="custom-products">
			<div class="custom-best-selling-products-slider">

				<?php while ($products->have_posts()) : $products->the_post(); ?>

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
					$single_custom_product_link = get_permalink($product_id); ?>


					<div class="custom-products-item">
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
									<?php echo esc_html($product_name); ?>
								</a>
							</div>
							<div class="product-card-image">
								<?php $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'woocommerce_thumbnail'); ?>
								<?php if ($product_image) : ?>
									<a href="<?php echo esc_url(get_permalink()); ?>">
										<img src="<?php echo esc_url($product_image[0]); ?>" width="<?php echo esc_attr($product_image[1]); ?>" height="<?php echo esc_attr($product_image[2]); ?>" alt="<?php echo esc_attr($product_name); ?>">
									</a>
								<?php endif; ?>
							</div>

							<div class="product-card-details best-selling-product-mobile">
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
									<?php if ($product->is_type('variable')) : ?>
										<?php $product_variations = $product->get_available_variations(); ?>
										<?php if ($product_variations) : ?>
											<div class="add-to-cart-container vp-add-to-cart-wrapper">
												<a href="<?php echo esc_url($product->get_permalink()); ?>" class="wp-element-button vp-add-to-cart product_type_variable add_to_cart_button" aria-label="<?php esc_attr_e('Select options', 'woocommerce'); ?>">
													<?php esc_html_e('Select', 'woocommerce'); ?>
												</a>
											</div>
										<?php endif; ?>
									<?php else : ?>
										<div class="add-to-cart-container">
											<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>" class="wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart btn btn-outline-primary" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>" rel="nofollow" tabindex="0">
												<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/product-carousel-cart.svg'); ?>" alt="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>">
											</a>
										</div>
									<?php endif; ?>
								</div>

							</div>

							<div class="product-card-details best-selling-product-screen">
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

							</div>

							<div class="product-card-add-to-cart best-selling-product-screen">
								<?php if ($product->is_type('variable')) : ?>
									<?php $product_variations = $product->get_available_variations(); ?>
									<?php if ($product_variations) : ?>
										<div class="add-to-cart-container vp-add-to-cart-wrapper">
											<a href="<?php echo esc_url($product->get_permalink()); ?>" class="wp-element-button vp-add-to-cart product_type_variable add_to_cart_button" aria-label="<?php esc_attr_e('Select options', 'woocommerce'); ?>">
												<?php esc_html_e('Select', 'woocommerce'); ?>
											</a>
										</div>
									<?php endif; ?>
								<?php else : ?>
									<div class="add-to-cart-container">
										<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>" class="wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart btn btn-outline-primary" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>" rel="nofollow" tabindex="0">
											<span class="cart-icon"></span> In den Warenkorb
										</a>
									</div>
								<?php endif; ?>
							</div>

						</div>

					</div>

				<?php endwhile; ?>

			</div>
			<div class="custom-best-selling-products-navigation">
				<div class="custom-best-selling-products-dots"></div>
				<div class="custom-best-selling-products-arrows">
					<div class="custom-best-selling-products-prev"></div>
					<div class="custom-best-selling-products-next"></div>
				</div>
			</div>


		</div>
		<script>
			jQuery(document).ready(function($) {
				$('.custom-best-selling-products-slider').slick({
					slidesToShow: 4.2,
					infinite: false,
					dots: true,
					arrows: true,
					prevArrow: '.custom-best-selling-products-prev',
					nextArrow: '.custom-best-selling-products-next',
					appendDots: '.custom-best-selling-products-dots',
					variableWidth: true,
					responsive: [{
							breakpoint: 1200,
							settings: {
								slidesToShow: 3.2
							}
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: 2.2
							}
						},
						{
							breakpoint: 576,
							settings: {
								slidesToShow: 1.2
							}
						}
					]
				});
			});
		</script>
	<?php
	endif;
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode('my_custom_bestselling_products', 'my_custom_bestselling_products_shortcode');



//  function home_logos_shortcode() {
//     $output = '';

//     // Get the WPBakery row ID
//     $row_id = 'home_logos_pc'; // Replace with the actual row ID

//     // Get the WPBakery row content
//     $row_content = WPBMap::getShortCode($row_id)['content'];

//     // Wrap the row content in a div with a class
//     $output .= '<div class="my-custom-class">' . $row_content . '</div>';

//     return $output;
// }

// add_shortcode( 'home_logos_shortcode', 'home_logos_shortcode' );
add_action('pre_get_posts', 'custom_products_per_page');
function custom_products_per_page($query)
{
	if (!is_admin() && $query->is_main_query() && is_shop()) {
		$query->set('posts_per_page', 12);
	}
}


add_filter('loop_shop_columns', 'custom_loop_columns', 999);
function custom_loop_columns($columns)
{
	return 3;
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


// add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
// function custom_woocommerce_catalog_orderby( $sortby ) {
//     $sortby['menu_order'] = 'Sort by menu order';
//     $sortby['popularity'] = 'Sort by popularity';
//     $sortby['rating'] = 'Sort by rating';
//     $sortby['date'] = 'Sort by latest';
//     $sortby['price'] = 'Sort by price: low to high';
//     $sortby['price-desc'] = 'Sort by price: high to low';
//     return $sortby;
// }


function wc_custom_filter_register_sidebar()
{
	register_sidebar(array(
		'name' => __('WooCommerce Filters', 'theme'),
		'id' => 'woocommerce_filters',
		'description' => __('Add widgets for WooCommerce filters here.', 'theme'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'wc_custom_filter_register_sidebar');


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


add_action(
	'woocommerce_after_single_product_summary',
	function () {
		echo '<div class="testclass container-fluid"><div class="container">';
	},
	9
);
add_action(
	'woocommerce_after_single_product_summary',
	function () {
		echo '</div></div>';
	},
	31
);

add_image_size('post-image-size', 1440, 395, true);
function custom_excerpt_length($length)
{
	return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length');



/* similar products */
function my_custom_similar_products_shortcode($atts)
{
	global $post;

	// Get the categories of the current product
	$categories = wp_get_post_terms($post->ID, 'product_cat', array('fields' => 'ids'));

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 8,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => $categories
			)
		),
		'post__not_in' => array($post->ID)
	);

	$products = new WP_Query($args);

	if ($products->have_posts()) :
	?>
		<div class="custom-products">
			<div class="custom-best-selling-products-slider third-slider">

				<?php while ($products->have_posts()) : $products->the_post(); ?>

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
					$single_custom_product_link = get_permalink($product_id); ?>



					<div class="custom-products-item">
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
									<?php echo esc_html($product_name); ?>
								</a>
							</div>
							<div class="product-card-image">
								<?php $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'woocommerce_thumbnail'); ?>
								<?php if ($product_image) : ?>
									<a href="<?php echo esc_url(get_permalink()); ?>">
										<img src="<?php echo esc_url($product_image[0]); ?>" width="<?php echo esc_attr($product_image[1]); ?>" height="<?php echo esc_attr($product_image[2]); ?>" alt="<?php echo esc_attr($product_name); ?>">
									</a>
								<?php endif; ?>
							</div>

							<div class="product-card-details best-selling-product-mobile">
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
									<?php if ($product->is_type('variable')) : ?>
										<?php $product_variations = $product->get_available_variations(); ?>
										<?php if ($product_variations) : ?>
											<div class="add-to-cart-container vp-add-to-cart-wrapper">
												<a href="<?php echo esc_url($product->get_permalink()); ?>" class="wp-element-button vp-add-to-cart product_type_variable add_to_cart_button" aria-label="<?php esc_attr_e('Select options', 'woocommerce'); ?>">
													<?php esc_html_e('Select', 'woocommerce'); ?>
												</a>
											</div>
										<?php endif; ?>
									<?php else : ?>
										<div class="add-to-cart-container">
											<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>" class="wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart btn btn-outline-primary" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>" rel="nofollow" tabindex="0">
												<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/product-carousel-cart.svg'); ?>" alt="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>">
											</a>
										</div>
									<?php endif; ?>
								</div>

							</div>

							<div class="product-card-details best-selling-product-screen">
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

							</div>

							<div class="product-card-add-to-cart best-selling-product-screen">
								<?php if ($product->is_type('variable')) : ?>
									<?php $product_variations = $product->get_available_variations(); ?>
									<?php if ($product_variations) : ?>
										<div class="add-to-cart-container vp-add-to-cart-wrapper">
											<a href="<?php echo esc_url($product->get_permalink()); ?>" class="wp-element-button vp-add-to-cart product_type_variable add_to_cart_button" aria-label="<?php esc_attr_e('Select options', 'woocommerce'); ?>">
												<?php esc_html_e('Select', 'woocommerce'); ?>
											</a>
										</div>
									<?php endif; ?>
								<?php else : ?>
									<div class="add-to-cart-container">
										<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>" class="wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart btn btn-outline-primary" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>" rel="nofollow" tabindex="0">
											<span class="cart-icon"></span> In den Warenkorb
										</a>
									</div>
								<?php endif; ?>
							</div>


						</div>

					</div>

				<?php endwhile; ?>

			</div>
			<div class="custom-best-selling-products-navigation">
				<div class="custom-best-selling-products-dots"></div>
				<div class="custom-best-selling-products-arrows">
					<div class="custom-best-selling-products-prev"></div>
					<div class="custom-best-selling-products-next"></div>
				</div>
			</div>


		</div>
		<script>
			jQuery(document).ready(function($) {
				$('.third-slider').slick({
					slidesToShow: 4.2,
					infinite: false,
					dots: true,
					arrows: true,
					prevArrow: '.custom-best-selling-products-prev',
					nextArrow: '.custom-best-selling-products-next',
					appendDots: '.custom-best-selling-products-dots',
					variableWidth: true,
					responsive: [{
							breakpoint: 1200,
							settings: {
								slidesToShow: 3.2
							}
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: 2.2
							}
						},
						{
							breakpoint: 576,
							settings: {
								slidesToShow: 1.2
							}
						}
					]
				});
			});
		</script>
		<?php
	endif;
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode('my_custom_similar_products', 'my_custom_similar_products_shortcode');



/* Custom wpbakery element - single product */
function my_custom_vc_product_element()
{
	vc_map(array(
		"name" => __("My Custom Product Element", "understrap-child"),
		"base" => "my_custom_product",
		"category" => __("My Custom Elements", "understrap-child"),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Product ID", "understrap-child"),
				"param_name" => "product_id",
				"description" => __("Enter the ID of the product to display", "understrap-child"),
			)
			// Add other necessary parameters here
		)
	));
}
add_action('vc_before_init', 'my_custom_vc_product_element');


function my_custom_product_shortcode($atts)
{
	$atts = shortcode_atts(array(
		'product_id' => '', // Default value for product ID
	), $atts);
	ob_start();
	if (!empty($atts['product_id'])) {
		$product = wc_get_product($atts['product_id']); // Get the product object
		if ($product) {

			$product_name = $product->get_name();
			$product_category = get_the_terms($product->get_id(), 'product_cat');
			$product_type = $product->get_type();
			$product_id = $product->get_id();
			$single_custom_product_link = get_permalink($product_id); ?>
			<div class="custom-product">
				<div class="product-card" onclick="location.href='<?php echo $single_custom_product_link; ?>'">
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
						<?php $product_id = $product->get_id();
						$single_custom_product_link = get_permalink($product_id); ?>
						<a href="<?php echo $single_custom_product_link; ?>">
							<?php echo esc_html($product_name); ?>
						</a>
					</div>
					<div class="product-card-image">
						<?php echo $product->get_image(); ?>
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
							<?php if ($product->is_type('variable')) : ?>
								<?php $product_variations = $product->get_available_variations(); ?>
								<?php if ($product_variations) : ?>
									<div class="add-to-cart-container vp-add-to-cart-wrapper">
										<a href="<?php echo esc_url($product->get_permalink()); ?>" class="wp-element-button vp-add-to-cart product_type_variable add_to_cart_button" aria-label="<?php esc_attr_e('Select options', 'woocommerce'); ?>">
											<?php esc_html_e('Select', 'woocommerce'); ?>
										</a>
									</div>
								<?php endif; ?>
							<?php else : ?>
								<div class="add-to-cart-container">
									<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="<?php echo esc_attr(isset($quantity) ? $quantity : 1); ?>" class="wp-element-button product_type_simple add_to_cart_button ajax_add_to_cart btn btn-outline-primary" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>" rel="nofollow" tabindex="0">
										<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/product-carousel-cart.svg'); ?>" alt="<?php esc_attr_e('Add to cart', 'woocommerce'); ?>">
									</a>
								</div>
							<?php endif; ?>
						</div>

					</div>
				</div>
			</div>
	<?php
		} else {
			// Display an error message if the product ID is not valid
			echo 'Invalid product ID';
		}
	}
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode('my_custom_product', 'my_custom_product_shortcode');

//Custom WooCommerce registration form

// Add first and last name fields to registration form
add_action('woocommerce_register_form', 'add_first_last_name_to_registration_form');
function add_first_last_name_to_registration_form()
{
	?>


	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="firma"><?php esc_html_e('Firma', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="firma" id="firma" value="<?php if (!empty($_POST['firma'])) esc_attr_e($_POST['firma']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="legal_form"><?php esc_html_e('Rechtsform', 'woocommerce'); ?> <span class="required">*</span></label>
		<select name="legal_form" id="legal_form" class="woocommerce-Input woocommerce-Input--select input-select form-control" required>
			<option value="AG"><?php esc_html_e('AG', 'woocommerce'); ?></option>
			<option value="GmbH"><?php esc_html_e('GmbH', 'woocommerce'); ?></option>
			<option value="Genossenschaft"><?php esc_html_e('Genossenschaft', 'woocommerce'); ?></option>
			<option value="Verband"><?php esc_html_e('Verband', 'woocommerce'); ?></option>
			<option value="Einzelfirma"><?php esc_html_e('Einzelfirma', 'woocommerce'); ?></option>
			<option value="Andere"><?php esc_html_e('Andere', 'woocommerce'); ?></option>
		</select>
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="street"><?php esc_html_e('Strasse', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="street" id="street" value="<?php if (!empty($_POST['street'])) esc_attr_e($_POST['street']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="plz"><?php esc_html_e('Plz', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="plz" id="plz" value="<?php if (!empty($_POST['plz'])) esc_attr_e($_POST['plz']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="ort"><?php esc_html_e('Ort', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="ort" id="ort" value="<?php if (!empty($_POST['ort'])) esc_attr_e($_POST['ort']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="company_registration_number"><?php esc_html_e('Handelsregister-Nummer', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="company_registration_number" id="company_registration_number" value="<?php if (!empty($_POST['company_registration_number'])) esc_attr_e($_POST['company_registration_number']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="file_upload"><?php esc_html_e('Kopie Handelsregisterauszug', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="file" class="woocommerce-Input woocommerce-Input--file input-file form-control" name="file_upload" id="file_upload" accept=".pdf,.jpg,.png" required />
	</p>


	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="telephone"><?php esc_html_e('Telefon ( Hauptnummer )', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="telephone" id="telephone" value="<?php if (!empty($_POST['telephone'])) esc_attr_e($_POST['telephone']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="website"><?php esc_html_e('Website', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="website" id="website" value="<?php if (!empty($_POST['website'])) esc_attr_e($_POST['website']); ?>" required />
	</p>


	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="salutation"><?php esc_html_e('Anrede', 'woocommerce'); ?> <span class="required">*</span></label>
		<select name="salutation" id="salutation" class="woocommerce-Input woocommerce-Input--select input-select form-control" required>
			<option value="Herr"><?php esc_html_e('Herr', 'woocommerce'); ?></option>
			<option value="Frau"><?php esc_html_e('Frau', 'woocommerce'); ?></option>
			<option value="Divers/keine Anrede"><?php esc_html_e('Divers/keine Anrede', 'woocommerce'); ?></option>
		</select>
	</p>



	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="first_name"><?php esc_html_e('Vorname', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="first_name" id="first_name" value="<?php if (!empty($_POST['first_name'])) esc_attr_e($_POST['first_name']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="last_name"><?php esc_html_e('Name', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="last_name" id="last_name" value="<?php if (!empty($_POST['last_name'])) esc_attr_e($_POST['last_name']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="function"><?php esc_html_e('Funktion / Abteilung', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="function" id="function" value="<?php if (!empty($_POST['function'])) esc_attr_e($_POST['function']); ?>" required />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="direct_telephone"><?php esc_html_e('Telefon ( Direkt )', 'woocommerce'); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="direct_telephone" id="direct_telephone" value="<?php if (!empty($_POST['direct_telephone'])) esc_attr_e($_POST['direct_telephone']); ?>" required />
	</p>

<?php
}

// Save first and last name fields to user meta
add_action('woocommerce_created_customer', 'save_first_last_name_to_user_meta');
function save_first_last_name_to_user_meta($customer_id)
{

	if (isset($_POST['firma'])) {
		update_user_meta($customer_id, 'firma', sanitize_text_field($_POST['firma']));
	}

	if (isset($_POST['legal_form'])) {
		update_user_meta($customer_id, 'legal_form', sanitize_text_field($_POST['legal_form']));
	}

	if (isset($_POST['street'])) {
		update_user_meta($customer_id, 'street', sanitize_text_field($_POST['street']));
	}

	if (isset($_POST['plz'])) {
		update_user_meta($customer_id, 'plz', sanitize_text_field($_POST['plz']));
	}

	if (isset($_POST['ort'])) {
		update_user_meta($customer_id, 'ort', sanitize_text_field($_POST['ort']));
	}

	if (isset($_POST['company_registration_number'])) {
		update_user_meta($customer_id, 'company_registration_number', sanitize_text_field($_POST['company_registration_number']));
	}

	error_log("create customer: " . print_r($customer_id, true));

	if (isset($_FILES['file_upload']) && !empty($_FILES['file_upload']['name'])) {
		error_log("About to call wp_upload_bits");
		$upload = wp_upload_bits($_FILES['file_upload']['name'], null, file_get_contents($_FILES['file_upload']['tmp_name']));
		error_log("wp_upload_bits returned: " . print_r($upload, true));

		error_log("Upload URL: " . $upload['url']);

		if (!empty($upload['error'])) {
			throw new Exception($upload['error']);
		}

		$update_result = update_user_meta($customer_id, 'file_upload', $upload['url']);
		if ($update_result === false) {
			error_log("Error saving meta value: " . print_r(error_get_last(), true));
		}
	}

	error_log("save_first_last_name_to_user_meta called for customer_id: " . $customer_id);



	if (isset($_POST['telephone'])) {
		update_user_meta($customer_id, 'telephone', sanitize_text_field($_POST['telephone']));
	}

	if (isset($_POST['website'])) {
		update_user_meta($customer_id, 'website', sanitize_text_field($_POST['website']));
	}

	if (isset($_POST['salutation'])) {
		update_user_meta($customer_id, 'salutation', sanitize_text_field($_POST['salutation']));
	}

	if (isset($_POST['first_name'])) {
		update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['first_name']));
	}

	if (isset($_POST['last_name'])) {
		update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['last_name']));
	}

	if (isset($_POST['function'])) {
		update_user_meta($customer_id, 'function', sanitize_text_field($_POST['function']));
	}

	if (isset($_POST['direct_telephone'])) {
		update_user_meta($customer_id, 'direct_telephone', sanitize_text_field($_POST['direct_telephone']));
	}
}

// Add fields to user profile
add_action('show_user_profile', 'add_first_last_name_to_user_profile');
add_action('edit_user_profile', 'add_first_last_name_to_user_profile');
function add_first_last_name_to_user_profile($user)
{
?>
	<h3><?php esc_html_e('Additional Information', 'woocommerce'); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="firma"><?php esc_html_e('Firma', 'woocommerce'); ?></label></th>
			<td><input type="text" name="firma" id="firma" value="<?php echo esc_attr(get_the_author_meta('firma', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="legal_form"><?php esc_html_e('Rechtsform', 'woocommerce'); ?></label></th>
			<td>
				<select name="legal_form" id="legal_form" class="regular-text">
					<option value="AG" <?php selected(get_the_author_meta('legal_form', $user->ID), 'AG'); ?>><?php esc_html_e('AG', 'woocommerce'); ?></option>
					<option value="GmbH" <?php selected(get_the_author_meta('legal_form', $user->ID), 'GmbH'); ?>><?php esc_html_e('GmbH', 'woocommerce'); ?></option>
					<option value="Genossenschaft" <?php selected(get_the_author_meta('legal_form', $user->ID), 'Genossenschaft'); ?>><?php esc_html_e('Genossenschaft', 'woocommerce'); ?></option>
					<option value="Verband" <?php selected(get_the_author_meta('legal_form', $user->ID), 'Verband'); ?>><?php esc_html_e('Verband', 'woocommerce'); ?></option>
					<option value="Einzelfirma" <?php selected(get_the_author_meta('legal_form', $user->ID), 'Einzelfirma'); ?>><?php esc_html_e('Einzelfirma', 'woocommerce'); ?></option>
					<option value="Andere" <?php selected(get_the_author_meta('legal_form', $user->ID), 'Andere'); ?>><?php esc_html_e('Andere', 'woocommerce'); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="street"><?php esc_html_e('Strasse', 'woocommerce'); ?></label></th>
			<td><input type="text" name="street" id="street" value="<?php echo esc_attr(get_the_author_meta('street', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="plz"><?php esc_html_e('Plz', 'woocommerce'); ?></label></th>
			<td><input type="text" name="plz" id="plz" value="<?php echo esc_attr(get_the_author_meta('plz', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="ort"><?php esc_html_e('Ort', 'woocommerce'); ?></label></th>
			<td><input type="text" name="ort" id="ort" value="<?php echo esc_attr(get_the_author_meta('ort', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="company_registration_number"><?php esc_html_e('Handelsregister-Nummer', 'woocommerce'); ?></label></th>
			<td><input type="text" name="company_registration_number" id="company_registration_number" value="<?php echo esc_attr(get_the_author_meta('company_registration_number', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="file_upload"><?php esc_html_e('Kopie Handelsregisterauszug', 'woocommerce'); ?></label></th>
			<td>
				<?php $file_upload = esc_attr(get_the_author_meta('file_upload', $user->ID)); ?>
				<?php if (!empty($file_upload)) : ?>
					<a href="<?php echo $file_upload; ?>" target="_blank"><?php echo basename($file_upload); ?></a>
				<?php else : ?>
					<em><?php esc_html_e('No file uploaded', 'woocommerce'); ?></em>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label for="telephone"><?php esc_html_e('Telefon ( Hauptnummer )', 'woocommerce'); ?></label></th>
			<td><input type="text" name="telephone" id="telephone" value="<?php echo esc_attr(get_the_author_meta('telephone', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="website"><?php esc_html_e('Website', 'woocommerce'); ?></label></th>
			<td><input type="text" name="website" id="website" value="<?php echo esc_attr(get_the_author_meta('website', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="salutation"><?php esc_html_e('Anrede', 'woocommerce'); ?></label></th>
			<td><input type="text" name="salutation" id="salutation" value="<?php echo esc_attr(get_the_author_meta('salutation', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="first_name"><?php esc_html_e('Vorname', 'woocommerce'); ?></label></th>
			<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr(get_the_author_meta('first_name', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="last_name"><?php esc_html_e('Name', 'woocommerce'); ?></label></th>
			<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr(get_the_author_meta('last_name', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="function"><?php esc_html_e('Funktion / Abteilung', 'woocommerce'); ?></label></th>
			<td><input type="text" name="function" id="function" value="<?php echo esc_attr(get_the_author_meta('function', $user->ID)); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="direct_telephone"><?php esc_html_e('Telefon ( Direkt )', 'woocommerce'); ?></label></th>
			<td><input type="text" name="direct_telephone" id="direct_telephone" value="<?php echo esc_attr(get_the_author_meta('direct_telephone', $user->ID)); ?>" class="regular-text"></td>
		</tr>

	</table>
<?php
}

// Redirect non-logged-in users to the login page
add_action('template_redirect', 'redirect_non_logged_in_users_to_login');
function redirect_non_logged_in_users_to_login()
{
	if (!is_user_logged_in() && (is_checkout())) {
		// wp_safe_redirect( wp_login_url( get_permalink() ) );
		wp_safe_redirect(wc_get_account_endpoint_url('dashboard'));
		exit;
	}
}

function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');



// AJAX handler for loading the cart fragment
// add_action('wp_ajax_load_cart_fragment', 'load_cart_fragment');
// add_action('wp_ajax_nopriv_load_cart_fragment', 'load_cart_fragment');
// function load_cart_fragment() {
// 	error_log('load_cart_fragment() function called'); // Debug statement

//     ob_start();
//     woocommerce_mini_cart();
//     $cart_html = ob_get_clean();

//     // Debug statements
//     error_log('Cart Count: ' . WC()->cart->get_cart_contents_count());
//     error_log('Cart Total: ' . WC()->cart->get_cart_total());

//     wp_send_json_success(array(
//         'fragment'    => $cart_html,
//         'cart_count'  => WC()->cart->get_cart_contents_count(),
//         'cart_total'  => WC()->cart->get_cart_total()
//     ));
// }


// Add a custom filter to modify the excerpt ellipsis
function custom_excerpt_more($more)
{
	return '';
}
add_filter('excerpt_more', 'custom_excerpt_more');

function add_readonly_to_quantity_buttons()
{
	// Add readonly attribute to the "+" and "-" buttons
	add_filter('woocommerce_quantity_input_args', function ($args, $product) {
		$args['input_value'] = 1;
		$args['max_value'] = apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product);
		$args['min_value'] = apply_filters('woocommerce_quantity_input_min', 1, $product);
		$args['readonly'] = 'readonly';
		return $args;
	}, 10, 2);
}
add_action('woocommerce_single_product_add_to_cart', 'add_readonly_to_quantity_buttons');


function after_product_short_description_add_content()
{
	// Get the ACF field value
	$product_variation_title = get_field('product_variation_title');

	// Display the ACF field if it's not empty
	if (!empty($product_variation_title)) {
		echo '<div class="product-variation-title">';
		echo $product_variation_title;
		echo '</div>';
	}
}

add_action('woocommerce_single_product_summary', 'after_product_short_description_add_content', 22);


function enqueue_admin_bar_styles()
{
	if (is_admin_bar_showing() && current_user_can('administrator')) {
		wp_enqueue_style('admin-bar-styles', get_stylesheet_directory_uri() . '/css/admin-bar-styles.css');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_admin_bar_styles');


// Redirect woocommerce user after successful login
// function custom_login_redirect( $redirect, $user ) {
//     $redirect = home_url( '/mein-konto/' );
//     return $redirect;
// }
// add_filter( 'woocommerce_login_redirect', 'custom_login_redirect', 10, 2 );
