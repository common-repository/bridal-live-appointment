<?php 
  if ( ! defined( 'ABSPATH' ) ) exit; 
  global $wpdb;
  // Show data value

  $tableName    = $wpdb->prefix.'cits_bridallive_options';
  $all_posts     = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE id = %d", 1), ARRAY_A);


  foreach($all_posts as $single_post) :
    // var_dump($single_post);
    $retailer_id   = $single_post["retailer_id"];
    $api_key       = $single_post["api_key"];

  $credentials = array(
    'retailerId' =>  $retailer_id,
    'apiKey' => $api_key
  );
  $bridal_credentials = wp_json_encode($credentials);

  $bridal_credential_args = array(
    'retailerId' => $retailer_id,
    'status' => 'A',
    'bookOnline' => 'true'
  );
  $bridal_credentials_other = wp_json_encode($bridal_credential_args);

function bridal_live__token(){ 
  global $bridal_credentials;
  $args = array(
    'body'        => $bridal_credentials,
    'blocking'    => true,
    'headers'     => array(
      'Content-Type'=>'application/json',
      'Cookie'=>'AWSALB=P9XW4UWt3Fji4f2pPvJJ7Kc2WaB6ojAF4Qb23HARRqq9UKHKbga/aYlFdiDa8Mr5V+lOHJIR3SkxwvbiA/SpJmF/CRjYyzBWBZm9U97elxk51ETDjbO3yYOVlFt6; AWSALBCORS=P9XW4UWt3Fji4f2pPvJJ7Kc2WaB6ojAF4Qb23HARRqq9UKHKbga/aYlFdiDa8Mr5V+lOHJIR3SkxwvbiA/SpJmF/CRjYyzBWBZm9U97elxk51ETDjbO3yYOVlFt6'
    ),
    'cookies'     => array(),
  );
  // User Api
  $response = wp_remote_post( 'https://app.bridallive.com/bl-server/api/auth/apiLogin', $args );
  $body = wp_remote_retrieve_body( $response );
  $login_data = json_decode($body,true);  
  if(isset($login_data['errors'])){
      $login['error'] = $login_data['errors'][0]['message'];;
      return $login;
  }
  else{
      $login['token'] = $login_data['token'];
      return $login;
  }   
}

// Get Available Packages
function bridal_live__available_packages($token){
  global $bridal_credentials_other;
  $args = array(
    'body'        => $bridal_credentials_other,
    'blocking'    => true,
    'headers'     => array(
      'token'=> $token,
      'Content-Type'=>'application/json;charset=UTF-8',
      'Cookie'=>'AWSALB=IBR1cRjyAtut7oWRTrCyoXHwDQ9d7vKTwVV+vseoVypIGSxf334otBN3tMB5VUZhf/EcebU2fR08tFpsVea0G3UbaPaGg23moy/u/DDUWeujEZ3oIEH1sCXwBAd5; AWSALBCORS=IBR1cRjyAtut7oWRTrCyoXHwDQ9d7vKTwVV+vseoVypIGSxf334otBN3tMB5VUZhf/EcebU2fR08tFpsVea0G3UbaPaGg23moy/u/DDUWeujEZ3oIEH1sCXwBAd5'
    ),
    'cookies'     => array(),
  );
  // User Api
  $response2 = wp_remote_post( 'https://app.bridallive.com/bl-server/api/appointmentTypes/list', $args );
  $body = wp_remote_retrieve_body( $response2 );
  $response = json_decode($body,true);
  return $response;
}


