<!DOCTYPE html>
<html>
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<link href="/assets/Crazzy/css/styles.css" type="text/css" rel="stylesheet">
		<link media="screen" href="/assets/Crazzy/css/style.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<video autoplay loop poster="<?=BACKGROUND;?>" id="bgindex">
			<source src="/assets/Crazzy/img/bg.webm" type="video/webm">
			<source src="/assets/Crazzy/img/bg.mp4" type="video/mp4">
		</video>
		<div id="content">
			<a href="/" style="logo">
				<img src="<?=LOGOTYPE;?>" style="logo" alt="" />
			</a>
			<div id="gran" style="left: 870px; top: 5px; position: absolute; ">
				<script>function test(a){if(a=="13"){$("#test").click()}}</script>
				<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px; position: relative; bottom: -8px;" id="search" type="text">
				<input class="btn" value="Поиск" id="test" style="height: 36px; line-height: 1px; position: relative; bottom: -8px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
			</div>
			<div class="menuClass" style="width: 100%; float: left;">
				<ul id="menu">
					<? $obj = json_decode(MENU, true); ?>
					<? foreach($obj as $name => $url){ ?>
					<li style="width: 20%;"><a href="<?=$url;?>"><?=$name;?></a></li>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li style="width: 20%;"><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
					<? } ?>
				</ul>
			</div>
			<div id="left">
				<div id="leftcatname">Категории</div>
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<div id="leftline"></div>
					<a href="/item/<?=$row['name'];?>" id="leftcat"><?=$row['category'];?></a>
					<? } ?>
					<div id="leftline"></div>
					<a href="/myorders/" id="leftcat">Мои покупки</a>
				<? } ?>
				<div id="leftcatname">Контакты</div>
				<div id="blockContacts" style="min-height: 50px; color: white; text-align: center; position: relative; top: 15px;">
					<?=CONTACTS;?>
				</div>
				<div id="leftcatname">Информация</div>
				<div id="blockInformation" style="min-height: 50px; color: white; text-align: center; position: relative; top: 15px;">
					<?=INFORMATION;?>
				</div>
			</div>
			<style>
			#container10i {
    background-color: <?=COLORCRAZZYFON;?>;
}
			</style>
			<Style>
			#left {
    background-color: <?=COLORCRAZZYFON;?>;
}
</style>
<style>
#menu li {
    background-color: <?=COLORCRAZZYFON;?>;
}
</style>
			<div id="container10i" style="min-height: 600px;">