	<? include('leftMenu.php'); ?>
	<? include('rightMenu.php'); ?>
	<aside id="side-center">
		<div class="items">
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
			<div class="b-poster">
				<div class="coast lpsn"><?=$price['WMR'];?><i>руб.</i></div>
				<div class="title"><p><?=$row['item'];?></p></div>
				<a href="/item/<?=$row['item_id'];?>"><img src="<?=$row['image'];?>" width="188" height="108"></a>
			</div>
			<? } ?>
			<? } else { ?>
			<center>
				<font color="red">Товаров нет.</font>
			</center>
			<? } ?>
		</div>
	</aside>