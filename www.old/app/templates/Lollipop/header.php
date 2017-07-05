<html class="">
	<head>
		<meta charset="utf-8"> 
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<script src="http://code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
		<script src="/assets/Lollipop/js/bootstrap.min.js"></script>
		<script src="/assets/Lollipop/js/respond.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
		<link href="/assets/Lollipop/css/style.css" rel="stylesheet" media="screen">
		<link href="/assets/Lollipop/css/bootstrap-glyphicons.css" rel="stylesheet" media="screen">
		<link href="/assets/Lollipop/css/bootstrapcssleque.css" rel="stylesheet" media="screen">
		<link href="/assets/Lollipop/css/limev2.css" rel="stylesheet" media="screen">
		<style>
			html, body {
				background-image: url(<?=BACKGROUND;?>);
				background-attachment: fixed;
				background-size: cover;
				background-repeat: no-repeat;
			}
			body {
				font-family: Arial;
				font-size: 13px;
				color: black;
				text-shadow:;
			}
			.modal-content {
				background-color: #111736;
			}
			.pop_file img {
				width: 143px;
				height: 143px;
				max-width: 100%;
				padding-left: 29px;
			}
			.pop_file img {
				width: 143px;
				height: 143px;
				max-width: 100%;
				padding-left: 29px;
			}
			.modal-content {
				color: rgb(0, 0, 0);
			}
			.tab-box {
				width: 796px;
			}
		</style>
		<style>
		.block-top, #side-right .block-top {
    background: url(<?=COLORLOLIPOPBLOCK;?>) no-repeat, url(/assets/Lollipop/img/block-top-blue.png);
	background-position: 0 -33px;
}
</style>
<style>
input[type="button"], input[type="submit"], input[type="reset"], button {
    background: <?=COLORLOLIPOPKLICK;?>;
}
</style>
<style>
.full-nav li:hover, .full-nav li.cur {
    background: <?=COLORLOLIPOPKLICK;?>;
}
</style>
<Style>
.full-box .buy-item .coast {
    background: <?=COLORLOLIPOPKLICKFN;?>;
}
</style>
	</head>
	<body data-twttr-rendered="true" style="overflow: auto;">
		<div id="main">
			<div id="header">
				<ul id="h-nav">
					<? $obj = json_decode(MENU, true); ?>
					<? foreach($obj as $name => $url){ ?>
					<li><a href="<?=$url;?>"><?=$name;?></a></li>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
					<? } ?>
					<li><a href="/myorders/">Мои покупки</a></li>
					<div style="float: right; left: 12px; position: relative;">
						<script>function test(a){if(a=="13"){$("#test").click()}}</script>
						<input placeholder="Поисковой запрос.." onkeyup="test(event.keyCode)" style="height: 30px;border:0;" id="search" />
						<input value="Поиск" type="button" id="test" style="height: 30px; line-height: 1px; position: relative; bottom: 5px;" onclick="location.href = '/search/'+$('#search').val();" />
					</div>
				</ul>
				<div id="h-poster">
                    <div id="h-shadw"></div>
                    <a style="background: url() no-repeat;width: 250px;" href="/" id="h-logo"></a>
                    <img src="<?=LOGOTYPE;?>" />
                </div>
            </div>
			<section id="middle" style="min-height: 80%;">