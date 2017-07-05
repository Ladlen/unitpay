QIWI = {
    load: false,
    name: '',
    order: false,
    amount: false,
	status: false,
    phone: '',
    main: {
        init: function() {
            QIWI['amount'] = QIWI['amount'];
            a = "";
            if (QIWI['amount'] > 0 && QIWI['order'] != "") {
                a = QIWI.html[3];
                a = a.replace(/ONCLICK/, 'QIWI.main.pay()');
                a = a.replace(/NAME/, 'Оплатить');
                b = QIWI.html[4];
                b = b.replace(/AMOUNT/g, QIWI['amount']);
                c = QIWI.html[5];
                c = c.replace(/AMOUNT/g, QIWI['amount'])
            } else {
                e = QIWI.html[2];
                e = e.replace(/TYPE/, 'error');
                e = e.replace(/ICON/, 'fa fa-times-circle');
                e = e.replace(/ALERT/, 'Неверные параметры платежа')
            }
            d = QIWI.html[0];
            d = d.replace(/NAME/, QIWI['name']);
            d = d.replace(/ORDER/, (QIWI['order'] != "" ? QIWI['order'] : "Неизвестная ошибка"));
            d = d.replace(/AMOUNT/g, QIWI['amount']);
            d = d.replace(/FOOTER/, QIWI.html[1]);
            d = d.replace(/BUTTON/, a);
            d = d.replace(/NOTIFY/, (QIWI['amount'] > 0 && QIWI['order'] != "" ? "" : e));
            d = d.replace(/CONTENT/, (QIWI['amount'] > 0 && QIWI['order'] != "" ? b : ""));
            d = d.replace(/BLOCK/, (QIWI['amount'] > 0 && QIWI['order'] != "" ? c : ""));
            d = d.replace('<section class="checkout-section checkout-continue" data-reactid=".0.1:0:2.1"><div class="checkout-section-wrap button" data-reactid=".0.1:0:2.1.0"></div></section>', '');
            $(".content").html(d)
        },
        loader: function() {
            if (QIWI['load'] == true) {
                QIWI['load'] = false;
                $(".loader").show()
            } else {
                QIWI['load'] = true;
                $(".loader").hide()
            }
        },
        check: function() {
			if(QIWI.status == false) {
				QIWI.main.loader();
				a = QIWI.html[2];
				a = a.replace(/TYPE/, "waiting");
				a = a.replace(/ICON/, "fa-clock-o");
				a = a.replace(/ALERT/, "Выполняется поиск вашего платежа..");
				$('.notification').html(a);
				setTimeout(function() {
					b = QIWI.html[2];
					$.get("/order/"+QIWI['link'], function(data) {
						try {
							obj = JSON.parse(data);
							b = b.replace(/TYPE/, obj.type);
							b = b.replace(/ICON/, (obj.type == "success" ? "fa-chevron-circle-down" : "fa fa-times-circle"));
							b = b.replace(/ALERT/, obj.alert);
							if (obj.type == "success") {
								QIWI.status = true;
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
						QIWI.main.loader()
					})
				}, 1000);
			}
        },
        pay: function() {
            a = QIWI.html[2];
            a = a.replace(/TYPE/, "success");
            a = a.replace(/ICON/, "fa-lock");
            a = a.replace(/ALERT/, "Выполняется переход на QIWI..");
            $('.notification').html(a);
            setTimeout(function() {
                a = QIWI.html[2];
                a = a.replace(/TYPE/, "waiting");
                a = a.replace(/ICON/, "fa-share");
                a = a.replace(/ALERT/, "Нажмите кнопку Далее после оплаты..");
                $('.notification').html(a)
            }, 500);
            setTimeout(function() {
                $('.notification').html(a);
				
				var amount = QIWI['amount'];
				var sum = amount.split(".");
				
                window.open("https://w.qiwi.com/transfer/form.action?extra%5B%27account%27%5D=" + QIWI['phone'] + "&amountInteger=" + sum[0] + "&amountFraction="+ sum[1] +"&extra%5B%27comment%27%5D=" + QIWI['order'])
            }, 1000);
            b = QIWI.html[3];
            b = b.replace(/ONCLICK/, 'QIWI.main.check()');
            b = b.replace(/NAME/, 'Далее');
            setInterval(QIWI.main.check, 10000);
            $(".button").html(b)
        },
    },
    html: ['<div data-reactid=".0.1:0:2"><section class="checkout-section"><div class="checkout-section-wrap" data-reactid=".0.1:0:2.0.0"><div class="checkout-carrier-info" data-reactid=".0.1:0:2.0.0.0"><div class="checkout-carrier" data-reactid=".0.1:0:2.0.0.0.0"><h1 class="checkout-carrier-title" data-reactid=".0.1:0:2.0.0.0.0.0">NAME</h1><p class="checkout-carrier-text" data-reactid=".0.1:0:2.0.0.0.0.1">ORDER</p>BLOCK</div>NOTIFY</div>CONTENT</div></section><section class="checkout-section checkout-continue" data-reactid=".0.1:0:2.1"><div class="checkout-section-wrap button" data-reactid=".0.1:0:2.1.0">BUTTON</div></section></div><div class="qw-identification-form" data-reactid=".0.1:1">FOOTER</div>', '<section class="qw-identification-form-footer" zata-reactid=".0.1:1.0"><div class="qw-identification-form-footer-support" data-reactid=".0.1:1.0.0"><span data-reactid=".0.1:1.0.0.0">Служба поддержки QIWI +7 495 777-74-94 (Москва)</span><br data-reactid=".0.1:1.0.0.1"><span data-reactid=".0.1:1.0.0.2">8 800 707-77-59 (регионы, бесплатный номер)</span></div></section>', '<div class="checkout-alert checkout-alert-TYPE" data-reactid=".0.1:0:1"><div class="checkout-sep" data-reactid=".0.1:0:1.0"></div><div class="checkout-alert-wrapper" data-reactid=".0.1:0:1.1"><div class="checkout-alert-icon" data-reactid=".0.1:0:1.1.0"><span class="fa ICON" data-reactid=".0.1:0:1.1.0.0"></span></div><div class="checkout-alert-content" data-reactid=".0.1:0:1.1.1"><span data-reactid=".0.1:0:1.1.1.0">ALERT</span></div></div></div>', '<button id="processPayment" class="btn" data-reactid=".0.1:0:2.1.0.0" onclick="ONCLICK"><span data-reactid=".0.1:0:2.1.0.0.0">NAME</span></button>', '<div class="checkout-sep" data-reactid=".0.1:0:2.0.0.1"></div><div class="checkout-billing-header" data-reactid=".0.1:0:2.0.0.2"><h2 class="checkout-billing-title" data-reactid=".0.1:0:2.0.0.2.0"><span data-reactid=".0.1:0:2.0.0.2.0.0"><span data-reactid=".0.1:0:2.0.0.2.0.0.0">Оплата с </span><span data-reactid=".0.1:0:2.0.0.2.0.0.1">Рублевого</span><span data-reactid=".0.1:0:2.0.0.2.0.0.2"> счёта Visa QIWI Wallet</span></span></h2></div><div class="checkout-billing-content" data-reactid=".0.1:0:2.0.0.3"><div class="checkout-billing-content-field" data-reactid=".0.1:0:2.0.0.3.0"><div class="checkout-billing-content-title" data-reactid=".0.1:0:2.0.0.3.0.0"><span data-reactid=".0.1:0:2.0.0.3.0.0.0">Ваша покупка</span></div><div class="checkout-billing-content-amount" data-reactid=".0.1:0:2.0.0.3.0.1"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.3.0.1.0"><span data-reactid=".0.1:0:2.0.0.3.0.1.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.3.0.1.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.3.0.1.0.2"></i></span></div></div><div class="checkout-billing-content-field checkout-billing-content-total" data-reactid=".0.1:0:2.0.0.3.2"><div class="checkout-billing-content-title" data-reactid=".0.1:0:2.0.0.3.2.0"><span data-reactid=".0.1:0:2.0.0.3.2.0.0">Сумма к оплате</span></div><div class="checkout-billing-content-amount" data-reactid=".0.1:0:2.0.0.3.2.1"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.3.2.1.0"><span data-reactid=".0.1:0:2.0.0.3.2.1.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.3.2.1.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.3.2.1.0.2"></i></span></div></div><div class="notification"></div></div><noscript data-reactid=".0.1:0:2.0.0.4"></noscript>', '<div class="checkout-carrier-amount" data-reactid=".0.1:0:2.0.0.0.0.2"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.0.0.2.0"><span data-reactid=".0.1:0:2.0.0.0.0.2.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.0.0.2.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.0.0.2.0.2"></i></span></div>', ]
};
$(document).ready(function() {
    setTimeout(function() {
        QIWI.main.loader();
        QIWI.main.init()
    }, 500)
});