<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

add_action('woocommerce_cart_calculate_fees', function(){

    global $woocommerce;

    if(is_admin() && !defined('DOING_AJAX')){
        return;
    }

    $cart_total_price = $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total;
    $percentage = floatval($this->get_value('event_processing_fee_rate')) / 100;

    if($cart_total_price != 0 && $percentage > 0){
        $surcharge = ($cart_total_price) * $percentage + 0.30;
        $woocommerce->cart->add_fee('Payment Processing Fee', $surcharge, true, '');
    }

    $total_gst = 0;

    //Iterate through each cart item
    foreach($woocommerce->cart->cart_contents as $key => $value){

        //Check if GST is enabled and rate is set
        if($this->get_value('enable_gst') == 'on' && floatval($this->get_value('gst_rate')) > 0 && isset($value['variation_id'])){

            if(get_post_meta($value['variation_id'], 'gst_value', true) == 1){
                $gst = $value['data']->get_price() * (floatval($this->get_value('gst_rate')) / 100);
                $total_gst += $gst * $value['quantity'];
            } elseif (get_post_meta($value['variation_id'], 'gst_exclusive', true) == 1) {
                $gst = $value['data']->get_price() * (1 + (floatval($this->get_value('gst_rate')) / 100)) - $value['data']->get_price();
                $total_gst += $gst*$value['quantity'];
            }

        }
        
    }

    if($total_gst != 0){
        $woocommerce->cart->add_fee('GST Total', $total_gst, true, '');
    }

});