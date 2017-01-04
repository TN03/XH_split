jQuery(document).ready(function ($) {



	// Auf und Zuklappen der Accordeon Boxen

	$('.accordion>h5').click(function(){

		$('.activeNews').find('.acctxt').slideDown('slow');

		$('.activeNews>h5>em').removeClass().addClass('fa fa-chevron-down');

		$(this).parent().toggleClass('activeNews').find('.acctxt').slideToggle('slow');

		$('.accordion>h5').not(this).parent().removeClass('activeNews').find('.acctxt').slideUp();



		if($('.accordion').hasClass('activeNews')) {

			$('.accordion>h5>em').removeClass().addClass('fa fa-chevron-down');

			$('em',this).removeClass().addClass('fa fa-chevron-up');

		}else{

			$('.accordion>h5>em').removeClass().addClass('fa fa-chevron-down');

		};



	});

});







