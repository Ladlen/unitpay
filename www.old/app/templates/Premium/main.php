			<?
				# Сортировка по категориям
				if(Defined('CID')){
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC LIMIT 3");
				# Обычный вывод без сортировки
				} else {
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC LIMIT 3");
				}
			?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<section id="slider_container">
				<div id="slider">
					<ul>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<? $price = json_decode($row['price'], true); ?>
						<li>
							<img src="<?=$row['image'];?>" />
							<div class="sl_text">
								<div class="sl_title"><?=$row['item']?></div>
								<div class="sl_price"><?=$price['WMR'];?> руб.</div>
								<a class="big_more" href="/item/<?=$row['item_id'];?>">Подробности</a>
							</div>
						</li>
						<? } ?>
					</ul>
				</div>
			</section>
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
			<section>
				<div class="main_title">
					<h3>Товар</h3>
					<div class="some_shadow"></div>
				</div>
				<div class="goods-list with-clear">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<? $price = json_decode($row['price'], true); ?>
					<div class="list-item" id="last_add-item-<?=$row['item_id'];?>">
						<div class="list-item-image-preview">
							<img src="<?=$row['image'];?>" id="last_add-gphoto-<?=$row['item_id'];?>">
							<a class="quick_view big_more ulightbox" href="<?=$row['image'];?>">Увеличить</a>
						</div>
						<div class="list-item-title">
							<a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a>
						</div>
						<div class="list-item-descr"></div>
						<div class="list-item-price">
							<span class="last_add-good-<?=$row['item_id'];?>-price"><?=$price['WMR'];?> руб.</span>
						</div>
						<div class="list-item-buttons">
							<a href="/item/<?=$row['item_id'];?>" class="big_more_inverse">Подробнее</a>
						</div>
					</div>
					<? } ?>
				</div>
				<div class="clr"></div>
			</section>
			<? } else { ?>
				<center>
					<font color="red">Товаров нет.</font>
				</center>
			<? } ?>
		</div>