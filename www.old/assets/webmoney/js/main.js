WEBMONEY = {
	load: false,
	page: 'init',	
	name: 'Merchant',
	order: false,
	amount: false,
	status: false,
	wallet: false,
	system: false,
	
	main: {
		init: function(){
            a = "";
            if (WEBMONEY['amount'] > 0 && WEBMONEY['order'] != "") {
				a = WEBMONEY.html[3];
				a = a.replace('<button id="processPayment" class="btn" data-reactid=".0.1:0:2.1.0.0" onclick="ONCLICK"><span data-reactid=".0.1:0:2.1.0.0.0">NAME</span>', '<button id="processPayment" class="btn" data-reactid=".0.1:0:2.1.0.0" onclick="ONCLICK" style="position: relative; left: -3px;"><span data-reactid=".0.1:0:2.1.0.0.0">NAME</span> <button id="processPayment" class="btn" data-reactid=".0.1:0:2.1.0.0" onclick="ONCLICK1" style="position: relative; right: -3px;"><span data-reactid=".0.1:0:2.1.0.0.0">NAME1</span>');
				a = a.replace(/ONCLICK1/, 'WEBMONEY.main.payMini()');
				a = a.replace(/NAME1/, 'Mini');
				a = a.replace(/ONCLICK/, 'WEBMONEY.main.payKeeper()');
				a = a.replace(/NAME/, 'Keeper');
			} else {
                e = WEBMONEY.html[2];
                e = e.replace(/TYPE/, 'error');
                e = e.replace(/ICON/, 'fa fa-times-circle');
                e = e.replace(/ALERT/, 'Неверные параметры платежа')
			}
			
			b = WEBMONEY.html[5];
			b = b.replace(/AMOUNT/g, WEBMONEY['amount'])
			b = b.replace(/SYSTEM/, WEBMONEY['system']);
			
			c = WEBMONEY.html[0];
			c = c.replace(/NAME/, WEBMONEY['name']);
			c = c.replace(/ORDER/, (WEBMONEY['order'] != "" ? WEBMONEY['order'] : "Неизвестная ошибка"));
			
			c = c.replace(/NOTIFY/, (WEBMONEY['amount'] > 0 && WEBMONEY['order'] != "" ? "" : e));
            c = c.replace(/CONTENT/, (WEBMONEY['amount'] > 0 && WEBMONEY['order'] != "" ? b : ""));			
			c = c.replace(/BLOCK/, '');
			c = c.replace(/SYSTEM/, WEBMONEY['system']);
			c = c.replace(/FOOTER/, '');
			c = c.replace(/BUTTON/, a);
			c = c.replace('<section class="checkout-section checkout-continue" data-reactid=".0.1:0:2.1" style="height: 90px;"><div class="checkout-section-wrap button" data-reactid=".0.1:0:2.1.0"></div></section>', '');
			
			$(".content").html(c);
		},
		loader: function(){
			if(WEBMONEY['load'] == true){
				WEBMONEY['load'] = false;
				$(".loader").show();
			} else {
				WEBMONEY['load'] = true;
				$(".loader").hide();
			}
		},
		check: function(){
			if(WEBMONEY.status == false) {
				WEBMONEY.main.loader();
				
				a = WEBMONEY.html[2];
				
				setTimeout(function() {
					b = WEBMONEY.html[2];
					$.get("/order/"+WEBMONEY['link'], function(data) {
						try {
							obj = JSON.parse(data);
							b = b.replace(/TYPE/, obj.type);
							b = b.replace(/ICON/, (obj.type == "success" ? "fa-chevron-circle-down" : "fa fa-times-circle"));
							b = b.replace(/ALERT/, obj.alert);
							if (obj.type == "success") {
								WEBMONEY.status = true;
								$(".checkout-continue").remove();
								location.href = obj.order;
								setTimeout(function() {
									location.href = "http://"+location.host;
								}, 2000);
							}
						} catch (err) {
							b = b.replace(/TYPE/, "error");
							b = b.replace(/ICON/, "fa fa-times-circle");
							b = b.replace(/ALERT/, "Неверный ответ сервера")
						}
						$('.notification').html(b);
						WEBMONEY.main.loader()
					})
				}, 1000);
			}
		},
		payMini: function(){
			setInterval(WEBMONEY.main.check, 10000);
			
			window.open("https://mini.webmoney.ru/SendWebMoney.aspx?Purse="+WEBMONEY['wallet']+"&Amount="+WEBMONEY['amount']+"&Description="+WEBMONEY['order']);
			
			a = WEBMONEY.html[3];
			a = a.replace(/ONCLICK/, 'WEBMONEY.main.check()');
			a = a.replace(/NAME/, 'Далее');
			
			$(".button").html(a);
			
			setInterval(function(){
				if(WEBMONEY.status == false){
					WEBMONEY.main.check();
				}
			}, 5000);
		},
		payKeeper: function(){
			setInterval(WEBMONEY.main.check, 10000);
			
			location = "wmk:payto?Purse="+WEBMONEY['wallet']+"&Amount="+WEBMONEY['amount']+"&Desc="+WEBMONEY['order']+"&BringToFront=Y";
			
			a = WEBMONEY.html[3];
			a = a.replace(/ONCLICK/, 'WEBMONEY.main.check()');
			a = a.replace(/NAME/, 'Далее');
			
			$(".button").html(a);
			
			setInterval(function(){
				if(WEBMONEY.status == false){
					WEBMONEY.main.check();
				}
			}, 5000);
		},
	},
	html: [
		'<div data-reactid=".0.1:0:2"><section class="checkout-section"><div class="checkout-section-wrap" data-reactid=".0.1:0:2.0.0"><div class="checkout-carrier-info" data-reactid=".0.1:0:2.0.0.0"><div class="checkout-carrier" data-reactid=".0.1:0:2.0.0.0.0"><h1 class="checkout-carrier-title" data-reactid=".0.1:0:2.0.0.0.0.0">NAME</h1><p class="checkout-carrier-text" data-reactid=".0.1:0:2.0.0.0.0.1">ORDER</p>BLOCK</div>NOTIFY</div>CONTENT</div></section><section class="checkout-section checkout-continue" data-reactid=".0.1:0:2.1" style="height: 90px;"><div class="checkout-section-wrap button" data-reactid=".0.1:0:2.1.0">BUTTON</div></section></div><div class="qw-identification-form" data-reactid=".0.1:1">FOOTER</div>',
		'',
		'<div class="checkout-alert checkout-alert-TYPE" data-reactid=".0.1:0:1"><div class="checkout-sep" data-reactid=".0.1:0:1.0"></div><div class="checkout-alert-wrapper" data-reactid=".0.1:0:1.1"><div class="checkout-alert-icon" data-reactid=".0.1:0:1.1.0"><span class="fa ICON" data-reactid=".0.1:0:1.1.0.0"></span></div><div class="checkout-alert-content" data-reactid=".0.1:0:1.1.1"><span data-reactid=".0.1:0:1.1.1.0">ALERT</span></div></div></div>',
		'<button id="processPayment" class="btn" data-reactid=".0.1:0:2.1.0.0" onclick="ONCLICK"><span data-reactid=".0.1:0:2.1.0.0.0">NAME</span>',
		'',
		'<div class="checkout-sep" data-reactid=".0.1:0:2.0.0.1"></div><div class="checkout-billing-header" data-reactid=".0.1:0:2.0.0.2"><h2 class="checkout-billing-title" data-reactid=".0.1:0:2.0.0.2.0"><span data-reactid=".0.1:0:2.0.0.2.0.0"><span data-reactid=".0.1:0:2.0.0.2.0.0.0">Пополнение </span><span data-reactid=".0.1:0:2.0.0.2.0.0.1">счета</span><span data-reactid=".0.1:0:2.0.0.2.0.0.2"> Webmoney</span></span></h2></div><div class="checkout-billing-content" data-reactid=".0.1:0:2.0.0.3"><div class="checkout-billing-content-field" data-reactid=".0.1:0:2.0.0.3.0"><div class="checkout-billing-content-title" data-reactid=".0.1:0:2.0.0.3.0.0"><span data-reactid=".0.1:0:2.0.0.3.0.0.0">Ваша покупка</span></div><div class="checkout-billing-content-amount" data-reactid=".0.1:0:2.0.0.3.0.1"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.3.0.1.0"><span data-reactid=".0.1:0:2.0.0.3.0.1.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.3.0.1.0.1">&nbsp;</span>SYSTEM</span></div></div><div class="checkout-billing-content-field checkout-billing-content-total" data-reactid=".0.1:0:2.0.0.3.2"><div class="checkout-billing-content-title" data-reactid=".0.1:0:2.0.0.3.2.0"><span data-reactid=".0.1:0:2.0.0.3.2.0.0">Сумма к оплате</span></div><div class="checkout-billing-content-amount" data-reactid=".0.1:0:2.0.0.3.2.1"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.3.2.1.0"><span data-reactid=".0.1:0:2.0.0.3.2.1.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.3.2.1.0.1">&nbsp;</span>SYSTEM</span></div></div><div class="notification"></div></div><noscript data-reactid=".0.1:0:2.0.0.4"></noscript>',
		'<div class="checkout-carrier-amount" data-reactid=".0.1:0:2.0.0.0.0.2"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.0.0.2.0"><span data-reactid=".0.1:0:2.0.0.0.0.2.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.0.0.2.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.0.0.2.0.2"></i></span></div>',
		'<div class="checkout-field" data-reactid=".0.1:0:2.0.0.1.0"><label for="login" class="label" data-reactid=".0.1:0:2.0.0.1.0.0"><span data-reactid=".0.1:0:2.0.0.1.0.0.0">Примечание</span></label><div class="input-wrap" data-reactid=".0.1:0:2.0.0.1.0.1"><div data-reactid=".0.1:0:2.0.0.1.0.1.0"><input class="input-text order" id="login" placeholder="ORDER" data-reactid=".0.1:0:2.0.0.1.0.1.0.0"></div><noscript data-reactid=".0.1:0:2.0.0.1.0.1.1"></noscript></div><div class="notification"></div></div>',
		'<a data-reactid=".0.1:0:2.0.0.1.2"><span data-reactid=".0.1:0:2.0.0.1.2.0" style="cursor: pointer;" onclick="WEBMONEY.main.iHaveComment()">У меня есть примечание</span></a>',
	]
};
$(document).ready(function(){
	setTimeout(function(){
		WEBMONEY.main.loader();
		WEBMONEY.main.init();
	}, 500);
});