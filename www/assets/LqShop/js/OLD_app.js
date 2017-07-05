// function price_rub() {
//     $('.dlrprice').each(function () {
//         var price = $(this);
//         price.hide();
// 	});
//     $('.rubprice').each(function () {
//         var price = $(this);
//         price.show();
// 	});
// };

// function price_dlr() {
//     $('.rubprice').each(function () {
//         var price = $(this);
//         price.hide();
// 	});
//     $('.dlrprice').each(function () {
//         var price = $(this);
//         price.show();
// 	});
// };

// function validateEmail(email) {
//     var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return re.test(email);
// }

// function showerr(data) {
//     $().toastmessage('showToast', {
//         text: data,
//         sticky: false,
//         position: 'top-right',
//         type: 'warning'
// 	});
// }

// function showmsg(data) {
//     $().toastmessage('showToast', {
//         text: data,
//         sticky: false,
//         position: 'top-right',
//         type: 'notice'
// 	});
// }

// function sendData() {
//     var email = $('input[name=email]').val();
//     var countAccs = $('input[name=count]').val() || 0;
//     var selectType = $('select[name=item]').val();
// 	var bonus = $('input[name=bonus]:checked').val();
//     var minCount = $('option[value="' + selectType + '"]').attr('data-min_order');
//     var countType = $('td[data-id=' + selectType + ']').html();
// 	const funds = $('select[name=funds]').val();
// 	const copupon = $('#copupon').val() || ''; 
// 	console.log('funds: ', funds);
// 	console.log('copupon: ', copupon);

//     if (!validateEmail(email)) {
//         var err = 'Указан неверный email адрес';
//         showerr(err);
//         return false;
// 	}
//     if (parseInt(countAccs) < parseInt(minCount)) {
//         var err = 'Мин. кол-во для заказа: ' + minCount;
//         showerr(err);
//         return false;
// 	}
//     if (parseInt(countType) < parseInt(countAccs)) {
//         var err = 'Такого количества товара нет';
//         showerr(err);
//         return false;
// 	}

//     $.post("/order/", {
//         email: email,
//         count: countAccs,
// 		bonus: bonus,
//         type: selectType,
//         fund: funds,
// 		copupon: copupon
// 		}, function (data) {
//         try {
//             var res = JSON.parse(data);
// 			console.log('res: ', res)
//             if (res.ok == 'TRUE') {

// 				if(res.redirect == 'yes'){
// 					location=res.url;
// 					document.location.href=res.url;
// 					location.replace(res.url);
// 					window.location.reload(res.url);
// 					document.location.replace(res.url);
// 				}
// 				else{
// 					$('.paytable .payitem').text(res.name);
// 					$('.paytable .paycount').text(res.count);
// 					$('.paytable .payprice').text(res.price);
// 					$('.paytable .payfund').html(res.fund);
// 					$('.paytable .paybill').html(res.bill);
// 					$('.paytable .discount').html(res.discount);
// 					$('.paytable .bonuspr').html(res.bonus);
// 					$('.paytable .link').html(res.linkwm);
// 					$('.checkpaybtn').attr('onclick', "checkpay('" + res.check_url + "')");
// 					var newpay = $('.modalpay').attr('newpay');
// 					if(newpay == '1'){	
// 						var inst = $('[data-remodal-id=paymodal]').remodal();
// 						inst.open();
// 						}else{
// 						$('#paymodal').modal('toggle');
// 					}
// 				}
// 			}
//             if (typeof (res.error) !== "undefined" && res.error !== null) {
//                 showerr(res.error);
// 			}
// 			} catch (err) {
//             alert('Что-то пошло не так, попробуйте еще раз');
// 		}
// 	});
// }

// function checkpay(url) {
//     $('.checkpaybtn').button('loading');
//     $.get(url, function (data) {
//         $('.checkpaybtn').button('reset');
//         var res = JSON.parse(data);
// 		if (res.status == "wait_30_sec") {
// 			showerr(res.message);
// 			throw "stop";
// 		}
// 		if (res.status == "reset_pass") {
// 			alert('Владельцу магазина необходимо обновить пароль своего QIWI кошелька! ')
// 			throw "stop";
// 		}
// 		if (res.status == "Bad_log_pass" || res.status == "error_log_pass") {
// 			alert('Владельцу магазина необходимо проверить правильность ввода данных QIWI кошелька! ')
// 			throw "stop";
// 		}

// 		if (res.status == "ok") {
// 			$('.checkpaybtn').attr('onclick', 'window.location ="' + res.chkurl + '"');
// 			$('.checkpaybtn').text('Скачать');
// 			} else {
// 			alert('Платеж не найден :(  Попробуйте еще раз через мгновение :) ')
// 		}
// 	});
// }




// function chkp(url) {
// 	$('.checkpaybtnr').button('loading');
// 	$.get(url, function (data) {
// 		$('.checkpaybtnr').button('reset');
// 		var res = JSON.parse(data);

