	<? include('leftMenu.php'); ?>
	<div class="middle_part">
		<div class="middle_part_in">
			<div class="info-tabs ui-tabs">
				<ul class="menu__products">
					<li><center><a>Товары</a></li>
				</ul>
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
					<div class="detals">
						<ul class="products">
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $price = json_decode($row['price'], true); ?>
							<li>
								<a href="/item/<?=$row['item_id'];?>">
									<img src="<?=$row['image'];?>" />
								</a>
								<p><?=$price['WMR'];?> Руб.</p>
								<span style="color: #FFFFFF; font-family: verdana; font-size: 12px; width: 212px; text-align: center;"><center><?=$row['item'];?></center></span>
							</li>
							<? } ?>
						</ul>
					</div>
					<? } ?>							
				</div>
			</div>
		</div>
		<? include('rightMenu.php'); ?>