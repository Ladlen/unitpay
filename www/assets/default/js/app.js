var code = ""; 
function price_rub(){
	$('.dlrprice').each(function(){
		var price = $(this);
		price.hide();
	});
	$('.rubprice').each(function(){
		var price = $(this);
		price.show();
	});
}

function price_dlr(){
	$('.rubprice').each(function(){
		var price = $(this);
		price.hide();
	});
	$('.dlrprice').each(function(){
		var price = $(this);
		price.show();
	});
}

function validateEmail(email){ 
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function showerr(data){
	$().toastmessage('showToast', {
		text     : data,
		sticky   : false,
		position : 'top-right',
		type     : 'warning'
	});
}

function showmsg(data){
	$().toastmessage('showToast', {
		text     : data,
		sticky   : false,
		position : 'top-right',
		type     : 'notice'
	});
}


function sendData(){
    var email = $('input[name=email]').val();
	var count = $('input[name=count]').val() || 0;
	var item = $('select[name=item]').val();
	var minCount = $('option[value="' + item + '"]').attr('data-min_order');
	var countItem = $('td[data-id=' + item + ']').html();

	if (!validateEmail(email)){
		var err = 'Указан неверный email адрес';
		showerr(err);
		return false;
	}
	
	if (parseInt(count) < parseInt(minCount)){
		var err = 'Мин. кол-во для заказа: ' + minCount;
		showerr(err);
		return false;
	}
	
	if (parseInt(countItem) < parseInt(count)){
		var err = 'Такого количества товара нет';
		showerr(err);
		return false;
	}

	$("#loading").show();
	$.post("/order/", {email: email, count: count, item: item, code: code, wallet: $('select[name=wallets]').val()}, function(data){
		try {
			var res = JSON.parse(data);
			if(res.error == false){
				$('.checkpaybtn').text('Проверить');
				$('.paytable .payitem').text(res.item);
				$('.paytable .paycount').text(res.count);
				$('.paytable .payprice').text(res.price);
				$('.paytable .paywallet').html(res.wallet);
				$('.paytable .paybill').html(res.bill);
				$('.paykc').html(res.paykc);
				$('.checkpaybtn').attr('onclick',"checkpay('" + res.order + "')");
				$('#paymodal').modal('toggle');
				$("#loading").hide();
			} else if(res.error){
				$("#loading").hide();
				showerr(res.error);
			}
		} catch(err){
			$("#loading").hide();
			alert('Настройки для этого метода оплаты неверны! \r\nСообщите продавцу об этом!');
		}
	}); 
}

function checkpay(url){
	$('.checkpaybtn').button('loading');
	$.get(url, function(data) {
		$('.checkpaybtn').button('reset');
		var res = JSON.parse(data);
		if(res.error == false){
			$('.checkpaybtn').attr('onclick','window.location ="'+res.order+'"');
			$('.checkpaybtn').text('Скачать');
		} else {
			alert('Платеж не найден! Попробуйте позже');
		}
	});
}

$(document).ready(function(){
  var inpcp;
  var svcpn;
  $('#coupon').popover({
  	html: true,
  	placement: 'left',
 	content: function() {
		inpcp = $(this).parent().find('.popover_content');
		inpcp.find('input').attr('value', coupon);
  		return inpcp.html();
  	}
  });
  $('#coupon').click(function (e) {
	svcpn = $(this).parent().find('.popover').find('input');
  	svcpn.bind("change paste keyup", function() {
       code = $(this).val(); 
    });
  });
  $('body').on('click', function (e) {
      $('#coupon').each(function () {
          if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
			$(this).popover('hide');
          }
      });
  });
});