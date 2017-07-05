	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<? if(Defined('EID') || Defined('CID')){ ?>
		<li><a href="/admin/codes">Купоны</a> <span class="divider">/</span></li>
		<li class="active"><?=Defined('EID') ? 'Редактирование' : 'Добавление';?> купона</li>
		<? } else { ?>
		<li class="active">Купоны</li>
		<? } ?>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['codes'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<?
		# Добавление и Редактирование купона
		if(Defined('EID') || Defined('CID')){
			# Редактирование
			if(Defined('EID')){
				# Запросы
				$CODE = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `codes` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(EID)."'"));
			} else {
				$CODE = false;
			}
	?>
	<form action="/admin/codes/<?=(Defined('EID') ? 'edit/'.EID : 'add');?>" method="post" accept-charset="utf-8">
		<table class="table">
			<tbody>
				<? if(!Defined('EID')){ ?>
				<tr>
					<td style="width: 250px;">Тип купона:</td>
					<td>
						<div class="btn-group">
							<label class="btn btn-primary <?=($_POST['type'] == "single" ? "active" : ($CODE == false ? "single" : ($CODE['type'] == "single" ? "active" : "")));?>" id="single" onclick="select('single')">Одноразовый</label>
							<label class="btn btn-primary <?=($_POST['type'] == "reusable" ? "active" : ($CODE == false ? "reusable" : ($CODE['type'] == "reusable" ? "active" : "")));?>" id="reusable" onclick="select('reusable')">Многоразовый</label>
						</div>
						<input name="type" value="<?=(isset($_POST['type']) ? $_POST['type'] : "");?>" type="hidden">
					</td>
				</tr>
				<? } ?>
				<tr>
					<td>Процент скидки</td>
					<td>
						<input name="discount" value="<?=($_POST ? $_POST['discount'] : ($CODE == false ? "" : $CODE['discount']));?>" class="form-control" type="text">
						<?=($_POST ? ($_POST['discount'] == "" ? "<br/><font color=\"red\">Заполните поле Процент скидки.</font>" : "") : "");?>
					</td>
				</tr>
				<tr>
					<td>Товар</td>
					<td>
						<select name="item">
							<option value="*">Для любого товара</option>
							<?
								$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `id` = '".intval($CODE['item'])."' AND `sid` = '".intval(SID)."'"));
								$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."'");
								if(mysqli_num_rows($SQL) > 0){
									while($row = mysqli_fetch_array($SQL)){
										echo '<option value="'.$row['item_id'].'" '.($_POST ? ($_POST['item'] == $row['item_id'] ? "selected" : "") : ($ITEM['item_id'] == $row['item_id'] ? "selected" : "")).'>'.$row['item'].'</option>';
									}
								}
							?>
						</select>						
						<?=($_POST ? ($_POST['item'] == "" ? "<br/><font color=\"red\">Заполните поле ID товара.</font>" : "") : "");?>
					</td>
				</tr>
				<? if(Defined('EID')){ ?>
				<tr id="single" style="display:<?=($CODE['type'] == "single" || Defined('EID') ? "" : "none");?>;">
					<td>Купон</td>
					<td>
						<input name="code" value="<?=($_POST ? $_POST['code'] : $CODE['code']);?>" class="form-control" type="text">
						<?=($_POST ? ($_POST['code'] == "" ? "<br/><font color=\"red\">Заполните поле Купон.</font>" : "") : "");?>
					</td>
				</tr>
				<tr id="single" style="display:<?=($CODE['type'] == "single" || Defined('EID') && $CODE['type'] == "single" ? "" : "none");?>;">
					<td>Количество активаций</td>
					<td>
						<input name="count" value="<?=($_POST ? $_POST['count'] : $CODE['count']);?>" class="form-control" type="text" placeholder="">
					</td>
				</tr>
				<? } ?>
				<? if(!Defined('EID')){ ?>
				<tr id="single" style="display:<?=($CODE['type'] == "single" || Defined('EID') ? "" : "none");?>;">
					<td>Купон</td>
					<td>
						<input name="code" value="<?=($_POST ? $_POST['code'] : $CODE['code']);?>" class="form-control" type="text">
						<?=($_POST ? ($_POST['code'] == "" ? "<br/><font color=\"red\">Заполните поле Купон.</font>" : "") : "");?>
					</td>
				</tr>
				<tr id="single" style="display:<?=($CODE['type'] == "single" || Defined('EID') && $CODE['type'] == "single" ? "" : "none");?>;">
					<td>Количество активаций</td>
					<td>
						<input name="count" value="<?=($_POST ? $_POST['count'] : $CODE['count']);?>" class="form-control" type="text" placeholder="">
					</td>
				</tr>
				<tr id="reusable" style="display:<?=($CODE['type'] == "reusable" ? "" : "none");?>;">
					<td>Слог</td>
					<td>
						<input name="slog" value="<?=($_POST ? $_POST['slog'] : $CODE['code']);?>" class="form-control" type="text" placeholder="SHOPSN">
						<?=($_POST ? ($_POST['slog'] == "" ? "<br/><font color=\"red\">Заполните поле Слог.</font>" : "") : "");?>
					</td>
				</tr>
				<tr id="reusable" style="display:<?=($CODE['type'] == "reusable" ? "" : "none");?>;">
					<td>Количество купонов</td>
					<td>
						<input name="count_slog" value="<?=($_POST ? $_POST['count_slog'] : $CODE['count']);?>" class="form-control" type="text" placeholder="Максимум 20">
						<?=($_POST ? ($_POST['count_slog'] == "" ? "<br/><font color=\"red\">Заполните поле Количество купонов.</font>" : "") : "");?>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td></td>
					<td><input value="Сохранить" class="btn btn-primary" type="submit"></td>
				</tr>
			</tbody>
		</table>
	</form>
	<script>
		function select(a){
			if(a == "reusable"){
				$("input[name='type']").val('reusable');
				$("label[id='reusable']").addClass('active');
				$("label[id='single']").removeClass('active');
				$("tr[id='single']").css('display','none');
				$("tr[id='reusable']").css('display','');
			} else if(a == "single"){
				$("input[name='type']").val('single');
				$("label[id='reusable']").removeClass('active');
				$("label[id='single']").addClass('active');
				$("tr[id='single']").css('display','');
				$("tr[id='reusable']").css('display','none');
			}
		}
	</script>
	<? } else { ?>
	<button class="btn" style="float:left; margin-top:-14px; margin-bottom: 5px;" onclick="location.href = '/admin/codes/add';">Новый купон</button>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `codes` WHERE `sid` = '".intval(SID)."' ORDER BY cid ASC"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<table class="table tblsort table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Купон</th>
				<th>Скидка</th>
				<th>Редактирование</th>
				<th>Удаление</th>
			</tr>
		</thead>
		<tbody class="ui-sortable">
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<tr id="code-<?=$row['id'];?>">
				<td><?=$row['cid'];?></td>
				<td><?=$row['code'];?></td>
				<td><?=$row['discount'];?>%</td>
				<td>
					<a href="/admin/codes/edit/<?=$row['cid'];?>">
						<i class="icon-pencil"></i>
					</a>
				</td>
				<td>
					<a href="/admin/codes/delete/<?=$row['cid'];?>">
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
						url: "/admin/codes/sort",
						type: 'POST',
						data: $(this).sortable("serialize"), 
					});
				}
			});
			$(".tblsort tbody").disableSelection();
		});  
	</script>
	<? } else { ?>
	<br/><div class="alert alert-success">Добавьте свой первый купон.</div>
	<? } ?>
	<?
			}
		}
	?>