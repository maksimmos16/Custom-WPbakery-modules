<?php

/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
?>

<div class="top-header-wrapper">
	<div class="container">
		<div class="row top-header">
			<div class="col-lg-4 col-md-5 col-3 header-search-wrapper d-flex align-items-center">

				<button type="submit" class="mobile-search-toggle">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header-search-icon.svg" alt="Search" />
				</button>



				<div class="header-search-bar">
					<?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
				</div>

				<a href="<?php echo home_url('/cart/'); ?>" class="header-cart-small header-cart-mob-dev">
					<?php if (is_active_sidebar('header-cart-widget')) : ?>
						<?php dynamic_sidebar('header-cart-widget'); ?>
					<?php endif; ?>
				</a>
			</div>
			<div class="col-lg-4 col-md-2 col-6 header-logo-wrapper d-flex justify-content-center align-items-center">
				<?php if (has_custom_logo()) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<h1><?php bloginfo('name'); ?></h1>
					<p><?php bloginfo('description'); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-lg-4 col-md-5 col-3 header-menu-wrapper d-flex justify-content-end align-items-center">
				<div class="top-header-cart-login">
					<?php if (is_user_logged_in()) : ?>
						<a class="btn btn-secondary ms-2 header-register-button" href="<?php echo esc_url(wc_get_account_endpoint_url('')); ?>"><?php _e('Mein Konto', 'understrap-child'); ?></a>
					<?php else : ?>
						<a class="btn btn-secondary ms-2 header-register-button" href="<?php echo esc_url(wc_get_account_endpoint_url('')); ?>"><?php _e('Kunde werden', 'understrap-child'); ?></a>
					<?php endif; ?>
					<?php
					global $woocommerce;
					$cart_url = $woocommerce->cart->get_cart_url();
					$cart_items_count = $woocommerce->cart->get_cart_contents_count();
					$cart_total = $woocommerce->cart->get_cart_total();
					?>

					<?php if (is_user_logged_in()) { ?>
						<a class="btn btn-secondary ms-2 header-login-button" href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Logout', 'understrap-child'); ?></a>
					<?php } else { ?>
						<a class="btn btn-secondary ms-2 header-logout-button" href="<?php echo home_url('/login-page'); ?>"><?php _e('Login', 'understrap-child'); ?></a>
					<?php } ?>

					<a href="<?php echo home_url('/cart/'); ?>" class="header-cart-small">
						<?php if (is_active_sidebar('header-cart-widget')) : ?>
							<?php dynamic_sidebar('header-cart-widget'); ?>
						<?php endif; ?>
					</a>

					<a href="<?php echo home_url('/cart/'); ?>" class="btn btn-primary header-cart">
						<?php if (is_active_sidebar('header-cart-widget')) : ?>
							<?php dynamic_sidebar('header-cart-widget'); ?>
						<?php endif; ?>
					</a>
					<div id="popup-cart-container">
						<div id="popup-cart-products"></div>
						<div id="popup-cart-total"></div>
						<div class="popup-cart-btn-wrapper">
							<a class="popup-cart-btn" href="<?php echo home_url('/cart/'); ?>"><?php _e('Cart', 'understrap-child'); ?></a>
						</div>
					</div>
				</div>
				
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'understrap'); ?>" id="mobile-menu-btn">
					<img class="mobile-menu-icon active" src="<?php echo get_stylesheet_directory_uri(); ?>/images/mobile-menu-btn2.svg" alt="Mobile menu" />
					<img class="mobile-menu-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/mobile-menu-btn3.svg" alt="Mobile menu" />
				</button>



			</div>
		</div>
	</div>
</div>


<div class="container-fluid mobile-search-wrapper">
	<div class="mobile-search-form">
		<?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
	</div>
</div>




<nav id="main-nav" class="navbar navbar-expand-md navbar-dark bg-primary" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e('Main Navigation', 'understrap'); ?>
	</h2>


	<!-- The WordPress Menu goes here -->
	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'container_class' => 'collapse navbar-collapse',
			'container_id'    => 'navbarNavDropdown',
			'menu_class'      => 'navbar-nav ms-auto',
			'fallback_cb'     => '',
			'menu_id'         => 'main-menu',
			'depth'           => 3,
			'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
		)
	);
	?>

	<div class="mobile-menu-html">

		<p class="mobile-reg-link">
		<?php if (is_user_logged_in()) : ?>
			<a class="header-register-button" href="<?php echo esc_url(wc_get_account_endpoint_url('')); ?>"><?php _e('Mein Konto', 'understrap-child'); ?></a>
		<?php else : ?>
			<a class="header-register-button" href="<?php echo esc_url(wc_get_account_endpoint_url('')); ?>"><?php _e('Kunde werden', 'understrap-child'); ?></a>
		<?php endif; ?>
		</p>

		<?php if (is_user_logged_in()) { ?>
			<a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Logout', 'understrap-child'); ?></a>
		<?php } else { ?>
			<a href="<?php echo home_url('/login-page'); ?>"><?php _e('Login', 'understrap-child'); ?></a>
		<?php } ?>
	</div>

</nav><!-- #main-nav -->

<div class="bottom-header-wrapper">
	<div class="container">
		<nav class="navbar navbar-expand-md" aria-labelledby="main-nav-label">

			<h2 id="main-nav-label" class="screen-reader-text">
				<?php esc_html_e('Main Navigation', 'understrap'); ?>
			</h2>



			<!-- The WordPress Menu goes here -->
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'navbarNavDropdown',
					'menu_class'      => 'navbar-nav ms-auto',
					'fallback_cb'     => '',
					'menu_id'         => 'main-menu',
					'depth'           => 3,
					'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
				)
			);
			?>


		</nav><!-- #main-nav -->
	</div>
</div>

