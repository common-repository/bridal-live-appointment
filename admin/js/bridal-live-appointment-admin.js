(function( $ ) {
	'use strict';
$(document).ready(function () {
	// Update Alart Dismiss
	$('.main-notice-dismiss').click(function(){
		$(this).parent().addClass('main-notice-dismiss-hide');
	});
	// Banner - Carousel
	$('.coderit-cl').owlCarousel({
		items:1,
		loop:true,
		dots:false,
		nav:true,
	    autoplayHoverPause:false,
	    autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 5000,
        autoplaySpeed: 800,
	});
	// Tab Content
	$('.settings-mains-single h2 a').on('click', function(evt) {
	  evt.preventDefault();
	  $('.settings-mains-single h2 a').removeClass('active-btn');
	  $(this).addClass('active-btn');
	  var sel = this.getAttribute('data-toggle-target');
	  $('.tab-content').removeClass('active-btn').filter(sel).addClass('active-btn');
	});

});

//Select To Copy	
$(document).ready(function () {
	// ShortCode Copy
	let toolt = document.querySelector('.submit-shortcode');
	let span = toolt.querySelector('.tlt');
	function showToolTip(e) {
	  span.classList.add('show');
	  if(e.type == "click") {
	    span.innerText = "Copied"
	    let shortcode = document.querySelector('#cits_shortcode');
	    shortcode.select();
	    document.execCommand('copy');
	  };
	};
	function hideToolTip() {
	  span.classList.remove('show');
	  span.innerText = "Click Now";
	};
	toolt.addEventListener('click', showToolTip);
	toolt.addEventListener('mouseenter', showToolTip);
	toolt.addEventListener('mouseleave', hideToolTip);
});
//Select To Copy
$(document).ready(function () {
	//Value Set
	$('#textarea_val').val("<?php echo do_shortcode('[bridal__live__appointment]'); ?>");
	// TextArea Copy
	let toolt = document.querySelector('.submit-textarea');
	let span = toolt.querySelector('.tlt2');
	function showToolTip(e) {
	  span.classList.add('show');
	  if(e.type == "click") {
	    span.innerText = "Copied"
	    let shortcode = document.querySelector('#textarea_val');
	    shortcode.select();
	    document.execCommand('copy');
	  };
	};
	function hideToolTip() {
	  span.classList.remove('show');
	  span.innerText = "Click Now";
	};
	toolt.addEventListener('click', showToolTip);
	toolt.addEventListener('mouseenter', showToolTip);
	toolt.addEventListener('mouseleave', hideToolTip);
});

})( jQuery );
