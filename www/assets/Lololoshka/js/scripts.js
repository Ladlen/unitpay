

$(function(){
	
$.getScript('/template/js/jquery-ui.custom.min.js');

var __rand = function(min, max){
	return Math.round(Math.random() * (max - min - 1)) + min;
};

var apiUrl = '/api';

var __openCase = function(){	
	$('.opencase-bottom-open').hide();
	var id = $('.opencase-bottom-open').attr("data-id");
	$.ajax({
		url: apiUrl,
		type: 'post',
		data: {case: id, action: 'openCase'},
		dataType: 'json',
		success: function(rdata){
			if('false' == rdata.result){
				switch(rdata.message){
					case 'no_money':
						$('.opencase-bottom-nofunds').show();
						break;

					case 'no_realmoney':
						$('.opencase-bottom-norealfunds').show();
						break;						
						
					case 'need_action':
						$('.opencase-bottom-action').show();
						break;							
						
					case 'no_link':
						$('.opencase-bottom-link').show();
						break;						
						
					case 'no_login':
						$('.opencase-bottom-auth').show();
						break;
						
					case 'no_items':
						$('.opencase-bottom-items').show();
						break;
				}
			} else {
				__buildLine(rdata);
			}
		}
	});
};
	
var __buildLine = function(data){
	$('.opencase-top-case, .opencase-bottom-open').hide();
	$('.opencase-top-carousel, .opencase-bottom-opening').show();
	var rand;
	function randomInteger(min, max) {
		rand = min + Math.random() * (max + 1 - min);
		rand = Math.floor(rand);
		return rand;
	}
	randomInteger(-138, 138)
	$('.opencase-top-carousel-line').html('');

	$.each(data.items, function(_, v){
		//if(v.color == "uncommon") v.color = "#305f8d";
		/*if(v.color == "milspec") v.color = "#3f50be";
		if(v.color == "restricted") v.color = "#7339bd";
		if(v.color == "classified") v.color = "#bb22b6";
		if(v.color == "covert") v.color = "#d43c39";
		if(v.color == "rare") v.color = "#ddb401";*/
		
		$('<div class="opencase-top-carousel-line-item">')
		.appendTo('.opencase-top-carousel-line')
		.append(
			$('<div class="opencase-top-carousel-line-item-image"><img src="' + v.image + '">')
		)
		.append(
			$('<div>').addClass('opencase-top-carousel-line-item-text').html(v.name_first)
		);
	});
$('.purse').html('Баланс: <span>'+data.balans+' <small>p</small></span>');
	var thing_win = data.items[data.win_slot];
	$('.opencase-opened-drop').html(thing_win.name_first);
	var regV = /110fx82f/; 
	var srcWinImg = thing_win.image.replace(regV, '385fx287f');
	$('.opencase-opened-image img').attr('src', srcWinImg);


	var start = parseInt( $('.opencase-top-carousel-line').css('left') ),
		slot_width = $('.opencase-top-carousel-line-item').outerWidth(true),
		offset = data.win_slot * slot_width + rand,
		position = 0,
		interval = setInterval(function(){
			var offset = parseInt( $('.opencase-top-carousel-line').css('left') ) - start,
				position_actual = Math.floor(offset / slot_width);

			if(position_actual !== position){
				var sound = $('audio#case_scroll')[0];
				sound.pause();
				sound.currentTime = 0;
				sound.play();
			}
			position = position_actual;
		}, 10);
	
	$('audio#case_open')[0].play();
	
	$('.opencase-top-carousel-line')
	.css('left', '')
	.animate({ left: '-=' + offset }, 380 * data.win_slot, 'easeOutQuad', function(){
		$('audio#item_reveal')[0].play();
		clearInterval(interval);

		$('.opencase-top-carousel, .opencase-bottom-opening').hide();
		$('.opencase-top-case, .opencase-bottom-open').show();

		$('.opencase-top, .opencase-bottom').hide();
		$('.opencase-opened').show();
	});

	kek = apiUrl+"?action=sellItem&item_id="+data.info.item_id;
	$('.opencase-opened-actions-one.s__sell')
	.attr('href', kek)
	.children('.opencase-opened-actions-one-text')
		.html('Продать за ' + data.info.cost  + 'р');
	//$('.__inspect').attr('href', 'steam://rungame/' + data.info.ingame.ingame_appid + '/' + data.info.ingame.ingame_owner + '/+csgo_econ_action_preview%20' + data.info.ingame.ingame_hash);
};

$('.opencase-bottom-open').on('click', function(event){
	__openCase();
	
	event.preventDefault();
	return false;
});
$('.opencase-opened-actions-one.s__again').on('click', function(event){
	$('.opencase-opened').hide();
	$('.opencase-top, .opencase-bottom').show();
});

!function __last_drops(){
	$.ajax({
		url: apiUrl,
		type: 'post',
		data: {action: 'liveDrop', tlast: timelast},
		dataType: 'json',
		success: function(rdata){
			if('true' == rdata.result){	
				timelast = rdata.timelast;
				var els_max = Math.floor($('.live-line').width() / $('.live-line-item').width());
				if(rdata.last_drops != null) {
					$.each(rdata.last_drops, function(_, v){
						$('.line').prepend(
							$('<a href=/user/'+ v.steam +' class="item '+ v.rare +'">')
							.append(
								$('<figure class="cell"><img src="' + v.image + '" alt=""/></figure>')
							)
							.append(
								$('<div style="background:url(' + v.case_img + ') 50% 50% / contain no-repeat;" class="last-wins_hover-info">')
								.append(
									$('<div class="text">')
									.append('<span>' + v.nick + '</span>')
									.append('<span class="ago">' + v.name + '</span></div></a>')
								)
							)
							//.css('display', 'none')
							//.fadeIn(100)
						);
						$('.opened').html('<span>' + rdata.total.opened + '</span>')
						$('.regusers').html('<span>' + rdata.total.regusers + '</span>')
						$('.onusers').html('<span>' + rdata.total.onusers + '</span>')
					});
				}
			}

			setTimeout(__last_drops, 10000);
		}
	});
}();
});