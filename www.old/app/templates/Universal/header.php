<!DOCTYPE html>
<html>
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700|Lobster&subset=latin,cyrillic" rel="stylesheet" type="text/css" />
		<link type="text/css" rel="StyleSheet" href="/assets/Universal/css/my.css" />
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="stylesheet" href="/assets/Universal/img/flexslider.css" type="text/css" media="screen" />
		<link type="text/css" rel="StyleSheet" href="/assets/Universal/css/base.css" />
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link rel='stylesheet' href='/assets/Universal/css/moder_panel_new.css'>
		<link type="text/css" rel="StyleSheet" href="/assets/Universal/css/layer1.css" />
		<script type="text/javascript" src="/assets/Universal/js/jquery-1.7.2.js"></script>
		<script src="/assets/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
		<script src="/assets/Universal/js/cookies.js"></script>
		<script type="text/javascript" src="/assets/Universal/img/colors/js/colorpicker.js"></script>
		<script type="text/javascript" src="/assets/Universal/img/colors/js/eye.js"></script>
		<script type="text/javascript" src="/assets/Universal/img/colors/js/utils.js"></script>
		<script type="text/javascript" src="/assets/Universal/img/colors/js/layout.js?ver=1.0.2"></script>
		<link href="/assets/Universal/ulightbox/ulightbox.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/assets/Universal/ulightbox/ulightbox.js"></script>
		<script type="text/javascript" src="/assets/Universal/js/uwnd.js?2"></script>
		<style type="text/css">.UhideBlock {display:none}</style>
		<script type="text/javascript" src="/assets/Universal/js/shop_utils.js?2"></script>
		<script type="text/javascript" src="/assets/Universal/img/template.js"></script>
		<link type="text/css" rel="StyleSheet" href="/assets/Universal/css/social.css" />
		<link type="text/css" rel="StyleSheet" href="/assets/Universal/css/shop.css" />
		<script type="text/javascript" src="/assets/Universal/js/shop.js?2"></script>
	</head>
	<body>
		<style>body,.body,html{background: url(<?=BACKGROUND;?>) no-repeat top center;background-attachment:fixed;    background-size: cover;}</style>
		<div class="body">
			<div class="over_header">
				<div class="header">
					<img src="<?=LOGOTYPE;?>" class="logo" />
					<div id="h_menu" class="h_menu">
						<nav>
							<div id="uNMenuDiv1" class="uMenuV">
								<ul class="uMenuRoot">
									<? $obj = json_decode(MENU, true); ?>
									<? foreach($obj as $name => $url){ ?>
									<li class="first leaf"><a href="<?=$url;?>"><?=$name;?></a></li>
									<? } ?>
									<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
									<? while($row = mysqli_fetch_array($SQL)){ ?>
									<li class="first leaf"><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
									<? } ?>
									<li class="first leaf"><a href="/myorders/">Мои покупки</a></li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>