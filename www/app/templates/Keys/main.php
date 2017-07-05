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
						<a href="/item/<?=$row['item_id'];?>" class="viewn">
							<div class="viewnimages">
								<img src="<?=$row['image'];?>" alt="" />
							</div>
							<div class="viewnin">
								<div class="viewnprice">
									<div class="viewnrub"><b><?=$price['WMR'];?></b> <span>руб</span></div>
								</div>
								<div class="viewntitle"><?=$row['item'];?></div>
							</div>
						</a>
						<? } ?>
						<? } else { ?>
						<center>
							<br /><font color="red">Товаров нет.</font>
						</center>
						<? } ?>