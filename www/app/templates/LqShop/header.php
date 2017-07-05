<!DOCTYPE html>
<html>

<head>
    <link href="/assets/LqShop/css/bootstrapcssleque.css" rel="stylesheet" media="screen">
    <link href="/assets/LqShop/css/style.css" rel="stylesheet" media="screen">
    <link href="/assets/LqShop/css/jquery.toastmessage.css" rel="stylesheet" media="screen">

    <!--<script src="/assets/LqShop/js/jq.js"></script>
    <script src="/assets/LqShop/js/jquery-ui.js"></script>
    <script src="/assets/LqShop/js/bootstrap.min.js"></script>
    <script src="/assets/LqShop/js/ZeroClipboard.js"></script>
    <script src="/assets/LqShop/js/jquery.toastmessage.js"></script>-->

    <!-- leque meta start -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
    <link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
    <meta name="title" content="<?=TITLE;?>">
    <meta name="description" content="<?=DESCRIPTION;?>">
    <meta name="keywords" content="<?=KEYWORDS;?>">
    <meta name="document-state" content="dynamic">
    <meta http-equiv="content-language" content="ru-RU">
    <meta name="robots" content="all">
    <meta property="og:title" content="<?=TITLE;?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?=TITLE;?>">
    <meta property="og:description" content="<?=TITLE;?>">
    <meta property="og:locale" content="ru_RU">
    <!-- end leque meta -->
    <!-- JavaScripts Start-->
    <!--<script src="/assets/LqShop/js/app.js"></script>-->
    <!-- JavaScripts End-->
</head>

<div class="navbar navbar-static-top"style="background: <?=COLORLQSHOPVERX;?>;">
    <div class="container">
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
            </ul>
            <form style="margin: 10px;" class="navbar-form navbar-left" method="get" action="/">
                <div class="form-group">
                    <input type="text" placeholder="Поиск..." class="form-control" id='search' name="search" onkeyup="test(event.keyCode)">
                </div>
                <input id="test" type="button" onclick="location.href = '/search/'+$('#search').val();" class="btn btn-primary" value="Поиск">
            </form>
        </nav>
    </div>
</div>

<body>
    <div class="container">
				<div id="myCarousel" class="carousel slide" style="min-width:781px;">
				<div class="carousel-inner">
					<div class="active item"><img src="<?=LOGOTYPE;?>"></div>
				</div>
				<a class="carousel-control left" href="#myCarousel"data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#myCarousel"data-slide="next">&rsaquo;</a>
			</div>

        <div class="row maincont" style="background:<?=COLORLQSHOPFON;?>;margin-top: 0px;">
            <div class="col-lg-8"><Style>
.row {
background-color: LightYellow;
}
</style>
<style>
.btn-primary {
    color: #fff;
    background-color: <?=COLORLQSHOPPAY;?>;
    border-color: <?=COLORLQSHOPPAYK;?>;
}
</style>
<style>
.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
    color: #fff;
    background-color: <?=COLORLQSHOPPAYN;?>;
    border-color: <?=COLORLQSHOPPAYK;?>;
}
</style>
<Style>
.modal-content {
    background-color: <?=COLORLQSHOPPAYOPL;?>;
}
</style>
<style>
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border-right: 1px solid <?=COLORLQSHOPBORDER;?>;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    border-top: 1px <?=COLORLQSHOPBORDER;?>;
}
.table-bordered {
    border: 1px solid <?=COLORLQSHOPBORDER;?>;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    border-top: 1px solid <?=COLORLQSHOPBORDER;?>;
}

</style>
