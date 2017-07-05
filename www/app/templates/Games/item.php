	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $ITEM = mysqli_fetch_array($SQL); ?>
	<? $price = json_decode($ITEM['price'], true); ?>
	<link href="/assets/css/oplata.css" rel="stylesheet" type="text/css">
	<script src="/assets/js/payment.js"></script>
	<script src="/assets/js/app.js"></script>
	<script src="/assets/js/popup_buy.js"></script>
	<a href="#" class="overlay" id="pay"></a>
	<div class="popup" style="height: 400px; ">
		<div class="title_modal">Покупка <?=$ITEM['item'];?></div>
		<div aria-hidden="false" class="modal fade in" id="paymodal" style="display: none; margin: 0px auto; overflow: hidden; position: absolute; width: 570px; top: 60px;">
			<div class="select_pay">Проверка оплаты:</div>
			<center>
				<table class="paytable" style="font-size: 16px; position: relative; top: -25px; width: 60%;">
					<tbody>
						<tr>
							<td style="color:#000000;">Товар:</td>
							<td style="color:#000000; width: 100px;" class="payitem"></td>
						</tr>
						<tr>
							<td style="color:#000000;">Кол-во:</td>
							<td style="color:#000000;" class="paycount"></td>
						</tr>
						<tr>
							<td style="color:#000000;">К оплате:</td>
							<td style="color:#000000;" class="payprice"></td>
						</tr>
						<tr>
							<td style="color:#000000;">Кошелек для платежа:</td>
							<td style="color:#000000;" class="copyitem paywallet" data-clipboard-target="copywallet">...</td>
						</tr>
						<tr>
							<td style="color:#000000;">Примечание к платежу:</td>
							<td style="color:#000000;" class="copyitem paybill" data-clipboard-target="copybill">...</td>
						</tr>
					</tbody>
				</table>
				<div class="payfoot modal-footer" style="position: relative; top: 0px;">
					<input class="btn-buy checkpaybtn btn btn-default pull-left" value="Проверить" data-loading-text="Проверяем..." class="checkpaybtn btn btn-primary" style="position: relative; width: 80%;" type="button" />
				</div>
			</center>
			<div style="color:#000000;padding: 10px 35px 10px 15px;background-color: #E4D7D7;border: 1px solid #fbeed5;border-radius: 4px;margin-left: 28px;" class="alert alert-danger">
				<span class="label label-important" style="background-color: rgb(204, 4, 0);display: inline;  padding: .25em .6em;    font-weight: 500;  line-height: 1;  color: #fff;  text-align: center;  white-space: nowrap;  vertical-align: middle;   font-size: 10px;">Внимание!</span> Очень важно чтобы вы переводили деньги с этим примечанием, иначе средства не будут зачислены автоматически.
			</div>
		</div>
		<div id="selectPay" style="display:block;">
			<div class="select_pay">Выберите способ оплаты:</div>
			<div style="margin-left: 56px; color: black;" id="paym" class="tabs"> 
				<ul class="tabNavigation"> 
					<? $wallets = json_decode(WALLETS, true); ?>
					<? foreach($wallets as $name => $wallet){ ?>
					<? if($wallet != false){ ?>
					<?
						# Webmoney
						if($name == "WMR" || $name == "WMU" || $name == "WMZ" || $name == "WME"){
							$image = "webmoney";
						# Яндекс Деньги
						} else if($name == "YAD"){
							$image = "yandex";
						# QIWI
						} else if($name == "QIWI"){
							$image = "qiwi";
						# Robokass'a
						} else if($name == "ROBOKASSA"){
							$image = "robokassa";
						# Freekass'a
						} else if($name == "FREEKASSA"){
							$image = "freekassa";
						# Primeare'a
						} else if($name == "PRIMEAREA"){
							$image = "primearea";
						# Payeer
						} else if($name == "PAYEER"){
							$image = "payeer";
						}
					?>
					<li>
						<a class="" href="#<?=$name;?>">
							<span style="position: relative; top: 0px;">
								<img src="/assets/img/<?=$image;?>.png">
								<?=($name == "WMR" ? "₽" : ($name == "WMU" ? "₴" : ($name == "WMZ" ? "$" : ($name == "WME" ? "€" : ""))));?>
							</span>
						</a>
					</li>
					<? } ?>
					<? } ?>
				</ul>
				<form onsubmit="return false;">
					<input style="opacity: 1; color: black; margin-top: 15px; width: 290px;" class="captcha-shop-input" placeholder="Введите свой email" name="email" id="alert-box-email" type="email" required="">
					<input style="color: black; margin-top: -45px; width: 120px; margin-left: 327px;" name="count" id="end-number" class="captcha-shop-input" placeholder="Кол-во" required="">
					<input type="text" placeholder="Купон" class="captcha-shop-input" id="cupon" style="color: black; margin-top: 10px; width: 427px; ">
				</form>
				<? $wallets = json_decode(WALLETS, true); ?>
				<? foreach($wallets as $name => $wallet){ ?>
				<? if($wallet != false){ ?>
				<div id="<?=$name;?>" style="display: none;"> 
					<br />
					<center>
						<input type="submit" class="btn-buy buy_game btn btn-default pull-left" onclick="setWayForMoney('<?=$name;?>'); setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" value="перейти к оплате" style="width: 438px;position: relative;right: 33px;top: -5px;" />	
					</center>
				</div>
				<? } ?>
				<? } ?>
			</div>
		</div>
	</div>
	<div class="panel" style="display:none;">
		<div class="row">
			<div class="col-lg-3">
				<label class="control-label" for="item">Товар:</label>
				<select class="form-controler input-small" name="item" id="item-selected">
					<option value="<?=$ITEM['item_id'];?>" data-id="<?=$ITEM['item_id'];?>" data-min_order="<?=$ITEM['min'];?>"><?=$ITEM['item'];?></option>
				</select>
			</div>
			<div class="col-lg-2">
				<label class="control-label" for="wallets">Валюта:</label>
				<select class="form-control input-small" id="walletsSelect" name="wallets">
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
				<input type="email" id="row-box-email" class="form-controler input-small" name="email">
			</div>
			<div class="col-lg-2">
				<button onclick="sendData();" type="button" class="btn btnbuy btn-primary btn-lg btn-block">Оплатить</button>
			</div>
		</div>
	</div>
	
	<article class="item-full">
		<div class="block-title">
			<i class="icv ic-items"></i>
			<span><?=$ITEM['item'];?></span>
		</div>
		<div class="block-wrap"style="background: <?=COLORGAMESTVR;?>">
			<div class="item-full-pict">		
				<div class="i-pict">
					<img src="<?=$ITEM['image'];?>" />
				</div>
            </div>
			<div class="item-full-content">
				<div class="i-heads">
					<div class="i-price">
						<span class="i-price-val"><?=$price['WMR'];?></span> рублей
					</div>
					<div class="i-content">
						<div class="i-titles">
							<h1><?=$ITEM['item'];?></h1>
						</div>
				</div>
				<div class="idesc js-tabs-wrap">
					<div class="js-tabs-btn">
						<a class="current">ОПИСАНИЕ</a>
					</div>
					<div class="js-tabs-box current" style="display: block;">
						<?=$ITEM['body'];?>
					</div>
				</div>
				<div class="item-full-buy">
					<a class="btn-buy js_fbox" href="#pay" style="float: right;">Оплатить товар</a>
				</div>
			</div>
		</div>
	</article>
	<? } else { ?>
	<article class="page-full">
		<div class="block-wrap idesc">
			<center>
				<font color="white">Товара не существует.</font>
			</center>
		</div>
	</article>
	<? } ?>