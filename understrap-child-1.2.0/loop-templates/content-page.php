<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php
	if ( is_singular() && get_post_type() === 'post' ) {
		the_title(
			'<header class="entry-header"><h1 class="entry-title">',
			'</h1></header><!-- .entry-header -->'
		);
	}
	

	echo get_the_post_thumbnail( $post->ID, 'large' );
	?>

	<div class="entry-content">

		<?php
		the_content();
		understrap_link_pages();
		?>

		<?php
		if (is_page(5)) { // Check if current page is homepage
			if (wp_is_mobile()) { // If mobile, show metaslider shortcode
				echo do_shortcode('[metaslider id="150"]');
			} else { // If desktop, show content of Home logos
				 $post = get_post(146);
				 echo apply_filters('the_content', $post->post_content);
				//  echo do_shortcode('[metaslider id="150"]');
			}
		}
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
