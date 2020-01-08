<?php
/**
* Plugin Name: Network PD GST
* Plugin URI: https://virson.wordpress.com/
* Description: A wordpress WooCommerce extension plugin to implement GST taxes and Order Invoices in PDF sent to customers for Network PD site.
* Version: 0.0.1a
* Author: Virson Ebillo
* Author URI: https://virson.wordpress.com/
*/

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Deactivate if WooCommerce Core plugin is not activated
if(function_exists('is_plugin_active')){

	//Check if WooCommerce Core plugin is activated
	if( !is_plugin_active('woocommerce/woocommerce.php') ){
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die('Error on activating <b>WooCommerce GST & PDF Invoices</b> plugin:<br />Please enable/activate <b>WooCommerce</b> plugin before using this plugin. <a href="' . admin_url() . '">Go back.</a>');
    }
    
}

//Define our constants
define('NPD_GST_DIR_URL', preg_replace('/\s+/', '', plugin_dir_url(__FILE__)));
define('NPD_GST_DIR_PATH', preg_replace('/\s+/', '', plugin_dir_path(__FILE__)));

//Include the main class.
if( !class_exists( 'NPD_GST_Main', false ) ) {
	include_once NPD_GST_DIR_PATH . 'Classes/NPD_GST_Main.php';
}

NPD_GST_Main::instance();