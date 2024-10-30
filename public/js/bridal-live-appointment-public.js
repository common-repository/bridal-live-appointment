(function( $ ) {
	'use strict';

	$(document).ready(function () {


		// From Error text	
		$("#booking_form_ajax .form-item input").focusout(function () {
			var text_val = $(this).val();
			if (text_val == "") {				
				$(this).parent().addClass('has-value');
			} else {
				$(this).removeClass('error');
				$(this).siblings('.ci_input_error').text(' ');
			}
		});














		// Fast Appointment Button
		$('.appointment-btn').click(function () {
		  	$('.appointment-btn').parent().parent().parent().addClass('hide-content');  
			let btn_data = $(this).data();
			// Set values
			$('.sp_2_heading').text(btn_data.name);
			$('.sp_2_duration').text(btn_data.duration); 
			$('.sp_2_description').text(btn_data.description);
			$('#selected_pack_id').val(btn_data.id);
			// console.log(btn_data); 
		  	return false;
		});
		//  Appointment Back Button
		$('.back-btn').click(function () {
			$('.back-btn').parent().parent().removeClass('hide-content');
			$('.ui-state-default.ui-state-active').removeClass('ui-state-active');
			$('.appointment-time-btn.appointment-time-btn-active').removeClass('appointment-time-btn-active');
			$('.appointment-sec-single').addClass('appointment-sec-single-time');
		
			return false;
		});
		//  Date Picker
		$("#datepicker,#datepicker-form").datepicker({
		  minDate: 0,
		  dateFormat : 'dd-mm-yy',
		  onSelect: function (selectedDate) { 
			selected_pack_id = $('#selected_pack_id').val();  
			$('#selected_date').val(selectedDate);  
			show_available_times(selectedDate,selected_pack_id); 
		  }
		});
		function show_available_times(get_date,selected_id){ 
			$('.loader').show(); 
			$('#available_date_times').empty();
			$.ajax({
				url: coder_ajax_object.ajaxurl,
				_ajax_nonce: coder_ajax_object.nonce,
				type:"POST", 
				data: {
				   action:'bridal_live__times',
				   get_date:get_date,
				   selected_id:selected_id,
				},   
				success: function(response) { 
					let data = JSON.parse(response);
					// console.log(typeof(data));
					if(data.length != 0){

						$('#available_date_times').empty();  
						$.each(data,function(i,item){
							$('<div>').html( 
								'<button data-startdatetime="'+data[i].startDateTime+'" data-enddatetime="'+data[i].endDateTime+'" data-duration="'+data[i].duration+'" data-fittingroomid="'+data[i].fittingRoomId+'" class="appointment-time-btn">'+data[i].startDateTimeForView+'</button>'
							).appendTo('#available_date_times'); 
						});

						$('.appointment-time-btn').click(function () {
							$('.appointment-time-btn').removeClass('appointment-time-btn-active');
							$(this).addClass('appointment-time-btn-active');
							$('.appointment-main-item.hide-content').addClass('hide-all-content');

							$('#booking_form_ajax').show();
							$('#success_message').hide();
							$('#error_message').hide();
							

							let startdatetime = $(this).data('startdatetime');
							let enddatetime = $(this).data('enddatetime');
							let duration = $(this).data('duration');
							let fittingroomid = $(this).data('fittingroomid');

							$('#startdatetime').val(startdatetime);
							$('#enddatetime').val(enddatetime);
							$('#duration').val(duration);
							$('#fittingRoomId').val(fittingroomid);
							return false;
						});

						$('.loader').hide();


					}
					else{
						
						$('#available_date_times').html('<div class="ci-alert-danger">No Appointment Available this day</div>'); 
						$('.loader').hide();

					}
					//   console.log(data); 
				}, 
				error: function(error){ 
				  console.log(error);   
				}
			});

		}
		$('#event_date').datepicker(); 
		//  Form Back Button
		$('.back-btn-form').click(function () {
			$('.ui-state-default.ui-state-active').removeClass('ui-state-active');
			$('.appointment-time-btn.appointment-time-btn-active').removeClass('appointment-time-btn-active');
			$('.appointment-main-item.hide-content').removeClass('hide-all-content'); 
			return false;
		});
 
		// Submit form
		var fn_count = 0;
		var ln_count = 0;
		var p_count = 0;
		var e_count = 0;
		var d_count = 0;
		$('#booking_form_ajax').on('submit',function(e){
			e.preventDefault();  
			let first_name = $('#first_name').val();
			let last_name = $('#last_name').val();
			let phone = $('#phone').val();
			let email = $('#email').val();

			let address = $('#address').val();
			let address_2 = $('#address_2').val();
			let city = $('#city').val();
			let state = $('#state').val();
			let postcode = $('#postcode').val();

			let event_date = $('#event_date').val();
			let people_of_join = $('#people_of_join').val();
			let budget = $('#budget').val();
			let about_us = $('#about_us').val();
			let gowns = $('#gowns').val();
			let interested = $('#interested').val();
			let check = $('#check').val();

			let selected_pack_id = $('#selected_pack_id').val();
			let form_startdatetime = $('#startdatetime').val();
			let form_enddatetime = $('#enddatetime').val();
			let form_duration = $('#duration').val();
			let form_fittingRoomId = $('#fittingRoomId').val();
			let form_selectedDate = $('#selectedDate').val();

			if(first_name.length == 0){
				$('#first_name').addClass('error'); 
				fn_count += 1;
				if (fn_count == 1) {
					$('#first_name').after('<label class="ci_input_error">First Name is Required!</label>');
				};
			}
			if(last_name.length == 0){
				$('#last_name').addClass('error');
				ln_count += 1;
				if (ln_count == 1) {
					$('#last_name').after('<label class="ci_input_error">Last Name is Required!</label>');
				};
			}
			if(phone.length == 0){
				$('#phone').addClass('error');
				p_count += 1;
				if (p_count == 1) {
					$('#phone').after('<label class="ci_input_error">Phone Number is Required!</label>');
				};
			}
			if(email.length == 0){
				$('#email').addClass('error');
				e_count += 1;
				if (e_count == 1) {
					$('#email').after('<label class="ci_input_error">Email is Required!</label>');
				};
			}
			if(event_date.length == 0){
				$('#event_date').addClass('error');
				d_count += 1;
				if (d_count == 1) {
					$('#event_date').after('<label class="ci_input_error">Event Date is Required!</label>');
				};
			}
			else{
				$.ajax({
					url: coder_ajax_object.ajaxurl,
					_ajax_nonce: coder_ajax_object.nonce,
					type:"POST", 
					data: {
					   action:'bridal_live__appointment',
					   first_name:first_name,
					   last_name:last_name,
					   phone:phone,
					   email:email,
					   address:address,
					   address_2:address_2,
					   city:city,
					   state:state,
					   postcode:postcode,
					   event_date:event_date,
					   people_of_join:people_of_join,
					   budget:budget,
					   about_us:about_us,
					   gowns:gowns,
					   interested:interested,
					   selected_pack_id:selected_pack_id,
					   form_startdatetime:form_startdatetime,
					   form_enddatetime:form_enddatetime,
					   form_duration:form_duration,
					   form_fittingRoomId:form_fittingRoomId,
					   form_selectedDate:form_selectedDate
					},   
					success: function(data) { 
					  console.log(data); 
						if(data == 1){
							$('#booking_form_ajax').hide();
							$('#success_message').show();
						}
						else{
							$('#error_message').show();
						}
					}, 
					error: function(error){ 
					  console.log(error);   
					}
				});
			} 
		}); 
	 
	});

})( jQuery );
