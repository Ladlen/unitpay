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
		<div style="margin-left: 56px;" id="selectPay" class="tabs"> 
			<ul class="tabNavigation"> 
				<div class="select_pay">Выберите способ оплаты:</div>
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
				<input style="margin-top: 15px; width: 290px;" class="captcha-shop-input" placeholder="Введите свой email" name="email" id="alert-box-email" required="" type="email">
				<input style="margin-top: -45px;width: 120px;margin-left: 327px;" name="count" id="end-number" class="captcha-shop-input" placeholder="Кол-во" required="">
				<input placeholder="Купон" class="captcha-shop-input" id="cupon" style=" margin-top: 10px; width: 427px; " type="text">
			</form>
			<? $wallets = json_decode(WALLETS, true); ?>
			<? foreach($wallets as $name => $wallet){ ?>
			<? if($wallet != false){ ?>
				<div id="<?=$name;?>" style="display: none;"> 
					<br />
					<center>
						<input type="submit" class="buy_game" onclick="setWayForMoney('<?=$name;?>'); setEmail();" style="width: 437px; right: 43px; bottom:10px; position: relative;" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal"  value="перейти к оплате">	
					</center>
				</div>
			<? } ?>
			<? } ?>
			<style>#selectPay > .panel {width:1px; height:1px; opacity:0;}</style>
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
	</div>
	<div id="dle-content">
		<style>
			ul.tabNavigation {
				list-style: none;
				margin-left: 20px;
				padding: 0;
			}
			 
			ul.tabNavigation li {
				display: inline;
			}
			 
			ul.tabNavigation li a {
				padding: 24px 18px 6px 18px;
				color: #000;
				text-decoration: none;
			}
			 
			ul.tabNavigation li a.selected,
			ul.tabNavigation li a.selected:hover {
				background: rgba(177, 182, 184, 0.24);
				color: #000;
				border-radius: 4px;
			}
			 
			ul.tabNavigation li a:hover {
				background: rgba(177, 182, 184, 0.24);
				color: #000;
				border-radius: 4px;
				-webkit-transition: all ease .9s;
				-moz-transition: all ease .9s;
				-ms-transition: all ease .9s;
				-o-transition: all ease .9s;
				transition: all ease .9s;    
			}
			 
			ul.tabNavigation li a:focus {
				outline: 0;
			}
			 
			div.tabs div h2 {
				margin-top: 0;
			}
		</style>
		<div class="breadcrumb">
			<a href="/">Главная</a>
			<div class="crumb"></div>
			<a><?=$ITEM['item'];?></a>
		</div><br />
		<h1 itemprop="name"><?=$ITEM['item'];?></h1>
		<div class="big-info">
			<div class="inf-left">
				<div class="gallery-block-one">
					<div class="gallery" style="overflow: hidden; width: 475px; height: 272px;">
						<img src="<?=$ITEM['image'];?>" style="display:inline; height:267px; width:475px;">
					</div>
					<div class="buy-block">
						<div class="big-price">
							<span itemprop="price"><?=$price['WMR'];?></span> руб.
						</div>
						<div style="height: 15px;" class="safe"></div>
						<a href="#pay"><div class="buy-button">Купить</div></a> 
					</div>
				</div>
				<div class="inf">
					<div style="font-weight: bold;">Моментальная доставка</div>
					Данные придут через несколько секунд после покупки, на Ваш почтовый ящик!
				</div>
				<div id="goods">
					<nav class="main-tabs" style="width: 787px;margin-top: 10px;">
						<div class="op">Описание</div>
						<div class="info"><?=$ITEM['body'];?></div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<? } else { ?>
		<center>
			<font color="red">Товара с заданным ID не найдено.</font>
		</center>
	<? } ?>