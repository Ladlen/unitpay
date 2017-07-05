<!DOCTYPE html>
<html>
	<head>
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link href="/assets/Mamba/css/style.css" rel="stylesheet" type="text/css">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<script type="text/javascript" src="/assets/Elegant/js/jquery-1.7.2.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<script src="/assets/Mamba/js/jquery.flexslider-min.js"></script>
		<script src="/assets/Mamba/js/payment.js"></script> 
		<link rel="stylesheet" type="text/css" href="/assets/Mamba/css/shop.css" media="screen" />
		<style>body {background: #000 url(<?=BACKGROUND;?>) no-repeat; background-attachment: fixed;background-size: cover;background-attachment:fixed;}</style>
	</head>
	<body>
		<div class="wrapper">
			<header class="header">
				<div class="submenu">
					<div class="topbar">
						<div class="left">
							<ul class="tmenu" style="width: 900px;">
								<? $obj = json_decode(MENU, true); ?>
								<? foreach($obj as $name => $url){ ?>
								<li><a href="<?=$url;?>"><?=$name;?></a></li>
								<? } ?>
								<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<li><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
								<? } ?>
								<li><a href="/myorders/">Мои покупки</a></li>
								<div style="float: right; left: -2px; position: relative; bottom: 3px;">
									<script>function test(a){if(a=="13"){$("#test").click()}}</script>
									<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="padding: 0px; height: 25px; position: relative; bottom: -7px; min-height: 0px;" id="search" type="text">
									<input class="btn" value="Поиск" id="test" style="height: 30px;line-height: 1px;position: relative;bottom: -7px;background: #e06138;border-bottom: 1px solid #3D3F3F;padding: 7px 0px;border-right: none;border-left: none;border-top: none;color: #fff;cursor: pointer;width: 55px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
								</div>
							</ul>
						</div>
					</div>
					<div class="topbar2">
						<div class="section">
							<script>
								$(window).load(function () {
									$('.flexslider').flexslider({
										animation: "slide"
									});
								});
							</script>
						</div>
					</div>
				</div>
				<div class="top">
					<a class="logo" href="/">
						<img style="max-width: 300px; max-height: 80px;" src="<?=LOGOTYPE;?>">
					</a>
				</div>
				<div id="sidebar"></div>
			</header>
			<div class="container">
				<div id="notification"></div>
					<div id="content">