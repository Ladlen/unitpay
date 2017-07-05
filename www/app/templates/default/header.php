<!DOCTYPE html>
<html>
  <head>
	<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
	<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
    <!-- Bootstrap -->
    <link href="/assets/default/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/assets/default/css/style.css" rel="stylesheet">
    <link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
    <link href="/assets/default/css/bootstrap-glyphicons.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
	<script src="/assets/default/js/bootstrap.min.js"></script>
    <script src="/assets/default/js/respond.js"></script>
	<script type="text/javascript" src="/assets/default/js/app.js"></script>
	<script src="/assets/js/jquery.toastmessage.js"></script>
	<style type="text/css">
		#coupon {
			float:right;
			margin:9px;
			margin-bottom:0px;
			font-size:11px;
        }
		.cpnin {
			margin-top:0px !important;
		}
        #coupon:hover {
            cursor:pointer; 
		}
	</style>
	<style>
.btn-primary {
    color: #fff;
    background-color: <?=COLORDEFAULTBUTTON;?>;
    border-color: <?=COLORDEFAULTBUTTON;?>;
	}
	</style>
	<style>
.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
    color: #fff;
    background-color: <?=COLORDEFAULTBUTTON;?>;
    border-color: <?=COLORDEFAULTBUTTON;?>;
}
</style>
<style>
a {
    color: <?=COLORDEFAULTTEXT;?>;
    text-decoration: none;
}
</style>
  </head>
  <body>
	<div class="navbar navbar-static-top"style="background-color: <?=COLORDEFAULT;?>;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">Развернуть/Свернуть</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><?=TITLE;?></a>
			</div>
			<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
				<ul class="nav navbar-nav">
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
				<div style="float: right; left: -2px; position: relative;">
					<script>function test(a){if(a=="13"){$("#test").click()}}</script>
					<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px;position: relative;bottom: -8px;border:0;border-radius: 5px;" id="search" type="text">
					<input class="btn" value="Поиск" id="test" style="height: 30px;line-height: 1px;position: relative;bottom: -7px;" onclick="location.href = '/search/'+$('#search').val();" type="button">
				</div>
			</nav>
		</div>
	</div>
	<div class="container">
		<div class="jumbotron"style="background-color: <?=COLORDEFAULTFON;?>;">
			<h1><?=TITLE;?></h1>
		</div>
		<div class="row maincont">
			<div class="col-lg-8">
				<ol class="breadcrumb">
					<li><a href="/">Главная</a></li>					
					<? if(Defined("CAT") && CAT == "p" || Defined("PID")){ ?>
					<li><a href="/page/">Публикации</a></li>
					<? } ?>
					<? if(Defined("GID") || PAGE == "gifts"){ ?>
					<li><a href="/gifts/">Раздачи</a></li>
					<? } ?>
					<? if(Defined("MENU_PAGE_NAME")){ ?>
					<li><a href="<?=ADDRESS;?>"><?=MENU_PAGE_NAME;?></a></li>
					<? } ?>
				</ol>