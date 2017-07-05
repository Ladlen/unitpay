	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<? if(Defined('EID') || Defined('ITEM_ID')){ ?>
		<li><a href="/admin/items">Товары</a> <span class="divider">/</span></li>
		<li class="active"><?=Defined('EID') ? 'Редактирование' : 'Добавление';?> товара</li>
		<? } else if(Defined('BID')){ ?>
		<li><a href="/admin/items">Товары</a> <span class="divider">/</span></li>
		<li class="active">Резервные копии</li>
		<? } else { ?>
		<li class="active">Товары</li>
		<? } ?>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['items'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<?
		# Добавление и Редактирование товара
		if(Defined('EID') || Defined('ITEM_ID')){
			# Редактирование
			if(Defined('EID')){
				# Запросы
				$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `item_id` = '".intval(EID)."'"));
				# Парсим цены
				$price = json_decode($ITEM['price'], true);
			} else {
				$ITEM = false;
				$price = false;
			}
			# Категории
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' ORDER BY cid DESC");
	?>
	<ul class="breadcrumb" style="overflow: auto; height: 90.5%;">
		<form action="/admin/items/<?=(Defined('EID') ? 'edit/'.EID : 'add');?>" class="table table-bordered table-striped" method="post" accept-charset="utf-8" enctype="multipart/form-data"> 
			<table class="table">
				<tbody>
					<tr>
						<td style="width: 250px;">Категория:</td>
						<td>
							<select name="category">
								<option value="0">Без категории</option>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<option value="<?=$row['id'];?>" <?=($ITEM['cid'] == $row['id'] ? "selected" : "");?>><?=$row['category'];?></option>
								<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>На главной:</td>
						<td>
							<select name="main">
								<option value="0" <?=($_POST ? $_POST['main'] : ($ITEM == false ? "" : $ITEM['main'])) == FALSE ? 'selected=""' : '';?>>Не показывать</option>
								<option value="1" <?=($_POST ? $_POST['main'] : ($ITEM == false ? "" : $ITEM['main'])) == TRUE ? 'selected=""' : '';?>>Показывать</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Название:</td>
						<td>
							<input name="item" value="<?=($_POST ? $_POST['item'] : ($ITEM == false ? "" : $ITEM['item']));?>" class="form-control" type="text">
							<?=($_POST ? ($_POST['item'] == "" ? "<br/><font color=\"red\">Заполните поле Название.</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Описание:</td>
						<td>
							<textarea name="body" class="form-control"><?=($_POST ? $_POST['body'] : ($ITEM == false ? "" : $ITEM['body']));?></textarea>
							<?=($_POST ? ($_POST['body'] == "" ? "<br/><font color=\"red\">Заполните поле Описание.</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Иконка (URL):</td>
						<td>
							<input name="image" value="<?=($_POST ? $_POST['image'] : ($ITEM == false ? "" : $ITEM['image']));?>" class="form-control" type="text">
							<?=(isset($_POST['image']) ? ($_POST['image'] == "" ? "<br/><font color=\"red\">Заполните поле Иконка (URL).</font>" : "") : "");?>
						</td>
					</tr>
					<tr> 
						<td>Цена (Рубли):</td>
						<td>
							<input name="price[WMR]" id="WMR" value="<?=($_POST ? $_POST['price']['WMR'] : ($price == false ? "" : $price['WMR']));?>" class="form-control" type="text" onkeyup="FINANCE.select(0);">
							<?=($_POST ? ($_POST['price']['WMR'] == "" ? "<br/><font color=\"red\">Заполните поле Цена (Рубли).</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Цена (Гривны):</td>
						<td>
							<input name="price[WMU]" id="WMU" value="<?=($_POST ? $_POST['price']['WMU'] : ($price == false ? "" : $price['WMU']));?>" class="form-control" type="text" onkeyup="FINANCE.select(3);">
							<?=($_POST ? ($_POST['price']['WMU'] == "" ? "<br/><font color=\"red\">Заполните поле Цена (Гривны).</font>" : "") : "");?>
						</td>
					</tr>
					<tr> 
						<td>Цена (Доллары):</td>
						<td>
							<input name="price[WMZ]" id="WMZ" value="<?=($_POST ? $_POST['price']['WMZ'] : ($price == false ? "" : $price['WMZ']));?>" class="form-control" type="text" onkeyup="FINANCE.select(1);">
							<?=($_POST ? ($_POST['price']['WMZ'] == "" ? "<br/><font color=\"red\">Заполните поле Цена (Доллары).</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Цена (Евро):</td>
						<td>
							<input name="price[WME]" id="WME" value="<?=($_POST ? $_POST['price']['WME'] : ($price == false ? "" : $price['WME']));?>" class="form-control" type="text" onkeyup="FINANCE.select(2);">
							<?=($_POST ? ($_POST['price']['WME'] == "" ? "<br/><font color=\"red\">Заполните поле Цена (Евро).</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Мин. кол-во для заказа:</td>
						<td>
							<input name="min" value="<?=($_POST ? $_POST['min'] : ($ITEM == false ? "" : $ITEM['min']));?>" class="form-control" type="text">
							<?=($_POST ? ($_POST['min'] == "" ? "<br/><font color=\"red\">Заполните поле минимальное количество для заказа.</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Метод продажи:</td>
						<td>
							<div class="btn-group">
								<label class="btn btn-primary <?=(($_POST ? $_POST['type'] : ($ITEM == false ? "" : $ITEM['type'])) == 'text' ? 'active' : '');?>" id="text" onclick="select('text')">Строки</label>
								<label class="btn btn-primary <?=(($_POST ? $_POST['type'] : ($ITEM == false ? "" : $ITEM['type'])) == 'file' ? 'active' : '');?>" id="file" onclick="select('file')">Файл</label>
							</div>
							<input name="type" value="<?=($_POST ? $_POST['type'] : ($ITEM == false ? "" : $ITEM['type']));?>" type="hidden">
						</td>
					</tr>
					<tr class="type" id="text" style="display:<?=(($_POST ? $_POST['type'] : ($ITEM == false ? "" : $ITEM['type'])) == 'text' ? '' : 'none');?>;">
						<td>Товар (строки):</td>
						<td>
							<textarea name="items" cols="40" rows="10" class="form-control"><? if($ITEM == true){ echo file_get_contents('uploads/'.md5(SID).'/'.md5($ITEM['id'])); } ?></textarea>
							<?=($_POST ? ($_POST['items'] == "" ? "<br/><font color=\"red\">Заполните поле Товар (строки).</font>" : "") : "");?>
						</td>
					</tr>
					<tr class="type" id="file" style="display:<?=(($_POST ? $_POST['type'] : ($ITEM == false ? "" : $ITEM['type'])) == 'file' ? '' : 'none');?>;">
						<td>Товар (Файл):</td>
						<td>
							<input name="items_file" size="20" class="form-control" type="file">
							<?=(isset($_POST['items_file']) ? ($_POST['items_file'] == "" ? "<br/><font color=\"red\">Заполните поле Товар (файл).</font>" : "") : "");?>
						</td>
					</tr>
					<tr>
						<td>Резервная копия</td>
						<td>
							 <input type="checkbox" name="backup" style="margin-bottom: 5px;"> Создать бекап
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input value="Сохранить" class="btn btn-primary" type="submit"></td>
					</tr>
				</tbody>
			</table>
		</form>
	</ul>
	<? $obj = json_decode(file_get_contents("/home/curse.json"), true); ?>
	<script>
	CKEDITOR.replace('body');
	var FINANCE = {
			config: {
				WMR: ['<?=$obj['RUB'][0];?>', '<?=$obj['RUB'][1];?>', '<?=$obj['RUB'][2];?>', '<?=$obj['RUB'][3];?>'],
				WMZ: ['<?=$obj['USD'][0];?>', '<?=$obj['USD'][1];?>', '<?=$obj['USD'][2];?>', '<?=$obj['USD'][3];?>'],
				WME: ['<?=$obj['EUR'][0];?>', '<?=$obj['EUR'][1];?>', '<?=$obj['EUR'][2];?>', '<?=$obj['EUR'][3];?>'],
				WMU: ['<?=$obj['UAH'][0];?>', '<?=$obj['UAH'][1];?>', '<?=$obj['UAH'][2];?>', '<?=$obj['UAH'][3];?>'],
				cur: ["WMR", "WMZ", "WME", "WMU"],
				ths: [false, 0]
			},
			calc: function(){
				for(i = 0; i <= 3; i++){
					var b = $("#"+FINANCE.config['cur'][i]).val();
					FINANCE.config['ths'][0] = b;
					for(ii = 0; ii <= 3; ii++){
						if(ii != FINANCE.config['ths'][1]){
							$("#"+FINANCE.config['cur'][ii]).val((FINANCE.config[FINANCE.config['cur'][ii]][i] * b).toFixed(2));
						}
					}
				}
			},
			checker: function(){
				var a = $("#"+FINANCE.config['cur'][FINANCE.config['ths'][1]]).val();
				if(a != FINANCE.config['ths'][0]){
					if(a == ""){
						for(i = 1; i <= 3; i++){
							$("#"+FINANCE.config['cur'][i]).val('');
						}
					} else {
						FINANCE.calc();
					}
				}
			},
			select: function(ths){
				FINANCE.config['ths'][1] = ths;
			}
		};
		setInterval(FINANCE.checker, 100);
		
		function select(a){
			if(a == "text"){
				$("input[name='type']").val('text');
				$("label[id='text']").addClass('active');
				$("label[id='file']").removeClass('active');
				$("tr[id='file']").css('display','none');
				$("tr[id='text']").css('display','');
			} else if(a == "file"){
				$("input[name='type']").val('file');
				$("label[id='text']").removeClass('active');
				$("label[id='file']").addClass('active');
				$("tr[id='file']").css('display','');
				$("tr[id='text']").css('display','none');
			}
		}
	</script>
	<? } else if(Defined('BID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval(BID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $ITEM = mysqli_fetch_array($SQL); ?>
		<? if($ITEM['type'] == "text"){ ?>
			<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `backups` WHERE `sid` = '".intval(SID)."' AND `item_id` = '".intval(BID)."' ORDER BY id DESC"); ?>
			<? if(mysqli_num_rows($SQL1) > 0){ ?>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Имя бекапа</th>
						<th>Дата</th>
						<th>Ссылка для скачивания</th>
					</tr>
				</thead>
				<tbody>
					<? while($row = mysqli_fetch_array($SQL1)){ ?>
					<tr>
						<td>
							<?=$row['bid'];?>
						</td>
						<td>
							<?=$ITEM['item'];?>
						</td>
						<td>
							<?=$row['date'];?>
						</td>
						<td>
							<a href="/admin/items/backup/download/<?=BID;?>/<?=$row['bid'];?>">
								<li class="icon icon-download"></li>
							</a>
						</td>
					</tr>
					<? } ?>
				</tbody>
			</table>
			<? } else { ?>
			<div class="alert alert-success">Для начала создайте бекап.</div>
			<? } ?>
		<? } else { ?>
		<div class="alert alert-danger">Товар является файлом.</div>
		<? } ?>
	<? } else { ?>
	<div class="alert alert-danger">Товар не существует.</div>
	<? } ?>
	<? } else { ?>
	<button class="btn" style="margin-top: -14px; margin-bottom: 5px;" onclick="location.href = '/admin/items/add';">Новый товар</button>
	<ul class="breadcrumb" style="overflow: auto; height: 90%;">
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ORDER BY item_id"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<table class="table tblsort table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Товар</th>
					<th>Количество</th>
					<th>Цена</th>
					<th>Резервные копии</th>
					<th>Редактирование</th>
					<th>Удаление</th>
				</tr>
			</thead>
			<tbody class="ui-sortable">
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<? $price = json_decode($row['price'], true); ?>
				<tr id="item-<?=$row['id'];?>">
					<td><?=$row['item_id'];?></td>
					<td><?=$row['item'];?></td>
					<td><?=($row['type'] == 'file' ? 'Файл' : $row['count']);?></td>
					<td>
						<?
							# Подключенные кошельки
							$obj = json_decode(WALLETS, true);
							# Прогоним циклом
							foreach($obj as $wallet => $a){
								# Подключен
								if($a != false){
									# Оплата рублями
									if($wallet == "WMR" || $wallet == "QIWI" || $wallet == "YAD" || $wallet == "ROBOKASSA" || $wallet == "FREEKASSA"){
										$b['WMR'] = $price['WMR'];
									# Оплата долларами
									} else if($wallet == "WMZ"){
										$b['WMZ'] = $price['WMZ'];
									# Оплата евро
									} else if($wallet == "WME"){
										$b['WME'] = $price['WME'];
									# Оплата гривнами
									} else if($wallet == "WMU"){
										$b['WMU'] = $price['WMU'];
									}
								}
							}
							# Прогоним циклом
							foreach($b as $wallet => $sum){
								# Выводим цены
								echo $sum.' '.($wallet == "WMU" ? "₴" : ($wallet == "WME" ? "€" : ($wallet == "WMZ" ? "$" : "₽"))).' ';
							}
						?>
					</td>
					<td style="text-align: center;">
						<a href="/admin/items/backup/<?=$row['id'];?>">
							<i class="icon-folder-open"></i>
						</a>
					</td>
					<td style="text-align: center;">
						<a href="/admin/items/edit/<?=$row['item_id'];?>">
							<i class="icon-pencil"></i>
						</a>
					</td>
					<td style="text-align: center;">
						<a href="/admin/items/delete/<?=$row['item_id'];?>">
							<i class="icon-remove"></i>
						</a>
					</td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<script>
			$(document).ready(function(){
				var fixHelper = function(e, ui){
					ui.children().each(function(){
						$(this).width($(this).width());
					});
					return ui;
				};
				$(".tblsort tbody").sortable({
					helper: fixHelper,
					opacity: 0.8, 
					cursor: 'move', 
					tolerance: 'pointer',  
					items:'tr',
					placeholder: 'state', 
					forcePlaceholderSize: true,
					update: function(event, ui){
						$.ajax({
							url: "/admin/items/sort",
							type: 'POST',
							data: $(this).sortable("serialize"), 
						});
					}
				});
				$(".tblsort tbody").disableSelection();
			});  
		</script>
		<? } else { ?>
		<br/><div class="alert alert-success">Добавьте свой первый товар.</div>
		<? } ?>
	</ul>
	<?
			}
		}
	?>