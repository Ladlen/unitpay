<html class=" js no-touch csstransitions">
	<head>
		<meta charset="utf-8">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link type="text/css" rel="StyleSheet" href="/assets/Elegant/css/my.css">
		<link href="http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,400,300,700italic,700&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="/assets/Elegant/css/font-awesome.min.css">
		<link rel="stylesheet" href="/assets/Elegant/css/animate.css">
		<link type="text/css" rel="StyleSheet" href="/assets/Elegant/css/base.css">
		<link rel="stylesheet" href="/assets/Elegant/css/moder_panel_new.css">
		<link type="text/css" rel="StyleSheet" href="/assets/Elegant/css/layer1.css">
		<script type="text/javascript" src="/assets/Elegant/js/jquery-1.7.2.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link href="/assets/Elegant/ulightbox/ulightbox.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/assets/Elegant/ulightbox/ulightbox.js"></script>
		<script type="text/javascript" src="/assets/Elegant/js/uwnd.js?2"></script>
		<style type="text/css">.UhideBlock {display:none}</style>
		<script type="text/javascript" src="/assets/Elegant/js/shop_utils.js?2"></script>
		<link type="text/css" rel="StyleSheet" href="/assets/Elegant/css/social.css">
		<link type="text/css" rel="StyleSheet" href="/assets/Elegant/css/shop.css">
		<script type="text/javascript" src="/assets/Elegant/js/shop.js"></script>
		<script src="/assets/Elegant/js/plugins.js"></script>
		<script src="/assets/Elegant/js/scripts.js"></script>
		
		<script src="/assets/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
	</head>
	<body>
		<div id="_umenu0" class="x-unselectable" style="display: none; position: absolute; z-index: 25050;">
			<div class="u-menu u-menumarks" unselectable="on" style="position: absolute; z-index: 2; left: 0px; width: 81px; height: auto;">
				<div class="xw-tl" unselectable="on"><div class="xw-tr" unselectable="on"><div class="xw-tc xw-tsps" unselectable="on"></div></div></div>
				<div class="xw-ml" unselectable="on"><div class="xw-mr" unselectable="on"><div class="xw-mc" unselectable="on"><div class="u-menubody" unselectable="on">
				<div class="u-menucont" style="overflow: visible; height: auto; width: 65px;" unselectable="on"><div class="u-menuvitem">Restore</div>
				<div class="u-menuvitem">Minimize</div><div class="u-menuvitem">Maximize</div><div class="u-menuvsep"></div>
				<div class="u-menuvitem">Close</div></div></div></div></div></div><div class="xw-bl" unselectable="on">
				<div class="xw-br" unselectable="on"><div class="xw-bc" unselectable="on"><div class="xw-footer" unselectable="on"></div></div></div></div>
			</div>
			<div class="x-sh xsl" style="position: absolute; z-index: 1; width: 6px; left: -4px; top: 0px; height: 108px;"><div class="xstl"><div class="xsml"></div></div></div>
			<div class="x-sh xsr" style="position: absolute; z-index: 1; width: 6px; top: 0px; height: 108px; left: 79px;"><div class="xstr">
			<div class="xsmr"></div></div></div>
			<div class="x-sh xsb" style="position: absolute; z-index: 1; height: 6px; left: -4px; width: 89px; top: 108px;">
			<div class="xsbl"><div class="xsbr"><div class="xsbc"></div></div></div></div>
		</div>
		<div id="t-loader" style="display: none;"></div>
		<div id="t-container">
			<style>#t-container{background: url(<?=BACKGROUND;?>) no-repeat top center; background-size: cover;background-attachment:fixed;}</style>
			<header id="header">
				<div class="cnt clr">
					<a id="logo" class="left" href="/"><img src="<?=LOGOTYPE;?>"></a>
					 <br/><br/>
				</div>
			</header>
			<div id="menu" class="cnt clr">
				<nav class="left">
					<div id="uNMenuDiv1" class="uMenuV">
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
					</div>
				</nav>
				<div style="float: right; left: -2px; position: relative;">
					<script>function test(a){if(a=="13"){$("#test").click()}}</script>
					<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px; position: relative; bottom: -8px; min-height: 0px;" id="search" type="text">
					<input class="btn" value="Поиск" id="test" style="height: 30px; line-height: 1px; position: relative; bottom: -7px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
				</div>
			</div> 
			<div id="specials" class="cnt clr">
				<div class="col-370px col-3 left">
					<div class="special clr">
						<i class="fa fa-leaf"></i>
						<p><span>Скидки</span><br/> Еженедельно скидки</p>
					</div>
				</div>
				<div class="col-370px col-3 left">
					<div class="special clr">
						<i class="fa fa-shopping-cart"></i>
						<p><span>Товара</span><br /> Многвенаня выдача товара</p>
					</div>
				</div>
				<div class="col-370px col-3 left">
					<div class="special clr">
						<i class="fa fa-gift"></i>
						<p><span>Приятные сюрпризы и подарки</span><br/> Подарки при покупке</p>
					</div>
				</div>
			</div>
			<style>
			<style>
			#t-container input[type="button"], #t-container input[type="submit"], #t-container input[type="reset"], .uMenuRoot .uMenuItemA, .uMenuRoot > li > a:hover, nav .uMenuV .uMenuRoot > li.uWithSubmenu:hover > a, nav .uMenuV .uMenuRoot > li.uWithSubmenu a:hover, .cd-active.cd-dropdown ul li span:hover, .block-title .fa, .block .cat-blocks > div:hover, .block .cat-blocks > div.active, .button, .item-add, a.more, .pgSwchA, .swchItemA, #tabsHead a, .ss-header, .ss-get-code, .calWday, .calWdaySu, .calWdaySe, .gTableTop {
    background: <?=COLORELEGANTPAY;?>;
}
</style>
<style>
#menu {
    background: <?=COLORELEGANTMN;?>;
}
</style>
<style>
.block-title {
    background: <?=COLORELEGANTMN;?>;
}
</style>
<style>
#menu {
    background: <?=COLORELEGANTMN;?>;
}
</style>
<Style>
.aTabs > .aTabsHead > span.aTabsHeadSpanActive {
    background: <?=COLORELEGANTOP;?>;
}
</style>