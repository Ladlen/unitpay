		<link href="/assets/css/oplata.css" rel="stylesheet" type="text/css">
		<script src="/assets/Deer/js/payment.js"></script>
		<script src="/assets/Deer/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
		<style>.modal-backdrop {display:none;}</style>
		<div class="row">
			<div class="col-md-12">
				<div class="row row-block row-block-header">
					<div class="col-md-12">
						<p style="text-align:center;">
							<a><img src="<?=LOGOTYPE;?>" /></a>
						</p>
					</div>
				</div>
				<input type="hidden" id="test1" value="" />
				<div class="row"><center><?=CONTACTS;?></center>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="col-md-3">
						<div class="nav nav-cat">
							<div class="list-group">
								<a href="/" class="list-group-item active">
									<span class="fa fa-diamond"></span> Все
								</a>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<a href="/item/<?=$row['name']?>" class="list-group-item">
									<span class="fa fa-bookmark"></span> <?=$row['category'];?></span>
								</a>
								<? } ?>
							</div>
						</div>
					</div>
					<? } ?>					
					<div class="col-md<?=(mysqli_num_rows($SQL) > 0 ? "-9" : "");?>">
						<div class="table-responsive">
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
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $price = json_decode($row['price'], true); ?>
							<a href="#" class="overlay" id="pay-<?=$row['item_id'];?>"></a>
							<div class="popup" style="height: 400px;">
								<div class="title_modal">Покупка <?=$row['item'];?></div>
								<div aria-hidden="false" class="modal fade in" id="paymodal-<?=$row['item_id'];?>" style="display: none; margin: 0px auto; overflow: hidden; position: absolute; width: 570px; top: 60px;">
									<div class="select_pay">Проверка оплаты:</div>
									<center>
										<table class="paytable-<?=$row['item_id'];?>" style="font-size: 16px; position: relative; top: -25px; width: 60%;">
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
											<input class="checkpaybtn" value="Проверить" data-loading-text="Проверяем..." class="checkpaybtn btn btn-primary" style="width: 55%; position: relative; left: -121px;" type="button" />
										</div>
									</center>
																				<style>
											.checkpaybtn {
color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;									
	 display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
									<div style="color:#000000;padding: 10px 35px 10px 15px; margin-top:-36px;   background-color: #E4D7D7;  border: 1px solid #fbeed5;  border-radius: 4px;" class="alert alert-danger">
										<span class="label label-important" style="background-color: rgb(204, 4, 0);display: inline;  padding: .25em .6em;    font-weight: 500;  line-height: 1;  color: #fff;  text-align: center;  white-space: nowrap;  vertical-align: middle;   font-size: 10px;">Внимание!</span> Очень важно чтобы вы переводили деньги с этим примечанием, иначе средства не будут зачислены автоматически.
									</div>
								</div>
								<div id="selectPay-<?=$row['item_id'];?>" style="display:block;">
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
												}
											?>
											<li>
												<a class="" href="#<?=$name;?>" onclick="test1('<?=$name;?>')">
													<span style="position: relative; top: -9px;">
														<img src="/assets/img/<?=$image;?>.png">
														<?=($name == "WMR" ? "₽" : ($name == "WMU" ? "₴" : ($name == "WMZ" ? "$" : ($name == "WME" ? "€" : ""))));?>
													</span>
												</a>
											</li>
											<? } ?>
											<? } ?>
										</ul>
										<form onsubmit="return false;">
											<input style="margin-top: 15px; width: 290px;" class="captcha-shop-input" placeholder="Введите свой email" name="email-<?=$row['item_id'];?>" id="alert-box-email" type="email" required="">
											<input style="margin-top: -45px; width: 120px; margin-left: 327px;" name="count-<?=$row['item_id'];?>" id="end-number" class="captcha-shop-input" placeholder="Кол-во" required="">
											<input type="text" placeholder="Купон" class="captcha-shop-input" id="cupon-<?=$row['item_id'];?>" style=" margin-top: 10px; width: 427px; ">
										</form>
										<? $wallets = json_decode(WALLETS, true); ?>
										<? foreach($wallets as $name => $wallet){ ?>
										<? if($wallet != false){ ?>
										<div id="<?=$name;?>" style="display: none;"> 
											<br />
											<center>
												<input type="submit" class="buy_game" onclick="setWayForMoney('<?=$name;?>'); setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" value="перейти к оплате" style="width: 427px; right: 37px; position: relative; top: -10px;" />	
											</center>
											<style>
											.buy_game {
	    color: #fff;
    background-color: #449d44;
    border-color: #398439;										
	 display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
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
											<option value="<?=$row['item_id'];?>" data-id="<?=$row['item_id'];?>" data-min_order="<?=$row['min'];?>"><?=$row['item'];?></option>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="control-label" for="wallets-<?=$row['item_id'];?>">Валюта:</label>
										<input type="hidden" id="sa<?=$row['item_id'];?>" value="WMR" />
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
										<label class="control-label" for="email-<?=$row['item_id'];?>">E-mail:</label>
										<input type="email" id="row-box-email" class="form-controler input-small" name="email">
									</div>
									<div class="col-lg-2">
										<button onclick="sendData();" type="button" class="btn btnbuy btn-primary btn-lg btn-block">Оплатить</button>
									</div>
								</div>
							</div>
							<? } ?>
							<? } ?>
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
							<table class="table table-bordered shop_goods">
								<tr>
									<th>Продукт</th>
									<th>Кол&#8209;во</th>
									<th>За&nbsp;1&nbsp;шт.</th>
									<th></th>
								</tr>
								<tr class="separator"style="background: <?=COLORDEERTOVAR;?>;">
									<td colspan="4" class="text-center">
										Все товары
									</td>
								</tr>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $price = json_decode($row['price'], true); ?>
                                <tr>
                                    <td>
                                        <div class="title" data-toggle="tooltip" title="">
											<img src="<?=$row['image'];?>"style="width: 20px;height: 20px;"/>
                                            <?=$row['item'];?>
										</div>
                                    </td>
                                    <td><?=($row['type'] == 'file' ? 'Файл' : $row['count']);?></td>
                                    <td><span class="price_tbl"><?=$price['WMR'];?></span>&nbsp;<span class="rouble">₽</span></td>
                                    <td class="text-center"><a href="#pay-<?=$row['item_id'];?>" onclick="$('#test1').val('<?=$row['item_id'];?>');"><i class="fa fa-shopping-cart"> Купить</i></a></td>
                                </tr>
								<? } ?>
							</table>
							<? } else { ?>
							<table class="table table-bordered shop_goods">
								<tr>
									<td>
										<center>
											<font color="red">Товаров нет.</font>
										</center>
									</td>
								</tr>
							</table>
							<? } ?>
							<?=INFORMATION;?>
						</div>        
					</div>
				</div>
				<div class="row row-block row-block-footer">
					<div class="col-md-12">
						<p style="text-align:center;">
							<span style="font-size:28px;"><span style="color:rgb(192,80,77);"><strong> </strong></span></span><br />
						</p>
					</div>
				</div>
			</div>
		</div>