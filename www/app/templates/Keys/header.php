<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link type="text/css" rel="stylesheet" href="/assets/Keys/css/015.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<style>.logo { background: url('<?=LOGOTYPE;?>') no-repeat 0 0;}</style>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="/assets/js/jquery.toastmessage.js"></script>
	</head>
	<body style="background-image: url('<?=BACKGROUND;?>');">
		<div class="wrapper">
			<div class="full">
				<div class="header">
					<a href="/" id='top' class="logo"></a>
					<ul class="nav">
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
					<div class="search">
						<script>function test(a){if(a=="13"){$("#test").click()}}</script>
						<input type="text" id="search" placeholder="Что ищем?" onkeyup="test(event.keyCode)" />
						<input type="submit" value="" id="test" onclick="location.href = '/search/'+$('#search').val();" />
					</div>
				</div>
				<div class="container"style="background: <?=COLORKEYSFON;?>;">
					<div class="container-l">
						<div class="blocktop">Меню</div>
						<li class="bnav"><a href="/"><span class="other">Весь товар</span></a></li>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<li class="bnav"><a href="/item/<?=$row['name'];?>" ><span><?=$row['category'];?></span></a></li>
							<? } ?>
						<? } ?>
						<div class="blocktop">Контакты</div>
						<div id="blockContacts" style="min-height: 50px; color: white; text-align: center; position: relative; top: 15px;">
							<?=CONTACTS;?>
						</div>
						<div class="blocktop">Информация</div>
						<div id="blockInformation" style="min-height: 50px; color: white; text-align: center; position: relative; top: 15px;">
							<?=INFORMATION;?>
						</div>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<div class="blocktop">Последние продажи</div>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
						<? if(mysqli_num_rows($SQL1) > 0){ ?>
						<? $ITEM = mysqli_fetch_array($SQL1); ?>
						<div class="lastitem">
							<div class="lastitemimages">
								<div class="lastitemprice"><?=$row['price'];?> <span><?=$row['wallet'];?></span></div>
								<img src="<?=$ITEM['image'];?>" alt="" />
							</div>
							<div class="lastitemname">
								<a href="/item/<?=$row['item_id'];?>"><?=$ITEM['item'];?></a>
							</div>
						</div>
						<? } ?>
						<? } ?>
						<? } ?>
					</div>
					<style>
					.footer {
    background: <?=COLORKEYSNUZ;?>;
}
</style>
<style>
.vfullico1 {
    background: <?=COLORKEYSFONN;?>;
}
</style>
<style>
.vfullico3 {
    background: <?=COLORKEYSFONN;?>;
}
</style>
					<div class="container-r">