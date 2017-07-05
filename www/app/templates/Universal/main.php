			<?
				# Сортировка по категориям
				if(Defined('CID')){
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
					
				# Обычный вывод без сортировки
				} else {
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
				}
			?>
			<div class="h_content">
				<div class="h_title">Товар</div>
				<div class="over_cnt">
					<div class="cnt_in">
						<div class="goods-list with-clear">
							<? if(mysqli_num_rows($SQL) > 0){ ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $price = json_decode($row['price'], true); ?>
							<div class="list-item" id="last_add-item-<?=$row['item_id'];?>">
								<div class="one_mtr">
									<div class="one_mtr_image">
										<div class="one_mtr_links">
											<a href="/item/<?=$row['item_id'];?>" class="one_mtr_zoom">&nbsp;</a>
										</div>
										<a href="/item/<?=$row['item_id'];?>">
											<span class="one_mtr_bottom">
												<span class="one_mtr_name"><span class="one_mtr_name_in"><?=$row['item'];?></span></span>
												<span class="one_mtr_price"><span class="last_add-good-14-price"><?=$price['WMR'];?> руб.</span></span>
											</span>
											<img id="top_view-gphoto-14" src="<?=$row['image'];?>">
										</a>
									</div>
								</div>
							</div>
							<? } ?>
							<? } ?>
						</div>
					</div>
				</div>
			</div>