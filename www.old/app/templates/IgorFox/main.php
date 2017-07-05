				<center>
					<ul class="menu">
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<li><a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a></li>
						<? } ?>
					<? } ?>
					</ul>
				</center>
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
				<div class="items" style="width: 1020px; margin: 0 auto; bottom: 30px; position: relative;">
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<? $price = json_decode($row['price'], true); ?>
				<a href="/item/<?=$row['item_id'];?>" class="product layout-<?=$row['item_id'];?>" style="width: 330px;height: 200px;margin-top: 50px;">
					<div class="product-image" style="background-image: url('<?=$row['image'];?>')"></div>
					<div class="product_overlay">
						<div class="product_title"><?=$row['item'];?></div>
					</div>
					<div class="price">
						<span class="new_price"><?=$price['WMR'];?></span>
					</div>
				</a>
				<? } ?>
				</div>
				<br />
				<br />
				<? } else { ?>
				<center>
					<br /><font color="white">Товаров нет.</font>
				</center>
				<? } ?>