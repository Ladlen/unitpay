	<? include('leftMenu.php'); ?>
	<? include('rightMenu.php'); ?>
	<aside id="side-center">
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
		<a href="item/<?=$row['item_id'];?>">
			<div class="layer">
				<div class="item-loop">
					<div class="poster">
						<img style="border-left: 3px solid #e9eff2;height: 54px;width: 127px;" src="<?=$row['image'];?>" />
						<a href="item/<?=$row['item_id'];?>"><span>Купить</span></a>
					</div>
					<div class="title">
						<a href="item/<?=$row['item_id'];?>"><?=$row['item'];?></a>
					</div>
					<div class="coast">
						<?=$price['WMR'];?> <i>руб.</i>
					</div>
				</div>
			</div>
		</a>
		<? } ?>
		<? } else { ?>
		<center>
			<font color="red">Товаров нет.</font>
		</center>
		<? } ?>
		<div id="dle-content"></div>
	</aside>