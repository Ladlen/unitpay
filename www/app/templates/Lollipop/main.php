	<? include('menuLeft.php'); ?>
	<div class="layer">
		<div id="content">
			<? include('menuRight.php'); ?>
			<div id="content-c">
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
			<div class="item-loop">
			
				<div class="coast"><?=$price['WMR'];?> руб.</div>
				<div class="name"><a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a></div>
				<div class="poster"><a href="/item/<?=$row['item_id'];?>"><img src="<?=$row['image'];?>"></a></div>
			</div>
			<? } ?>
			<? } else { ?>
			<center>
				<font color="red">Товаров нет.</font>
			</center>
			<? } ?>
			</div>
		</div>
	</div>