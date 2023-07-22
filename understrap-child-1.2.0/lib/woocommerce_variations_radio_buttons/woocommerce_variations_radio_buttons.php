<?php

add_action('woocommerce_before_variations_form',function(){
	echo '<span id="variations_radio_buttons_data" 
				data-currency="'.get_woocommerce_currency_symbol().'"
				data-instock="'.__( 'In stock', 'woocommerce' ).'"
				data-outofstock="'.__( 'Out of stock', 'woocommerce' ).'"				
			>		
		</span>';
});




