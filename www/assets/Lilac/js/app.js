function price_rub() {
    $('.dlrprice').each(function () {
        var price = $(this);
        price.hide();
    });
    $('.rubprice').each(function () {
        var price = $(this);
        price.show();
    });
};

function price_dlr() {
    $('.rubprice').each(function () {
        var price = $(this);
        price.hide();
    });
    $('.dlrprice').each(function () {
        var price = $(this);
        price.show();
    });
};

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function showerr(data) {
    $().toastmessage('showToast', {
        text: data,
        sticky: false,
        position: 'top-right',
        type: 'warning'
    });
}

function showmsg(data) {
    $().toastmessage('showToast', {
        text: data,
        sticky: false,
        position: 'top-right',
        type: 'notice'
    });
}

function sendData() {
	var _el = jQuery('.fbox:last');
    var email = _el.find('input[name=email]').val();
    var countAccs = _el.find('input[name=count]').val() || 0;
    var selectType = _el.find('input[name=item]').val();
	// var bonus = _el.find('input[name=bonus]:checked').val();
    // var minCount = _el.find('option[value="' + selectType + '"]').attr('data-min_order');
    // var countType = _el.find('td[data-id=' + selectType + ']').html();
    if (!validateEmail(email)) {
        var err = 'Указан неверный email адрес';
        showerr(err);
        return false;
    }

    $.post("/order/", {
        email: email,
        count: countAccs,
		// bonus: bonus,
        type: selectType,
        fund: $('select[name=funds]').val(),
		'copupon': _el.find('#copupon').val() 
    }, function (data) {
        try {
            var res = JSON.parse(data);
            if (res.ok == 'TRUE') {
                $('.payitem').html(res.name);
                $('.paycount').text(res.count);
                $('.payprice').text(res.price);
                $('.payfund').html(res.fund);
                $('.paybill').html(res.bill);
				$('.discount').html(res.discount);
				$('.bonuspr').html(res.bonus);
				$('.link').html(res.linkwm);
                $('.checkpaybtn').attr('onclick', "checkpay('" + res.check_url + "')");
                // $('#paymodal').modal('toggle')
				// $(".gg").trigger( "click" );
				
				var $fancyTpl_btn = {
		wrap     : '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div><a title="Close" class="fancybox-item fancybox-close" href="javascript:;"><i class="icon-exit"></i></a></div></div>',
		closeBtn : '',
		next     : '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
		prev     : '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
	};
		$.fancybox({
			'type':'html',
			'content' : $('#get-item-buy-check').html(),
			'openEffect'  : 'fade',
			'closeEffect' : 'fade',
			'nextEffect'  : 'elastic',
			'prevEffect'  : 'elastic',
			'padding' : [0,0,0,0],
			'wrapCSS' : 'fanbox',
			'fitToView' : false,
			'tpl' : $fancyTpl_btn
		});
		
            }
            if (typeof (res.error) !== "undefined" && res.error !== null) {
                showerr(res.error);
            }
        } catch (err) {
            alert('Настройки оплаты не верны! \r\nСообщите продавцу об этом!');
        }
    });
}


function checkpay(url) {
    // $('.checkpaybtn').button('loading');
	 $('.checkpaybtn').text('Проверяем платеж...');
	 $('.checkpaybtn').prop( "disabled", true );
    $.get(url, function (data) {
        // $('.checkpaybtn').button('reset');
        var res = JSON.parse(data);
		if (res.status == "wait_30_sec") {
            alert('Повторите пожалуйста запрос через 30 секунд! ');
			$('.checkpaybtn').prop( "disabled", false );
			$('.checkpaybtn').text('Проверить');
			throw "stop";
        }
		if (res.status == "reset_pass") {
            alert('Владельцу магазина необходимо обновить пароль своего QIWI кошелька! ');
			$('.checkpaybtn').prop( "disabled", false );
			$('.checkpaybtn').text('Проверить');
			throw "stop";
        }
		if (res.status == "Bad_log_pass" || res.status == "error_log_pass") {
            alert('Владельцу магазина необходимо проверить правильность ввода данных QIWI кошелька! ');
			$('.checkpaybtn').prop( "disabled", false );
			$('.checkpaybtn').text('Проверить');
			throw "stop";
			
        }
		
        if (res.status == "ok") {
			$('.checkpaybtn').prop( "disabled", false );
            $('.checkpaybtn').attr('onclick', 'window.location ="' + res.chkurl + '"');
            $('.checkpaybtn').text('Скачать');
        } else {
            alert('Платеж не найден :(  Попробуйте еще раз через мгновение :) ');
			$('.checkpaybtn').prop( "disabled", false );
			$('.checkpaybtn').text('Проверить');
			
        }
    });
}


			
			
			function chkp(url) {
    $('.checkpaybtnr').button('loading');
    $.get(url, function (data) {
        $('.checkpaybtnr').button('reset');
        var res = JSON.parse(data);
        if (res.status == "ok") {
            $('.checkpaybtnr').attr('onclick', 'window.location ="' + res.chkurl + '"');
            $('.checkpaybtnr').text('Скачать');
        } else  {
            alert('Увы , но платеж не найден.')
        }
    });
}

function qq(){
var search =  $('#search').val();
$.ajax({
  type: 'GET',
  url: '/',
  data: "search="+search,
  success: function(data){
    $('div.layer').html(data);
  }
});
}

