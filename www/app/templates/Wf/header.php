<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=1002">
		<link href="/assets/Wf/css/style.css" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery.js"></script>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<style>
			.formbox .rows:nth-child(3){
				display:none
			}
			.wrap {
				min-width: 1002px;
				padding-top: 286px;
				overflow: hidden;
			}
			cat1 {
				background: url(http://i.imgur.com/2BbSz4d.gif);
			}
			mailak {
				color: rgb(255, 0, 0);
				font-family: arial;
				background: url(http://i.imgur.com/darLNdO.gif);
			}
			sale {
				color: rgb(255, 0, 0);
				font-family: arial;
				background: url(http://i.imgur.com/darLNdO.gif);
			}
			don1 {
				color:#fff;
				text-shadow: 0 0 5px #fff;
				background: url(http://youhack.ru/images/backround11.gif);
			}
			text1 {
				color: #00FF00;
				text-shadow: 0px 0px 5px #00FF00;
			}
			text2 {
				color: #fcff00;
				text-shadow: 0px 0px 5px #fcff00;
			}
			text3 {
				color: #06a0f9;
				text-shadow: 0px 0px 5px #06a0f9;
			}
			@-webkit-keyframes pulsate {
				50% {
					color: #fff;
					text-shadow: 0 -1px rgba(0,0,0,.3), 0 0 5px #ffd, 0 0 8px #fff;
				}
			}
			@keyframes pulsate {
				50% {
					color: #fff;
					text-shadow: 0 -1px rgba(0,0,0,.3), 0 0 5px #ffd, 0 0 8px #fff;
				}
			}
			#blink7 {
				color: rgb(245,245,245);
				text-shadow: 0 -1px rgba(0,0,0,.1);
				-webkit-animation: pulsate 1.2s linear infinite;
				animation: pulsate 1.2s linear infinite;
			}
			.itemf .pict {
				pointer-events: none;
			}
			sr { 
				color: #06a0f9; 
				text-shadow: 0 0 3px #06a0f9; 
				background: url(http://i.imgur.com/14jaKGi.gif); 
			}
			bravo { 
				color: #00e4ff; 
				text-shadow: 0 0 5px #00e4ff; 
			}
			text5 { 
				color: #FF1493; 
				text-shadow: 0px 0px 5px #FF1493; 
			}
			body {
				margin: 0;
				padding: 0;
				font: 500 12px/1.2 'AgoraSansPro', Arial, Helvetica, sans-serif;
				color: #fff;
				text-transform: uppercase;
				background-size: cover;
			}
			.wrap {
				min-width: 1002px;
				padding-top: 286px;
				overflow: hidden;
				background: url('<?=BACKGROUND;?>') no-repeat center 0;
			}
			g1 {
				color: #00ff44;
				text-shadow: 0 0 4px #00ff53;
				background: url(http://i.imgur.com/LZCg5Q7.gif);
			}
		</style>
		<style>
		.hnav > ul {
    background: <?=COLORWFPANEL;?>;
}
</style><style>
.sb_title {
    background: <?=COLORWFPANEL;?>;
}
</style>
<style>
.content_full {
    background: <?=COLORWFFONP;?>;
}
</style>
<style>
.content_full .bg_layer {
    background: <?=COLORWFFON;?>;
}
</style>
		<link href="/assets/Wf/css/sc.css" media="screen" rel="stylesheet" type="text/css">
	</head>
	<body id="body">
		<div class="wrap">
			<div class="wrapper">
				<nav class="hnav">
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
					</ul>
				</nav>
				<div class="content_full">
					<div class="side_right" style="z-index: 9999;">