<!doctype html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/assets/ZakaBlue/css/main.min.css" />
		<link href='http://fonts.googleapis.com/css?family=open+sans:400,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="/assets/ZakaBlue/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="/assets/ZakaBlue/js/main.js?v12"></script>
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<meta http-equiv="content-language" content="ru" />
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
	</head>
	<body>
		<style>
			html, body {
				background-image: url(<?=BACKGROUND;?>);
				background-attachment: fixed;
				background-size: cover;
				background-repeat: no-repeat;
			}
		</style>
		<div class="header_info">
			<table width="980" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td>
							<? $obj = json_decode(MENU, true); ?>
							<? foreach($obj as $name => $url){ ?>
							<a href="<?=$url;?>"><?=$name;?></a>
							<? } ?>
							<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a>
							<? } ?>
							<a href="/myorders/">Мои покупки</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="width:980px;margin: auto;">
			<div id="main">
				<table width="980" cellspacing="0" cellpadding="0" border="0" class="header_logo header_bg">
					<tbody>
						<tr>
							<td class="logo"><a href="/"><img src="<?=LOGOTYPE;?>"></a></td>
							<td class="pros">
								<table>
									<tr>
										<td class="odd">Лучшие цены</td>
										<td>Моментальная доставка</td>
									</tr>
									<tr>
										<td class="odd">Скидки и акции</td>
										<td>Раздачи и конкурсы</td>
									</tr>
									<tr>
										<td colspan="2">Гарантии</td>
									</tr>
								</table>
							</td>
							<TD style="width:260px">
								<FORM id="search">
									<script>function test(a){if(a=="13"){$("#test").click()}}</script>
									<INPUT type="text" onkeyup="test(event.keyCode)" class="text" id="search1" placeholder="Поиск.." autocomplete="off" />
									<INPUT type="button" onclick="location.href = '/search/'+$('#search1').val();" class="submit" />
								</FORM>
							</TD>
						</TR>
					</TBODY>
				</TABLE>	
				<?
					# Случайный товар
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ORDER BY RAND() LIMIT 4");
				?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<DIV id="slider">
					<UL>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<? $price = json_decode($row['price'], true); ?>
						<LI style="float: left;">
							<A href="/item/<?=$row['item_id'];?>">
								<IMG src="<?=$row['image'];?>" />
								<DIV>
									<H1><?=$row['item'];?></H1>
									<P><?=$row['body'];?></P>
									<h3><p><?=$price['WMR'];?><span>р.</span></p></h3>
								</DIV>
							</A>
						</LI>
						<? } ?>
					</UL>
				</DIV>
				<? } ?>
				<DIV class="center_main">
					<DIV class="left_div">
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<DIV class="genres gray_bg">
							<H1 class="col_top">Категории</H1>
							<ul>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<li><a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a></li>
								<? } ?>
							</ul>
						</DIV>
						<? } ?>
						<DIV class="news gray_bg" style="min-height: auto; height: auto;">
							<H1 class="col_top">Контакты</H1>
							<UL>
								<?=CONTACTS;?>
							</UL>
						</DIV>
						<DIV class="news gray_bg" style="min-height: auto; height: auto;">
							<H1 class="col_top">Информация</H1>
							<UL>
								<?=INFORMATION;?>
							</UL>
						</DIV>
					</DIV>