$(document).ready(function(){
	$("a.price_down").live('click', function(e){
			$('.popup_buy').show();
	});
	$('.cancel').click(function(){
		$('.popup_buy').hide();
	});	
	$('.popup_buy').click(function(e){
		e.stopPropagation();
	});
//	$('a.rew').click(function(){
//		$('.tabs li').removeClass('ui-state-active');
//		$('.tabs li').removeClass('ui-tabs-selected');
//		$('.tabs li.rew_tab').addClass('ui-state-active');
//		$('.tabs li.rew_tab').addClass('ui-tabs-selected');
//		$('#info, #video, #kupit').addClass('ui-tabs-hide');
//		$('#responses').removeClass('ui-tabs-hide');
//	});	
});