// WP AJAX - Get Available Times
add_action( 'wp_ajax_bridal_live__times', 'bridal_live__times' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_bridal_live__times', 'bridal_live__times'); //execute when logged out
function bridal_live__times(){
  $token = bridal_live__token();
  $get_date = sanitize_text_field( $_POST['get_date'] ); 
  $selected_id = sanitize_text_field( $_POST['selected_id'] ); 
  $args = array(
    'body'        => $bridal_credentials_other,
    'blocking'    => true,
    'headers'     => array(
      'token'=> $token['token'],
      'Content-Type'=>'application/json;charset=UTF-8',
      'Cookie'=>'AWSALB=mjXEm2pjcrHXHoxXMhCLGWw83pKIH3rAKNZ7ggh7o+2PzfszkeVvbHK5aezFTEAeEhUc+NkyPo8KTvTxRJhTTQACydY8FcDs8ZkSL3NsphzmT3L2Ra1fcLfW+DHt; AWSALBCORS=mjXEm2pjcrHXHoxXMhCLGWw83pKIH3rAKNZ7ggh7o+2PzfszkeVvbHK5aezFTEAeEhUc+NkyPo8KTvTxRJhTTQACydY8FcDs8ZkSL3NsphzmT3L2Ra1fcLfW+DHt'
    ),
    'cookies'     => array(),
  );
  // User Api
  $resUrl = 'https://app.bridallive.com/bl-server/api/appointments/getAvailableTime/'.$selected_id.'/'.$get_date;
  $response = wp_remote_get( $resUrl, $args );
  $body = wp_remote_retrieve_body( $response );
  wp_send_json($body);
  die();
}


// WP AJAX - Get Appointment
add_action( 'wp_ajax_bridal_live__appointment', 'bridal_live__appointment' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_bridal_live__appointment', 'bridal_live__appointment'); //execute when logged out
function bridal_live__appointment(){
  $token = bridal_live__token();
  if ( ! defined( 'ABSPATH' ) ) exit;
  global $wpdb;
  $tableName    = $wpdb->prefix.'cits_bridallive_options';
  $all_posts    = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE id = %d", 1), ARRAY_A);
  $single_post  = $all_posts[0];
  $retailer_id  = sanitize_text_field( $single_post["retailer_id"] );

  if ( isset( $_POST['bridal_booking_nonce'] ) &&  wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['bridal_booking_nonce'] ) ) , 'bridal_booking' ) ){
    $form_data = array(
      "retailerId"=>$retailer_id,
      "firstName"=> sanitize_text_field( $_POST['first_name'] ),
      "lastName"=> sanitize_text_field( $_POST['last_name'] ),
      "phone"=> sanitize_text_field( $_POST['phone'] ),
      "phoneType"=> 3,
      "email"=> sanitize_email( $_POST['email'] ),
      "eventDateStr"=> sanitize_text_field( $_POST['event_date'] ),
      "budgetStr"=> sanitize_text_field( $_POST['budget'] ),
      "numberOfPeople"=> sanitize_text_field( $_POST['people_of_join'] ),
      "addressOne"=> sanitize_text_field( $_POST['address'] ),
      "addressTwo"=> sanitize_text_field( $_POST['address_2'] ),
      "city"=> sanitize_text_field( $_POST['city'] ),
      "state"=> sanitize_text_field( $_POST['state'] ),
      "zip"=> sanitize_text_field( $_POST['postcode'] ),
      "appointmentTypeId"=> sanitize_text_field( $_POST['selected_pack_id'] ),
      "howHeardId"=> sanitize_text_field( $_POST['about_us'] ),
      "selectedDate"=> sanitize_text_field( $_POST['form_selectedDate'] ),
      "emailOptIn"=> false,
      "smsOptIn"=> false,
      "startDateTimeStr"=> sanitize_text_field( $_POST['form_startdatetime'] ),
      "endDateTimeStr"=> sanitize_text_field( $_POST['form_enddatetime'] ),
      "duration"=> sanitize_text_field( $_POST['form_duration'] ),
      "fittingRoomId"=> sanitize_text_field( $_POST['form_fittingRoomId'] ),
    );
    $form_data_str = wp_json_encode($form_data);
    $args = array(
      'body'        => $form_data_str,
      'blocking'    => true,
      'headers'     => array(
        'token'=> $token['token'],
        'Content-Type'=>'application/json;charset=UTF-8',
        'Cookie'=>'AWSALB=yUwJSP55AqyS84DpenG7/sw0tosflJN4ojGtC0ChSIve+ZAtSVrv384+gkCc3WSXjaMVWnSN5uqTcneypCeARVGhP+S6nzIfyHfPD6wXx7C3iesUp3Ji0RGK3dUh; AWSALBCORS=yUwJSP55AqyS84DpenG7/sw0tosflJN4ojGtC0ChSIve+ZAtSVrv384+gkCc3WSXjaMVWnSN5uqTcneypCeARVGhP+S6nzIfyHfPD6wXx7C3iesUp3Ji0RGK3dUh'
      ),
      'cookies'     => array(),
    );
    // User API
    $response = wp_remote_post( 'https://app.bridallive.com/bl-server/api/appointments/scheduleAppointment', $args );
    $body = wp_remote_retrieve_body( $response );
    $body = json_decode($body,true); 

    // wp_send_json($response);
    if(isset($body['errors'])){
      echo 0;
    }
    else{ echo 1;} 
    };


  die(); 
}
  
