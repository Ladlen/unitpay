					<div class="items-ins">
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
						<div class="ii-item">
							<div class="o-pict"><a href="/item/<?=$row['item_id'];?>"><img src="<?=$row['image'];?>" /></a></div>
							<div class="i-cont">
								<div class="i-heads">
									<p class="i-titles">
										<a href="/item/<?=$row['item_id'];?>">
											<?=$row['item'];?>
										</a>
									</p>
									<p class="i-titles-sub"></p>
								</div>
								<div class="item-buy"><a class="btn-buy" href="/item/<?=$row['item_id'];?>">Купить <span class="i-price"><?=$price['WMR'];?><span class="i-sc">Р</span></span></a></div>
							</div>
						</div>
						<? } ?>
						<? } else { ?>
						<center>
							<font color="red">Товаров нет.</font>
						</center>
						<? } ?>
					</div>
					