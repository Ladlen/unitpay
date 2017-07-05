	<?
		# Парсим конфиг
		$CONFIG = json_decode(CONFIG, true);
	?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Шаблоны</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['templates'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<ul class="breadcrumb" style="overflow: auto; height: 90%;">
	<style>
		.filemanager .thmb {
			border: 1px solid #FCFCFC;
			background: #FCFCFC none repeat scroll 0% 0%;
			border-radius: 3px;
			padding: 10px;
			margin-bottom: 20px;
			position: relative;
			box-shadow: 0px 3px 0px rgba(12, 12, 12, 0.03);
		}
		.row {
			margin-left: 2%;
		}
		.filemanager .thmb-prev {
			background: #EEE none repeat scroll 0% 0%;
			overflow: hidden;
		}
		.img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
			display: block;
			max-width: 100%;
			height: auto;
		}
		.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
			padding-left: 10px;
			padding-right: 10px;
		}
		.col-md-3 {
			width: 30%;
		}
		.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
			float: left;
		}
	</style>

<link rel="Stylesheet" type="text/css" href="/assets/css/jPicker-1.1.6.min.css"/>
<link rel="Stylesheet" type="text/css" href="/assets/css/jPicker.css"/>
<style>
span.jPicker {
    line-height: 2.2em;
    margin-left: 5px;
}
table.jPicker {
    border-collapse: separate;
    line-height: 1em;
}
table.jPicker label {
    font-size: 11px !important;
}
.jPicker td[class="Text"] input {
    padding: 0;
    border-radius: 0;
}
.jPicker td.Radio input {
    margin-right: 3px;
}
.jPicker tr.Hue td.Radio,
.jPicker tr.Hue td.Text,
.jPicker tr.Saturation td.Radio,
.jPicker tr.Saturation td.Text,
.jPicker tr.Value td.Radio,
.jPicker tr.Value td.Text
{
    vertical-align: top;
}
.jPicker tr.Value td.Radio,
.jPicker tr.Value td.Text
{
    line-height: 0.3em;
}
.jPicker tr.Hex label {
    display: inline;
}
.jPicker tr.Hex input {
    margin-left: 3px;
}
.jPicker td.Button hr {
    margin: 6px 0;
    border-top: 1px black solid;
}
.jPicker h2 {
    line-height: 2em;
}
</style>

	<form action="/admin/templates" method="post" accept-charset="utf-8">
		<div class="row filemanager">
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/6DgHETm.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Default</a> <input style="opacity: 1;position: inherit;" value="default" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/z6eCuo7.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Aqua</a> <input style="opacity: 1;position: inherit;" value="Aqua" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/PVmrY19.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Boxy</a> <input style="opacity: 1;position: inherit;" value="Boxy" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/GVAtCQ0.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Elegant</a> <input style="opacity: 1;position: inherit;" value="Elegant" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/UYCrg5X.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Galaxy</a> <input style="opacity: 1;position: inherit;" value="Galaxy" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/DcqeJ8p.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Game</a> <input style="opacity: 1;position: inherit;" value="Game" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/4o5tinK.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Liberty</a> <input style="opacity: 1;position: inherit;" value="Liberty" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/6EM6ow3.jpg" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Lite</a> <input style="opacity: 1;position: inherit;" value="Lite" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/H8RLy0L.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Lollipop</a> <input style="opacity: 1;position: inherit;" value="Lollipop" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/eVBcNl9.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Mamba</a> <input style="opacity: 1;position: inherit;" value="Mamba" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/V872AqY.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Mirage</a> <input style="opacity: 1;position: inherit;" value="Mirage" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/Woin3Ao.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Paradox</a> <input style="opacity: 1;position: inherit;" value="Paradox" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/Ll5c8Sp.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Perfect</a> <input style="opacity: 1;position: inherit;" value="Perfect" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/dxH8ElV.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Premium</a> <input style="opacity: 1;position: inherit;" value="Premium" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/NTuf54K.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Universal</a> <input style="opacity: 1;position: inherit;" value="Universal" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/9KdDDmq.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Deer</a> <input style="opacity: 1;position: inherit;" value="Deer" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/lgxHQ7e.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>SellWhite</a> <input style="opacity: 1;position: inherit;" value="SellWhite" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/wBxEois.jpg" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>ZakaBlue</a> <input style="opacity: 1;position: inherit;" value="ZakaBlue" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/zJYAwVH.jpg" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>StempPay</a> <input style="opacity: 1;position: inherit;" value="StempPay" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/zCzhy1w.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>ShopNew</a> <input style="opacity: 1;position: inherit;" value="ShopNew" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/ehgUPXS.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>WhiteBs</a> <input style="opacity: 1;position: inherit;" value="WhiteBs" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://i.imgur.com/ZDdK6DC.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Lilac</a> <input style="opacity: 1;position: inherit;" value="Lilac" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/470a773310d3405fba8a18fd26c693b2.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Crazzy</a> <input style="opacity: 1;position: inherit;" value="Crazzy" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/9d9fa982ee454b3a916413378ba26364.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Lucky</a> <input style="opacity: 1;position: inherit;" value="Lucky" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/20686284d2b9456eae5d114571556d9b.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>IgorFox</a> <input style="opacity: 1;position: inherit;" value="IgorFox" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/24ef3d075aa64943942a8d0644a66ecf.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Games</a> <input style="opacity: 1;position: inherit;" value="Games" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/c6daf63f917248c39d58d8e3b20e8f7a.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Lololoshka</a> <input style="opacity: 1;position: inherit;" value="Lololoshka" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/763fdf53a1c84804bf97f9941aa083cb.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Keys</a> <input style="opacity: 1;position: inherit;" value="Keys" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="http://image.prntscr.com/image/48e6b1b755d34aa9b0ec8ede75b8bc27.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>Wf</a> <input style="opacity: 1;position: inherit;" value="Wf" name="template" type="radio"></h5>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 image">
				<div class="thmb">
					<div class="thmb-prev">
						<a data-rel="prettyPhoto" rel="prettyPhoto">
							<img src="https://image.prntscr.com/image/NpSvsTQGQreHis5kbvEUkA.png" class="img-responsive" style="height: 160px;">
						</a>
					</div>
					<h5 class="fm-title"><a>LqShop</a> <input style="opacity: 1;position: inherit;" value="LqShop" name="template" type="radio"></h5>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped">
			<tbody>
				<tr>
					<td>Название магазина:</td>
					<td style="width: 67%;">
						<input name="title" value="<?=(isset($_POST['title']) ? $_POST['title'] : $CONFIG['title']);?>" class="form-control" type="text">
					</td>
				</tr>
				<tr>
					<td>Логотип:</td>
					<td style="width: 67%;">
						<input name="logotype" value="<?=(isset($_POST['logotype']) ? $_POST['logotype'] : $CONFIG['logotype']);?>" class="form-control" type="text">
					</td>
				</tr>
				<tr>
					<td>Блок информация:</td>
					<td>
						<textarea name="information"><?=(isset($_POST['information']) ? $_POST['information'] : $CONFIG['information']);?></textarea>
					</td>
				</tr>
				<tr>
					<td>Блок контакты:</td>
					<td>
						<textarea name="contacts"><?=(isset($_POST['contacts']) ? $_POST['contacts'] : $CONFIG['contacts']);?></textarea>
					</td>
				</tr>
				<tr>
					<td>Фон сайта:</td>
					<td>
						<input name="background" value="<?=(isset($_POST['background']) ? $_POST['background'] : $CONFIG['background']);?>" class="form-control" type="text" />
					</td>
				</tr>
				<tr>
					<td>Иконка (favicon):</td>
					<td>
						<input name="favicon" value="<?=(isset($_POST['favicon']) ? $_POST['favicon'] : $CONFIG['favicon']);?>" class="form-control" type="text" />
					</td>
				</tr>
				<tr>
					<td>JS Скрипты:</td>
					<td>
						<textarea name="scripts" style="height: 200px; width: 98%;"><?=(isset($_POST['scripts']) ? $_POST['scripts'] : $CONFIG['scripts']);?></textarea>
					</td>
				</tr>

				
