	<? include('payModal.php'); ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'"); ?>
	<div class="panel">
		<? if(mysqli_fetch_array($SQL) > 0){ ?>
		<? $ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'")); ?>
		<? $price = json_decode($ITEM['price'], true); ?>
		<div class="panel-heading">
			<div class="panel-title fulliname" style="width:70%;display:inline-block">
				<img style="width:50px;margin-right:5px;" src="<?=$ITEM['image'];?>">
				<?=$ITEM['item'];?>
			</div>
			<div class="text-right priceinfo" style="font-size:12px;display:inline-block;float:right;">
				<strong>Цена в <span class="rur">p<span>уб.</span></span>: </strong> <?=$price['WMR'];?> за 1 шт. <br />
				<strong>Цена в $: </strong> <?=$price['WMZ'];?> за 1 шт.<br />
				<strong>Кол-во: </strong> <?=($ITEM['type'] == "file" ? "Файл" : $ITEM['count']);?>
			</div>
		</div>
				<style>
		body {
    background-image: url(<?=BACKGROUND;?>);
}
</style>
		<div class="panel-body">
			<p><?=$ITEM['body'];?></p>
		</div>
		<div class="panel-footer">
			<div class="row">
				<a title="" data-original-title="" class="cpnin" id="coupon">Есть промо-код?</a>
				<div class="hide popover_content">
					<input class="input-small form-control" id="cpn_inp" value="" type="text" />
				</div>
				<div class="col-lg-3">
					<label class="control-label" for="count">Кол-во:</label>
					<input class="form-control input-small" name="count" type="text">
				</div>
				<div class="col-lg-3">
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
					<input class="form-control input-small" name="email" type="email">
				</div>
				<select class="form-control input-small" name="item" style="display:none;">
					<option value="<?=$ITEM['item_id'];?>" data-id="<?=$ITEM['item_id'];?>" data-min_order="<?=$ITEM['min'];?>" selected=""></option>
				</select>
				<div class="col-lg-3">
					<button onclick="sendData();" type="button" class="btn btn-primary btn-block btnbuyin">Оплатить</button>
				</div>
			</div>
		</div>
		<? } else { ?>
		<div class="panel-heading">
			<center>
				<font color="red">Запрашиваемого Вами товара с заданым ID не найдено.</font>
			</center>
		</div>
		<? } ?>
	</div>