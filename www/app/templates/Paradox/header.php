<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<script type="text/javascript" src="/assets/Paradox/js/jquery.js"></script>
		<script type="text/javascript" src="/assets/Paradox/js/jqueryui.js"></script>
		<script type="text/javascript" src="/assets/Paradox/js/dle_js.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.toastmessage.js"></script>
		<link href="/assets/Paradox/css/style.css" rel="stylesheet" media="screen">
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<link href="/assets/Paradox/css/bootstrapgoodakk.css" rel="stylesheet" media="screen">
	</head>
    <body>
		<style>
			body {
				background-image: url(<?=BACKGROUND;?>);
				background-attachment:fixed;
			}
		</style>
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
					<div style="float: right; position: relative; bottom: 3px; left: 18px;">
						<script>function test(a){if(a=="13"){$("#test").click()}}</script>
						<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px; position: relative; bottom: -8px; min-height: 0px; padding: 6px;" id="search" type="text">
						<input class="btn" value="Поиск" id="test" style="height: 30px; position: relative; bottom: -7px; line-height: 5px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
					</div>
				</ul>
				<div id="m-nav">
					<div class="h-logo" style="background:url(<?=LOGOTYPE;?>) no-repeat;">
						<a href="/" class="logo"></a>
					</div>
				</div>
				<div id="b-cat"></div>
			</header>
			<section id="middle">