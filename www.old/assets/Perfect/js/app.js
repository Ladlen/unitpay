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

function sendData() {
    //читаем данные из формы
    var email = $('input[name=email]').val();
	var countAccs = $('input[name=count]').val() || 0;
	var selectType = $('select[name=item]').val();
	var minCount = $('option[value="' + selectType + '"]').attr('data-min_order');
	var countType = $('td[data-id=' + selectType + ']').html();
	
	if (!validateEmail(email))
	{
		var err = 'Указан неверный email адрес';
		showerr(err);
		return false;
	}
	
	if (parseInt(countAccs) < parseInt(minCount))
	{
		var err = 'Мин. кол-во для заказа: ' + minCount;
		showerr(err);
		return false;
	}
	
	if (parseInt(countType) < parseInt(countAccs))
	{
		var err = 'Такого количества товара нет';
		showerr(err);
		return false;
	}
	
	$.post("/order/", { email: email, count:countAccs, type: selectType, fund: $('select[name=funds]').val(), cupon: $('#cupon').val()},
	function(data) {
		try
        {
			var res = JSON.parse(data);
			if(res.ok == 'TRUE')
			{
				$('.paytable .payitem').text(res.name);
				$('.paytable .paycount').text(res.count);
				$('.paytable .payprice').text(res.price);
				$('.paytable .paypercentage').text(res.percentage);
				$('.paytable .paysposob').text(res.sposob);
				$('.paytable .payfund').html(res.fund);
				$('.paytable .paybill').html(res.bill);
				$('.checkpaybtn').attr('onclick',"checkpay('" + res.check_url + "')");
				$('#paymodal').modal('toggle')
			}
			if(typeof(res.error) !== "undefined" && res.error !== null) {
				showerr(res.error);
			}
		}
		catch(err)
		{
			alert('Произошла ошибка. Попробуйте еще раз!');
		}
		
		
	});
            
}

function checkpay(url)
{
$('.checkpaybtn').button('loading');
$.get(url, function(data) {
  $('.checkpaybtn').button('reset');
  var res = JSON.parse(data);
  if(res.status == "ok")
  {
	$('.checkpaybtn').attr('onclick','window.location ="'+res.chkurl+'"');
	$('.checkpaybtn').text('Скачать');
  }
  else
  {
	alert('Платеж не найден! Попробуйте позже')
  }
});
}