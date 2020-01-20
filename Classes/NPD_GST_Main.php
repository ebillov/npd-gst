<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

class NPD_GST_Main {

    //Version
    public $version = '0.0.1a';

    //Default option string
    private $option_prefix = 'npd_gst_';

	//A single instance of the class DC_Main
    protected static $_instance = null;

    /**
     * Define option dependencies
     * This is where the options are marked with a warning message when a certain dependency plugin is not active
     * @var array where array key is the form name field and value is the main plugin file path to be checked with is_plugin_active()
     */
    public $option_dependencies = [
        'enable_pdf_invoice' => 'woocommerce-pdf-invoices-packing-slips/woocommerce-pdf-invoices-packingslips.php'
    ];
	
	/**
     * GST_PDF_Main Instance ensuring that only 1 instance of the class is loaded
     */
	final public static function instance(){
		if(is_null(self::$_instance)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
     * Cloning is forbidden
     */
	public function __clone() {
		$error = new WP_Error('forbidden', 'Cloning is forbidden.');
		return $error->get_error_message();
	}
	
	/**
     * Unserializing instances of this class is forbidden
     */
	public function __wakeup() {
		$error = new WP_Error('forbidden', 'Unserializing instances of this class is forbidden.');
		return $error->get_error_message();
	}

    /**
     * Our constructor
     */
    public function __construct(){
        $this->includes();
    }

    /**
     * Method to define included files
     */
    public function includes(){

        //Helpers
        //include_once NPD_GST_DIR_PATH . 'includes/helpers.php';

        //libraries
        //include_once NPD_GST_DIR_PATH . 'lib/phpqrcode/qrlib.php';

        //Classes
        //include_once NPD_GST_DIR_PATH . 'Classes/QR_Code.php';
        include_once NPD_GST_DIR_PATH . 'Classes/NPD_GST_Admin_Menu.php';

        //Action Hooks
        include_once NPD_GST_DIR_PATH . 'hooks/actions/woocommerce_cart_calculate_fees.php';
        include_once NPD_GST_DIR_PATH . 'hooks/actions/woocommerce_before_calculate_totals.php';
        include_once NPD_GST_DIR_PATH . 'hooks/actions/woocommerce_add_order_item_meta.php';

        //Filter Hooks
        include_once NPD_GST_DIR_PATH . 'hooks/filters/woocommerce_get_item_data.php';
        include_once NPD_GST_DIR_PATH . 'hooks/filters/woocommerce_add_cart_item_data.php';

    }

    /**
     * Method to check for dependencies defined in an option form field
     * @param string the form name field
     * @return bool
     */
    public function has_dependency(string $key){

        //Quick check for the name field
        if(array_key_exists($key, $this->option_dependencies)){
            if( !is_plugin_active($this->option_dependencies[$key]) ){
                return true;
            }
        }

        return false;

    }

    /**
     * Method to get the option data
     * @param string the name field
     * @return mixed value that was set
     */
    public function get_value(string $name){
        return get_option($this->option_prefix . $name);
    }

    /**
     * Method to set the option data
     * @param string the name field
     * @param mixed the value
     * @return void
     */
    public function set_value(string $name, $value){
        update_option($this->option_prefix . $name, $value);
    }

}