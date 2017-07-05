<!doctype html>
<head>
	<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
	<meta charset="UTF-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
	<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
	<link rel="stylesheet" href="/assets/StempPay/css/style.css"/>
	<script src="/assets/StempPay/js/jquery.min.js"></script>
	<script src="/assets/StempPay/js/jquery-ui.min.js"></script>
	<script src="/assets/StempPay/js/jquery.anythingslider.min.js"></script>
	<script src="/assets/StempPay/js/core.js"></script>
	<script src="/assets/StempPay/js/main_slider.js"></script>
	<script src="/assets/StempPay/js/tabs.js"></script>
</head>
<body class="main">
	<style>
		html, body {
			background-image: url(<?=BACKGROUND;?>);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
		}
	</style>
	<header>
		<div class="inner">
			<nav id="header-menu">
				<ul>
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
			</nav>
		</div>
	</header>
	<div id="wrapper">
		<div class="bottom-header">
			<a id="logo" href="/"><img src="<?=LOGOTYPE;?>" style="position: relative; bottom: 28px;" /></a>
			<a id="search">
				<div class="img"></div>
			</a>
			<div class="header-search">
				<form>
					<script>function test(a){if(a=="13"){$("#test").click()}}</script>
					<input class="submit" id="test" onclick="location.href = '/search/'+$('#search1').val();" type="button" />
					<input type="text" id="search" onkeyup="test(event.keyCode)"  placeholder="Поиск по играм" autocomplete="off" />
				</form>
				<div class="clear"></div>
				<div class="inside"></div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="container">
			<section id="content">
				<div id="left-shadow"></div>
				<div id="right-shadow"></div>