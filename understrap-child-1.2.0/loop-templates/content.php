<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php if (has_post_thumbnail()) : ?>
		<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'post-image-size')[0]; ?>" alt="<?php the_title_attribute(); ?>" />
	<?php endif; ?>

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php echo "Posted on " . get_the_date('d.m.Y'); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_excerpt();
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	

</article><!-- #post-<?php the_ID(); ?> -->
