<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Add metadata as part of the ticket product details in the cart and checkout page
add_filter('woocommerce_get_item_data', function($item_data, $cart_item){

    //Check if GST is enabled and rate is set
    if($this->get_value('enable_gst') == 'on' && floatval($this->get_value('gst_rate')) > 0){
        
        $item_data[] = array(
			'key' => 'GST',
			'value' => wc_price(
                $cart_item['line_subtotal'] * (
                    floatval($this->get_value('gst_rate')) / 100
                )
            )
        );

	}
    return $item_data;
    
}, 10, 2);