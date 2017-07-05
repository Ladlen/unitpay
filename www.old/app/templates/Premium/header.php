<html>
	<head>
		<meta charset="utf-8">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link type="text/css" rel="StyleSheet" href="/assets/Premium/css/my.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link type="text/css" rel="StyleSheet" href="/assets/Premium/css/base.css" />
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link rel='stylesheet' href='/assets/Premium/css/moder_panel_new.css'>
		<link type="text/css" rel="StyleSheet" href="/assets/Premium/css/layer1.css" />
		<script type="text/javascript" src="/assets/Premium/js/jquery-1.7.2.js"></script>
		<link href="/assets/Premium//ulightbox/ulightbox.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/assets/Premium//ulightbox/ulightbox.js"></script>
		<script type="text/javascript" src="/assets/Premium/js/uwnd.js?2"></script>
		<style type="text/css">#fancybox-buttons {display:none}</style>
		<script type="text/javascript" src="/assets/Premium/js/shop_utils.js?2"></script>
		<script src="/assets/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
		<link type="text/css" rel="StyleSheet" href="/assets/Premium/css/social.css" />
		<link type="text/css" rel="StyleSheet" href="/assets/Premium/css/shop.css" />
		<script type="text/javascript" src="/assets/Premium/js/shop.js?2"></script>
	</head>
	<body>
		<style>body {background:url(<?=BACKGROUND;?>);background-attachment:fixed;}</style>
		<div id="device_type"></div>
		<div id="top_line"></div>
		<div id="main_container">
			<header id="site_header">
				<h1 id="site_logo">
					<img src="<?=LOGOTYPE;?>" />
				</h1>
			</header>
			<div id="navi">
				<nav>
					<ul class="uMenuRoot">
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
				<div class="some_shadow">
					<div style="float: right; position: relative; bottom: 43px; left: 1px; z-index: 9999;">
						<script>function test(a){if(a=="13"){$("#test").click()}}</script>
						<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px; position: relative; bottom: -7px; min-height: 0px; padding: 6px;" id="search" type="text">
						<input class="btn" value="Поиск" id="test" style="height: 27px; position: relative; bottom: -8px; line-height: 5px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
					</div>
				</div>
			</div>