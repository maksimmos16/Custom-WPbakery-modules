<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
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

<ul class="woocommerce-error" role="alert">
    <?php foreach ( $notices as $notice ) : ?>
        <li<?php echo wc_get_notice_data_attr( $notice ); ?>>
            <?php
            $error_message = wp_kses_post( $notice['notice'] );
            $error_message = str_replace( 'Error:', '', $error_message );
            $error_message = trim( $error_message );
            ?>
            <p class="wc-custom-msg-title">
                <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/wc-custom-error-icon.svg' ); ?>" alt="Error Icon" class="error-icon">
				<strong><?php echo esc_html__( 'Error:', 'understrap-child' ); ?></strong>
            </p>
			<p class="wc-custom-msg"><?php echo $error_message; ?></p>
            <button class="woocommerce-error-close" type="button">×</button>
        </li>
    <?php endforeach; ?>
</ul>



