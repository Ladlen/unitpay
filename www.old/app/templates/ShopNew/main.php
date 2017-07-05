				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				
				<div class="content-category">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
						<a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
					<? } ?>
				</DIV>
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
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<? $price = json_decode($row['price'], true); ?>	
				<div class="item-entry">
					<div class="o-pict-crop" style="background-image:url(<?=$row['image'];?>);"></div>
					<ul class="i-label">
						<li class="i-price"><?=$price['WMR'];?> <i class="icon-rouble"></i></li>
					</ul>
					<div class="i-content">
						<p class="i-titles"><?=$row['item'];?></p>
						<ul class="i-prop">
						
               <li><i class="icon-lightbulb"></i> В наличии: <span class="i-value"><?=($row['type'] == 'file' ? 'Файл' : $row['count']);?> шт.</span></li>
            </ul>
					</div>
					<a class="i-link" href="#" data-item-buy="<?=$row['item_id'];?>">Подробнее</a>
				</div>
				<? } ?>
				<? } else { ?>
				<center>
					<font color="red">Товаров нет.</font>
				</center>
				<? } ?>
				<div class="form-order-wrap">
					<ul class="form-order">
						<li class="i-clmn-pcs"><input  name="count"  type="text" placeholder="Количество"></li>
						<li class="i-clmn-item" style="width: 240px; min-width: 240px; max-width: 240px;">
							<div class="o_select_pseudo_radio i-drop-up">
								<span class="i_selt_title">Выберите товар</span>
								<div class="i_selt_drop">
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
									<label><input data-id="<?=$row['item_id'];?>" data-min_order="<?=$row['min'];?>" type="radio" name="item" value="<?=$row['item_id'];?>" ><span><?=$row['item'];?></span></label>
									<? } ?>
									<? } ?>
								</div>
							</div>
						</li>
						<li class="i-clmn-payments">
							<div class="o_select_pseudo_radio i-drop-up" style="width: 200px; min-width: 200px; max-width: 200px;">
								<span class="i_selt_title">Выберите способ оплаты</span>
								<div class="i_selt_drop">
									<? $wallets = json_decode(WALLETS, true); ?>
									<? foreach($wallets as $name => $wallet){ ?>
									<? if($wallet != false){ ?>
									<label><input type="radio" id="fundsSelect" name="funds" name="funds" data-fund="<?=$name;?>" value="<?=$name;?>"><span><?=($name == "YAD" ? "Яндекс.Деньги" : $name);?></span></label>
									<? } ?>
									<? } ?>
								</div>
							</div>
						</li>
						<li class="i-clmn-email"><input name="email" type="text" placeholder="Введите свой E-mail"></li>
						<li class="i-clmn-pay"><input class="btn-pay" onclick="senddat();" type="submit" value="Оплатить"></li>
						<li class="i-clmn-coupon"><input class="btn-coupon js-fbox" data-fancybox-href="#box-coupon" type="button" value="Ввести купон"></li>
					</ul>
				</div>
				<div class="none" id="box-coupon">
					<div class="box-wrap">
						<div class="box-title">Активация купона на скидку</div>
						<form class="box-form">
							<div class="input-text"><input type="text" id="copupon" placeholder="Введите купон"></div>
							<input type="submit" value="Отправить">
						</form>
					</div>
				</div>
				<div class="none" id="buy_modal">
					<div class="box-wrap">
						<div class="box-title">Оплата товара</div>
						<div class="box-form">
							<table class="paytable">
								<tbody>
									<tr>
										<td>Наименование продукта:</td>
										<td class="payitem">...</td>
									</tr>
									<tr>
										<td>Количество:</td>
										<td class="paycount">..</td>
									</tr>
									<tr>
										<td>К оплате:</td>
										<td class="payprice">...</td>
									</tr>
									<tr>
										<td>Кошелек для платежа:</td>
										<td class="payfund"><b>...</b></td>
									</tr>
									<tr>
										<td>Примечание к платежу:</td>
										<td class="paybill"><b>...</b></td>
									</tr>
								</tbody>
							</table>
							<input type="submit" class="checkpaybtn"  data-loading-text='Проверяем...' value="Проверить платеж">
							<br> 
						</div>
					</div>
				</div>
				<div class="none" id="recheck">
					<div class="box-wrap">
						<div class="box-title">Проверка платежа</div>
						<div class="box-form">
							<div class="input-text"><input type="text" onkeyup="link();" id="descript" placeholder="Введите примечание из скобочек"></div>
							<input type="submit"  class="checkpaybtnr"  data-loading-text='Проверяем...'  id="link" value="Отправить">
						</div>
					</div>
				</div>
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
				<div class="none" id="buy_modal_<?=$row['item_id'];?>">
					<div class="box-wrap js_tabs_wrap">
						<div class="box-title"><?=$row['item'];?></div>
						<div class="box-item-buy-tabs">
							<div class="ins-tabs js_tabs_btn">
								<a href="#" class="current">Описание</a>
								<a href="#">Доп. информация</a>
							</div>
						</div>
						<div class="box-item-tab idesc">
							<div class="js_tabbox current">
								<p><?=$row['item'];?></p>
							</div>
							<div class="js_tabbox"><?=$row['body'];?></div>
						</div>
					</div>
				</div>
				<? } ?>
				<? } ?><br><?=INFORMATION;?>