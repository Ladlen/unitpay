			<?
				# Сортировка по категориям
				if(Defined('CID')){
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC LIMIT 3");
				# Обычный вывод без сортировки
				} else {
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC LIMIT 3");
				}
			?>
			<div id="middle" class="cnt clr">
				<div id="content">
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div id="slider-container">
						<div class="slider">
							<ul>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $price = json_decode($row['price'], true); ?>
								<li>
									<div class="discount">
										<img src="<?=$row['image'];?>" style="height: 200px; border: 2px solid gainsboro; width: 300px; position: absolute; margin-left:550px; margin-top:30px;">
									</div>
									<div class="slide-content">
										<div class="slide-title">
											<?=$row['item'];?><br />
										</div>
										<a class="button" href="/item/<?=$row['item_id'];?>">Купить сейчас</a>
									</div>
								</li>
								<? } ?>
							</ul>
						</div>
					</div>
					<? } ?>
					<div id="new-items" class="white-cnt">
						<h2 class="title">Товар </h2>
						<div class="goods-list with-clear">
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
							<div class="list-item" id="last_add-item-<?=$row['item_id'];?>">
								<a class="item-img" href="/item/<?=$row['item_id'];?>"><img id="last_add-gphoto-<?=$row['item_id'];?>" src="<?=$row['image'];?>" style="width: 250px; height: 250px;"></a>
								<a href="/item/<?=$row['item_id'];?>" class="item-name"><?=$row['item'];?></a>
								<div class="item-price"><span class="last_add-good-11-price"><?=$price['WMR'];?> руб.</span></div>
								<div class="item-buttons clr">
									<a href="javascript:void(0);" class="item-add left" onclick="location.href='/item/<?=$row['item_id'];?>'"><i class="fa fa-shopping-cart"></i>Купить</a>
									<a href="/item/<?=$row['item_id'];?>" class="item-read-more">Подробнее <i class="fa fa-angle-right"></i></a>
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
				</div>
				<? include('leftMenu.php'); ?>
			</div>