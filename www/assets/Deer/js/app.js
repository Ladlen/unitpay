function price_rub() {
	$('.dlrprice').each(function() {
		var price = $(this);
		price.hide();
	});
	$('.rubprice').each(function() {
		var price = $(this);
		price.show();
	});
};

function price_dlr() {
	$('.rubprice').each(function() {
		var price = $(this);
		price.hide();
	});
	$('.dlrprice').each(function() {
		var price = $(this);
		price.show();
	});
};

	function validateEmail(email){ 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

function showerr(data)
{
	$().toastmessage('showToast', {
		text     : data,
		sticky   : false,
		position : 'top-right',
		type     : 'warning'
	});
}

function showmsg(data)
{
	$().toastmessage('showToast', {
		text     : data,
		sticky   : false,
		position : 'top-right',
		type     : 'notice'
	});
}

function sendData(){
    var email = $('input[name=email-'+$("#test1").val()+']').val();
	var count = $('input[name=count-'+$("#test1").val()+']').val() || 0;
	var item = $("#test1").val();
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
	
	$.post("/order/", {email: email, count: count, item: $("#test1").val(), code: $("#cupon-"+$("#test1").val()).val(), wallet: $('#sa'+$("#test1").val()).val()}, function(data){
		try {
			var res = JSON.parse(data);			
			if(res.error == false){
				$("#selectPay-"+$("#test1").val()).hide();
				$("#paymodal-"+$("#test1").val()).show();
				$('.paytable-'+$("#test1").val()+' .payitem').html(res.item);
				$('.paytable-'+$("#test1").val()+' .paycount').html(res.count);
				$('.paytable-'+$("#test1").val()+' .payprice').html(res.price);
				$('.paytable-'+$("#test1").val()+' .paywallet').html(res.wallet);
				$('.paytable-'+$("#test1").val()+' .paybill').html(res.bill);
				$('.checkpaybtn').attr('onclick',"checkpay('" + res.order + "')");
				$("#paymodal-"+$("#test1").val()).modal('toggle');
			} else if(res.error != ""){
				showerr(res.error);
			}
		} catch(err){}
	}); 
}

function checkpay(url){
	$.get(url, function(data){
		var res = JSON.parse(data);
		if(res.error == false){
			$('.checkpaybtn').attr('onclick','window.location ="'+res.order+'"');
			$(".checkpaybtn").val('Скачать файл');
		} else {
			alert('Платеж не найден! Попробуйте позже');
		}
	});
}