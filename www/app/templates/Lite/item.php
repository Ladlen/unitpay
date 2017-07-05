	<div id="container">
		<? include('leftMenu.php'); ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $ITEM = mysqli_fetch_array($SQL); ?>
		<? $price = json_decode($ITEM['price'], true); ?>
		<link href="/assets/css/oplata.css" rel="stylesheet" type="text/css">
		<script src="/assets/js/payment.js"></script>
		<script src="/assets/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
		<a href="#" class="overlay" id="pay"></a>
		<div class="popup">
			<div class="title_modal">Покупка <?=$ITEM['item'];?></div>
			<div aria-hidden="false" class="modal fade in" id="paymodal" style="display:none;">
				<div class="select_pay">Проверка оплаты:</div>
				<center>
					<table class="paytable" style="margin-top: -35px; font-size: 16px;">
						<tbody>
							<tr>
								<td style="color:#000000;">Товар:</td>
								<td style="color:#000000;" class="payitem"></td>
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
					<div class="payfoot modal-footer">
						<input class="checkpaybtn" value="Проверить" data-loading-text="Проверяем..." class="checkpaybtn btn btn-primary" style="width: 55%; margin-top: 8px;" type="button" />
					</div>
				</center>
				<div style="color:#000000;padding: 10px 35px 10px 15px; margin-top:10px;   background-color: #E4D7D7;  border: 1px solid #fbeed5;  border-radius: 4px;" class="alert alert-danger">
					<span class="label label-important" style="background-color: rgb(204, 4, 0);display: inline;  padding: .25em .6em;    font-weight: 500;  line-height: 1;  color: #fff;  text-align: center;  white-space: nowrap;  vertical-align: middle;   font-size: 10px;">Внимание!</span> Очень важно чтобы вы переводили деньги с этим примечанием, иначе средства не будут зачислены автоматически.
				</div>
			</div>
			<div id="selectPay" style="display:block;">
				<div class="select_pay">Выберите способ оплаты:</div>
				<div style="margin-left: 56px;" id="paym" class="tabs"> 
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
								<img src="/assets/img/<?=$image;?>.png">
								<?=($name == "WMR" ? "₽" : ($name == "WMU" ? "₴" : ($name == "WMZ" ? "$" : ($name == "WME" ? "€" : ""))));?>
							</a>
						</li>
						<? } ?>
						<? } ?>
					</ul>
					<form onsubmit="return false;">
						<input style="margin-top: 15px; width: 290px;" class="captcha-shop-input" placeholder="Введите свой email" name="email" id="alert-box-email" type="email" required="">
						<input style="margin-top: -53px; width: 120px; margin-left: 327px;" name="count" id="end-number"  class="captcha-shop-input" placeholder="Кол-во" required="">
						<input type="text" placeholder="Купон" class="captcha-shop-input" id="cupon" style=" margin-top: 10px; width: 427px; ">
					</form>
					<? $wallets = json_decode(WALLETS, true); ?>
					<? foreach($wallets as $name => $wallet){ ?>
					<? if($wallet != false){ ?>
					<div id="<?=$name;?>" style="display: none;"> 
						<br />
						<center>
							<input type="submit" class="buy_game" onclick="setWayForMoney('<?=$name;?>'); setEmail();" style="width: 426px; right: 38px; position: relative;" name="" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal"  value="перейти к оплате">	
						</center>
					</div>
					<? } ?>
					<? } ?>
				</div>
			</div>
		</div>
		<aside class="side-middle">
			<div class="speedbar">
				<a href="/" class="home"></a>
				<span class="green"><?=$ITEM['item'];?></span>
			</div>
			<div class="item-view">
				<div class="poster">
					<div class="title"><?=$ITEM['item'];?></div>
					<img src="<?=$ITEM['image'];?>" alt="">
				</div>
				<ul class="item-sub">
					<? if($ITEM['cid'] != "0"){ ?>
					<? $CAT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ITEM['cid'])."'")); ?>
					<li class="item-type">
						<span><?=$CAT['category'];?></span>
					</li>
					<? } ?>
					<li><span class="item-order">В наличии: <?=($ITEM['type'] == "file" ? "Файл" : $ITEM['count']." шт");?></span></li>
					<li><span class="item-order">Моментальная доставка</span></li>
					<li><span class="item-order">Безопасная сделка</span></li>
					<li><span class="item-order">Выгодная цена</span></li>
				</ul>
				<div class="item-detail">
					<div class="price">
						<?=$price['WMR'];?> <span>руб.</span>
					</div>
					<a href="#pay" class="buying"><b>Купить</b></a>
				</div>
			</div>
			<ul class="tab-nav">
				<li class="cur"><span>Описание</span></li>
			</ul>
			<div class="tab-box cur">
				<p><?=$ITEM['body'];?></p>
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
			</div>
		</aside>
		<? } else { ?>
			<center>
				<font color="red">Товара с заданным ID не найдено.</font>
			</center>
		<? } ?>
	</div>