// 		if (res.status == "wait_30_sec") {
// 			showerr(res.message);
// 			throw "stop";
// 		}
// 		if (res.status == "ok") {
// 			$('.checkpaybtnr').attr('onclick', 'window.location ="' + res.chkurl + '"');
// 			$('.checkpaybtnr').text('Скачать');
// 			} else  {
// 			alert('Увы , но платеж не найден.')
// 		}
// 	});
// }

// function qq(){
// 	var search =  $('#search').val();
// 	$.ajax({
// 		type: 'GET',
// 		url: '/',
// 		data: "search="+search,
// 		success: function(data){
// 			$('div.layer').html(data);
// 		}
// 	});
// }





// function GetPay(email,count,selectType,minCount,allcount,fund,coupon) {

// 	if (!validateEmail(email)) {
// 		var err = 'Указан неверный email адрес';
// 		showerr(err);
// 		return false;
// 	}
// 	if (parseInt(allcount) < parseInt(minCount)) {
// 		var err = 'Мин. кол-во для заказа: ' + minCount;
// 		showerr(err);
// 		return false;
// 	}
// 	if (parseInt(countType) < parseInt(count)) {
// 		var err = 'Такого количества товара нет';
// 		showerr(err);
// 		return false;
// 	}

// 	$.post("/order/", {
// 		email: email,
// 		count: count,
// 		type: selectType,
// 		fund: fund,
// 		'copupon': coupon
// 		}, function (data) {
// 		try {
// 			var res = JSON.parse(data);
// 			if (res.ok == 'TRUE') {

// 				if(res.redirect == 'yes'){
// 					window.location.replace(res.url);
// 				}
// 				else if(res.redirect == 'no'){

// 					$('.paytable .payitem').text(res.name);
// 					$('.paytable .paycount').text(res.count);
// 					$('.paytable .payprice').text(res.price);
// 					$('.paytable .payfund').html(res.fund);
// 					$('.paytable .paybill').html(res.bill);
// 					$('.paytable .discount').html(res.discount);
// 					$('.paytable .bonuspr').html(res.bonus);
// 					$('.paytable .link').html(res.linkwm);
// 					$('.checkpaybtn').attr('onclick', "checkpay('" + res.check_url + "')");
// 					var newpay = $('.modalpay').attr('newpay');
// 					if(newpay == '1'){	
// 						var inst = $('[data-remodal-id=paymodal]').remodal();
// 						inst.open();
// 					}
// 					else{ 
// 						$('#paymodal').modal('toggle');
// 					}
// 				}
// 			}
// 			if (typeof (res.error) !== "undefined" && res.error !== null) {
// 				showerr(res.error);
// 			}
// 			} catch (err) {
// 			alert('Настройки оплаты не верны! \r\nСообщите продавцу об этом!');
// 		}
// 	});
// }

// jQuery(document).ready(function(){
// content from app.js
$("tr").easyTooltip();

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

const sendData = () => {
	var email = $('input[name=email]').val();
	var countAccs = $('input[name=count]').val() || 0;
	var selectType = $('select[name=item]').val();
	var bonus = $('input[name=bonus]:checked').val();
	var minCount = $('option[value="' + selectType + '"]').attr('data-min_order');
	var countType = $('td[data-id=' + selectType + ']').html();
	// const funds = $('select[name=funds]').val();
	const wallet = $('select[name=funds]').val();
	const copupon = $('#copupon').val() || '';
	// console.log('wallet: ', wallet);
	// 	console.log('copupon: ', copupon);

	if (!validateEmail(email)) {
		var err = 'Указан неверный email адрес';
		showerr(err);
		return false;
	}
	if (parseInt(countAccs) < parseInt(minCount)) {
		var err = 'Мин. кол-во для заказа: ' + minCount;
		showerr(err);
		return false;
	}
	if (parseInt(countType) < parseInt(countAccs)) {
		var err = 'Такого количества товара нет';
		showerr(err);
		return false;
	}

	$.post("/order/", {
		email: email,
		count: countAccs,
		bonus: bonus,
		item: selectType,
		wallet: wallet,
		copupon: copupon
	}, function (data) {
		try {
			var res = JSON.parse(data);
			console.log('res: ', res)
			// if (res.ok == 'TRUE') { 
			if (res.error === false) {

				if (res.redirect == 'yes') {
					location = res.url;
					document.location.href = res.url;
					location.replace(res.url);
					window.location.reload(res.url);
					document.location.replace(res.url);
				}
				else {
					$('.paytable .payitem').text(res.name);
					$('.paytable .paycount').text(res.count);
					$('.paytable .payprice').text(res.price);
					$('.paytable .payfund').html(res.fund);
					$('.paytable .paybill').html(res.bill);
					$('.paytable .discount').html(res.discount);
					$('.paytable .bonuspr').html(res.bonus);
					$('.paytable .link').html(res.linkwm);
					// $('.checkpaybtn').attr('onclick', "checkpay('" + res.check_url + "')");
					$('.checkpaybtn').attr('onclick', "checkpay('" + res.order + "')");
					var newpay = $('.modalpay').attr('newpay');
					if (newpay == '1') {
						var inst = $('[data-remodal-id=paymodal]').remodal();
						inst.open();
					} else {
						$('#paymodal').modal('toggle');
					}
				}
			}
			if (typeof (res.error) !== "undefined" && res.error !== null) {
				showerr(res.error);
			}
		} catch (err) {
			alert('Что-то пошло не так, попробуйте еще раз');
		}
	});
}

