	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $ITEM = mysqli_fetch_array($SQL); ?>
	<? $price = json_decode($ITEM['price'], true); ?>
	<link href="/assets/css/oplata.css" rel="stylesheet" type="text/css">
	<script src="/assets/js/payment.js"></script>
	<script src="/assets/js/app.js"></script>
	<script src="/assets/js/popup_buy.js"></script>
	<a href="#" class="overlay" id="pay"></a>
	<div class="popup" style="height: 350px;">
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
				<div class="payfoot modal-footer" style="position: relative; top: -20px;">
					<input class="checkpaybtn btn btn-default pull-left" value="Проверить" data-loading-text="Проверяем..." class="checkpaybtn btn btn-primary" style="position: relative; width: 80%; left: 15px;" type="button" />
				</div>
			</center>
			<div style="color: rgb(0, 0, 0); padding: 10px 35px 10px 15px; margin-top: -36px; background-color: rgb(228, 215, 215); border: 1px solid rgb(251, 238, 213); border-radius: 4px; margin-left: 26px;" class="alert alert-danger">
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
							<span style="position: relative; top: -2px;">
								<img src="/assets/img/<?=$image;?>.png">
								<?=($name == "WMR" ? "₽" : ($name == "WMU" ? "₴" : ($name == "WMZ" ? "$" : ($name == "WME" ? "€" : ""))));?>
							</span>
						</a>
					</li>
					<? } ?>
					<? } ?>
				</ul>
				<form onsubmit="return false;">
					<input style="margin-top: 15px; width: 290px;" class="captcha-shop-input" placeholder="Введите свой email" name="email" id="alert-box-email" type="email" required="">
					<input style="margin-top: -45px; width: 120px; margin-left: 327px;" name="count" id="end-number" class="captcha-shop-input" placeholder="Кол-во" required="">
					<input type="text" placeholder="Купон" class="captcha-shop-input" id="cupon" style=" margin-top: 10px; width: 427px; ">
				</form>
				<? $wallets = json_decode(WALLETS, true); ?>
				<? foreach($wallets as $name => $wallet){ ?>
				<? if($wallet != false){ ?>
				<div id="<?=$name;?>" style="display: none;"> 
					<br />
					<center>
						<input type="submit" class="buy_game btn btn-default pull-left" onclick="setWayForMoney('<?=$name;?>'); setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" value="перейти к оплате" style="width: 440px; position: relative; right: 34px; top: 10px;" />	
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
	<div class="other-goods" style="margin-bottom: 20px;">
		<h2><?=$ITEM['item'];?></h2>
	</div>
	<div class="goods3">
		<div class="info-left">
			<div class="video">
				<a id="digiseller-article-img-preview" rel="prettyPhoto[a]">
					<img src="<?=$ITEM['image'];?>" alt="" height="350" width="630">
				</a>
			</div>
			<div id="goods">
				<nav class="main-tabs">
					<a id="d_tab1" class="desc desc_size desc_active">Описание</a>
				</nav>
				<div class="teeeest">
					<div id="con_d_tab1" class="di_tabs block_active">
						<div class="info">
							<?=$ITEM['body'];?>
						</div>
					</div>		
				</div>
			</div>
		</div>
		<div class="info-right">
			<img class="big-img" src="<?=$ITEM['image'];?>" style="margin-bottom: -5px;">
			<div class="buy-block">
				<div class="big-price"><span itemprop="price"><?=$price['WMR'];?></span> руб.</div>
				<div class="safe">Гарантия качества!</div>
				<a href="#pay" class="digiseller-buyButton">
					<div class="buy-button">Купить</div>
				</a>
			</div>
		</div>
	</div>
	<? } else { ?>
		<center>
			<font color="red">Товара не существует.</font>
		</center>
	<? } ?>