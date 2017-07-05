	<? include('rightMenu.php'); ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval(ITEM_ID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $ITEM = mysqli_fetch_array($SQL); ?>
		<? $price = json_decode($ITEM['price'], true); ?>
		<script src="http://code.jquery.com/jquery.js"></script>
		<link href="/assets/css/oplata.css" rel="stylesheet" type="text/css">
		<script src="/assets/js/payment.js"></script>
		<script src="/assets/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
		<a href="#" class="overlay" id="pay"></a>
		<div class="popup">
			<div class="title_modal">Покупка <?=$ITEM['item'];?></div>
			<div aria-hidden="false" class="modal fade in" id="paymodal" style="display:none;">
				<div class="select_pay" style="color:black;">Проверка оплаты:</div>
				<center>
					<table class="paytable" style="margin-top: -35px; font-size: 16px; width: 55%;">
						<tbody>
							<tr>
								<td style="color:#000000;" style="width:100px;">Товар:</td>
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
					<div class="select_pay" style="color: black; position: relative; left: -28px;">Выберите способ оплаты:</div>
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
							<?=($name == "WMR" ? "?" : ($name == "WMU" ? "?" : ($name == "WMZ" ? "$" : ($name == "WME" ? "€" : ""))));?>
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
						<input type="submit" class="buy_game" onclick="setWayForMoney('<?=$name;?>'); setEmail();" style="width: 426px; right: 38px; position: relative;" name="" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal"  value="перейти к оплате">	
					</center>
				</div>
				<? } ?>
				<? } ?>	
			</div>
		</div>
		<section role="main" class="clearfix">
			<a id="main-content"></a> 
			<h1 class="title" id="page-title"><?=$ITEM['item'];?></h1>
			<div id="page-goods-block-1">
				<h1>Купить <?=$ITEM['item'];?></h1>
			</div>
			<div id="page-goods-block-2">		
				<div class="page-goods-block-2-left">		
					<div class="field field-name-field-image field-type-image field-label-hidden">
						<div class="field-items">
							<div class="field-item even">
								<img src="<?=$ITEM['image'];?>" height="250" width="460">
							</div>	
						</div>
					</div>
				</div>
				<div class="page-goods-block-2-right">
					<div class="info_price">
						<div>
							<div class="myprice"><?=$price['WMR'];?><span> RUR</span></div>
						</div>
						<div class="delivery_and_info">	
							<div class="instant_delivery">Мгновенная доставка</div>
						</div>
					</div>		
					<div>
						<div class="field field-name-field-buy field-type-link-field field-label-hidden">
							<div class="field-items">
								<div class="field-item even">
									<a href="#pay">Купить</a>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>	
			<section id="block-panels-mini-info-good" class="block block-panels-mini">
				<div class="content">
					<div class="panel-display panel-2col clearfix" id="mini-panel-info_good">
						<div class="panel-panel panel-col-first">
							<div class="inside">
								<div class="panel-pane pane-block pane-quicktabs-product-description">
									<div class="pane-content">
										<div id="quicktabs-product_description" class="quicktabs-ui-wrapper qt-ui-tabs-processed-processed ui-tabs ui-widget ui-widget-content ui-corner-all">
											<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
												<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
													<a>Описание</a>
												</li>
											</ul>
											<div id="qt-product_description-ui-tabs1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style=" background-color: rgba(0,0,0,0.2); display: block; border-width: 0; padding: 10px; background-color: rgba(0,0,0,0.2); ">
												<div class="view view-product-description view-id-product_description view-display-id-block view-dom-id-fa8fd795a7bef86618d33faa3cd37d89">
													<div class="view-content">
														<div>
															<div class="views-field views-field-body">        
																<div class="field-content"><p><?=$ITEM['body'];?></p></div>  
															</div>  
														</div>
													</div>
												</div>
											</div>				
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			
		</section>
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
	<? } ?>