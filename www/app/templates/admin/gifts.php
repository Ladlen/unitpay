	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Раздачи</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['gifts'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<?
		# Запросы
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `gifts` WHERE `sid` = '".intval(SID)."' ORDER BY gid DESC LIMIT 1");
		$GIFT = mysqli_fetch_array($SQL);
	?>
	<style>
		.mce-tinymce {
			width: 545px;
			margin: 0 auto;
		}
	</style>
	<form action="/admin/gifts" method="post">
		<table width="100%" class="table table-bordered table-striped">
			<tbody> 
				<tr>
					<td style="padding:4px" class="option">
						<div style="padding-bottom:5px;"><b>Наименование товара:</b></div>
						<div class="small">Название раздаваемого товара</div>
					</td>
					<td style="width: 64%; text-align:center;">
						<input placeholder="Что раздаём?" style="text-align:center;width:368px;" name="gift" value="<?=($_POST ? $_POST['gift'] : $GIFT['gift']);?>" type="text">
						<?=($_POST ? ($_POST['gift'] == "" ? "<br/><font color=\"red\">Заполните поле Наименование товара.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td style="padding:4px" class="option">
						<div style="padding-bottom:5px;"><b>Изображение (URL):</b></div>
						<div class="small">Ссылка на изображения товара</div>
					</td>
					<td style="text-align:center;">
						<input placeholder="Введите полный URL изображения" style="text-align:center;width:368px;" name="image" value="<?=($_POST ? $_POST['image'] : $GIFT['image']);?>" type="text">
						<?=($_POST ? ($_POST['image'] == "" ? "<br/><font color=\"red\">Заполните поле Изображение (URL).</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td style="padding:4px" class="option">
						<div style="padding-bottom:5px;"><b>Описание раздачи:</b></div>
						<div class="small">Дополнительные описание, условия, требования для раздачи</div>
					</td>
					<td style="text-align:center;">
						<textarea placeholder="Дополнительное описание" style="height:150px;" name="desc"><?=($_POST ? $_POST['desc'] : $GIFT['desc']);?></textarea>
						<?=($_POST ? ($_POST['desc'] == "" ? "<br/><font color=\"red\">Заполните поле Описание раздачи.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td style="padding:4px" class="option">
						<div style="padding-bottom:5px;"><b>Время окончания:</b></div>
						<div class="small">Время окончания раздачи, по МСК.<br />Чтобы сбить время нажмите "Применить" без изменения времени.</div>
					</td>
					<td style="text-align:center;">
						<input style="text-align: center;width:368px;" name="time" value="<?=($_POST ? $_POST['time'] : ($GIFT['time'] != "" ? Date("Y-m-d H:i:s", $GIFT['time']) : Date("Y-m-d H:i:s", time())));?>" type="text">
						<?=($_POST ? ($_POST['time'] == "" ? "<br/><font color=\"red\">Заполните поле Время окончания.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td style="padding:4px" class="option">
						<div style="padding-bottom:5px;"><b>Группа ВК:</b></div><div class="small">Ссылка на группу ВК</div>
					</td>
					<td style="text-align:center;">
						<input placeholder="Например, https://vk.com/shopsn_su" style="text-align: center;width:368px;" name="vk" value="<?=($_POST ? $_POST['vk'] : $GIFT['vk']);?>" type="text">
						<?=($_POST ? ($_POST['vk'] == "" ? "<br/><font color=\"red\">Заполните поле Группа ВК.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td style="padding:4px" class="option">
						<div style="padding-bottom:5px;"><b>Победитель:</b></div>
						<div class="small">Текущий победитель раздачи, которому нужно отправить приз</div>
					</td>
					<td style="text-align:center;">
						<?
							# Раздача существует
							if(mysqli_num_rows($SQL) > 0){
								# Раздача завершена по времени
								if($GIFT['time'] < time()){
									# Победитель еще не был выбран
									if($GIFT['winner'] != ""){
										echo '<a href="'.$GIFT['winner'].'">'.$GIFT['winner'].'</a>';
									} else {
										echo 'Победитель еще не выбран.';
									}
								# Раздача еще не завершена
								}
							# Раздача не создана
							} else {
								echo 'Раздача еще не создана..';
							}
						?>
					</td>
				</tr>
				<tr>
					<td>
						<div style="padding-bottom:5px;"><b>Для сохранения:</b></div>
						<div class="small">Нажмите кнопку "Применить".<br>Раздача после создания доступна по ссылке http://вашмагазин/gifts/1</div>
					</td>
					</td>
					<td style="text-align:center;"><input class="btn btn-success" value="Применить" type="submit"></td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
		CKEDITOR.replace('desc');
	</script>
	<?
		}
	?>