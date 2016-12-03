jQuery(document).ready(function ($) {

	// Auf und Zuklappen der Accordeon Boxen
	$('.accordion>p.accH').click(function(){
		$('.activeNews').find('.acctxt').slideDown('slow');
		$('.activeNews>p.accH>em').removeClass().addClass('fa fa-chevron-down');
		$(this).parent().toggleClass('activeNews').find('.acctxt').slideToggle('slow');
		$('.accordion>p.accH').not(this).parent().removeClass('activeNews').find('.acctxt').slideUp();

		if($('.accordion').hasClass('activeNews')) {
			$('.accordion>p.accH>em').removeClass().addClass('fa fa-chevron-down');
			$('em',this).removeClass().addClass('fa fa-chevron-up');
		}else{
			$('.accordion>p.accH>em').removeClass().addClass('fa fa-chevron-down');
		};

	});
});


