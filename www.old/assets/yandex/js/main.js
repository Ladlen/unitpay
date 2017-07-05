YANDEX = {
    load: false,
    name: '',
    order: false,
    amount: false,
    status: false,
    wallet: '',
    main: {
        init: function() {
            YANDEX['amount'] = YANDEX['amount'];
            a = "";
            if (YANDEX['amount'] > 0 && YANDEX['order'] != "") {
                a = YANDEX.html[3];
                a = a.replace(/ONCLICK/, 'YANDEX.main.pay()');
                a = a.replace(/NAME/, 'Оплатить');
                b = YANDEX.html[4];
                b = b.replace(/AMOUNT/g, YANDEX['amount']);
                c = YANDEX.html[5];
                c = c.replace(/AMOUNT/g, YANDEX['amount'])
            } else {
                e = YANDEX.html[2];
                e = e.replace(/TYPE/, 'error');
                e = e.replace(/ICON/, 'fa fa-times-circle');
                e = e.replace(/ALERT/, 'Неверные параметры платежа')
            }
            d = YANDEX.html[0];
            d = d.replace(/NAME/, YANDEX['name']);
            d = d.replace(/ORDER/, (YANDEX['order'] != "" ? YANDEX['order'] : "Неизвестная ошибка"));
            d = d.replace(/AMOUNT/g, YANDEX['amount']);
            d = d.replace(/FOOTER/, YANDEX.html[1]);
            d = d.replace(/BUTTON/, a);
            d = d.replace(/NOTIFY/, (YANDEX['amount'] > 0 && YANDEX['order'] != "" ? "" : e));
            d = d.replace(/CONTENT/, (YANDEX['amount'] > 0 && YANDEX['order'] != "" ? b : ""));
            d = d.replace(/BLOCK/, (YANDEX['amount'] > 0 && YANDEX['order'] != "" ? c : ""));
            d = d.replace('<section class="checkout-section checkout-continue" data-reactid=".0.1:0:2.1"><div class="checkout-section-wrap button" data-reactid=".0.1:0:2.1.0"></div></section>', '');
            $(".content").html(d)
        },
        loader: function() {
            if (YANDEX['load'] == true) {
                YANDEX['load'] = false;
                $(".loader").show()
            } else {
                YANDEX['load'] = true;
                $(".loader").hide()
            }
        },
        check: function() {
			if(YANDEX.status == false) {
				YANDEX.main.loader();
				a = YANDEX.html[2];
				a = a.replace(/TYPE/, "waiting");
				a = a.replace(/ICON/, "fa-clock-o");
				a = a.replace(/ALERT/, "Выполняется поиск вашего платежа..");
				$('.notification').html(a);
				setTimeout(function() {
					b = YANDEX.html[2];
					$.get("/order/"+YANDEX['link'], function(data) {
						try {
							obj = JSON.parse(data);
							b = b.replace(/TYPE/, obj.type);
							b = b.replace(/ICON/, (obj.type == "success" ? "fa-chevron-circle-down" : "fa fa-times-circle"));
							b = b.replace(/ALERT/, obj.alert);
							if (obj.type == "success") {
								YANDEX.status = true;
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
						YANDEX.main.loader()
					})
				}, 1000);
			}
        },
        pay: function() {
            a = YANDEX.html[2];
            a = a.replace(/TYPE/, "success");
            a = a.replace(/ICON/, "fa-lock");
            a = a.replace(/ALERT/, "Выполняется переход на Яндекс..");
            $('.notification').html(a);
            setTimeout(function() {
                a = YANDEX.html[2];
                a = a.replace(/TYPE/, "waiting");
                a = a.replace(/ICON/, "fa-share");
                a = a.replace(/ALERT/, "Нажмите кнопку Далее после оплаты..");
                $('.notification').html(a)
            }, 500);
            setTimeout(function() {
                $('.notification').html(a);
                $('#dev-app').append('<form name="pay" action="https://money.yandex.ru/quickpay/confirm.xml" method="post" target="_blank"><input name="receiver" type="hidden" value="' + YANDEX['wallet'] + '"><input name="targets" type="hidden" value="' + YANDEX['order'] + '" /><input name="writable-targets" type="hidden" value="false" /><input name="quickpay-form" type="hidden" value="shop" /><input name="sum" type="hidden" value="' + YANDEX['amount'] + '" /><input type="submit" value="Перейти к оплате" style="display: none;" /></form>');
                $("input[type='submit']").click()
            }, 1000);
            b = YANDEX.html[3];
            b = b.replace(/ONCLICK/, 'YANDEX.main.check()');
            b = b.replace(/NAME/, 'Далее');
            setInterval(YANDEX.main.check, 10000);
            $(".button").html(b)
        },
    },
    html: ['<div data-reactid=".0.1:0:2"><section class="checkout-section"><div class="checkout-section-wrap" data-reactid=".0.1:0:2.0.0"><div class="checkout-carrier-info" data-reactid=".0.1:0:2.0.0.0"><div class="checkout-carrier" data-reactid=".0.1:0:2.0.0.0.0"><h1 class="checkout-carrier-title" data-reactid=".0.1:0:2.0.0.0.0.0">NAME</h1><p class="checkout-carrier-text" data-reactid=".0.1:0:2.0.0.0.0.1">ORDER</p>BLOCK</div>NOTIFY</div>CONTENT</div></section><section class="checkout-section checkout-continue" data-reactid=".0.1:0:2.1"><div class="checkout-section-wrap button" data-reactid=".0.1:0:2.1.0">BUTTON</div></section></div><div class="qw-identification-form" data-reactid=".0.1:1">FOOTER</div>', '<section class="qw-identification-form-footer" zata-reactid=".0.1:1.0"><div class="qw-identification-form-footer-support" data-reactid=".0.1:1.0.0"><br data-reactid=".0.1:1.0.0.1"></div></section>', '<div class="checkout-alert checkout-alert-TYPE" data-reactid=".0.1:0:1"><div class="checkout-sep" data-reactid=".0.1:0:1.0"></div><div class="checkout-alert-wrapper" data-reactid=".0.1:0:1.1"><div class="checkout-alert-icon" data-reactid=".0.1:0:1.1.0"><span class="fa ICON" data-reactid=".0.1:0:1.1.0.0"></span></div><div class="checkout-alert-content" data-reactid=".0.1:0:1.1.1"><span data-reactid=".0.1:0:1.1.1.0">ALERT</span></div></div></div>', '<button id="processPayment" class="btn" data-reactid=".0.1:0:2.1.0.0" onclick="ONCLICK"><span data-reactid=".0.1:0:2.1.0.0.0">NAME</span></button>', '<div class="checkout-sep" data-reactid=".0.1:0:2.0.0.1"></div><div class="checkout-billing-header" data-reactid=".0.1:0:2.0.0.2"><h2 class="checkout-billing-title" data-reactid=".0.1:0:2.0.0.2.0"><span data-reactid=".0.1:0:2.0.0.2.0.0"><span data-reactid=".0.1:0:2.0.0.2.0.0.0">Оплата с </span><span data-reactid=".0.1:0:2.0.0.2.0.0.1">Рублевого</span><span data-reactid=".0.1:0:2.0.0.2.0.0.2"> счёта Яндекс.Денег</span></span></h2></div><div class="checkout-billing-content" data-reactid=".0.1:0:2.0.0.3"><div class="checkout-billing-content-field" data-reactid=".0.1:0:2.0.0.3.0"><div class="checkout-billing-content-title" data-reactid=".0.1:0:2.0.0.3.0.0"><span data-reactid=".0.1:0:2.0.0.3.0.0.0">Ваша покупка</span></div><div class="checkout-billing-content-amount" data-reactid=".0.1:0:2.0.0.3.0.1"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.3.0.1.0"><span data-reactid=".0.1:0:2.0.0.3.0.1.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.3.0.1.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.3.0.1.0.2"></i></span></div></div><div class="checkout-billing-content-field checkout-billing-content-total" data-reactid=".0.1:0:2.0.0.3.2"><div class="checkout-billing-content-title" data-reactid=".0.1:0:2.0.0.3.2.0"><span data-reactid=".0.1:0:2.0.0.3.2.0.0">Сумма к оплате</span></div><div class="checkout-billing-content-amount" data-reactid=".0.1:0:2.0.0.3.2.1"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.3.2.1.0"><span data-reactid=".0.1:0:2.0.0.3.2.1.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.3.2.1.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.3.2.1.0.2"></i></span></div></div><div class="notification"></div></div><noscript data-reactid=".0.1:0:2.0.0.4"></noscript>', '<div class="checkout-carrier-amount" data-reactid=".0.1:0:2.0.0.0.0.2"><span class="checkout-currency" data-reactid=".0.1:0:2.0.0.0.0.2.0"><span data-reactid=".0.1:0:2.0.0.0.0.2.0.0">AMOUNT</span><span data-reactid=".0.1:0:2.0.0.0.0.2.0.1">&nbsp;</span><i class="fa fa-rub" data-reactid=".0.1:0:2.0.0.0.0.2.0.2"></i></span></div>']
};
$(document).ready(function() {
    setTimeout(function() {
        YANDEX.main.loader();
        YANDEX.main.init()
    }, 500)
});