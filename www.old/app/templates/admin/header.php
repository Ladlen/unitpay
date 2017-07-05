<!DOCTYPE html>
<html>
	<head>
		<title><?=TITLE;?></title>
		<script src="http://code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
		<link href="/assets/css/bootstrap.css" rel="stylesheet">
		<link href="/assets/css/docs.css" rel="stylesheet">
		<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
		<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>
	</head>
	<body>
		<style>
			body {
				position: unset;
				overflow-x:  hidden;
			}
			.background {
				position: absolute;
				width: 100%;
				height: 100%;
				top: 0px;
				right: 0px;
				text-shadow: 0px 1px 3px rgba(0, 0, 0, 0.4), 0px 0px 30px rgba(0, 0, 0, 0.075);
				background: transparent linear-gradient(45deg, #020031 0%, #6D3353 100%) repeat scroll 0% 0%;
				box-shadow: 0px 3px 7px rgba(0, 0, 0, 0.2) inset, 0px -3px 7px rgba(0, 0, 0, 0.2) inset;
			}
			.background:after {
				width: 100%;
				height: 100%;
				content: '';
				display: block;
				background: url(http://getbootstrap.com/2.3.2/assets/img/bs-docs-masthead-pattern.png) repeat center center;
				opacity: 0.4;
			}
			.left {
				position: fixed;
				top: 2%;
				width: 17%;
				background: #F5F5F5;
				height: 100%;
			}
			.affix {
				position: relative;
			}
			.bs-docs-sidenav.affix {
				top: 10px;
			}
			.bs-docs-sidenav > li:first-child > a, .bs-docs-sidenav > li:last-child > a{
				border-radius: 0px 0px 0px 0px;
			}
			.bs-docs-sidenav {
				width: 96%;
			}
			.right {
				position: absolute;
				top: 3%;
				height: 96%;
				left: 17%;
				width: 83%;
				background: #FFF;
				opacity: 1;
			}
			.headerTheme {
				color: white;
				height: 25px;
				background: black;
				position: fixed;
				top: 0px;
				width: 100%;
				z-index: 9999;
			}
			.footerTheme {
				color: white;
				height: 25px;
				background: black;
				position: fixed;
				bottom: 0px;
				width: 100%;
				z-index: 9999;
			}
			.headerContent, .footerContent {
				text-align: center;
				position: relative;
				top: 2px;
			}
			.rightContent {
				position: relative;
				margin: 0 auto;
				height: 96%;
				width: 95%;
				top: 12px;
			}
		</style>
		<!--<div class="background"></div>-->
		<div class="headerTheme">
			<div class="headerContent">
				Аренда магазина истекает через <font color="red"><?=DAYS;?></font> дней. <b><a href="https://bill.shopsu.ru/continue">Продлить</a></b>
			</div>
		</div>
		<div class="content">
			<div class="left">
				<ul class="nav nav-list bs-docs-sidenav affix" style="margin: 0 auto; position: relative; top: 2%;">
					<li><a href="/admin/"><i class="icon-home"></i> Главная</a></li>
					<li><a href="/"><i class="icon-shopping-cart"></i> В магазин</a></li>
					<li><a href="/admin/items"><i class="icon-file"></i> Товары</a></li>
					<li><a href="/admin/orders"><i class="icon-tasks"></i> Заказы</a></li>
					<li><a href="/admin/pages"><i class="icon-pencil"></i> Страницы</a></li>
					<li><a href="/admin/categories"><i class="icon-list-alt"></i> Категории</a></li>
					<li><a href="/admin/statistics"><i class="icon-signal"></i> Статистика</a></li>
					<li><a href="/admin/secure"><i class="icon-lock"></i> Безопасность</a></li>
					<li><a href="/admin/logs"><i class="icon-picture"></i> Логи Авторизаций</a></li>
					<li><a href="/admin/users"><i class="icon-user"></i> Пользователи</a></li>
					<li><a href="/admin/settings"><i class="icon-wrench"></i> Настройки</a></li>
					<li><a href="/admin/codes"><i class="icon-tags"></i> Купоны</a></li>
					<li><a href="/admin/gifts"><i class="icon-gift"></i> Раздачи</a></li>
					<li><a href="/admin/templates"><i class="icon-picture"></i> Шаблоны</a></li>
					<li><a href="/admin/logout"><i class="icon-arrow-left"></i> Выйти</a></li>
					<center>
						<li style="border: 1px solid #dddddd; border-radius: 0px 0px 5px 5px;"><div id="vk_groups" style="padding: 10px;"></div></li>
					</center>
					<script type="text/javascript">
						VK.Widgets.Group("vk_groups", {mode: 2, width: "210", height: "180"}, 73396752);
					</script>
				</ul>
			</div>
			<div class="right">
				<div class="rightContent">
				<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>