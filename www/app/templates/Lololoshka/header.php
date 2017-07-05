<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="stylesheet" href="/assets/Lololoshka/css/styles.css">
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/Lololoshka/js/v1.11.0-jquery.min.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<script>
			var timelast = 15000;
		</script>
		<script src="/assets/Lololoshka/js/scripts.js"></script>
	</head>
	<body style="background: url('<?=BACKGROUND;?>') no-repeat #000; -moz-background-size: 100%; -webkit-background-size: 100%; -o-background-size: 100%; background-size: 100%;">
		<header class="main-header" style="height: 350px;">
			<div class="main-header_top">
				<div class="wrapper relative">
					<nav>
						<? $obj = json_decode(MENU, true); ?>
						<? foreach($obj as $name => $url){ ?>
						<a href="<?=$url;?>"><?=$name;?></a>
						<? } ?>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a>
						<? } ?>
						<a href="/myorders/">Мои покупки</a>
					</nav>
				</div>
			</div>
		</header>
		<div class="content">