<?php

/**    
 * @wordpress-plugin
 * Plugin Name:       Bridal Live Appointment
 * Plugin URI:        https://coderitsolution.com
 * Description:       Bridal Live Appointment Online Booking WordPress Plugin.
 * Version:           1.1.2
 * Author:            Ashikur Rahman
 * Author URI:        https://ashik.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bridal-live-appointment
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'ABSPATH' ) ) exit; 
global $wpdb;




/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BRIDAL_LIVE_APPOINTMENT_VERSION', '1.1.2' );
define( 'BRIDAL_LIVE_APPOINTMENT_URL', plugin_dir_url( __FILE__ ) );
define( 'BRIDAL_LIVE_APPOINTMENT_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bridal-live-appointment-activator.php
 */
function bridal_live_appointment__activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bridal-live-appointment-activator.php';
	// Bridal_Live_Appointment_Activator::activate();
    // EEEEEExtra
    $activator = new Bridal_Live_Appointment_Activator;
    $activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bridal-live-appointment-deactivator.php
 */
function bridal_live_appointment__deactivate() {
	// require_once plugin_dir_path( __FILE__ ) . 'includes/class-bridal-live-appointment-deactivator.php';
	// Bridal_Live_Appointment_Deactivator::deactivate();

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-bridal-live-appointment-activator.php';
    $activator = new Bridal_Live_Appointment_Activator;

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-bridal-live-appointment-deactivator.php';
    $deactivator = new Bridal_Live_Appointment_Deactivator($activator);
    $deactivator->deactivate();
}

register_activation_hook( __FILE__, 'bridal_live_appointment__activate' );
register_deactivation_hook( __FILE__, 'bridal_live_appointment__deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bridal-live-appointment.php';
require plugin_dir_path( __FILE__ ) . 'public/partials/bridal-live-appointment-public-display.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function bridal_live_appointment__run() {

	$plugin = new Bridal_Live_Appointment();
	$plugin->run();

}
bridal_live_appointment__run();
