			<?
				# Сортировка по категориям
				if(Defined('CID')){
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
				# Обычный вывод без сортировки
				} else {
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC");
				}
			?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<div id="h-slider">
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<? $price = json_decode($row['price'], true); ?>
				<a href="/item/<?=$row['item_id'];?>" class="item poster">
					<div class="info">
						<div class="row">
							<span class="coast"><?=$price['WMR'];?></span>
							<span class="price">руб.</span>
						</div>
						<span class="title"><?=$row['item'];?></span>
					</div>
					<img src="<?=$row['image'];?>" width="225" height="120">
				</a>
				<? } ?>
			</div>
			<? } ?>
			<div id="container">
				<? include('leftMenu.php'); ?>
				<? include('rightMenu.php'); ?>
				<aside class="side-middle">
					<div class="c-detail">
						<div class="view-item">
							<span class="lcol">Вид товара</span>
							<a class="item-block cur"></a>
							<a class="item-list"></a>
						</div>
					</div>
					<div class="content-item">
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
						<a class="c-item" href="/item/<?=$row['item_id'];?>">
							<span class="coast"><?=$price['WMR'];?> руб.</span>
							<span class="title"><?=$row['item'];?></span>
							<span class="img">
								<img src="<?=$row['image'];?>" />
							</span>
							<span class="cat"></span>
						</a>
						<? } ?>
						<? } else { ?>
						<center>
							<font color="red">Товаров нет.</font>
						</center>
						<? } ?>
					</div>
				</aside>
			</div>