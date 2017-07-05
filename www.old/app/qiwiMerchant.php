<?
	/*
		Номер заказа передан
	*/	
	if(isset($_POST['order'])){
		/*
			Поиск платежа в заказах шопа
		*/
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `oid` = '".intval($_POST['order'])."' AND `sid` = '".intval(SID)."' AND `wallet` = 'QIWI' AND `status` = '0'");
		/*
			Заказ найден
		*/
		if(mysqli_num_rows($SQL) > 0){
			/*
				Информация о заказе
			*/
			$ORDER = mysqli_fetch_array($SQL);
			/*
				Кошельки
			*/
			$WALLET = json_decode(WALLETS, true);
		}
	}
?>
<html>
	<head>
		<title>Visa QIWI Wallet</title>
		<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no" />
		<link rel="icon" type="image/png" href="https://static.qiwi.com/img/qiwi_com/favicon/favicon-16x16.png" sizes="16x16" />
		<link rel="icon" type="image/png" href="https://static.qiwi.com/img/qiwi_com/favicon/favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="https://static.qiwi.com/img/qiwi_com/favicon/favicon-96x96.png" sizes="96x96" />
		<link rel="icon" type="image/png" href="https://static.qiwi.com/img/qiwi_com/favicon/favicon-192x192.png" sizes="192x192" />
		<link rel="apple-touch-icon" href="https://static.qiwi.com/img/qiwi_com/favicon/favicon-76x76.png" sizes="76x76" />
		<link rel="apple-touch-icon" href="https://static.qiwi.com/img/qiwi_com/favicon/favicon-152x152.png" sizes="152x152" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/assets/qiwi/js/main.js"></script>
		<link href="http://<?=$_SERVER['HTTP_HOST'];?>/assets/qiwi/css/main.css" rel="stylesheet" media="all" />
	</head>
	<body>
		<div id="dev-app">
			<div class="checkout" data-reactid=".0"><header class="checkout-header" data-reactid=".0.0"><a href="https://qiwi.com" data-reactid=".0.0.0"><span class="checkout-logo" data-reactid=".0.0.0.0"></span></a><div class="checkout-guarantee" data-reactid=".0.0.1"><div class="icon icon-security" data-reactid=".0.0.1.0"><svg viewBox="279.5 22.5 400.8 515.5" data-reactid=".0.0.1.0.0"><g data-reactid=".0.0.1.0.0.0"><path class="icon-stroke" d="M480,530l4.5-1.6c174.6-64.2,188.3-232.5,188.4-234.2v-0.9V47.8l-10.8-1.9C658.4,45.3,570,30,479.9,30S301.5,45.3,297.8,45.9L287,47.8v246.4c0.1,1.7,13.8,170,188.4,234.2L480,530L480,530z" data-reactid=".0.0.1.0.0.0.0"></path><path d="M410.5,228.7c0-1.2,0-2.2,0-3.2c0.2-11.3-0.2-22.7,0.5-34c1.2-17.1,9-31,21.1-42.8c9.1-8.8,19.7-15,32.2-17.6c20.4-4.2,39.3-1,56.2,11.6c12,8.9,20.8,20.2,25.5,34.5c2.4,7.3,3.4,14.7,3.4,22.2c0,8.8,0,17.5,0,26.3c0,0.9,0,1.8,0,2.9c1.8,0,3.3,0,4.9,0c8.6,0.2,15,6.4,15,14.9c0.1,29.6,0.1,59.2,0,88.8c0,9-6.3,15.3-15.4,15.3c-49.2,0-98.4,0-147.7,0c-9.4,0-15.6-6.3-15.7-15.8c0-29.2,0-58.4,0-87.6c0-9.4,6.3-15.6,15.7-15.7C407.6,228.7,408.8,228.7,410.5,228.7L410.5,228.7zM519.7,228.7c0-10.6,0.2-20.9-0.1-31.3c-0.1-3.6-0.7-7.3-1.8-10.7c-6-18.7-23.9-29.7-43.5-27.1c-18.9,2.5-33.4,18.5-34,37.7c-0.2,10.1-0.1,20.1-0.1,30.3c0,0.3,0.2,0.6,0.2,1C466.9,228.7,493.1,228.7,519.7,228.7L519.7,228.7z" data-reactid=".0.0.1.0.0.0.1"></path></g></svg></div><span data-reactid=".0.0.1.1">Гарантируем безопасность платежа и&nbsp;сохранность ваших личных данных</span></div></header><noscript data-reactid=".0.1:0:0"></noscript><div class="content"></div></div>
			<div class="loader" data-reactid=".0.1:0:0" style="width: 46px; height: 46px; margin: 0 auto;">
				<div class="spinner" role="progressbar" style="position: absolute; width: 0px; top: 40%;">
					<img src="http://<?=$_SERVER['HTTP_HOST'];?>/assets/qiwi/img/loading.gif" />
				</div>
			</div>
		</div>
		<script>
			QIWI['name'] = 'Merchant';
			QIWI['phone'] = '<?=$WALLET['QIWI'];?>';
			QIWI['link'] = <?=(isset($ORDER['bill']) ? '"'.str_replace(Array(PREFIX, "[", "]"), Array("", "", ""), $ORDER['bill']).'"' : 'false');?>;
			QIWI['order'] = <?=(isset($ORDER['bill']) ? '"'.$ORDER['bill'].'"' : 'false');?>;
			QIWI['amount'] = <?=(isset($ORDER['price']) ? '"'.number_format($ORDER['price'], 2, '.', '').'"' : 'false');?>;
		</script>
	</body>
</html>