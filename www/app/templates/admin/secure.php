	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Безопасность</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['secure'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<ul class="breadcrumb" style="overflow: auto; height: 90%;">
		<center>
			<legend>Изменение пароля</legend>
			<form method="POST" action="/admin/secure/password">			
				<div class="control-group">
					<label class="control-label" for="inputPassword">Введите текущий пароль</label>
					<div class="controls">
						<div class="input-prepend input-append">
							<input id="inputPassword" name="password" type="password">
							<span class="add-on">
								<i class="icon-lock"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputNewPassword">Введите новый пароль</label>
					<div class="controls">
						<div class="input-prepend input-append">
							<input id="inputNewPassword" name="newpassword" type="password">
							<span class="add-on">
								<i class="icon-lock"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input class="btn btn-primary" value="Сменить пароль" type="submit">
					</div>
				</div>
			</form>
			<legend>Блокировка по IP</legend>
			<form method="POST" action="/admin/secure/block">
				<div class="control-group">
					<label class="control-label" for="inputIp">Введите IP-Адрес</label>
					<div class="controls">
						<div class="input-prepend input-append">
							<input id="inputIp" name="ip" type="text">
							<span class="add-on">
								<i class="icon-lock"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input class="btn btn-primary" value="Заблокировать" type="submit">
					</div>
				</div>
			</form>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `block_ip` WHERE `sid` = '".intval(SID)."' ORDER BY bid DESC"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
				<table class="table table-bordered table-striped" style="width:50%;">
					<thead>
						<th>ID</th>
						<th>IP-Адрес</th>
						<th>Дата блокировки</th>
						<th>Удаление</th>
					</thead>
					<tbody>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<tr>
							<td><?=$row['bid'];?></td>
							<td><?=$row['ip'];?></td>
							<td><?=$row['date'];?></td>
							<td>
								<a href="/admin/secure/block/delete/<?=$row['bid'];?>">
									<i class="icon-remove"></i>
								</a>
							</td>
						</tr>
						<? } ?>
					</tbody>
				</table>
			<? } ?>
		</center>
	</ul>
	<?
		}
	?>