add_shortcode( 'bridal__live__appointment', 'bridal_live_cits__shortcode');
function bridal_live_cits__shortcode() {

    ob_start(); ?>

    <?php  
      $login_token = bridal_live__token(); 
      if(!isset($login_token['error'])) : 
      if ( ! defined( 'ABSPATH' ) ) exit;
      global $wpdb;
      // Show data value
      $tableName    = $wpdb->prefix.'cits_bridallive_options';
      $all_posts    = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE id = %d", 1), ARRAY_A);
      $single_post = $all_posts[0];
      // Single All Table data
      $step_1_title                 = sanitize_text_field( $single_post["step_1_title"] );
      $step_2_title                 = sanitize_text_field( $single_post["step_2_title"] );
      $step_3_title                 = sanitize_text_field( $single_post["step_3_title"] );
      $step_4_title                 = sanitize_text_field( $single_post["step_4_title"] );
      $form_success_message         = sanitize_textarea_field( $single_post["form_success_message"] );
      $form_not_appointment_message = sanitize_textarea_field( $single_post["form_not_appointment_message"] );
      $terms_condition_title        = sanitize_text_field( $single_post["terms_condition_title"] );
      $terms_condition_content      = sanitize_textarea_field( $single_post["terms_condition_content"] );
      $submit_button_label          = sanitize_text_field( $single_post["submit_button_label"] );

    ?>
  <section class="coder-it all-appointment-area">
    <div class="container">  
      <div class="appointment-main-item">
        <!-- First Title -->
        <div class="appointment-title app-btm-bdr appointment-title-first">
          <h2><?php echo esc_html( $step_1_title ); ?></h2>
        </div>
        
        <!-- Appointment 1st Step -->
        <div class="appointment-items">
          <?php 
          $packages = bridal_live__available_packages($login_token['token']);
          foreach($packages as $package):
          ?>        
          <div class="appointment-single-item">
            <h2><?php echo esc_html( $package['description'] );?></h2>
            <h3><?php $hours = $package['duration']/3600000;  echo esc_html( $hours ); ?> Hr</h3>
            <p><?php echo esc_html( $package['onlineDescription'] );?></p>
            <button data-id="<?php echo esc_attr( $package['id'] );?>" data-name="<?php echo esc_attr( $package['description'] );?>" data-duration="<?php echo esc_attr( $hours );?> Hr" data-description="<?php echo esc_attr( $package['onlineDescription'] );?>" id="appointment-booking" class="appointment-btn">See Available Dates</button>
          </div>
          <?php endforeach;?> 
        </div>
        <!-- End Appointment 1st Step -->

        <!-- Start 2nd Step -->
        <div class="appointment-items-secound">
          <!-- Secound Title -->
          <div class="appointment-title app-btm-bdr">
            <h2><?php echo esc_html( $step_2_title ); ?></h2>
          </div>
          <div class="back-btn">
            <i class="gg-chevron-left"></i> Back
          </div>
          <div class="appointment-items-sec-conent">
            <div class="appointment-sec-single appointment-sec-single-fast">
              <h2 class="sp_2_heading"></h2>
              <h3 class="sp_2_duration"></h3>
              <p class="sp_2_description"></p>
            </div>
            <div class="appointment-sec-single calender_wapper">
              <input type="hidden" name="package_id"  id="selected_pack_id">
              <div id="datepicker"></div> 
              <span class="loader"></span>
            </div>
            <div class="appointment-sec-single appointment-sec-single-time" id="available_date_times"> 
            </div>
          </div>
        </div>
        <!-- End 2nd Step -->

        <!-- Start 3rd Step -->
        <div class="main-form-area">
          <!-- Last Title -->
          <div class="appointment-title app-btm-bdr">
            <h2><?php echo esc_html( $step_3_title ); ?></h2>
          </div>
          <div class="back-btn-form">
            <i class="gg-chevron-left"></i> Back
          </div>
          <form action="" method="POST" id="booking_form_ajax">
            <?php wp_nonce_field( 'bridal_booking', 'bridal_booking_nonce' ); ?>
            <input type="hidden" id="startdatetime">
            <input type="hidden" id="enddatetime">
            <input type="hidden" id="duration">
            <input type="hidden" id="fittingRoomId">
            <input type="hidden" id="selected_date">
 
            <h2>Personal Information</h2>
            <div class="form-group">
              <div class="form-item">
                <label for="first_name">First Name (Required)</label>
                <input type="text" id="first_name" placeholder="First Name">
              </div>
              <div class="form-item">
                <label for="last_name">Last Name (Required)</label>
                <input type="text" id="last_name" placeholder="Last Name">
              </div>
            </div>
            <div class="form-group">
              <div class="form-item">
                <label for="phone"> Phone Number (Required)</label>
                <input type="text" id="phone" placeholder="Phone Number">
              </div>
              <div class="form-item">
                <label for="email">Email Address (Required)</label>
                <input type="email" id="email" placeholder="Email">
              </div>
            </div>
            <h2>Location Information</h2>
            <div class="form-group">
              <div class="form-item">
                <label for="address">Address</label>
                <input type="text" id="address" placeholder="Address">
              </div>
              <div class="form-item">
                <label for="address_2">Address 2</label>
                <input type="text" id="address_2" placeholder="Address 2">
              </div>
            </div>
            <div class="form-group">
              <div class="form-item">
                <label for="city">City</label>
                <input type="text" id="city" placeholder="City">
              </div>
              <div class="form-item">
                <label for="state">State</label>
                <div class="select-item">
                  <select name="state" id="state">
                    <option value="" selected>Select State</option>
                    <option value="ACT">Australian Capital Territory</option>
                    <option value="NSW">New South Wales</option>
                    <option value="NT">Northern Territory</option>
                    <option value="QLD">Queensland</option>
                    <option value="SA">South Australia</option>
                    <option value="TAS">Tasmania</option>
                    <option value="VIC">Victoria</option>
                    <option value="WA">Western Australia</option>
                  </select>
                  <input type="text" id="postcode" placeholder="Postcode">
                </div>
              </div>
            </div>
            <h2>Event Information</h2>
            <div class="form-group">
              <div class="form-item">
                <label for="event_date">Event Date(Required)</label>
                <input type="text" id="event_date" placeholder="dd/mm/yy">
              </div>
              <div class="form-item">
                <label for="people_of_join"># of People Joining You</label>
                <select name="people_of_join" id="people_of_join">
                  <option value="" selected># of People Joining You</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option> 
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="form-item">
                <label for="budget">Budget</label>
                <input type="text" id="budget" placeholder="Budget">
              </div>
              <div class="form-item">
                <label for="about_us">How did you hear about us? (Required)</label>
                <select name="about_us" id="about_us">
                  <option value="" selected>How did you hear about us? (required)</option>
                  <option value="4348">Facebook</option>
                  <option value="4349">Google Search</option>
                  <option value="4351">Referral</option>
                  <option value="4352">Direct to Website</option>
                  <option value="4353">Instagram</option>
                  <option value="4354">Bridal Magazine</option>
                  <option value="4355">Press</option>
                  <option value="4356">Pinterest</option>
                  <option value="4357">Shopfront</option>
                  <option value="9785">Social Media - Other</option>
                  <option value="12045">Unknown</option>
                  <option value="15524">Expo</option>
                  <option value="15971">Yandina Station</option>
                  <option value="19972">Designers Website</option>
                  <option value="20023">Referral from another store</option>
                  <option value="20024">Referral from a friend</option>
                  <option value="20895">I AM A RETURNING CUSTOMER</option>
                </select>
              </div>
            </div>
            <div class="form-group">

              <div class="form-item">
                <label for="gowns">Will this be your first time trying bridal gowns?</label>
                <select name="gowns" id="gowns">
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              </div>
              <div class="form-item">
                <label for="interested">Interested in a specific gown?</label>
                <input type="text" id="interested">
              </div>
            </div>
            <div class="form-group check-item">
              <div class="form-item">
                <input type="checkbox" id="check" checked>
                <label for="check">Tick to confirm your booking Via SMS (required)</label>
              </div>
            </div>
            <div class="team-content">
              <h2><?php echo esc_html( $terms_condition_title ); ?></h2>
              <p><?php echo esc_html( $terms_condition_content ); ?></p>
            </div>
            <div class="form-group submit-button">
              <div class="form-item">
                <input type="submit" class="submit-btn" value="<?php echo esc_html( $submit_button_label ); ?>">
              </div>
            </div> 

          </form>

          <div class="alert__message">
            <div class="ei-alert-success" id="success_message">
              <?php echo esc_html( $form_success_message ); ?>
            </div>

            <div class="ci-alert-danger" id="error_message">
              Something went wrong, Please check again!
            </div>
            
          </div>
         

        </div>
        <!-- End 3rd Step -->
      </div>

    </div>
  </section>

    <?php  else:  ?>
        <div class="ci-alert-danger">
            <?php  echo esc_html( $login_token['error'] ); ?>
        </div>
    <?php  
    endif;
    
    return ob_get_clean();
}
 
endforeach; 
?>