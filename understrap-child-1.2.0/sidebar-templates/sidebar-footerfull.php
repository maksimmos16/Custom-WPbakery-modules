<?php
/**
 * Sidebar setup for footer full
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

?>

<?php if ( is_active_sidebar( 'footerfull' ) ) : ?>
	
	<!-- ******************* The Footer Full-width Widget Area ******************* -->
	

	<div class="wrapper" id="wrapper-footer-full" role="complementary">
		<!-- <div class="footer-top-image"></div> -->
		<div class="<?php echo esc_attr( $container ); ?>" id="footer-full-content" tabindex="-1">

			<div class="row">

				<?php dynamic_sidebar( 'footerfull' ); ?>

				<div class="footer-widget-areas-bottom">
					<div class="footer-widget-bottom">
						<?php dynamic_sidebar( 'footer-widget-bottom' ); ?>
					</div>
					<div class="footer-widget-bottom-second">
						<?php dynamic_sidebar( 'footer-widget-bottom-2' ); ?>
					</div>
				</div>	
			</div>

		</div>

	</div><!-- #wrapper-footer-full -->




	<?php
endif;
