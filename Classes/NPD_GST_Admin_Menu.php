<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

class NPD_GST_Admin_Menu extends NPD_GST_Main {

    /**
     * Initialize all the hooks
     */
    public function __construct(){

        //Add submenu to WooCommerce
        add_action('admin_menu', array( $this, 'render_settings' ) );

    }

    /**
     * Tab settings, fields and file view
     */
    public function render_settings(){

        add_submenu_page(
            'woocommerce',
            'GST Settings',
            'GST Settings',
            'manage_woocommerce',
            'npd-gst-settings',
            function(){

                //Prepare the fields for saving on post request
                $this->post_data( $this->general_settings() );
                $this->post_data( $this->gst_settings() );

                //Define the fields
                $tabs = [
                    'General' => $this->general_settings(),
                    'GST Settings' => $this->gst_settings()
                ];

                //Include the template
                include_once NPD_GST_DIR_PATH . 'views/admin/settings.php';

            }
            //'55.7'
        );

    }

    /**
     * General tab settings fields
     * @return array
     */
    public function general_settings(){

        return [
            [
                'type' => 'checkbox',
                'label' => 'Enable GST',
                'name' => 'enable_gst',
                'description' => 'Enable to display and include GST rates on the cart, checkout and invoices.'
            ],
            [
                'type' => 'text',
                'label' => 'Event Processing Fee Rate (%)',
                'name' => 'event_processing_fee_rate',
                'description' => '(Leave empty to disable) The processing fee rate for events added to the cart. Equation: ((Total cart contents + Shipping fee) * Processing Fee Rate ) + 0.30'
            ],
            /*
            [
                'type' => 'checkbox',
                'label' => 'Send PDF Invoice to Customer',
                'name' => 'enable_pdf_invoice',
                'description' => 'Enabling this option will send a PDF Invoice to the customer after checkout.',
                'dependency' => [
                    'value' => $this->has_dependency('enable_pdf_invoice'),
                    'description' => 'The plugin <a href="https://wordpress.org/plugins/woocommerce-pdf-invoices-packing-slips/" target="_blank">WooCommerce PDF Invoices & Packing Slips</a> must be activated to use this option.'
                ]
            ],
            */
            /*
            'checkbox' => [
                'label' => 'Include QR Code On Invoices',
                'name' => 'enable_qr_code',
                'description' => 'Enable to display the QR code of the invoices.'
            ],
            */
            [
                'type' => 'submit',
                'name' => 'general_save_settings',
                'value' => 'Save General Settings'
            ]
        ];

    }

    /**
     * GST tab settings fields
     * @return array
     */
    public function gst_settings(){

        return [
            [
                'type' => 'text',
                'label' => 'GSTIN Number',
                'name' => 'gstin_number',
                'description' => 'The GSTIN Number to be displayed on invoices.'
            ],
            [
                'type' => 'text',
                'label' => 'GST Rate (%)',
                'name' => 'gst_rate',
                'description' => 'The GST tax rate to be included in the cart, checkout details and order invoices. The GST rate is automatically included on each product price.'
            ],
            [
                'type' => 'submit',
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
    public function render_fields(array $fields = []){

        //Do not render anything at this point
        if(empty($fields)){
            return;
        }

        $content = '';

        //Begin iterations
        foreach($fields as $field){

            //Switch between key types
            switch($field['type']){
                case 'text':
                    $content .= ($field['dependency']['value']) ? '<div class="form_group has_dependency">' : '<div class="form_group">';
                    $content .= '<label class="field">' . $field['label'] . '</label>';
                    $content .= '<input type="text" name="' . $field['name'] . '" value="' . $this->get_value($field['name']) . '"/>';
                    $content .= ( (!empty($field['description'])) ? '<br><span class="description normal_desc">' . $field['description'] . '</span>' : '' );
                    $content .= ($field['dependency']['value']) ? '<span class="description warning_desc">' . $field['dependency']['description'] . '</span>' : '';
                    $content .= '</div>';
                    break;
                case 'checkbox':
                    $content .= ($field['dependency']['value']) ? '<div class="form_group has_dependency">' : '<div class="form_group">';
                    $content .= '<input type="checkbox" name="' . $field['name'] . '" ' . ( (!empty($this->get_value($field['name']))) ? 'checked' : '' ) . '/>';
                    $content .= '<label>' . $field['label'] . '</label>';
                    $content .= ( (!empty($field['description'])) ? '<br><span class="description normal_desc">' . $field['description'] . '</span>' : '' );
                    $content .= ($field['dependency']['value']) ? '<span class="description warning_desc">' . $field['dependency']['description'] . '</span>' : '';
                    $content .= '</div>';
                    break;
                case 'submit':
                    $content .= '<div class="form_group">';
                    $content .= '<input type="submit" class="button-primary" name="' . $field['name'] . '" value="' . $field['value'] . '"/>';
                    $content .= '</div>';
                    break;

            }

        }

        return $content;

    }

    /**
     * Method to save data from post requests
     * @param array the fields array
     * @return void
     */
    public function post_data(array $fields = []){

        //Quick check
        if(empty($fields)){
            return;
        }

        //Get the submit name field
        $submit_field = '';
        foreach($fields as $field){
            if($field['type'] == 'submit'){
                $submit_field = $field['name'];
                break;
            }
        }
        
        //Check the submit name field
        if(!empty($submit_field) && isset($_POST[$submit_field]) && !empty($fields)){

            //Loop through each field and save it
            foreach($fields as $field){
                if($field['type'] != 'submit'){
                    $this->set_value($field['name'], $_POST[$field['name']]);
                }
            }
            
            //Print success notice
            echo '<div id="npd_gst_notice_success" class="notice notice-success"><p>Options Saved!</p></div>';

        }

    }

}
new NPD_GST_Admin_Menu();