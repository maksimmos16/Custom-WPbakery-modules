<?php

/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container = get_theme_mod('understrap_container_type');
?>

<div class="wrapper" id="single-wrapper">

	<div class="row">
		<div class="col-md-12 wc-shop-img-wrapper">
			<div class="wc-shop-img single-post-image-text" style="background-image: url(<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'post-image-size')[0]; ?>);">
				<div class="container">
					<div class="row">
						<div class="col-md-6 text-start">
							<h2><?php the_title(); ?></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part('global-templates/left-sidebar-check');
			?>

			<main class="site-main" id="main">

				<?php
				while (have_posts()) {
					the_post();
					get_template_part('loop-templates/content', 'single');
				?>
					<div class="row">
						<div class="col-md-1 d-none d-md-block"></div>
						<div class="col-md-10">
							<?php understrap_post_nav(); ?>
						</div>
						<div class="col-md-1 d-none d-md-block"></div>
					</div>
				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) {
						comments_template();
					}
				}
				?>


			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part('global-templates/right-sidebar-check');
			?>

		</div><!-- .row -->

		<div class="row product-info-wrapper">
			<div class="col-12 col-sm-6">
				<h3><?php esc_html_e('Top Products', 'understrap-child'); ?></h3>
			</div>
			<div class="col-12 col-sm-6">
				<a class="product-info-btn single-post-products" href="<?php echo esc_url( home_url( '/shop/?orderby=popularity' ) ); ?>">
					<?php esc_html_e('All Products', 'understrap-child'); ?>
				</a>
			</div>
		</div>
		<?php echo do_shortcode('[my_custom_bestselling_products]'); ?>


	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
