<?php

/**
 * Fired during plugin activation
 *
 * @link       https://ashik.me
 * @since      1.0.0
 *
 * @package    Bridal_Live_Appointment
 * @subpackage Bridal_Live_Appointment/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bridal_Live_Appointment
 * @subpackage Bridal_Live_Appointment/includes
 * @author     Ashikur Rahman <ashiktpi30@gmail.com>
 */
class Bridal_Live_Appointment_Activator {

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
 
    public function activate() {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    
    global $wpdb;
      // Table 1
      $cits_bridallive_options_query = "CREATE TABLE `".$this->cits_bridallive_options_prefix()."` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `business_name` varchar(255) NOT NULL,
              `retailer_id` varchar(255) NOT NULL,
              `api_key` varchar(255) NOT NULL,
              `step_1_title` varchar(255) NOT NULL,
              `step_2_title` varchar(255) NOT NULL,
              `step_3_title` varchar(255) NOT NULL,
              `step_4_title` varchar(255) NOT NULL,
              `form_success_message` varchar(255) NOT NULL,
              `form_not_appointment_message` varchar(255) NOT NULL,
              `terms_condition_title` varchar(255) NOT NULL,
              `terms_condition_content` varchar(255) NOT NULL,
              `submit_button_label` text NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";


      dbDelta($cits_bridallive_options_query);

      $tableName = $this->cits_bridallive_options_prefix();
      $data = array(
        'business_name' => 'Coder It Solution',
        'retailer_id'   => '12345678',
        'api_key'       => '1234567896857458',
        'step_1_title'  => 'Appointment Type',
        'step_2_title'  => 'Date and Time',
        'step_3_title'  => 'Please Fill in the required information',
        'step_4_title'  => 'To Book your Appointment',
        'form_success_message' => 'Send Success',
        'form_not_appointment_message' => 'No Appointment Available this day',
        'terms_condition_title' => 'Terms & Conditions',
        'terms_condition_content' => 'if you wish to reschedule or cancel your appointment, please do so a minimum of 48 hours prior to your schedule booking. By submitting this form, you consent to receiving marketing communication from White Lily Couture.',
        'submit_button_label' => 'SUBMIT APPOINTMENT',
      );
      $wpdb->insert($tableName, $data );




    } 
    
    // Prefix add korer jonno
    public function cits_bridallive_options_prefix(){
        if ( ! defined( 'ABSPATH' ) ) exit;
        global $wpdb;
        return $wpdb->prefix . "cits_bridallive_options";
    } 
}
