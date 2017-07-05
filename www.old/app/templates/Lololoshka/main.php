			<div class="content">
				<div class="wrapper">
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
						<a href="/item/<?=$row['item_id'];?>" class="figure">
							<img src="<?=$row['image'];?>" />
						</a>
						<h2 class="item-title"><?=$row['item'];?></h2>
						<div class="item_footer">
							<span class="cost">
								<span class="price"><?=$price['WMR'];?></span>
								<span class="book">рублей</span>
							</span>
							<a href="/item/<?=$row['item_id'];?>" class="btn">Купить игру</a>
						</div>
					</div>
					<? } ?>
					<? } else { ?>
					<center>
						<br /><font color="red">Товаров нет.</font>
					</center>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
						<aside class="aside">
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
						<? } ?>
						</aside>
					<? } ?>
				</div>
			</div>