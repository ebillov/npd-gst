<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

class NPD_GST_Admin_Menu {

    /**
     * Initialize all the hooks
     */
    public static function init(){

        //Add submenu to WooCommerce
        add_submenu_page(
            'woocommerce',
            'GST Settings',
            'GST',
            'manage_woocommerce',
            'npd-gst-settings',
            array(self, 'render_settings')
            //'55.7'
        );

    }

    /**
     * Tab settings, fields and file view
     */
    public static function render_settings(){
        $tabs = [
            'General',
            'GST',
            'PDF Invoice'
        ];
        
    }

    /**
     * General tab settings fields
     * @return array
     */
    public static function general(){

        return [
            'text' => [
                'label' => ''
            ]
        ];

    }

}
GP_Admin_Menu::init();