function checkpay(url) {
	$('.checkpaybtn').button('loading');
	$.get(url, function (data) {
		$('.checkpaybtn').button('reset');
		var res = JSON.parse(data);
		if (res.status == "wait_30_sec") {
			showerr(res.message);
			throw "stop";
		}
		if (res.status == "reset_pass") {
			alert('Владельцу магазина необходимо обновить пароль своего QIWI кошелька! ')
			throw "stop";
		}
		if (res.status == "Bad_log_pass" || res.status == "error_log_pass") {
			alert('Владельцу магазина необходимо проверить правильность ввода данных QIWI кошелька! ')
			throw "stop";
		}

		if (res.status == "ok") {
			$('.checkpaybtn').attr('onclick', 'window.location ="' + res.chkurl + '"');
			$('.checkpaybtn').text('Скачать');
		} else {
			alert('Платеж не найден :(  Попробуйте еще раз через мгновение :) ')
		}
	});
}




function chkp(url) {
	$('.checkpaybtnr').button('loading');
	$.get(url, function (data) {
		$('.checkpaybtnr').button('reset');
		var res = JSON.parse(data);

		if (res.status == "wait_30_sec") {
			showerr(res.message);
			throw "stop";
		}
		if (res.status == "ok") {
			$('.checkpaybtnr').attr('onclick', 'window.location ="' + res.chkurl + '"');
			$('.checkpaybtnr').text('Скачать');
		} else {
			alert('Увы , но платеж не найден.')
		}
	});
}

function qq() {
	var search = $('#search').val();
	$.ajax({
		type: 'GET',
		url: '/',
		data: "search=" + search,
		success: function (data) {
			$('div.layer').html(data);
		}
	});
}





function GetPay(email, count, selectType, minCount, allcount, fund, coupon) {

	if (!validateEmail(email)) {
		var err = 'Указан неверный email адрес';
		showerr(err);
		return false;
	}
	if (parseInt(allcount) < parseInt(minCount)) {
		var err = 'Мин. кол-во для заказа: ' + minCount;
		showerr(err);
		return false;
	}
	if (parseInt(countType) < parseInt(count)) {
		var err = 'Такого количества товара нет';
		showerr(err);
		return false;
	}

	$.post("/order/", {
		email: email,
		count: count,
		type: selectType,
		fund: fund,
		'copupon': coupon
	}, function (data) {
		try {
			var res = JSON.parse(data);
			if (res.ok == 'TRUE') {

				if (res.redirect == 'yes') {
					window.location.replace(res.url);
				}
				else if (res.redirect == 'no') {

					$('.paytable .payitem').text(res.name);
					$('.paytable .paycount').text(res.count);
					$('.paytable .payprice').text(res.price);
					$('.paytable .payfund').html(res.fund);
					$('.paytable .paybill').html(res.bill);
					$('.paytable .discount').html(res.discount);
					$('.paytable .bonuspr').html(res.bonus);
					$('.paytable .link').html(res.linkwm);
					$('.checkpaybtn').attr('onclick', "checkpay('" + res.order + "')");
					var newpay = $('.modalpay').attr('newpay');
					if (newpay == '1') {
						var inst = $('[data-remodal-id=paymodal]').remodal();
						inst.open();
					}
					else {
						$('#paymodal').modal('toggle');
					}
				}
			}
			if (typeof (res.error) !== "undefined" && res.error !== null) {
				showerr(res.error);
			}
		} catch (err) {
			alert('Настройки оплаты не верны! \r\nСообщите продавцу об этом!');
		}
	});
}

var getedId = 0;
let numOfItems = 0;
var setepaidway = 0;

const Basket = (getedId) => {
	console.log('getedId: ', getedId)
	const d = document;
	numOfItems = d.getElementById('number-of-items-' + getedId).value;
	d.getElementById('end-number').value = numOfItems;
	d.getElementById('item-selected').value = getedId;
}

function setpaidway(setepaidway) {
	document.getElementById('fundsSelect').value = setepaidway;
}

function setEmail() {
	document.getElementById('row-box-email').value = document.getElementById('alert-box-email').value;
	sendData();
}

// }); // end of onload


const test = (a) => {
	if (a == "13") {
		$("#test").click();
		console.log('$("#test").click(): ', $("#test").click())
	}
}
const d = document;
const sendButton = d.querySelector('#sendButton');
sendButton.addEventListener('click', () => {
	// console.log('click: ');
	sendData();
	// console.log('sendData(): ', sendData())
});
// sendData();