<?php
class Bridal_Live_Appointment_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}



	private $allowed_tags =  [
	    'div' => [
	        'class' => true,
	    ],
	    'img' => [
	        'src' => true,
	        'alt' => true,
	        'class' => true,
	    ],
	    'a' => [
	        'href' => true,
	        'title' => true,
	        'class' => true,
	        'target' => true,
	        'rel' => true
	    ],
	    'ul' => [
	        'class' => true,
	    ],
	    'li' => [
	        'class' => true,
	    ],
	    'p' => [
	        'class' => true,
	    ],
	    'h1' => [
	        'class' => true,
	    ],
	    'h2' => [
	        'class' => true,
	    ],
	    'h3' => [
	        'class' => true,
	    ],
	    'button' => [
	        'type' => true,
	        'class' => true,
	        'style' => true
	    ],
	    'table' => [
	        'class' => true,
	        'role' => true,
	    ],
	    'tbody' => [],
	    'tr' => [],
	    'th' => [
	        'scope' => true,
	    ],
	    'td' => [],
	    'span' => [
	        'class' => true,
	    ],
	    'textarea' => [
	        'class' => true,
	        'name' => true,
	        'placeholder' => true,
	        'readonly' => true,
	        'cols' => true,
	        'rows' => true,
	    ],
	    'form' => [
	        'method' => true,
	        'action' => true,
	        'class' => true,
	    ],
	    'input' => [
	        'type' => true,
	        'name' => true,
	        'value' => true,
	        'class' => true,
	        'id' => true,
	        'placeholder' => true,
	        'readonly' => true,
	    ],
	    'label' => [
	        'for' => true,
	        'class' => true,
	    ],
	    'br' => [],
	    'owl-carousel' => [
	        'class' => true,
	    ],
	    'owl-theme' => [
	        'class' => true,
	    ],
	];


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bridal-live-appointment-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owl-cl', BRIDAL_LIVE_APPOINTMENT_URL . 'admin/css/owl.carousel.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owl-theme', BRIDAL_LIVE_APPOINTMENT_URL . 'admin/css/owl.theme.default.min.css', array(), $this->version, 'all' );


	
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bridal-live-appointment-admin.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'owl-cl', BRIDAL_LIVE_APPOINTMENT_URL . 'admin/js/owl.carousel.min.js', array( 'jquery' ), $this->version, false );


	}


	public function add_bridal_live_appointment_manu(){
	
		add_menu_page(
	        "Bridal_Live_Appointment",
        	"Bridal Live",
	        "manage_options",
	        "bridal-live-appointment",
	        array($this, "bridal_live_appointment_plugin_function"),
	        BRIDAL_LIVE_APPOINTMENT_URL . 'admin/images/icon.ico'
	    );
	    add_submenu_page(
	    	"bridal-live-appointment",
	    	"Deshbord",
	    	"Deshbord",
	    	"manage_options",
	    	"bridal-live-appointment",
	    	array($this, "bridal_live_appointment_plugin_function")
	    );
	    add_submenu_page(
	    	'bridal-live-appointment',
	        'Configuration',
	        'Configuration',
	        'manage_options',
	        'bridal_live_configuration',
	        array($this, "bridal_live_configuration_function")
	    );

	    add_submenu_page(
	    	'bridal-live-appointment',
	        'Form Settings',
	        'Form Settings',
	        'manage_options',
	        'bridal_live_settings',
	        array($this, "bridal_live_appointment_settings_function")
	    ); 

	}
 
	public function bridal_live_appointment_plugin_function(){
		ob_start();
		include_once(BRIDAL_LIVE_APPOINTMENT_PATH . "admin/partials/bridal-live-appointment-deshbord.php");

		$template = ob_get_contents();
		ob_get_clean();
		echo wp_kses( $template ,$this->allowed_tags);
	}

	public function bridal_live_configuration_function(){
		ob_start();
		include_once(BRIDAL_LIVE_APPOINTMENT_PATH . "admin/partials/bridal-live-appointment-configuration.php");
		$template = ob_get_contents();
		ob_get_clean();
		echo wp_kses($template,$this->allowed_tags);
	}

	public function bridal_live_appointment_settings_function(){
		ob_start();
		include_once(BRIDAL_LIVE_APPOINTMENT_PATH . "admin/partials/bridal-live-appointment-settings.php");

		$template = ob_get_contents();
		ob_get_clean();
		echo wp_kses($template,$this->allowed_tags);
	} 
}
