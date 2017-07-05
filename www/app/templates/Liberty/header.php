<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link href="/assets/Liberty/css/style.css" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery.js"></script>
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
	</head>
	<body id="body">
		<style>
			body {
				background: url(<?=BACKGROUND;?>);
				background-attachment:fixed;
			}
			a.active {
				border-color: rgb(0, 143, 221);
				color: rgb(255, 255, 255);
				background: rgb(0, 172, 255);
				background: -moz-linear-gradient(top, rgba(0,172,255,1) 0%, rgba(0,162,240,1) 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(0, 172, 255)), color-stop(100%,rgb(0, 162, 240)));
				background: -webkit-linear-gradient(top, rgb(0, 172, 255) 0%,rgb(0, 162, 240) 100%);
				background: -o-linear-gradient(top, rgba(0,172,255,1) 0%,rgba(0,162,240,1) 100%);
				background: -ms-linear-gradient(top, rgba(0,172,255,1) 0%,rgba(0,162,240,1) 100%);
				background: linear-gradient(to bottom, rgb(0, 172, 255) 0%,rgb(0, 162, 240) 100%);
			}
		</style>
		<style>
		.hnav {
    background: <?=COLORLIBERTYVERX;?>;
}
		</style>
		<style>
.fbottom {
    background: <?=COLORLIBERTYVERX;?>;
}
</style>
<style>
.sb_title {
    background: <?=COLORLIBERTYBLOCK;?>;
}
</style>
<style>
.item .titles {
    background: <?=COLORLIBERTYITEM;?>;
}
</style>
<Style>
.itemf_tab .tabs_btn {
    background: <?=COLORLIBERTYITEM;?>;
}
</style>
<style>
.wrapper {
    background: <?=COLORLIBERTYFON;?>;
}
</style>
		<div class="wrap">
			<div class="wraps">
				<div class="wrapper">
					<header class="htop">
						<div class="logo">
							<a href="/"><img src="<?=LOGOTYPE;?>" /></a>
						</div> 
						<nav class="hnav">
							<ul class="hp_nav" style="text-align: center;">
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
						</nav>
					</header>
					<div class="content_full">