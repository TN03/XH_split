jQuery(document).ready(function ($) {
	$('.menuToggle').click(function () {
		$('.menuOpen').toggleClass('activeMenu').slideToggle('slow');
		$('.menuNorm').toggleClass('activeMenu').slideToggle('slow');
		
		if($('.menuToggle>i').hasClass('activeTogg')) {
			$('.menuToggle>i').removeClass().addClass('fa fa-plus-square-o');
		}else{
			$('.menuToggle>i').removeClass().addClass('fa fa-minus-square-o activeTogg');
		};

	});
});
