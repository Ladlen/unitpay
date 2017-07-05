<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="/assets/WhiteBs/css/bootstrap.css" rel="stylesheet">
		<link href="/assets/WhiteBs/css/font-awesome.min.css" rel="stylesheet">
		<link href="/assets/WhiteBs/css/jquery.bxslider.css" rel="stylesheet">
		<link href="/assets/WhiteBs/css/style.css" rel="stylesheet">
		<script src="/assets/WhiteBs/js/jquery.js"></script>
		<script src="/assets/WhiteBs/js/bootstrap.js"></script>
		<script src="/assets/WhiteBs/js/jquery.bxslider.min.js"></script>
		<script src="/assets/WhiteBs/js/jquery.blImageCenter.js"></script>
		<script src="/assets/WhiteBs/js/mi.js"></script>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
	</head>
	<body>
		<style>
			span.title {
				display: -moz-deck;
			}
			body {
				background-image: url(<?=BACKGROUND;?>);
				background-attachment: fixed;
				background-size: cover;
				background-repeat: no-repeat;
				font-family: Arial;
				cursor: url("http://www.geld-mit-homepage.net/wp-content/uploads/2011/03/klick.png"), auto;
				font-size: 28px;
				color: #4f42c7;
				text-shadow:0 1 0px #525050;
			}
			.modal-content {
				background-color: #d8cade;
			}
			#copybill {
				cursor: pointer;
			}
			#copyfund {
				cursor: pointer;
			}
		</style>
		<header>
			<div class="container">
				<div class="row1">
					<div class="col-lg-4 col-md-3 hidden-sm hidden-xs">
						<div class="well logo">
							<img onclick="location='/'" src="<?=LOGOTYPE;?>" />
						</div>
					</div>
					<div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
						<div class="well">
							<div class="input-group">
								<script>function test(a){if(a=="13"){$("#test").click()}}</script>
								<input type="text" class="form-control input-search"  placeholder="Введите текст для поиска" onkeyup="test(event.keyCode)" id="search">
								<span class="input-group-btn">
									<button class="btn btn-default no-border-left" id="test" onclick="location.href = '/search/'+$('#search').val();"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Переключение навигации</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
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
				</div>
			</div>
		</nav>
		<div class="container main-container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12">
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="col-lg-12 col-md-12 col-sm-6">
						<div class="no-padding">
							<span class="title" style="width: 150px;">Категории</span>
						</div>
						<div class="panel-group panel-categories" id="accordion">
							<div class="panel panel-default">
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="layer " href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
									</h4>
								</div>
								<? } ?>
							</div>
						</div>
					</div>
					<? } ?>
					<div class="col-lg-12 col-md-12 col-sm-6">
						<div class="no-padding">
							<span class="title" style="width: 150px;">Контакты</span>
						</div>
						<div class="panel-group panel-categories" id="accordion">
							<?=CONTACTS;?>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-6">
						<div class="no-padding">
							<span class="title"  style="width: 150px;">Информация</span>
						</div>
						<div class="panel-group panel-categories" id="accordion">
							<?=INFORMATION;?>
						</div>
					</div>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="col-lg-12 col-md-12 col-sm-6">
						<div class="no-padding">
							<span class="title  style="width: 150px;"">Последние покупки</span>
						</div>
						<div class='hero-feature'>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'")); ?>
							<div class='thumbnail text-center'>
								<a href="/item/<?=$row['item_id'];?>" class='link-p' style='overflow: hidden; position: relative;'><img src="<?=$ITEM['image'];?>" style='position: absolute; width: 250px; height: auto; max-width: none; max-height: none; left: -13px; top: 0px;'></a>
								<div class='caption prod-caption'>
									<h4><a href="/item/<?=$row['item_id'];?>"><?=$ITEM['item'];?></a></h4>
									<div class='btn-group'>
										<?=$row['price'];?> <?=$row['wallet'];?>
									</div>
									<p></p>
								</div>
							</div>
							<? } ?>
						</div>
					</div>
					<? } ?>
				</div>
				<Style>
				.navbar {
    background: <?=COLORWHITEBSOK;?>;
    border-color: <?=COLORWHITEBSOK;?>;
}
</style>
<style>
.navbar-inverse {
    background-color: <?=COLORWHITEBSOK;?>;
    border-color: <?=COLORWHITEBSOK;?>;
}
</style>
<style>
.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img {
    display: block;
    max-width: 60%;
    height: auto;
}
</style>
<style>
.btn-default {
    background-color: <?=COLORWHITEBSPAY;?>;
}
</style>
<style>
span.title {
    color: <?=COLORWHITEBSTEXT;?>;
}
</style>
<style>
.main-container {
    background: <?=COLORWHITEBSFON;?>;
}
</style>
				<div class="clearfix visible-sm"></div>
				