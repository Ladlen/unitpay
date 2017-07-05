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
			<div class="pict">
				<img src="<?=$row['image'];?>" />
				<div class="layer"></div>
			</div>
		</a>
		<div class="cont">
			<div class="heads">
				<p class="titles">
					<span>
						<a href="../item/<?=$row['item_id'];?>"><?=$row['item'];?></a>
					</span>
				</p>
			</div>
			<div class="middles">
				<div class="price">
					<span class="vals"><?=$price['WMR'];?></span> Руб.
				</div>
			</div>
		</div>
	</div>
	<? } ?>
	<? } ?>
	</div>
	</div>
	</div>
	<? include('rightMenu.php'); ?>
	</div>
	<? include('leftMenu.php'); ?>