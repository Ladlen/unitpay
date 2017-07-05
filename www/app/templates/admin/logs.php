	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Логи Авторизаций</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['logs'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `logs` WHERE `sid` = '".intval(SID)."' ORDER BY lid DESC LIMIT 25"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>IP</th>
				<th>Аккаунт</th>
				<th>Дата</th>
				<th>Статус</th>
			</tr>
		</thead>
		<tbody>
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<tr class="<?=($row['status'] == "1" ? "success" : "error");?>">
				<td><?=$row['lid'];?></td>
				<td><?=$row['ip'];?></td>
				<td><?=$row['login'];?></td>
				<td><?=$row['date'];?></td>
				<td><?=($row['status'] == "1" ? "Успешно" : "Не успешно");?></td>
			</tr>
			<? } ?>
		</tbody>
	</table>
	<? } else { ?>
    <div class="alert alert-success">Логов еще не было.</div>
	<? } ?>
	<?
		}
	?>