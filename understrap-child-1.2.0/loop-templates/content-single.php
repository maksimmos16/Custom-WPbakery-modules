<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<div class="entry-meta">
			<div class="row">
				<div class="col-md-1 d-none d-md-block"></div>
					<div class="col-md-10">
						<?php echo "Posted on " . get_the_date('d.m.Y'); ?>
					</div>
				<div class="col-md-1 d-none d-md-block"></div>
			</div>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content();


		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

	<div class="row">
		<div class="col-md-1 d-none d-md-block"></div>
			<div class="col-md-10">
			<?php understrap_entry_footer(); ?>
			</div>
		<div class="col-md-1 d-none d-md-block"></div>
	</div>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
