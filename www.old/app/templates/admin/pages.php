	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<? if(Defined('EID') || Defined('PAGE_ID')){ ?>
		<li><a href="/admin/pages">Страницы</a> <span class="divider">/</span></li>
		<li class="active"><?=(Defined('EID') ? 'Редактирование' : 'Добавление');?> страницы</li>
		<? } else { ?>
		<li class="active">Страницы</li>
		<? } ?>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['pages'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<?
		# Добавление и Редактирование товара
		if(Defined('EID') || Defined('PAGE_ID')){
			# Редактирование
			if(Defined('EID')){
				# Запросы
				$PAGE = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."' AND `pid` = '".intval(EID)."'"));
			} else {
				$PAGE = false;
			}
	?>
	<form action="/admin/pages/<?=(Defined('EID') ? 'edit/'.EID : 'add');?>" method="post">
		<table class="table">
			<tbody>
				<tr>
					<td>Заголовок:</td>
					<td>
						<input name="title" value="<?=($_POST ? $_POST['title'] : ($PAGE == false ? "" : $PAGE['title']));?>" class="form-control" type="text">
						<?=($_POST ? ($_POST['title'] == "" ? "<br/><font color=\"red\">Заполните поле Заголовок.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td>Описание</td>
					<td>
						<textarea name="body"><?=($_POST ? $_POST['body'] : ($PAGE == false ? "" : $PAGE['body']));?></textarea>
						<?=($_POST ? ($_POST['body'] == "" ? "<br/><font color=\"red\">Заполните поле Описание.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input value="Сохранить" class="btn btn-primary" type="submit"></td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
		CKEDITOR.replace('body');
	</script>
	<? } else { ?>	
	<button class="btn" style="float:left; margin-top:-14px; margin-bottom: 5px;" onclick="location.href = '/admin/pages/add';">Новая страница</button>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."' ORDER BY pid ASC"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<table class="table tblsort table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Страница</th>
				<th>Изменение</th>
				<th>Удаление</th>
			</tr>
		</thead>
		<tbody class="ui-sortable">
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<tr id="page-<?=$row['id'];?>">
				<td><?=$row['pid'];?></td>
				<td><?=$row['title'];?></td>
				<td>
					<a href="/admin/pages/edit/<?=$row['pid'];?>">
						<i class="icon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="/admin/pages/delete/<?=$row['pid'];?>">
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
						url: "/admin/pages/sort",
						type: 'POST',
						data: $(this).sortable("serialize"), 
					});
				}
			});
			$(".tblsort tbody").disableSelection();
		});  
	</script>
	<? } else { ?>
    <br/><div class="alert alert-success">Создайте первую страницу.</div>
	<? } ?>
	<? } ?>
	<?
		}
	?>