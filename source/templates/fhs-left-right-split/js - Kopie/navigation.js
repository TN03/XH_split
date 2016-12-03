
$(document).ready(function(){

	$(window).scroll(function(){
		var border = 200;
		if($(window).scrollTop() >= border){
			$("#navi").css({
					'position' : 'fixed',
					'top' : '0'
			});
		}
		if($(window).scrollTop() < border){
			$('#navi').removeAttr('style');			
		}
	})		

});
