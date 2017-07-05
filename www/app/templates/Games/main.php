

				<div class="block-title"><i class="icv ic-items"></i> <span>Товары магазина</span></div>
				<div class="block-wrap"style="background: <?=COLORGAMESTVR;?>">
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
					<div class="o-item">
						<div class="o-pict-crop" style="background-image:url('<?=$row['image'];?>');"></div>
						<div class="i-price"><span class="i-price-val"><?=$price['WMR'];?></span> рублей</div>
						<div class="i-content">
							<p class="i-titles">
								<a href="/item/<?=$row['item_id'];?>">
									<?=$row['item'];?>
								</a>
							</p>
						</div>
						<a class="i-link" href="/item/<?=$row['item_id'];?>">Подробнее</a>
					</div>
					<? } ?>
					<? } else { ?>
					<center>
						<font color="white">Товаров нет.</font>
					</center>
					<? } ?>
				</div>