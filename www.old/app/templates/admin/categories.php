	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<? if(Defined('EID') || Defined('CID')){ ?>
		<li><a href="/admin/categories">Категории</a> <span class="divider">/</span></li>
		<li class="active"><?=(Defined('EID') ? 'Редактирование' : 'Добавление');?> категории</li>
		<? } else { ?>
		<li class="active">Категории</li>
		<? } ?>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['categories'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<?
		# Добавление и Редактирование товара
		if(Defined('EID') || Defined('CID')){
			# Редактирование
			if(Defined('EID')){
				# Запросы
				$CAT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(EID)."'"));
			} else {
				$CAT = false;
			}
	?>
	<form action="/admin/categories/<?=(Defined('EID') ? 'edit/'.EID : 'add');?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<table class="table">
			<tbody>
				<tr>
					<td>Название</td>
					<td>
						<input name="category" value="<?=($_POST ? $_POST['category'] : $CAT['category']);?>" class="form-control" type="text">
						<?=($_POST ? ($_POST['category'] == "" ? "<br/><font color=\"red\">Заполните поле Название.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td>Адрес</td>
					<td>
						<input name="name" value="<?=($_POST ? $_POST['name'] : $CAT['name']);?>" class="form-control" type="text">
						<?=($_POST ? ($_POST['name'] == "" ? "<br/><font color=\"red\">Заполните поле Адрес.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td>На главной?</td>
					<td>
						<select name="main">
							<option value="0" <?=($CAT['main'] == FALSE ? 'selected' : '');?>>Не показывать</option>
							<option value="1" <?=($CAT['main'] == TRUE ? 'selected' : '');?>>Показывать</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input name="submit" value="Сохранить" class="btn btn-primary" type="submit"></td>
				</tr>
			</tbody>
		</table>
	</form>
	<? } else { ?>
	<button class="btn" style="float:left; margin-top:-14px; margin-bottom: 5px;" onclick="location.href = '/admin/categories/add';">Новая категория</button>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' ORDER BY cid ASC"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<table class="table tblsort table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>На главной?</th>
				<th>Изменение</th>
				<th>Удаление</th>
			</tr>
		</thead>
		<tbody class="ui-sortable">
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<tr id="category-<?=$row['id'];?>">
				<td><?=$row['cid'];?></td>
				<td><?=$row['category'];?></td>
				<td><?=($row['main'] == TRUE ? '<font color="red">Да</font>' : '<font color="green">Нет</font>');?></td>
				<td>
					<a href="/admin/categories/edit/<?=$row['cid'];?>">
						<i class="icon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="/admin/categories/delete/<?=$row['cid'];?>">
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
						url: "/admin/categories/sort",
						type: 'POST',
						data: $(this).sortable("serialize"), 
					});
				}
			});
			$(".tblsort tbody").disableSelection();
		});  
	</script>
	<? } else { ?>
	<br/><div class="alert alert-success">Создайте первую категорию.</div>
	<? } ?>
	<? } ?>
	<?
		}
	?>