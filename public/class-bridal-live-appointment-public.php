<?php
class Bridal_Live_Appointment_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {


		wp_enqueue_style('roboto_font', plugin_dir_url( __FILE__ ) . 'fonts/stylesheet.css', array(), $this->version, 'all' );
		wp_enqueue_style('jquery_ui_css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bridal-live-appointment-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script('jquery-ui-core');
    	wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'coder-ajax', plugin_dir_url( __FILE__ ) . 'js/bridal-live-appointment-public.js', array( 'jquery' )); 
		wp_localize_script( 'coder-ajax', 'coder_ajax_object',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);

	}
 
}