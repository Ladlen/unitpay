<!DOCTYPE html>
<html class="" lang="ru" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta name="viewport" content="width=device-width" />
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link type="text/css" rel="stylesheet" href="/assets/Game/css/css_xE-rWrJf-fncB6ztZfd2huxqgxu4WO-qwma6Xer30m4.css" media="all" />
		<link type="text/css" rel="stylesheet" href="/assets/Game/css/css_-TNq6F6EH1K3WcBMUMQP90OkyCq0Lyv1YnyoEj3kxiU.css" media="all" />
		<link type="text/css" rel="stylesheet" href="/assets/Game/css/css_0nT2QMlvAyFSMeaGidWkGyeea5QFTaaL-ilbftbQyR0.css" media="all" />
		<link type="text/css" rel="stylesheet" href="/assets/Game/css/css_n7aK8s-ciXhQyEYWNOJtISbWxtxQiQvnD-N_xWUtD5A.css" media="all" />
		<link type="text/css" rel="stylesheet" href="/assets/Game/css/css_qXxpRnW4oZdYln2vmlGQzISptNZEARpcwCTBLNGoTow.css" media="all" />
		<link type="text/css" rel="stylesheet" href="/assets/Game/css/css_Rya9I1mtKfova16j_KK4dcpUz2OKrQosyWnt9Qv0g3U.css" media="all" />
		<script type="text/javascript" src="/assets/Game/js/js_xAPl0qIk9eowy_iS9tNkCWXLUVoat94SQT48UBCFkyQ.js"></script>
		<script type="text/javascript" src="/assets/Game/js/js_SuHs_HrJsrfGuashcBEngJV51x91rkzJw2gsA7uNbH4.js"></script>
		<script type="text/javascript" src="/assets/Game/js/js_Z-xWfeau0BVF_eV2d5x7vgA0E55Iv3IzLj0Cnbd9qNs.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
	</head>
	<body class="html front not-logged-in one-sidebar sidebar-second page-frontpage" >
		<div id="background">
			<div class="view view-background view-id-background view-display-id-default view-dom-id-8d0b1d13f76428712b8152629536f4ff">
				<div class="view-content">
					<div class="views-row views-row-1 views-row-odd views-row-first views-row-last">
						<div class="views-field views-field-field-background">        
							<div class="field-content">
								<img typeof="foaf:Image" src="<?=BACKGROUND;?>" width="1920" height="1080" alt="" />
							</div>  
						</div>  
					</div>
				</div>
			</div>
		</div>
		<div id="menu_head">
			<div class="region region-menu-head">
				<section id="block-menu-menu-menu" class="block block-menu">
					<div class="content">
						<ul class="menu">
							<? $obj = json_decode(MENU, true); ?>
							<? foreach($obj as $name => $url){ ?>
							<li class="first leaf"><a href="<?=$url;?>"><?=$name;?></a></li>
							<? } ?>
							<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<li class="first leaf"><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
							<? } ?>
							<li class="first leaf"><a href="/myorders/">Мои покупки</a></li>
							<div style="float: right; left: -2px; position: relative;">
								<script>function test(a){if(a=="13"){$("#test").click()}}</script>
								<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 22px; position: relative; bottom: -5px; min-height: 0px;" id="search" type="text">
								<input class="btn" value="Поиск" id="test" style="height: 30px; line-height: 1px; position: relative; bottom: -5px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
							</div>
						</ul>  
					</div>
				</section>
			</div>
		</div>
		<div id="container" class="clearfix">
			<header id="header" role="banner" class="clearfix">
				<div class="block_one">
					<a href="/" title="Главная" id="logo">
						<img src="<?=LOGOTYPE;?>" alt="Главная" />
					</a>
				</div>
			</header>
<Style>
#container {
    background: <?=COLORGAMEFON;?>;
}
</style>
<style>
div#menu_head {
    background: <?=COLORGAMEVERX;?>;
}
</style>
<style>
.btnr {
    background-color: <?=COLORGAMEOPL;?>;
}
</style>