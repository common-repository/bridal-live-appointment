<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
global $wpdb;

// Show data value

$tableName    = $wpdb->prefix.'cits_bridallive_options';
$all_posts     = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE id = %d", 1), ARRAY_A);


$single_post = $all_posts[0];

if ( isset( $_POST['bridal_configuration_nonce'] ) &&  wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['bridal_configuration_nonce'] ) ) , 'bridal_configuration' ) ){
	$business_name 	= sanitize_text_field( $_POST['business_name'] );
	$retailer_id  	= sanitize_text_field( $_POST['retailer_id'] );
	$api_key 		= sanitize_text_field( $_POST['api_key'] );
	$updated_at 	= sanitize_text_field( gmdate('Y-m-d H:i:s') );

	if (empty($business_name)) {
		$error = "Business Name Is Required!";
	}else if (empty($retailer_id)) {
		$error = "Retailer Id Is Required";
	}else if (empty($api_key)) {
		$error = "API Key Is Required";
	}
	else{
		$tableName = $wpdb->prefix.'cits_bridallive_options';
		$wpdb->update($tableName, array(
		    'business_name' => $business_name,
		    'retailer_id' => $retailer_id,
		    'api_key' => $api_key,
		    'updated_at' => $updated_at
		), array( 'ID' => $single_post["id"] ) );
		$success = "Updated Successfully";
	};
};?>

<div class="configuration-area cits-content wrap">
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
		<h2>Configuration</h2>
		<ul> 
		    <li><a href="mailto:ashiktpi30@gmail.com"><img src="<?php echo esc_attr( BRIDAL_LIVE_APPOINTMENT_URL.'admin/images/question.png' ); ?>" alt="Support"> Support</a></li>
		</ul>
	</div>

	<div class="configuration-main-area">
		<div class="configuration-single-area c-l">
			<div class="wrap">
				<h1 class="cits-design">Bridal Live Account Configuration</h1>
				<form method="post" class="cits-design form-desing">
					<?php wp_nonce_field( 'bridal_configuration', 'bridal_configuration_nonce' ); ?>
					<p><a target="_blank" href="https://app.bridallive.com/#/settings/account">Here</a> you will get your API Access.</p>
					<table class="form-table" role="presentation">
						<tbody>
							<tr>
								<th scope="row">
									<label for="business_name">Business Name</label>
								</th>
								<td>
									<input name="business_name" type="text" id="business_name" class="regular-text" placeholder="Business Name" value="<?php if (isset($single_post["business_name"])) { echo esc_html( $single_post["business_name"] ); } ?>">
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="retailer_id">Retailer ID</label>
								</th>
								<td>
									<input name="retailer_id" type="text" id="retailer_id" class="regular-text" placeholder="Retailer ID" value="<?php if (isset($single_post["retailer_id"])) { echo esc_html( $single_post["retailer_id"] ); } ?>">
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="api_key">API Key</label>
								</th>
								<td>
									<input name="api_key" type="password" id="api_key" class="regular-text" placeholder="API Key" value="<?php if (isset($single_post["api_key"])) { echo esc_html( $single_post["api_key"] ); } ?>">
								</td>
							</tr>
						</tbody>
					</table>
					<p class="submit"><input type="submit" name="submit_save" id="submit" class="button button-primary" value="Save Changes"></p>
				</form>
			</div>
		</div>
		<div class="configuration-single-area">
			<div class="wrap single-items">
				<h1 class="cits-design">Bridal Live Form Shortcode</h1>
				<table class="form-table extra-table" role="presentation">
					<tbody>
						<tr>							
							<td>
								<input type="text" id="cits_shortcode" class="regular-text copy-val" value="[bridal__live__appointment]" readonly>
								<label><p class="submit submit-shortcode mt-0">
									<span class="button button-primary">Copy Now</span>
									<span class="tlt">Click Now</span>
								</p></label>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="wrap single-items single-items-btm">
				<h1 class="cits-design">Bridal Live Form PHP Code</h1>
				<table class="form-table extra-table extra-table-bottom" role="presentation">
					<tbody>
						<tr>							
							<td>
								<input type="text" id="textarea_val" class="regular-text copy-val" readonly>
								<label><p class="submit submit-textarea mt-0">
									<span class="button button-primary">Copy Now</span>
									<span class="tlt2">Click Now</span>
								</p></label>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>