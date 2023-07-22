<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>

<ul class="woocommerce-success woocommerce-info woocommerce-msg-info" role="alert">
	<?php foreach ( $notices as $notice ) : ?>
		<li <?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
			<?php
			$success_message = wp_kses_post( $notice['notice'] );
			$success_message = str_replace( 'Success:', '', $success_message );
			$success_message = trim( $success_message );
			?>
			<p class="wc-custom-msg-title">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/wc-custom-success-icon.svg' ); ?>" alt="Success Icon" class="success-icon">
				<strong><?php echo esc_html__( 'Success:', 'understrap-child' ); ?></strong>
			</p>
			<p class="wc-custom-msg"><?php echo $success_message; ?></p>
			<button class="woocommerce-success-close" type="button">×</button>
		</li>
	<?php endforeach; ?>
</ul>

