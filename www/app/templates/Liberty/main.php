	<div class="side_right">
		<div class="sider_center">
       		<aside class="sblock">
				<div class="sb_title">
					<i class="ics ic_04"></i> Товары
				</div>
				<div class="sb_cont">
					<div class="layer">
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
							<div class="pict">
								<img src="<?=$row['image'];?>" />
								<span class="instock"><?=($row['type'] == 'file' ? 'В НАЛИЧИИ' : ($row['count'] > 0 ? 'В НАЛИЧИИ' : 'НЕТ В НАЛИЧИИ'));?></span>
							</div>
							<div class="cont">
								<p class="titles"><a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a></p>
								<a class="btn" href="/item/<?=$row['item_id'];?>">Подробнее &raquo;</a>
								<p class="iprop">Цена: <span><?=$price['WMR'];?> руб.</span></p>
							</div>
						</div>
						<? } ?>
						<? } else { ?>
						<center>
							<font color="red">Товаров нет.</font>
						</center>
						<? } ?>											
					</div>
				</div>
			</aside> 
		</div>	 
		<? include('rightMenu.php'); ?>
	</div>
	<? include('leftMenu.php'); ?>