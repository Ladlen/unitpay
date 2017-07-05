<!DOCTYPE html>
<html>
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="stylesheet" href="/assets/Aqua/css/style.css">
		<script src="/assets/Aqua/js/jquery.min.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<script src="/assets/Aqua/js/scripts.js"></script>
		<script src="/assets/Aqua/js/set_type.js"></script>
	</head>
	<body>
		<style>body {background: url(<?=BACKGROUND;?>);background-attachment:fixed;}</style>
		<div id="main">
			<header id="header">
				<ul id="t-nav">
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
				<div style="float: right; left: -4px; position: relative; bottom: 35px;">
					<script>function test(a){if(a=="13"){$("#test").click()}}</script>
					<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px;border:0;border-radius: 5px;    width: 135px;" id="search">
					<input value="Поиск" id="test" style="height: 30px;line-height: 0px;background: #ffd958 url(/assets/Aqua/img/buying-h.png) no-repeat 80% 58%!important;border-radius: 5px;border: 0;padding-right: 79px;cursor: pointer;width: 12px;margin-left: 0px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
				</div>
				<div id="m-nav">
					<div class="h-logo" style="background: url(<?=LOGOTYPE;?>) no-repeat;"></div>
				</div>
				<div id="b-cat">
					
				</div>
			</header>
			<section id="middle">
			<style>
			#header #t-nav {
    background-color: <?=COLORAQUA;?>;
    height: 40px;
    padding: 0 18px;
    text-transform: uppercase;
    font-size: 12px;
}
</style>
<style>
#header #b-cat {
    background-color: <?=COLORAQUABG;?>;
    height: 40px;
    padding: 0 12px;
    position: relative;
    font-size: 12px;
}
</style>
<style>
#footer {
    background-color: <?=COLORAQUA;?>;
	</style>