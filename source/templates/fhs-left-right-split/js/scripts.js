jQuery(document).ready(function ($) {

	// Menu Toggle
	$('.menuToggle').click(function () {
		$('.menuOpen').toggleClass('activeMenu').slideToggle('slow');
		$('.menuNorm').toggleClass('activeMenu').slideToggle('slow');

		if ($('.menuToggle>i').hasClass('activeTogg')) {
			$('.menuToggle>i').removeClass().addClass('fa fa-plus-square-o');
		} else {
			$('.menuToggle>i').removeClass().addClass('fa fa-minus-square-o activeTogg');
		};
	});

	// Accordions
	$('.accordion>p.accH').click(function () {
		$('.activeNews').find('.acctxt').slideDown('slow');
		$('.activeNews>p.accH>em').removeClass().addClass('fa fa-chevron-down');
		$(this).parent().toggleClass('activeNews').find('.acctxt').slideToggle('slow');
		$('.accordion>p.accH').not(this).parent().removeClass('activeNews').find('.acctxt').slideUp();

		if ($('.accordion').hasClass('activeNews')) {
			$('.accordion>p.accH>em').removeClass().addClass('fa fa-chevron-down');
			$('em', this).removeClass().addClass('fa fa-chevron-up');
		} else {
			$('.accordion>p.accH>em').removeClass().addClass('fa fa-chevron-down');
		};

	});
});

// BackTop
!function (o) {
	o.fn.backTop = function (e) {
		var n = this,
		i = o.extend({
				position : 400,
				speed : 500,
				color : "white"
			}, e),
		t = i.position,
		c = i.speed,
		d = i.color;
		n.addClass("white" == d ? "white" : "red" == d ? "red" : "blue" == d ? "blue" : "black"),
		n.css({
			right : 20,
			bottom : 20,
			position : "fixed"
		}),
		o(document).scroll(function () {
			var e = o(window).scrollTop();
			e >= t ? n.fadeIn(c) : n.fadeOut(c)
		}),
		n.click(function () {
			o("html, body").animate({
				scrollTop : 0
			}, {
				duration : 1200
			})
		})
	}
}
(jQuery);
