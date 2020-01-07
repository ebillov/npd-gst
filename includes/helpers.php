<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

/**
 * Helper to send an email
 */
if(!function_exists('gst_pdf_send_mail')){
    function gst_pdf_send_mail( $params = array() ) {
        if ( empty( $params['to'] ) || !is_email( $params['to'] ) ) return;
        $to = $params['to'];
        $subject = isset( $params['subject'] ) ? $params['subject'] : __( 'QR Code', 'nwpd' );
        $body = isset( $params['body'] ) ? $params['body'] : '';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        if ( isset( $params['headers'] ) && is_array( $params['headers'] ) ) {
            $headers = array_merge( $headers, $params['headers'] );
        }
        if ( wp_mail( $to, $subject, $body, $headers ) ) {
            // Success!
        }
    }
}

/**
 * Sends the email to admin
 */
if(!function_exists('gst_pdf_send_to_admin')){
    function gst_pdf_send_to_admin() {
        $admin_email = get_option('admin_email', null);
        if(empty($admin_email)){
            return;
        }

        // Send
        gst_pdf_send_mail( array(
            'to' => $admin_email,
            'subject' => 'ABC QR Code - Admin',
            'body' => 'Example body!',
        ) );
    }
}

/**
 * Sends email to the customer
 */
if(!function_exists('gst_pdf_send_to_buyer')){
    function gst_pdf_send_to_buyer() {
        $buyer_mail = get_option('admin_email', null);
        if(empty($buyer_mail)){
            return;
        }

        // Send
        gst_pdf_send_mail( array(
            'to' => $buyer_mail,
            'subject' => 'ABC QR Code - Buyer',
            'body' => 'Example body!',
        ) );
    }
}