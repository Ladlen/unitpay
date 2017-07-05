<? include('leftMenu.php'); ?>
				<div class="right">
					<?
						# Сортировка по категориям
						if(Defined('CID')){
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC LIMIT 3");
						# Обычный вывод без сортировки
						} else {
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC LIMIT 3");
						}
					?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="slider has-dots" style="overflow: hidden; width: 100%; height: 360px;">
						<ul style="width: 500%; position: relative; left: 0%; height: 360px;">
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $price = json_decode($row['price'], true); ?>
							<li style="width: 20%; background-image: url('<?=$row['image']?>'); background-size: 100%;" onclick="location.href=`/item/<?=$row['item_id'];?>`">
								<div class="slider-blick"></div> 
								<div class="slider-info">
									<div class="big-title"><a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a></div>
									<div class="slider-price"> <?=$price['WMR'];?> руб.</div>
								</div>
							</li>
							<? } ?>
						</ul>
					</div>
					<? } ?>
					<div id="goods">
						<div class="teeeest">
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
							<div id="con_tab1" class="tabs active">
								<div class="rows">
									<? while($row = mysqli_fetch_array($SQL)){ ?>
									<? $price = json_decode($row['price'], true); ?>
									<div class="row">
										<div class="img" onclick="location.href='/item/<?=$row['item_id'];?>';">
											<img class="lazy img" src="<?=$row['image'];?>">
										</div>
										<div class="row-info">
											<div class="title">
												<a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a>
											</div>
											<div class="price"><?=$price['WMR'];?> руб.</div>
										</div>
									</div>
									<? } ?>
								</div>
							</div>
							<? } else { ?>
							<center><font color="red">Товаров нет.</font></center>
							<? } ?>
						</div>
					</div>
				</div>