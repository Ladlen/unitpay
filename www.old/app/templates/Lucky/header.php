<!DOCTYPE html>
<html>
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link type="text/css" rel="stylesheet" media="all" href="/assets/Lucky/css/bootstrap.min.css" />
		<link href="/assets/Lucky/css/style.css" rel="stylesheet" media="screen" />
		<link href="/assets/Lucky/css/jquery.toastmessage.css" rel="stylesheet" media="screen" />
		<link href="/assets/Lucky/css/bootstrap-glyphicons.css" rel="stylesheet" media="screen" />
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script type="text/javascript" src="/assets/Lucky/js/classie.js"></script>
		<script type="text/javascript" src="/assets/Lucky/js/modernizr.custom.js"></script>
		<script type="text/javascript" src="/assets/Lucky/js/script.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/slider.css" />
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/futurico-theme.css" />
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/default.css" />
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/component.css" />
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/styles.css" />
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/mac.css" />
		<link rel="stylesheet" type="text/css" href="/assets/Lucky/css/pre-style.css" />
	</head>
	<body class="common-home" style="background: #f6f6f6;">
		<div class="page-inner">
			<div class="page-inner">
				<div class="header">
					<div class="header-top">
						<div class="wrapp-hd">
							<div class="header-mob">
								<header>
									<div class="hdr-mob">
										<div id="showLeft">
											<span></span>
											<span></span>
											<span></span>
										</div>
									</div>
									<a class="logo-mob" href="/">
										<img src="<?=LOGOTYPE;?>" />
									</a>
								</header>
							</div>
							<a class="header-logo" href="/">
								<img src="<?=LOGOTYPE;?>" />
							</a>
							<div class="header-main" style="width: 20%; top: 62px; float: right; right: 40px; position: relative;">
								<div class="hdr-search" style="position: relative; bottom: 40px;">
									<div class="search-wr">
										<script>function test(a){if(a=="13"){$("#test").click()}}</script>										
										<input id="search" value class="search-wr-input-mob" onkeyup="test(event.keyCode)" placeholder="Поиск игры..." autocomplete="off" id="game-search-input">
										<input class="btn" value="" id="test" style="height: 36px; line-height: 1px; position: relative; bottom: -8px; display: none;" onclick="location.href = '/search/'+$('#search').val();" type="button">
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						$(document).scroll(function() {
							if (window.scrollY < 140) {
								$('.header-nav').removeClass('fixed')
							} else {
								$('.header-nav').addClass('fixed')
							}
						})
					</script>
					<div class="header-nav">
						<div class="wrapp">
							<nav class="header-navs">
								<? $obj = json_decode(MENU, true); ?>
								<? foreach($obj as $name => $url){ ?>
								<div class="header-nav-gr">
									<a href="<?=$url;?>" class="header-nav-gr-link">
										<span class="header-nav-link-txt"><?=$name;?></span>
									</a>
								</div>
								<? } ?>
								<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<div class="header-nav-gr">
									<a href="/page/<?=$row['pid'];?>" class="header-nav-gr-link">
										<span class="header-nav-link-txt"><?=$row['title'];?></span>
									</a>
								</div>
								<? } ?>
								<div class="header-nav-gr">
									<a href="/myorders/" class="header-nav-gr-link">
										<span class="header-nav-link-txt">Мои покупки</span>
									</a>
								</div>
							</nav>
						</div>
					</div>
				</div>
				<style>
				.header-nav {
    background-color: <?=COLORLUCKYVERX;?>;
}
				</style><style>
								.header-nav {
    background-color: <?=COLORLUCKYNUZ;?>;
}
				</style><Style>
				.gamecols__img, .gamecols__info {
    background-color: <?=COLORLUCKYFON;?>;
}
</style>
				<div class="main-container">
					<div id="content">