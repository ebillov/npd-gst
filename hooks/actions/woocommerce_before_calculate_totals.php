<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

add_action('woocommerce_before_calculate_totals', function($cart_obj){

    if(is_admin() && !defined('DOING_AJAX')){
        return;
    }

    //Iterate through each cart item
    foreach ($cart_obj->get_cart() as $key => $value){

        //Check if GST is enabled and rate is set
        if($this->get_value('enable_gst') == 'on' && floatval($this->get_value('gst_rate')) > 0 && isset($value['variation_id'])){
            
            if(get_post_meta($value['variation_id'], 'gst_value', true) == 1){
                $price = $value['data']->get_price() / (1 + (floatval($this->get_value('gst_rate')) / 100));
                $value['data']->set_price(($price));
            }

        }

    }

}, 10, 1);