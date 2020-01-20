<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Add order line to product meta data
add_action('woocommerce_add_order_item_meta', function($item_id, $values){

    //Quick check
    if(!empty($values['gst_calculated']) && $this->get_value('enable_gst') == 'on'){

        //Get the GST value
        $gst_calculated  = $values['gst_calculated'] * $values['quantity'];

        //Add the order item
        wc_add_order_item_meta(
            $item_id,
            'GST',
            get_woocommerce_currency_symbol() . number_format(
                $gst_calculated,
                2
            )
        );

    }

}, 12, 2);