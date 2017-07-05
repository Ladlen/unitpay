<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta name="viewport" content="width=1014">
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500italic,500&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		<link href="/assets/ShopNew/css/style.css" rel="stylesheet" type="text/css">
		<script src="/assets/ShopNew/js/jquery.js"></script>
		<script src="/assets/ShopNew/js/bootstrap.min.js"></script>
		<script src="/assets/ShopNew/js/jquery.toastmessage.js"></script>
		<script src="/assets/ShopNew/js/script_site.js"></script>
		<link href="/assets/ShopNew/css/jquery.toastmessage.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
	</head>
	<body id="body">
		<style>
			body {
				background-image: url(<?=BACKGROUND;?>);
				background-attachment: fixed;
				background-size: cover;
				background-repeat: no-repeat;
			}
			.content-logo {
				background:url(http://fastscr.ru/i/U1DyB816p1gn41074R.png) no-repeat center 0;
				-webkit-background-size: 100% auto;
				-moz-background-size: 100% auto;
				background-size: 100% auto;
			}
			HTML, BODY {
				background-attachment: fixed;
				background-size: cover;
				background-repeat: no-repeat;
				cursor: url("http://www.geld-mit-homepage.net/wp-content/uploads/2011/03/klick.png"), auto;
			}
			body {
				font-family:Arial;
				font-size:13px;
				color:black;
				text-shadow:;
			}
			.modal-content {
				background-color:#d1622e;
			}
			#copybill {
				cursor: pointer;
			}
			#copyfund {
				cursor: pointer;
			}
		</style>
		<style>
		.header-nav {
    background: <?=COLORSHOPNEWVERX;?>;
}
</style>
		<style>
.footer-bottom {
    background: <?=COLORSHOPNEWNUZ;?>;
}
</style>
<style>
.form-order .btn-pay:active {
    background: <?=COLORSHOPNEWPAY;?>;
}
</style>
<Style>
.wrapper {
    background: <?=COLORSHOPNEWFON;?>;
}
</style>
		<div class="wrap">
			<nav class="header-nav">
				<ul class="header-panel-nav" style="width: 1020px; margin: 0 auto;">
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
			<div style="float: right; left: -122px; position: relative; bottom: 55px;">
				<script>function test(a){if(a=="13"){$("#test").click()}}</script>
				<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px;color: black;border: 0;border-radius: 6px;" id="search">
				<input value="Поиск" id="test" style="height: 30px; line-height: 1px; position: relative;" onclick="location.href = '/search/'+$('#search').val();" type="button">
			</div>
			<div class="wrapper">
				<a href="/">
					<div class="content-logo" style="background: url('<?=LOGOTYPE;?>') no-repeat center;"></div>
				</a>