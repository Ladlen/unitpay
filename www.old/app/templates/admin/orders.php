<?
	if(Defined('PID')){
?>
	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Заказы</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['orders'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<? $COUNT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT COUNT(oid) FROM `orders` WHERE `sid` = '".intval(SID)."'")); ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' ORDER BY oid DESC LIMIT ".((PID-1) * 10).", 10"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Примечание</th>
				<th>Дата</th>
				<th>Товар</th>
				<th>Кол-во</th>
				<th>Цена</th>
				<th>Email</th>
				<th>IP</th>
				<th>Оплачен</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<tr>
				<td><?=$row['oid'];?></td>
				<td><?=$row['bill'];?></td>
				<td><?=Date("d.m.Y H:m:i", $row['time']);?></td>
				<td><?=$row['item'];?></td>
				<td><?=$row['count'];?></td>
				<td><?=$row['price'].' '.$row['wallet'];?></td>
				<td><?=$row['email'];?></td>
				<td><?=$row['ip'];?></td>
				<td><?=($row['status'] == 1 ? "Да" : "Нет");?></td>
				<td>
					<li class="icon-download" onclick="location.href = 'http://<?=$_SERVER['HTTP_HOST']?>/admin/orders/download/<?=$row['oid'];?>';" style="cursor: pointer;"></li>
				</td>
			</tr>
			<? } ?>
		</tbody>
	</table>
	<div class="pagination" style="text-align: center; margin-bottom: 35px;">
		<ul>
			<?
				# Количество страниц
				$pages = ($COUNT[0] > 10 ? ($COUNT[0] / 10) : '1');
				$round = round($pages);
				$test = ($pages > $round ? $pages : $round) - ($pages < $round ? $pages : $round);
				$pages = ($test > 0.1 ? (round($pages) + 2) : round($pages) + 1);
				# Выведем Paginator
				for($i = PID; $i < $pages; $i++){
					if($i < (PID + 15)){
						# Назад
						if($i == PID) echo '<li '.(PID == 1 ? 'class="disabled"' : '').'><a '.(PID == 1 ? '' : 'href="/admin/orders/'.(PID - 1).'"').'>«</a></li>';
						# Страницы
						echo '<li '.($i == PID ? 'class="disabled"' : '').'><a '.($i == PID ? '' : 'href="/admin/orders/'.$i.'"').'>'.$i.'</a></li>';
						# Вперед
						if($i == (PID + 14)) echo '<li '.($i == PID ? 'class="disabled"' : '').'><a '.($i == PID ? '' : 'href="/admin/orders/'.(PID + 1).'"').'>»</a></li>';
					}
				}
			?>
		</ul>
	</div>
	<? } else { ?>
    <div class="alert alert-success">Заказов еще не было.</div>
	<? } ?>
<?
		}
	}
?>