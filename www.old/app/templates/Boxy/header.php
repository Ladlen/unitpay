<!doctype html>
<html lang="ru">
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<script type="text/javascript" src="/assets/Elegant/js/jquery-1.7.2.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="/assets/Boxy/css/style.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
		<script src="/assets/Boxy/js/unslider.min.js"></script>
		<script src="/assets/Boxy/js/tabs.js"></script>
		<style>html,body{width:1024px;margin:0 auto;background:#000 url(<?=BACKGROUND;?>) no-repeat top center;background-attachment:fixed;background-attachment:fixed;}    
.logo{height: 100%;width: 100%;background:url(<?=LOGOTYPE;?>) no-repeat;}</style>
		<script>
			$(function() {
				$('.slider').unslider({
					delay: 4000,
					keys: true,
					dots: true,
					fluid: true
				});
			});
		</script>
	</head>
	<style>
	.header-nav {
    height: 39px;
    background: <?=COLORBOXYVERX;?> url(/assets/Boxy/img/header-nav-bg.png)/*tpa=http://012.bxpay.ru/012/header-nav-bg.png*/ no-repeat center;
}
</style>
<style>
.buy-button {
    background: <?=COLORBOXYPAY;?>;
}
</style>
<style>
.op {
    background-color: <?=COLORBOXYPAY;?>;
}
</style>
<style>
.buy_game {
    background: <?=COLORBOXYPAY;?>;
    border-bottom: 1px solid <?=COLORBOXYPAY;?>;
}
</style>
<style>
.btnr {
    background-color: <?=COLORBOXYOPL;?>;
}
</style>
	<body>
		<header>
			<div class="header-nav">
				<ul class="headmenu">
					<? $obj = json_decode(MENU, true); ?>
					<? foreach($obj as $name => $url){ ?>
					<li><a href="<?=$url;?>"><?=$name;?></a></li>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
					<? } ?>
					<li><a href="/myorders/">Мои покупки</a></li>
				</ul>
			</div>
			<div style="float: right; left: -4px; position: relative; bottom: 35px;">
				<script>function test(a){if(a=="13"){$("#test").click()}}</script>
				<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px; position: relative; bottom: 4px; width: auto;" id="search">
				<input value="Поиск" id="test" style="height: 30px;line-height: 1px;position: relative;bottom: 0px;background: #00A9FF;border-bottom: 1px solid #00A9FF;padding: 7px 0px;border-right: none;border-left: none;border-top: none;width: 48px;color: #fff;margin-left: 20px;cursor: pointer;" onclick="location.href = '/search/'+$('#search').val();" type="button">
			</div>
			<div class="header-line">
				<div class="container">
					<div class="header-wrapper">
						<div class="logo-wrapper" style="margin: 0;">
							<a href="/">
								<div class="logo"></div>
							</a>
						</div>
						<br/><br/>
						<div id="update"></div>
						<ul class="benefits">
							<li class="delivery-icon">Моментальная доставка</li>
							<li class="best-prices-icon">Лучшие цены</li>
							<li class="convenient-payment-methods">Удобные способы оплаты</li>
						</ul>
					</div>
				</div>
			</div>
		</header>
		<section>
			<div class="wrapper">