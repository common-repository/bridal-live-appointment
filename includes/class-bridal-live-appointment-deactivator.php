<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://ashik.me
 * @since      1.0.0
 *
 * @package    Bridal_Live_Appointment
 * @subpackage Bridal_Live_Appointment/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Bridal_Live_Appointment
 * @subpackage Bridal_Live_Appointment/includes
 * @author     Ashikur Rahman <ashiktpi30@gmail.com>
 */

class Bridal_Live_Appointment_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */

    private $table_activator;
    public function __construct($activator){
        $this->table_activator = $activator;
    }
    public function deactivate() {
        // Delete Table
        if ( ! defined( 'ABSPATH' ) ) exit;
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."cits_bridallive_options");

    }

}
