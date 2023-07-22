<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function() {
	$version = '1.0.1';
	wp_enqueue_style( 'woocommerce_variations_radio_buttons-css', get_stylesheet_directory_uri() . '/lib/woocommerce_variations_radio_buttons/css/woocommerce_variations_radio_buttons.css', array(), $version );
	wp_enqueue_script('woocommerce_variations_radio_buttons-js', get_stylesheet_directory_uri() . '/lib/woocommerce_variations_radio_buttons/js/woocommerce_variations_radio_buttons.js', array('jquery'), $version, true );
});
	