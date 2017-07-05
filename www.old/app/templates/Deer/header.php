<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
	<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
	<link rel="stylesheet" media="all" href="/assets/Deer/css/style.css" />
	<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
	<script src="/assets/js/jquery.toastmessage.js"></script>
    <script src="/assets/Deer/js/shop.new.js"></script>
    <script src="/assets/Deer/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            background: #000 url(/static/images/templates/alyssum/bg.jpg) no-repeat center top
        }
		body {
			background: url('<?=BACKGROUND;?>');
			background-attachment:fixed;
		}
		.row-block {
			background: rgba(255, 255, 255, 0);
		}
	</style>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
</head>
<body class="b-shop">
	<div id="overlay"></div>
	<div class="container">
	<style>
	.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
    z-index: 2;
    background-color: <?=COLORDEERCATEG;?>;
    border-color: <?=COLORDEERCATEG;?>;
}
</style>
<style>
table.shop_goods tr {
    background-color: <?=COLORDEERITEM;?>;
}
</style>
<style>
.buy_game {
    background-color: <?=COLORDEERPRT;?>;
}
</style>
<style>
.checkpaybtn {

    background-color: <?=COLORDEERPRT;?>;
}
</style>