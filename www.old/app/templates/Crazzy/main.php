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
				<div class="product-small2">
					<div class="mp-procuct-overlay"></div>
					<div class="mp-procuct-head mp-p-head-dailyday">
						<?=$row['item'];?>
					</div>
					<img src="<?=$row['image'];?>" class="main-pic" />
					<div class="mp-product-info">
						<div class="priceMin">
							<strong class="mp-pi-price-min"> <?=$price['WMR'];?> Руб.</strong>
						</div>
						<a href="/item/<?=$row['item_id'];?>" class="buy_nowa2">
							<button class="button_buy">Купить</button>
						</a>
					</div>
				</div>
				<? } ?>
				<? } else { ?>
				<center>
					<br /><font color="white">Товаров нет.</font>
				</center>
				<? } ?>