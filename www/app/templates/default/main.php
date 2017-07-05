		<?
			# Сортировка по категориям
			if(Defined('CID')){
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
			# Обычный вывод без сортировки
			} else {
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC");
			}
		?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? while($row = mysqli_fetch_array($SQL)){ ?>
		<div class="modal fade" id="myModal_<?=$row['item_id'];?>">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><?=$row['item'];?></h4>
					</div>
					<div class="modal-body">
						<p><?=$row['body'];?></p>
					</div>
				</div>
			</div>
		</div>
		<? } ?>
		<? } ?>
		<? include('payModal.php'); ?>
		<?
			# Сортировка по категориям
			if(Defined('CID')){
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
			# Обычный вывод без сортировки
			} else {
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
			}
		?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<style>
		body {
    background-image: url(<?=BACKGROUND;?>);
}
</style>
		<table class="table table-bordered">
			<thead>
				<th>Товар</th>
				<th>Кол-во</th>
				<th>Цена <div class="pull-right"><a class="modgl" onclick="price_rub();"><span class="rur">p<span>уб.</span></span></a> | <a class="modgl" onclick="price_dlr();">$</a></div></th>
			</thead>
			<tbody>
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<? $price = json_decode($row['price'], true); ?>
				<tr>
					<td class="modgl"><a class="itemlink" href="/item/<?=$row['item_id'];?>"><img class="iconurl" src="<?=$row['image'];?>" /><?=$row['item'];?><i class="pull-right glyphicon glyphicon-info-sign"></i></a></td>
					<td data-id="<?=($row['count'] != NULL ? $row['count'] : '');?>"><?=($row['type'] == 'file' ? 'Файл' : $row['count']);?></td>
					<td class="rubprice"><?=$price['WMR'];?> WMR за 1 шт.</td>
					<td class="dlrprice" style="display:none"><?=$price['WMZ'];?> WMZ за 1 шт.</td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="panel">
			<a id="coupon">Есть промо-код?</a>
			<div class="hide popover_content">
				<input type="text" class="input-small form-control" id="cpn_inp" value=''>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-2">
						<label class="control-label" for="count">Кол-во:</label>
						<input type="text" class="form-control input-small" name="count">
					</div>
					<div class="col-lg-3">
						<label class="control-label" for="item">Товар:</label>
						<select class="form-control input-small" name="item">
							<?
								# Сортировка по категориям
								if(Defined('CID')){
									$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
								# Обычный вывод без сортировки
								} else {
									$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC");
								}
							?>
							<? if(mysqli_num_rows($SQL) > 0){ ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<option value="<?=$row['item_id'];?>" data-id="<?=$row['item_id'];?>" data-min_order="<?=$row['min'];?>"><?=$row['item'];?></option>
							<? } ?>
							<? } ?>
						</select>
					</div>
					<div class="col-lg-2">
						<label class="control-label" for="wallets">Валюта:</label>
						<select class="form-control input-small" name="wallets">
							<? $wallets = json_decode(WALLETS, true); ?>
							<? foreach($wallets as $name => $wallet){ ?>
							<? if($wallet != false){ ?>
							<option value="<?=$name;?>" data-fund="<?=$name;?>"><?=($name == "YAD" ? "Яндекс.Деньги" : $name);?></option>
							<? } ?>
							<? } ?>
						</select>
					</div>
					<div class="col-lg-3">
						<label class="control-label" for="email">E-mail:</label>
						<input type="email" class="form-control input-small" name="email">
					</div>
					<div class="col-lg-2">
						<button onclick="sendData();" type="button" class="btn btnbuy btn-primary btn-block">Оплатить</button>
					</div>
				</div>
			</div>
		</div>
		<? } else { ?>
		<? if(Defined('CID')){ ?>
		<div class="panel-heading" style="padding:15px; text-align:center;">
			<font color="red">В этой категории нет товара.</font>
		</div><br />
		<? } else { ?>
		<div class="panel-heading" style="padding:15px; text-align:center;">
			<font color="red">Для продажи добавьте свой товар в Админке.</font>
		</div><br />
		<? } ?>
		<? } ?>