$(document).ready(function () {

	// Tab box

	$('.tab-nav').delegate('li:not(.cur)', 'click', function() {

		$(this).addClass('cur').siblings().removeClass('cur').parents().find('.tab-box').hide().removeClass('cur').eq($(this).index()).addClass('cur').fadeIn(100);

	});

	// Tab box 2

	$('.tab-nav2').delegate('li:not(.cur)', 'click', function() {

		$(this).addClass('cur').siblings().removeClass('cur').parents().find('.tab-box2').hide().removeClass('cur').eq($(this).index()).addClass('cur').fadeIn(100);

	});

	 //Drop menu block    
	$('ul.opened_nav').hide();
	$('.b-nav li a.opened_drop').click(function() {
		if($(this).parent().hasClass('current')) {
   		$(this).siblings('ul').slideUp('slow',function() {
		$(this).parent().removeClass('current');
   	});
  	} else {
   		$('ul.b-nav li.current ul').slideUp('slow',function() {
    		$(this).parent().removeClass('current');
   	});
   		$(this).siblings('ul').slideToggle('slow',function() {
    		$(this).parent().toggleClass('current');
   	});
  	}
  		return false;
 	});

	// Copyright

	$('body').after('<!--\nДизайн был разработан студией YtStyle\nАдрес студии: http://ytstyle.ru/\n-->');

});