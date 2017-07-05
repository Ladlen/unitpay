<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css' />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="/assets/IgorFox/css/reset.css" />
		<link rel="stylesheet" href="/assets/IgorFox/css/style.css" />
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/assets/IgorFox/css/jquery.fancybox.css" media="screen" />
		<script type="text/javascript" src="/assets/IgorFox/js/jquery.fancybox.pack.js"></script>
		<link rel="stylesheet" href="/assets/IgorFox/css/magnific-popup.css" />
		<script src="/assets/IgorFox/js/jquery.magnific-popup.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<style>
			body {
				background: #000 url('<?=BACKGROUND;?>') center top no-repeat;
				width: auto;
			}
			.logo {
				background: url('<?=LOGOTYPE;?>') no-repeat left center;
			}
		</style>
	</head>
	<body>
		<header>
			<a href="/" class="logo"></a>
			<ul class="menu">
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
		</header>
		<main>
			<div class="margin" style="position: relative; min-height: 440px;    ">