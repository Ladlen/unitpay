<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="stylesheet" href="/assets/SellWhite/css/style.css" type="text/css" media="screen, projection" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="/assets/SellWhite/js/login.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="/assets/SellWhite/js/jquery.lazyload.min.js"></script>
		<script src="/assets/SellWhite/js/script-lazy.js"></script>
		<script src="/assets/SellWhite/js/tabs.js"></script>
		<link href="/assets/SellWhite/css/prettyPhoto.css" media="screen" rel="stylesheet" type="text/css" />
		<script src="/assets/SellWhite/js/jquery.prettyPhoto.js"></script>
		<script src="/assets/SellWhite/js/script.js"></script>
	</head>
	<body id="page">
		<style>
			html, body {
				background-image: url(<?=BACKGROUND;?>);
				background-attachment: fixed;
				background-size: cover;
				background-repeat: no-repeat;
			}
		</style>
		<div class="wrapper">
			<div class="header-nav2" style="z-index: 9999;">
				<nav>					
					<? $obj = json_decode(MENU, true); ?>
					<? foreach($obj as $name => $url){ ?>
					<a href="<?=$url;?>"><?=$name;?></a>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a>
					<? } ?>
					<a href="/myorders/">Мои покупки</a>
				</nav>
			</div>
			<div class="header-nav">
				<a href="/">
					<div class="logo" style="background: url('<?=LOGOTYPE;?>'); width: 140px; height: 60px; bottom: 18px; left: -30px;"></div>
				</a>
				<div style="float: right; left: -6px; position: relative; margin-bottom: -30px; bottom: 35px;">
					<script>function test(a){if(a=="13"){$("#test").click()}}</script>
					<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 24px;" id="search">
					<input value="Поиск" id="test" style="height: 28px; line-height: 1px; position: relative;" onclick="location.href = '/search/'+$('#search').val();" type="button">
				</div>
				<ul class="menu_pun">
					<li class="delivery-icon">Моментальная доставка</li>
					<li class="best-prices-icon">Лучшие цены</li>
					<li class="convenient-payment-methods">Удобные способы оплаты</li>
				</ul>
			</div>
			<?
				# Случайный товар
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ORDER BY RAND() LIMIT 4");
			?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<div class="header-nav" style="height: 135px; background: #000;">
				<center>
					<p>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<a href="/item/<?=$row['item_id'];?>"><img src="<?=$row['image'];?>" style="width: 222px; height: 129px; margin-right: 15px;"></a>
						<? } ?>
					</p>
				</center>
			</div>
			<? } ?>