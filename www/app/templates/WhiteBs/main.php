				<div class="col-lg-9 col-md-9 col-sm-12">
					<div class="layer">
						<div class="col-lg-12 col-sm-12">
							<span class="title">Продаваемые товары</span>
						</div>
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
						<div  class="col-lg-4 col-sm-4 hero-feature text-center">
							<div class="thumbnail">
								<a href="/item/<?=$row['item_id'];?>" class="link-p" style="overflow: hidden; position: relative;">
									<img src="<?=$row['image'];?>" style="position: absolute; width: 250px; height: auto; max-width: none; max-height: none; left: -4px; top: 0px;">
								</a>
								<div class="caption prod-caption">
									<h4><a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a></h4>
									<p>
									</p>
									<div class="btn-group">
										<a href="/item/<?=$row['item_id'];?>" class="btn btn-default"><?=$price['WMR'];?> Руб.</a>
										<a href="/item/<?=$row['item_id'];?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Купить</a>
									</div>
									<p></p>
								</div>
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