<style type="text/css">
 .spoiler_body {display:none;}
 .spoiler_links {cursor:pointer;}
</style>
<script type="text/javascript">
$(document).ready(function(){
 $('.spoiler_links').click(function(){
  $(this).parent().children('div.spoiler_body').toggle('normal');
  return false;
 });
});
</script>
<script type="text/javascript"
src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
								<tr>
					<td>Цвета</td>
					<td><div>
 <a href="" class="spoiler_links">Нажмите для редактирования цветов:</a>(по умолчанию все поля стоят пустые, для смены цвета шаблона впишите код цвета, пример #fff или rgba(255, 255, 255, 0.8)) в некоторых можно вставить картинку url(ссылка на картинку)
 <div class="spoiler_body">
<div>
 <a href="" class="spoiler_links">Шаблон Default:</a>
 <div class="spoiler_body">Цвет верх. панели:<input name="colordefault" value="<?=(isset($_POST['colordefault']) ? $_POST['colordefault'] : $CONFIG['colordefault']);?>" class="form-control" type="text"/><br>
Цвет фона названия магазина:<input name="colordefaultfon" value="<?=(isset($_POST['colordefaultfon']) ? $_POST['colordefaultfon'] : $CONFIG['colordefaultfon']);?>" class="form-control" type="text"/>
<br>
Цвет кнопок оплатить/проверить:<input name="colordefaultbutton" value="<?=(isset($_POST['colordefaultbutton']) ? $_POST['colordefaultbutton'] : $CONFIG['colordefaultbutton']);?>" class="form-control" type="text"/>
<br>
Цвет текста:<input name="colordefaulttext" value="<?=(isset($_POST['colordefaulttext']) ? $_POST['colordefaulttext'] : $CONFIG['colordefaulttext']);?>" class="form-control" type="text"/>
 <br>
Цвет кнопки отправить в "Мои покупки":<input name="colordefaultpk" value="<?=(isset($_POST['colordefaultpk']) ? $_POST['colordefaultpk'] : $CONFIG['colordefaultpk']);?>" class="form-control" type="text"/>
</div>

 </div>
<div>
 <a href="" class="spoiler_links">Шаблон Aqua:</a>
 <div class="spoiler_body">Цвет верх/нижн панели:<input name="coloraqua" value="<?=(isset($_POST['coloraqua']) ? $_POST['coloraqua'] : $CONFIG['coloraqua']);?>" class="form-control" type="text"/><br>
Цвет панели под логотипом:<input name="coloraquabg" value="<?=(isset($_POST['coloraquabg']) ? $_POST['coloraquabg'] : $CONFIG['coloraquabg']);?>" class="form-control" type="text"/>
<br>
Цвет кнопки отправить в "Мои покупки":<input name="coloraquapk" value="<?=(isset($_POST['coloraquapk']) ? $_POST['coloraquapk'] : $CONFIG['coloraquapk']);?>" class="form-control" type="text"/>
  
</div>

 </div>
 
<div>
 <a href="" class="spoiler_links">Шаблон Boxy:</a>
 <div class="spoiler_body">Цвет верхней панели:<input name="colorboxyverx" value="<?=(isset($_POST['colorboxyverx']) ? $_POST['colorboxyverx'] : $CONFIG['colorboxyverx']);?>" class="form-control" type="text"/><br>
Цвет кнопки купить/перейти:<input name="colorboxypay" value="<?=(isset($_POST['colorboxypay']) ? $_POST['colorboxypay'] : $CONFIG['colorboxypay']);?>" class="form-control" type="text"/>
<br>
Цвет кнопки отправить в "Мои покупки":<input name="colorboxyopl" value="<?=(isset($_POST['colorboxyopl']) ? $_POST['colorboxyopl'] : $CONFIG['colorboxyopl']);?>" class="form-control" type="text"/>
  
</div>

 </div>
 
 <div>
 <a href="" class="spoiler_links">Шаблон Elegant:</a>
 <div class="spoiler_body">Цвет верхней панели:<input name="colorelegantmn" value="<?=(isset($_POST['colorelegantmn']) ? $_POST['colorelegantmn'] : $CONFIG['colorelegantmn']);?>" class="form-control" type="text"/><br>
Цвет кнопки купить/перейти/поиск:<input name="colorelegantpay" value="<?=(isset($_POST['colorelegantpay']) ? $_POST['colorelegantpay'] : $CONFIG['colorelegantpay']);?>" class="form-control" type="text"/>
<br>
Цвет фона описания:<input name="colorelegantop" value="<?=(isset($_POST['colorelegantop']) ? $_POST['colorelegantop'] : $CONFIG['colorelegantop']);?>" class="form-control" type="text"/>
  
</div>

 </div>
  <div>
 <a href="" class="spoiler_links">Шаблон Game:</a>
 <div class="spoiler_body">Цвет фона:<input name="colorgamefon" value="<?=(isset($_POST['colorgamefon']) ? $_POST['colorgamefon'] : $CONFIG['colorgamefon']);?>" class="form-control" type="text"/><br>
Цвет верх.панели:<input name="colorgameverx" value="<?=(isset($_POST['colorgameverx']) ? $_POST['colorgameverx'] : $CONFIG['colorgameverx']);?>" class="form-control" type="text"/>
<br>
Цвет фона описания:<input name="colorgameopl" value="<?=(isset($_POST['colorgameopl']) ? $_POST['colorgameopl'] : $CONFIG['colorgameopl']);?>" class="form-control" type="text"/>
  </div>
</div>
<div>
 <a href="" class="spoiler_links">Шаблон Liberty:</a>
 <div class="spoiler_body">Цвет верх/нижн.панелей:<input name="colorlibertyverx" value="<?=(isset($_POST['colorlibertyverx']) ? $_POST['colorlibertyverx'] : $CONFIG['colorlibertyverx']);?>" class="form-control" type="text"/><br>
Цвет фона названия товара:<input name="colorlibertyitem" value="<?=(isset($_POST['colorlibertyitem']) ? $_POST['colorlibertyitem'] : $CONFIG['colorlibertyitem']);?>" class="form-control" type="text"/>
<br>
Цвет фона информация/контакты/товары:<input name="colorlibertyblock" value="<?=(isset($_POST['colorlibertyblock']) ? $_POST['colorlibertyblock'] : $CONFIG['colorlibertyblock']);?>" class="form-control" type="text"/>
<br>
Цвет фона за товарами:<input name="colorlibertyfon" value="<?=(isset($_POST['colorlibertyfon']) ? $_POST['colorlibertyfon'] : $CONFIG['colorlibertyfon']);?>" class="form-control" type="text"/>
  
</div>

 </div>
 <div>
 <a href="" class="spoiler_links">Шаблон Lite:</a>
 <div class="spoiler_body">Цвет блоков/кнопок:<input name="colorliteblock" value="<?=(isset($_POST['colorliteblock']) ? $_POST['colorliteblock'] : $CONFIG['colorliteblock']);?>" class="form-control" type="text"/><br>
Цвет верхней и средней панелей:<input name="colorliteverx" value="<?=(isset($_POST['colorliteverx']) ? $_POST['colorliteverx'] : $CONFIG['colorliteverx']);?>" class="form-control" type="text"/>
<br>
Цвет фона информации о товаре:<input name="colorliteitem" value="<?=(isset($_POST['colorliteitem']) ? $_POST['colorliteitem'] : $CONFIG['colorliteitem']);?>" class="form-control" type="text"/>
<br>
Цвет фона названия товара:<input name="colorlitenazv" value="<?=(isset($_POST['colorlitenazv']) ? $_POST['colorlitenazv'] : $CONFIG['colorlitenazv']);?>" class="form-control" type="text"/>
  
</div>

 </div>
 
 <div>
 <a href="" class="spoiler_links">Шаблон Lolipop:</a>
 <div class="spoiler_body">Цвет блоков(укажите путь):<input name="colorlolipopblock" value="<?=(isset($_POST['colorlolipopblock']) ? $_POST['colorlolipopblock'] : $CONFIG['colorlolipopblock']);?>" class="form-control" type="text"/><br>Укажите какой надо цвет, пример: <br>/assets/Lollipop/img/block-top.png - Зеленый<br>
 /assets/Lollipop/img/block-top-blue.png - Синий<br>
 /assets/Lollipop/img/block-top-orange.png - Оранженвый<br>
 /assets/Lollipop/img/block-top-red.png - Красный<br>
 /assets/Lollipop/img/block-top-yellow.png - Жёлтый<br>
Цвет кнопки "Поиск/перейти к оплате/Проверить":<input name="colorlolipopklick" value="<?=(isset($_POST['colorlolipopklick']) ? $_POST['colorlolipopklick'] : $CONFIG['colorlolipopklick']);?>" class="form-control" type="text"/>
<br>
Цвет фона "в наличии, цена":<input name="colorlolipopklickfn" value="<?=(isset($_POST['colorlolipopklickfn']) ? $_POST['colorlolipopklickfn'] : $CONFIG['colorlolipopklickfn']);?>" class="form-control" type="text"/>

</div>

 </div>
  <div>
 <a href="" class="spoiler_links">Шаблон Perfect:</a>
 <div class="spoiler_body">Цвет блоков:<input name="colorperfectblock" value="<?=(isset($_POST['colorperfectblock']) ? $_POST['colorperfectblock'] : $CONFIG['colorperfectblock']);?>" class="form-control" type="text"/><br><br>

Цвет панели товары, кнопки купить,отправить,перейти к оплате:<input name="colorperfectverx" value="<?=(isset($_POST['colorperfectverx']) ? $_POST['colorperfectverx'] : $CONFIG['colorperfectverx']);?>" class="form-control" type="text"/>

</div>

 </div>
   <div>
 <a href="" class="spoiler_links">Шаблон DEER:</a>
 <div class="spoiler_body">Цвет категорий:<input name="colordeercateg" value="<?=(isset($_POST['colordeercateg']) ? $_POST['colordeercateg'] : $CONFIG['colorperfectblock']);?>" class="form-control" type="text"/><br><br>

Цвет фона надписи "Все товары":<input name="colordeertovar" value="<?=(isset($_POST['colordeertovar']) ? $_POST['colordeertovar'] : $CONFIG['colordeertovar']);?>" class="form-control" type="text"/>
<br>

Цвет фона товаров:<input name="colordeeritem" value="<?=(isset($_POST['colordeeritem']) ? $_POST['colordeeritem'] : $CONFIG['colordeeritem']);?>" class="form-control" type="text"/>
<br>

Цвет кнопки перейти к оплате/проверить:<input name="colordeerprt" value="<?=(isset($_POST['colordeerprt']) ? $_POST['colordeerprt'] : $CONFIG['colordeerprt']);?>" class="form-control" type="text"/>

</div>
   <div>
 <a href="" class="spoiler_links">Шаблон ShopNew:</a>
 <div class="spoiler_body">Цвет верх.меню:<input name="colorshopnewverx" value="<?=(isset($_POST['colorshopnewverx']) ? $_POST['colorshopnewverx'] : $CONFIG['colorshopnewverx']);?>" class="form-control" type="text"/><br><br>

Цвет нижн.меню:<input name="colorshopnewnuz" value="<?=(isset($_POST['colorshopnewnuz']) ? $_POST['colorshopnewnuz'] : $CONFIG['colorshopnewnuz']);?>" class="form-control" type="text"/>
<br>

Цвет кнопки ОПЛАТИТЬ:<input name="colorshopnewpay" value="<?=(isset($_POST['colorshopnewpay']) ? $_POST['colorshopnewpay'] : $CONFIG['colorshopnewpay']);?>" class="form-control" type="text"/>
<br>

Цвет фона товаров:<input name="colorshopnewfon" value="<?=(isset($_POST['colorshopnewfon']) ? $_POST['colorshopnewfon'] : $CONFIG['colorshopnewfon']);?>" class="form-control" type="text"/>

</div>



 </div>
   <div>
 <a href="" class="spoiler_links">Шаблон WhiteBs:</a>
 <div class="spoiler_body">Цвет верх/нижн.меню:<input name="colorwhitebsok" value="<?=(isset($_POST['colorwhitebsok']) ? $_POST['colorwhitebsok'] : $CONFIG['colorwhitebsok']);?>" class="form-control" type="text"/><br><br>

Цвет текста(категории,контакты,товар):<input name="colorwhitebstext" value="<?=(isset($_POST['colorwhitebstext']) ? $_POST['colorwhitebstext'] : $CONFIG['colorwhitebstext']);?>" class="form-control" type="text"/>
<br>

Цвет кнопки купить/поиск/+-/перейти к оплате:<input name="colorwhitebspay" value="<?=(isset($_POST['colorwhitebspay']) ? $_POST['colorwhitebspay'] : $CONFIG['colorwhitebspay']);?>" class="form-control" type="text"/>
<br>

Цвет фона товаров:<input name="colorshopnewfon" value="<?=(isset($_POST['colorwhitebsfon']) ? $_POST['colorwhitebsfon'] : $CONFIG['colorwhitebsfon']);?>" class="form-control" type="text"/>

</div>

 </div> 
    <div>
 <a href="" class="spoiler_links">Шаблон Lilac:</a>
 <div class="spoiler_body">Цвет кнопки купить/перейти к оплате:<input name="colorlilacpay" value="<?=(isset($_POST['colorlilacpay']) ? $_POST['colorlilacpay'] : $CONFIG['colorlilacpay']);?>" class="form-control" type="text"/><br><br>

Цвет контура кнопки купить:<input name="colorlilaccn" value="<?=(isset($_POST['colorlilaccn']) ? $_POST['colorlilaccn'] : $CONFIG['colorlilaccn']);?>" class="form-control" type="text"/>
<br>

Цвет фона магазина:<input name="colorlilacfon" value="<?=(isset($_POST['colorlilacfon']) ? $_POST['colorlilacfon'] : $CONFIG['colorlilacfon']);?>" class="form-control" type="text"/>
<br>


</div>

 </div> 
     <div>
 <a href="" class="spoiler_links">Шаблон Crazzy:</a>
 <div class="spoiler_body">Цвет фона товара/меню:<input name="colorcrazzyfon" value="<?=(isset($_POST['colorcrazzyfon']) ? $_POST['colorcrazzyfon'] : $CONFIG['colorcrazzyfon']);?>" class="form-control" type="text"/><br><br>

</div>

 </div> 
 
    <div>
 <a href="" class="spoiler_links">Шаблон Lucky:</a>
 <div class="spoiler_body">Цвет верх.меню:<input name="colorluckyverx" value="<?=(isset($_POST['colorluckyverx']) ? $_POST['colorluckyverx'] : $CONFIG['colorluckyverx']);?>" class="form-control" type="text"/><br><br>

Цвет нижн.панели:<input name="colorluckynuz" value="<?=(isset($_POST['colorluckynuz']) ? $_POST['colorluckynuz'] : $CONFIG['colorluckynuz']);?>" class="form-control" type="text"/>
<br>

Цвет фона магазина:<input name="colorluckyfon" value="<?=(isset($_POST['colorluckyfon']) ? $_POST['colorluckyfon'] : $CONFIG['colorluckyfon']);?>" class="form-control" type="text"/>
<br>


</div>

 </div> 
     <div>
 <a href="" class="spoiler_links">Шаблон Keys:</a>
 <div class="spoiler_body">Цвет нижн.панели магазина:<input name="colorkeysnuz" value="<?=(isset($_POST['colorkeysnuz']) ? $_POST['colorkeysnuz'] : $CONFIG['colorkeysnuz']);?>" class="form-control" type="text"/><br><br>

Цвет фона товаров:<input name="colorkeysfon" value="<?=(isset($_POST['colorkeysfon']) ? $_POST['colorkeysfon'] : $CONFIG['colorkeysfon']);?>" class="form-control" type="text"/>
<br>

Цвет фона названия и цены товара:<input name="colorkeysfonn" value="<?=(isset($_POST['colorkeysfonn']) ? $_POST['colorkeysfonn'] : $CONFIG['colorkeysfonn']);?>" class="form-control" type="text"/>
<br>
</div>

 </div> 
      <div>
 <a href="" class="spoiler_links">Шаблон WF:</a>
 <div class="spoiler_body">Цвет верх и боковых панелей:<input name="colorwfpanel" value="<?=(isset($_POST['colorwfpanel']) ? $_POST['colorwfpanel'] : $CONFIG['colorwfpanel']);?>" class="form-control" type="text"/><br><br>

Цвет боковых блоков:<input name="colorwffonp" value="<?=(isset($_POST['colorwffonp']) ? $_POST['colorwffonp'] : $CONFIG['colorwffonp']);?>" class="form-control" type="text"/>
<br>

Цвет фона товара:<input name="colorwffon" value="<?=(isset($_POST['colorwffon']) ? $_POST['colorwffon'] : $CONFIG['colorwffon']);?>" class="form-control" type="text"/>
<br>
</div>

 </div> 
       <div>
 <a href="" class="spoiler_links">Шаблон LqShop:</a>
 <div class="spoiler_body">Цвет фона товара:<input name="colorlqshopfon" value="<?=(isset($_POST['colorlqshopfon']) ? $_POST['colorlqshopfon'] : $CONFIG['colorlqshopfon']);?>" class="form-control" type="text"/><br><br>

Цвет фона верх.панели:<input name="colorlqshopverx" value="<?=(isset($_POST['colorlqshopverx']) ? $_POST['colorlqshopverx'] : $CONFIG['colorlqshopverx']);?>" class="form-control" type="text"/>
<br>

Цвет кнопок:<input name="colorlqshoppay" value="<?=(isset($_POST['colorlqshoppay']) ? $_POST['colorlqshoppay'] : $CONFIG['colorlqshoppay']);?>" class="form-control" type="text"/>
<br>

Цвет кнопок(при наведении):<input name="colorlqshoppayn" value="<?=(isset($_POST['colorlqshoppayn']) ? $_POST['colorlqshoppayn'] : $CONFIG['colorlqshoppayn']);?>" class="form-control" type="text"/>
<br>

Цвет контура кнопок:<input name="colorlqshoppayk" value="<?=(isset($_POST['colorlqshoppayk']) ? $_POST['colorlqshoppayk'] : $CONFIG['colorlqshoppayk']);?>" class="form-control" type="text"/>
<br>

Цвет фона окна оплаты:<input name="colorlqshoppayopl" value="<?=(isset($_POST['colorlqshoppayopl']) ? $_POST['colorlqshoppayopl'] : $CONFIG['colorlqshoppayopl']);?>" class="form-control" type="text"/>
<br>

Цвет контура товаров:<input name="colorlqshopborder" value="<?=(isset($_POST['colorlqshopborder']) ? $_POST['colorlqshopborder'] : $CONFIG['colorlqshopborder']);?>" class="form-control" type="text"/>
<br>

Цвет текста товаров:<input name="colorlqshopcolor" value="<?=(isset($_POST['colorlqshopcolor']) ? $_POST['colorlqshopcolor'] : $CONFIG['colorlqshopcolor']);?>" class="form-control" type="text"/>

</div>

 </div> 
 
 
 
 
</div>


</td>				
				
				<tr>
					<td></td>
					<td><input value="Сохранить" class="btn btn-primary" type="submit"></td>
				</tr>
			</tbody>
		</table>
		<script>
			CKEDITOR.replace('information');
			CKEDITOR.replace('contacts');
		</script>
	</form>

<script type="text/javascript" src="/assets/js/jpicker-1.1.6.min.js"></script>
<script type="text/javascript" src="/assets/js/picker.js"></script>

	<?
		}
	?>