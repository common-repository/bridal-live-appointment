<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
global $wpdb;

// Show data value
$tableName    = $wpdb->prefix.'cits_bridallive_options';
$all_posts     = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE id = %d", 1), ARRAY_A);

// var_dump($all_posts );
$single_post = $all_posts[0];

if ( isset( $_POST['bridal_setting_nonce'] ) &&  wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['bridal_setting_nonce'] ) ) , 'bridal_setting' ) ){
	$step_1_title 				= sanitize_text_field( $_POST['step_1_title'] );
	$step_2_title 				= sanitize_text_field( $_POST['step_2_title'] );
	$step_3_title 				= sanitize_text_field( $_POST['step_3_title'] );
	$step_4_title 				= sanitize_text_field( $_POST['step_4_title'] );
	$success_message 			= sanitize_textarea_field( $_POST['success_message'] );
	$not_appointment_message 	= sanitize_textarea_field( $_POST['not_appointment_message'] );
	$terms_condition_title 		= sanitize_text_field( $_POST['terms_condition_title'] );
	$terms_condition_content 	= sanitize_textarea_field( $_POST['terms_condition_content'] );
	$submit_button_label 		= sanitize_text_field( $_POST['submit_button_label'] );

	if (empty($step_1_title)) {
		$error = "Title 1 is Required!";
	}else if (empty($step_2_title)) {
		$error = "Title 2 is Required";
	}else if (empty($step_3_title)) {
		$error = "Title 3 is Required";
	}else if (empty($step_4_title)) {
		$error = "Title 4 is Required";
	}else if (empty($success_message)) {
		$error = "Success Message is Required";
	}else if (empty($not_appointment_message)) {
		$error = "Not Appointment Message is Required";
	}else if (empty($submit_button_label)) {
		$error = "Submit Button Label is Required";
	}
	else{
		$tableName = $wpdb->prefix.'cits_bridallive_options';
		$wpdb->update($tableName, array(
		    'step_1_title' 					=> $step_1_title,
		    'step_2_title' 					=> $step_2_title,
		    'step_3_title' 					=> $step_3_title,
		    'step_4_title' 					=> $step_4_title,
		    'form_success_message' 			=> $success_message,
		    'form_not_appointment_message' 	=> $not_appointment_message,
		    'terms_condition_title' 		=> $terms_condition_title,
		    'terms_condition_content' 		=> $terms_condition_content,
		    'submit_button_label' 			=> $submit_button_label,

		), array( 'ID' => $single_post["id"] ) ); 
		$success = "Data Update Successfully";  
	};
};?>


<div class="cits-content wrap">
	<?php if (isset($success)): ?>
	<div class="success-alart-update main-alart-show">
		<p><?php echo esc_html( $success ); ?></p>
		<button type="button" class="notice-dismiss main-notice-dismiss"></button>
	</div>
	<?php endif ?>
	<?php if (isset($error)): ?>
	<div class="error-alart-update main-alart-show">
		<p><?php echo esc_html( $error ); ?></p>
		<button type="button" class="notice-dismiss main-notice-dismiss"></button>
	</div>
	<?php endif ?> 

	<div class="cits-content-settings">
		<h2>form Settings</h2>
		<ul>
			<li><a href="mailto:ashiktpi30@gmail.com"><img src="<?php echo esc_attr( BRIDAL_LIVE_APPOINTMENT_URL.'admin/images/question.png' ); ?>" alt="Support"> Support</a></li>
		</ul>
	</div>

	<div class="form-new-settings-area">
		<form method="post" class="cits-design form-desing">
			<?php wp_nonce_field( 'bridal_setting', 'bridal_setting_nonce' ); ?>
				<h2>Set Form Steps Title</h2>	
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<label for="step_1_title">Form Step 1</label>
							</th>
							<td>
								<input name="step_1_title" type="text" class="regular-text" placeholder="Appointment Type" value="<?php if (isset($single_post["step_1_title"])) { echo esc_html( $single_post["step_1_title"] ); } ?>">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="step_2_title">Form Step 2</label>
							</th>
							<td>
								<input name="step_2_title" type="text" class="regular-text" placeholder="Date and Time" value="<?php if (isset($single_post["step_2_title"])) { echo esc_html( $single_post["step_2_title"] ); } ?>">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="step_3_title">Form Step 3</label>
							</th>
							<td>
								<input name="step_3_title" type="text" class="regular-text" placeholder="Please Fill in the required information" value="<?php if (isset($single_post["step_3_title"])) { echo esc_html( $single_post["step_3_title"] ); } ?>">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="step_4_title">Form Step 4</label>
							</th>
							<td>
								<input name="step_4_title" type="text" class="regular-text" placeholder="To Book your Appointment" value="<?php if (isset($single_post["step_4_title"])) { echo esc_html( $single_post["step_4_title"] ); } ?>">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="success_message">Success Message</label>
							</th>
							<td>
								<textarea name="success_message" type="textarea" class="regular-text" placeholder="Your Appointment Submit Successfully!"><?php if (isset($single_post["form_success_message"])) { echo esc_html( $single_post["form_success_message"] ); } ?></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="not_appointment_message">No Appointment Message</label>
							</th>
							<td>
								<textarea name="not_appointment_message" type="textarea" class="regular-text" placeholder="No Appointment Available this day"><?php if (isset($single_post["form_not_appointment_message"])) { echo esc_html( $single_post["form_not_appointment_message"] ); } ?></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="terms_condition_title">Terms Condition Title</label>
							</th>
							<td>
								<textarea name="terms_condition_title" type="textarea" class="regular-text" placeholder="Terms & Conditions"><?php if (isset($single_post["terms_condition_title"])) { echo esc_html( $single_post["terms_condition_title"] ); } ?></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="terms_condition_content">Terms Condition Content</label>
							</th>
							<td>
								<textarea name="terms_condition_content" type="textarea" class="regular-text" placeholder="if you wish to reschedule or cancel your appointment, please do so a minimum of 48 hours prior to your schedule booking. By submitting this form, you consent to receiving marketing communication from White Lily Couture."><?php if (isset($single_post["terms_condition_content"])) { echo esc_html( $single_post["terms_condition_content"] ); } ?></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="submit_button_label">Submit Button Label</label>
							</th>
							<td>
								<input name="submit_button_label" type="text" class="regular-text" placeholder="Submit Appointment" value="<?php if (isset($single_post["submit_button_label"])) { echo esc_html( $single_post["submit_button_label"] ); } ?>">
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit"><input type="submit" name="submit_title" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>  
</div>