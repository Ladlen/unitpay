<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<meta name="viewport" content="width=1200">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<style>
			warning {
				color: #fa005e;
				text-shadow: 0px 0px 5px #fa005e;
			}
			.item-full-pict .bx-prev {
				visibility: hidden;
			}
			.item-full-pict .bx-next {
				visibility: hidden;
			}
			bg1 {
				color: rgb(255, 255, 255);
				text-decoration: none;
				transition: 0.3s;
				text-shadow: 0 0 2px;
			}
			blockquote, .blockquote {
				padding: 11px 10px 15px;
				margin: 12px 0;
				border-left: 7px solid #6C50C1;
				font: 300 14px/1.3 'Open Sans', Arial, Helvetica, sans-serif;
				color: #fff;
				background: rgba(42, 66, 55, 0);
			}
			body {
				width: 100%;
				margin: 0;
				padding: 0;
				font: 400 14px/1.2 'Open Sans', Arial, Helvetica, sans-serif;
				color: #e7e7e7;
				background: #0C1212 url(/assets/Lilac/img/footer_bg.jpg) no-repeat center bottom;
			}
		</style>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		<link href="/assets/Lilac/css/style.css" rel="stylesheet" type="text/css">
		<script src="/assets/Lilac/js/jquery.js"></script>
		<script src="/assets/Lilac/js/script_site.js"></script>
	</head>
	<body id="body">
		<div class="wrap">
			<div class="wrapper">
				<div class="header-top">
					<span class="header-logo"><a href="/"><img src="<?=LOGOTYPE;?>" alt=""></a></span>
					<div class="header-search">
						<script>function test(a){if(a=="13"){$("#test").click()}}</script>
						<input type="text" id='search' placeholder="Введите запрос и нажмите Enter"  onkeyup="test(event.keyCode)">
						<input type="submit" id='test' value="" onclick="location.href = '/search/'+$('#search').val();">
					</div>
				</div>
				<ul class="category-nav">
					<? $obj = json_decode(MENU, true); ?>
					<? foreach($obj as $name => $url){ ?>
					<li><a href="<?=$url;?>"><span><?=$name;?></span></a></li>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li><a href="/page/<?=$row['pid'];?>"><span><?=$row['title'];?></span></a></li>
					<? } ?>
					<li><a href="/myorders/"><span>Мои покупки</span></a></li>
				</ul>
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<ul class="category-nav">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li><a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a></li>
					<? } ?>
				</ul>
				<? } ?>
				<style>
				.btn-buy:hover {
    background-color: <?=COLORLILACPAY;?>;
}
</style>
<style>
.btn-buy {
    color: <?=COLORLILACCN;?>;
}
</style>
<Style>
.item-full-cont .tabs-btn > a.current {
    border-bottom-color: <?=COLORLILACCN;?>, #6C50C1;
}
</style>
<Style>
blockquote, .blockquote {
    border-left: 7px solid <?=COLORLILACCN;?>, #6C50C1;
}
</style>
<style>
body {
    background: <?=COLORLILACFON;?>;
}
</style>
				<div class="items-wrap clearfix">