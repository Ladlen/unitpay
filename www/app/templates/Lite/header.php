<html class=" js boxshadow pointerevents placeholder js ">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link rel="stylesheet" href="/assets/Lite/css/styles.css">
		<link rel="stylesheet" href="/assets/css/jquery.toastmessage.css">
		<script src="/assets/Lite/js/jquery.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<script src="/assets/Lite/js/cookie.js"></script>
		<script src="/assets/Lite/js/ajax.js"></script>
		<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
	</head>
	<body>
		<div id="slide-nav">
			<div class="wrap">
				<ul class="h-nav">
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
				<div style="float: right; left: -2px; position: relative; width: 200px;">
					<script>function test(a){if(a=="13"){$("#test").click()}}</script>
					<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="padding: 5px; position: relative; bottom: -5px; min-height: 0px; width: 135px; height: 30px;" id="search" type="text">
					<input class="btn" value="Поиск" id="test" style="width: auto; height: 30px; position: relative; line-height: 1px; bottom: 33px; left: 139px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
				</div>
			</div>

		</div>

		<style>
			body {
				background: url(<?=BACKGROUND;?>) repeat;
				background-attachment:fixed;
			}
			.h-logo {
				background: none;
			}
		</style>
		<style>
		.block .block-top {
    background: <?=COLORLITEBLOCK;?>;
}
</style>
<style>
.b-item:hover .title, .c-item:hover .title {
    background-color: <?=COLORLITEBLOCK;?>;
}
</style>
<style>
.b-item, .c-item {
    background: <?=COLORLITEBLOCK;?>;
}
</style>
<style>
label, input[type="button"], input[type="submit"], input[type="reset"], button {
    background-color: <?=COLORLITEBLOCK;?>;
}
</style>
<style>
.h-nav li.cur a {
    background-color: <?=COLORLITEBLOCK;?>;
}
</style>
<style>
#slide-nav {
    background: <?=COLORLITEVERX;?>;
}
</style>
<style>
.c-detail {
    background-color: <?=COLORLITEVERX;?>;
}
</style>
<style>
.item-view {
    background: <?=COLORLITEITEM;?>;
}
</style>
<style>
.item-view .poster .title {
    background: <?=COLORLITENAZV;?>;
}
</style>
		<div class="wrapper">
			<header id="header" class="header6" style="background: transparent url(<?=LOGOTYPE;?>) no-repeat scroll 0% 0%;">
				<a class="h-logo" href="/"></a>
			</header>