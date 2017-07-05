<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,600,600italic,400italic&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css' />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link href="/assets/Games/css/style.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
	</head>
	<body id="body">
		<div class="wrap" style="background: url('<?=LOGOTYPE;?>') no-repeat center 0;">
			<header class="header-top"></header>
			<nav class="header-nav">
				<div class="wrapper">
					<ul class="header-nav-list">
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
			</nav>
			<div class="wrapper">
				<div class="content-top-category">
					<div class="block-title"><i class="icv ic-category"></i> <span>Категории</span></div>
					<div class="nav-category-list-wrap">
						<div class="nav-category-list-ins">
							<ul class="nav-category-list">
								<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
								<? if(mysqli_num_rows($SQL) > 0){ ?>
									<? while($row = mysqli_fetch_array($SQL)){ ?>
									<li>
										<a href="/item/<?=$row['name'];?>" class="current">
											<span><?=$row['category'];?></span>
										</a>
									</li>
									<? } ?>
								<? } ?>
							</ul>
						</div>
					</div>
				</div>
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 6"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<div class="content-top-item clearfix">
					<div class="side-block center" style="margin: 0 auto;">
						<div class="block-title"><i class="icv ic-sell-last"></i> <span>Последние покупки</span></div>
						<div class="block-wrap i-sell-last">
							<ul class="list-items-sell-last">
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
							<? if(mysqli_num_rows($SQL1) > 0){ ?>
							<? $ITEM = mysqli_fetch_array($SQL1); ?>
							<li><a href="/item/<?=$ITEM['item_id'];?>"><?=$row['item'];?></a></li>
							<? } ?>
							<? } ?>
							</ul>
						</div>
					</div>
				</div><style>
.header-nav {
    background: <?=COLORGAMESVERX;?>;
}</style>
								<Style>
				body {
    background: <?=COLORGAMESFON;?>;
}
</style><Style>
.block-wrap {
    background: <?=COLORGAMESTVR;?>;
}
</style>
<Style>
.btn-buy:hover {
    background: <?=COLORGAMESPAY;?>;
}
</style>
				<? } ?>