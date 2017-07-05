<html>
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<script src="http://code.jquery.com/jquery.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link href="/assets/Mirage/css/style.css" rel="stylesheet" type="text/css" />
		<link href="/assets/Mirage/css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/assets/Mirage/css/jquery.rating.css" />
		<script src="/assets/Mirage/js/jquery-ui.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript" src="/assets/Mirage/js/jquery.MetaData.js"></script>
		<script language="javascript" type="text/javascript" src="/assets/Mirage/js/jquery.rating.js"></script>
		<script type="text/javascript">$(document).ready(function() {$(".info-tabs").tabs({ fxSlide: true, fxFade: true, fxSpeed: 'normal' });});</script>
	</head>
	<body>
		<style>body { background: url(<?=BACKGROUND;?>);background-attachment:fixed; }</style>
		<div class="wrapper">
			<div class="header">
				<a class="logo" href="/" style="background:url(<?=LOGOTYPE;?>) no-repeat;"></a>
				<div class="menu">
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
						<div style="float: right; left: -25px; position: relative; bottom: 1px;">
							<script>function test(a){if(a=="13"){$("#test").click()}}</script>
							<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="padding: 0px; height: 25px; position: relative; bottom: -7px; min-height: 0px;border:0;" id="search" type="text">
							<input class="btn" value="Поиск" id="test" style="height: 25px;line-height: 1px;position: relative;bottom: -7px;background: #252525;border-bottom: 1px solid #3D3F3F;padding: 7px 0px;border-right: none;border-left: none;border-top: none;color: #fff;cursor: pointer;width: 55px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
						</div>
					</ul>
					<div class="left"></div>
					<div class="right"></div>
				</div>
			</div>
			<div class="content">