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
            'General' => self::general_settings(),
            'GST' => self::gst_settings()
        ];
        include_once NPD_GST_DIR_PATH . 'views/settings.php';
    }

    /**
     * General tab settings fields
     * @return array
     */
    public static function general_settings(){

        return [
            'checkbox' => [
                'label' => 'Include QR Code On Invoices',
                'name' => 'enable_qr_code',
                'value' => '',
                'description' => 'Enable to display the QR code of the invoices.'
            ],
            'submit' => [
                'name' => 'general_save_settings',
                'value' => 'Save General Settings'
            ]
        ];

    }

    /**
     * GST tab settings fields
     * @return array
     */
    public static function gst_settings(){

        return [
            'text' => [
                'label' => 'GSTIN Number',
                'name' => 'gstin_number',
                'value' => '',
                'description' => 'The GSTIN Number to be displayed on invoices.'
            ],
            'text' => [
                'label' => 'GST Rate',
                'name' => 'gst_rate',
                'value' => '',
                'description' => 'The GST tax rate to be included in the cart, checkout details and order invoices.'
            ],
            'submit' => [
                'name' => 'gst_save_settings',
                'value' => 'Save GST Settings'
            ]
        ];

    }

    /**
     * Method to render the form fields
     * @param array
     * @return string html contents
     */
    public static function render_fields(array $fields = []){

        //Do not render anything at this point
        if(empty($fields)){
            return;
        }

        $content = '';

        //Begin iterations
        foreach($fields as $key => $field){

            //Switch between key types
            switch($key){
                case 'text':
                    $content .= '<label>' . $field['label'] . '</label><br>';
                    $content .= '<input type="text" name="' . $field['name'] . '" value="' . $field['value'] . '"/>
                        ' . ( (!empty($field['description'])) ? '<span class="description">' . $field['description'] . '</spa>' : '' ) . '
                    <br>';
                    break;
                case 'checkbox':
                    $content .= '<label>' . $field['label'] . '</label><br>';
                    $content .= '<input type="checkbox" name="' . $field['name'] . '" ' . ( (!empty($field['value'])) ? 'checked' : '' ) . '/>
                        ' . ( (!empty($field['description'])) ? '<span class="description">' . $field['description'] . '</spa>' : '' ) . '
                    <br>';
                    break;
                case 'submit':
                    $content .= '<input type="submit" class="button-primary" name="' . $field['name'] . '" value="' . $field['value'] . '"/>';
                    break;

            }

        }

        return $content;

    }

}
NPD_GST_Admin_Menu::init();