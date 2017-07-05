						<div class="sider_center">
							<div class="layer">
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
								<div class="item">
									<a href="/item/<?=$row['item_id'];?>">
										<span class="pict">
											<img src="<?=$row['image'];?>" style="width: 263px; height: 115px;" />
										</span>
										<span class="i_price"><?=$price['WMR'];?> руб.</span>
										<span class="titles"><?=$row['item'];?></span>
									</a>
								</div>
								<? } ?>
								<? } else { ?>
								<center>
									<br /><font color="red">Товаров нет.</font>
								</center>
								<? } ?>
							</div>
						</div>