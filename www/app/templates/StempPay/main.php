				<div class="item-full">
					<div id="brifly" class="main two_column">
						<?
							# Случайный товар
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ORDER BY RAND() LIMIT 4");
						?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<div id="main_slider">
							<ul>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $price = json_decode($row['price'], true); ?>
								<li class="slide">
									<a href="/item/<?=$row['item_id'];?>">
										<img src="<?=$row['image'];?>" width="780" width="281" />
										<span class="main_info">
											<span class="name"><?=$row['item'];?> </span>  
										</span>  
										<div class="cost"><?=$price['WMR'];?><sup><i class="fa-wmr"></i></sup></div>
									</a>
								</li>
								<? } ?>
							</ul>
						</div>
						<? } ?>
						<div class="name_page">
							<div class="sort">
								<ul>
									<li class="active"><span class="select">Все товары</span></li>
								</ul>
							</div>
						</div>
						<div class="description">
							<div class="tab_box visible">
								<div class="list_products">
									<ul>
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
										<li>
											<a href="/item/<?=$row['item_id'];?>">
												<span class="photo"><img width="131" src="<?=$row['image'];?>" alt="photo"></span>
												<span class="main">
												<span class="name"><?=$row['item'];?></span>
												<span class="category" style="display: none;"><img src="/assets/StempPay/assets/StempPay/imgs/list_products/ico/steam.png" alt="category"></span><span class="dlc" style="display: none;">DLC</span> </span>
												<span class="cost"><?=$price['WMR'];?> <i class="fa-wmr"></i></span>
											</a>
										</li>
										<? } ?>
										<? } else { ?>
										<center>
											<font color="red">Товаров нет.</font>
										</center>
										<? } ?>
									</ul>
								</div>
							</div>
						</div>
						<? include('rightMenu.php'); ?>
					</div>
				</div>
			</section>