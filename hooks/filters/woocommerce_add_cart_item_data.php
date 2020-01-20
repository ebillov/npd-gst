<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Store the fee as part of the cart item data session
add_filter('woocommerce_add_cart_item_data', function($cart_item, $product_id, $variation_id){

    //Get product from variation id
    $variable_product = wc_get_product($variation_id);

    //Get the price
    $price = $variable_product->get_price();

    //Get the GST settings
    $gst_enabled = $this->get_value('enable_gst');
    $gst_rate = floatval($this->get_value('gst_rate'));

    //Set default value
    $gst_calculated   = '';

    if(!empty($variation_id) && $gst_enabled == 'on' && $gst_rate > 0){
        if(get_post_meta($variation_id, 'gst_value', true) == 1){
            $gst_calculated = $price - $price / (1 + ( $gst_rate / 100));
        } elseif(get_post_meta($variation_id, 'gst_exclusive', true)){
            $gst_calculated = $price * (1 + ( $gst_rate / 100)) - $price;
        }
    }

    //Define the meta key value
    if(!empty($gst_calculated)){
        $cart_item['gst_calculated'] = $gst_calculated;
    }

    return $cart_item;

}, 99, 3);