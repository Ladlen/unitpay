test
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
<script type="text/javascript">
	var getedId = 0;
	var numOfItems = 0;
	var setepaidway = 0;

	function Basket(getedId) {
	    numOfItems = document.getElementById('number-of-items-' + getedId).value;
	    document.getElementById('end-number').value = numOfItems;
	    document.getElementById('item-selected').value = getedId;
	}

	function setpaidway(setepaidway) {
	    document.getElementById('fundsSelect').value = setepaidway;
	}

	function setEmail() {
	    document.getElementById('row-box-email').value = document.getElementById('alert-box-email').value;
	    sendData();
	}
</script>
<div class="modal fade" id="<?=$row['item_id'];?>">
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
<div id='qqq'>
	<table class="table table-bordered">
		<thead>
			<th>Наименование продукта</th>
			<th>шт. в наличии</th>
			<th>Цена</th>
			<th style="border-right-color: rgba(0, 0, 0, 0);">Купить</th>
		</thead>
		<tbody>
			<? while($row = mysqli_fetch_array($SQL)){ ?>
				<pre>
					<? 
						var_dump($row)
					?>
				</pre>
			<? $price = json_decode($row['price'], true); ?>
			<tr>
				<td class="modgl"><a class="itemlink" href="/item/<?=$row['item_id'];?>"><img class="iconurl" src="<?=$row['image'];?>" /><?=$row['item'];?><i class="pull-right glyphicon glyphicon-info-sign"></i></a></td>
				<td data-id="<?=($row['count'] != NULL ? $row['count'] : '');?>"><?=($row['type'] == 'file' ? 'Файл' : $row['count']);?></td>
				<!-- тут цена должна быть в рублях -->
				<td class="rubprice"><?=$price['WMR'];?> руб за 1 шт.</td>
				<td class="dlrprice" style="display:none"><?=$price['WMZ'];?> руб за 1 шт.</td>
				<td style="border-right-color: rgba(0, 0, 0, 0);"> <img class="iconbasket" src="./assets/img/pay/basket.png" width="22px" height="22px" data-toggle="modal" data-target="#setpaidway" style="display: inline;float: right;margin-left:0px; cursor:pointer" onclick="Basket(<?=$row['item_id'];?>)">
					<input type="text" class="form-control input-micro" id="number-of-items-<?=$row['item_id'];?>" style="width: 20px;margin-left: 0px;height: 18px;display: inline;padding: 0;float: right;" value="1">
				</td>
			</tr>
			<? } ?>
		</tbody>
	</table>
</div>
<form class="form-inline">
    <label class="control-label" for="count"></label>
    <input type="text" placeholder="Кол-во" class="form-control input-small" name="count" id="end-number" style2="width: 49px;margin-left: -15px;">
    <label class="control-label" for="item">Товар:</label>
    <select class="form-control input-small" name="item" id="item-selected" style2="width: 124px;margin-left: -30px;">
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
	<label class="control-label" for="funds">Валюта:</label>
	<br>
		<? $wallets = json_decode(WALLETS, true); 
			var_dump($wallets)
		?>
	<br>
	<label class="control-label" for="funds"></label>
    <select class="form-control input-small" id="fundsSelect" name="funds">
		<? $wallets = json_decode(WALLETS, true); ?>
		<? foreach($wallets as $name => $wallet){ ?>
		<? if($wallet != false){ ?>
			<option value="<?=$name;?>" data-fund="<?=$name;?>">
			<?=($name == "YAD" ? "Яндекс.Деньги" : $name);?></option>
			<option value="<?=$name;?>" data-fund="<?=$name;?>">
			<?=($name == "QIWI" ? "QIWI" : $name);?></option>
			<option value="<?=$name;?>" data-fund="<?=$name;?>">
		<!-- не знаю что вместо name вписать-->
			<?=($name == "Банк.карты" ? "Банк.карты" : $name);?></option> 
			<option value="<?=$name;?>" data-fund="<?=$name;?>">
			<!-- не знаю что вместо name вписать-->
			<?=($name == "Oplata.info" ? "Oplata.info" : $name);?></option>
		<? } ?>
    </select>
    <input type="email" placeholder="E-mail" class="form-control input-small" id="row-box-email" name="email">
    <button onclick="sendData();" type="button" class="btn btn-primary" aria-hidden="true" style="">Оплатить</button>
    <button type='button' class='btn btn-primary' aria-hidden='true' data-toggle='modal' data-target='#kupon' styl3e='margin-bottom: 10px;width: 86px;padding-left: 1px;font-size: 14px;margin-left: 356px;font-weight: 100;'>Ввод купона</button>
</form>

<?} else { ?>
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