<?php

/**
 * The template for displaying search results pages
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');

?>

<?php
// Get the ID of the current shop page
$page_id = 349;
// Get the field value for the shop page image
$search_result_page_image = get_field('search_result_page_image', $page_id);
$search_result_page_title_image = get_field('search_result_page_title_image', $page_id);
$search_result_image_text = get_field('search_result_image_text', $page_id);
?>

<div class="wrapper" id="search-wrapper">

	<div class="row">
		<div class="col-md-12 wc-shop-img-wrapper">
			<div class="wc-shop-img" style="background-image: url('<?php echo esc_url($search_result_page_image); ?>')">
				<div class="container">
					<div class="row">
						<div class="col-md-6 text-start">
							<h2><?php echo ($search_result_page_title_image); ?></h2>
							<p><?php echo ($search_result_image_text); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="<?php echo esc_attr($container); ?> search-result-wrapper" id="content" tabindex="-1">

		<div class="row">
			<div class="col-md-1 d-none d-md-block"></div>
			<div class="col-md-10">
			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part('global-templates/left-sidebar-check');
			?>

			<main class="site-main" id="main">

				<?php if (have_posts()) : ?>

					<header class="page-header">
						<h1 class="page-title search-result-title">
							<?php
							$search_query = get_search_query();
							$search_results_count = $wp_query->found_posts;
							printf(
								/* translators: 1: query term, 2: search results count */
								esc_html__('Search Results for: %1$s', 'understrap-child'),
								'<span>' . $search_query . '</span>'
							);
							?>
						</h1>
						<p class="search-results-count">
							<?php
							printf(
								/* translators: search results count */
								esc_html__('Find %d results', 'understrap-child'),
								$search_results_count
							);
							?>
						</p>
					</header><!-- .page-header -->


					<div class="search-results">

						<?php while (have_posts()) : the_post(); ?>

							<?php if ('product' === get_post_type()) : ?>
								<div class="search-result-item">
									<div class="search-result-product-image">
										<?php
										if (has_post_thumbnail()) {
											the_post_thumbnail('full');
										}
										?>
									</div>
									<div class="search-result-product-info">
										<div class="search-result-product-row sr-price-cart-mobile">
											<div class="search-result-product-category sr-product-cat-pc">
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
												<div class="search-result-product-name">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</div>
											</div>
											<div class="search-result-product-price">

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
											<div class="search-result-add-to-cart">
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
										<div class="search-result-product-row ">
											<div class="search-result-product-category sr-product-cat-mobile">
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
												<div class="search-result-product-name">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</div>
											</div>
										</div>

										<div class="search-result-product-row">
											<div class="product-description">
												<?php
												$excerpt = get_the_excerpt();
												$excerpt = str_replace('[...]', '', $excerpt);
												echo $excerpt;
												?>
											</div>
										</div>
										<div class="search-result-product-row search-pr-link">
											<div class="search-result-product-link">
												<a href="<?php the_permalink(); ?>"><?php _e('View Product', 'woocommerce'); ?></a>
											</div>
										</div>
									</div>
								</div>
							<?php else : ?>
								<div class="search-result-item">
									<?php if (has_post_thumbnail()) : ?>
										<div class="search-result-product-image">
											<?php the_post_thumbnail(); ?>
										</div>
									<?php endif; ?>
									<div class="search-result-product-info">
										<div class="search-result-product-row">
											<div class="search-result-no-product-name">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</div>
										</div>
										<div class="search-result-product-row">
											<div class="product-description">
												<div class="search-result-product-row">
													<div class="product-description">
														<?php
														$excerpt = get_the_excerpt();
														$words = explode(' ', $excerpt);
														$word_count = count($words);
														$custom_message = "No description available.";

														// Define the desired minimum word count
														$minimum_words = 12;

														if (empty($excerpt) || $word_count < $minimum_words) {
															echo $custom_message;
														} else {
															echo $excerpt;
														}
														?>
													</div>
												</div>
											</div>
										</div>
										<div class="search-result-product-row search-pr-link">
											<div class="search-result-product-link">
												<a href="<?php the_permalink(); ?>"><?php _e('Read More', 'your-theme-textdomain'); ?></a>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endwhile; ?>

					</div>
				<?php else : ?>
					<p><?php _e('No results found.', 'understrap-child'); ?></p>
				<?php endif; ?>

			</main>

			<?php
			// Display the pagination component.
			understrap_pagination();

			// Do the right sidebar check and close div#primary.
			get_template_part('global-templates/right-sidebar-check');
			?>
			</div>
			<div class="col-md-1 d-none d-md-block"></div>
		</div><!-- .row -->

		<div>

			<?php
			if (is_search()) {
				$page_id = 349;

				// Retrieve the content of the page with ID 100
				$page_query = new WP_Query(array('page_id' => $page_id));

				// Check if the page query has posts
				if ($page_query->have_posts()) {
					while ($page_query->have_posts()) {
						$page_query->the_post();

						// Display the content of the page
						the_content();
					}
				}

				// Restore the original post data
				wp_reset_postdata();
			}
			?>
		</div><!-- #content -->

	</div><!-- #search-wrapper -->



	<?php
	get_footer();
