				<? include('leftMenu.php'); ?>
				<?
					# Сортировка по категориям
					if(Defined('CID')){
						$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
					# Обычный вывод без сортировки
					} else {
						$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
					}
				?>
				<aside id="side-center">
					<div class="block-title1">
						<center>Товары</center>
					</div>
					<div class="layer">
						<div class="title">		
							<?/* if(mysqli_num_rows($SQL) > 0){ */?><!--
								--><?/* while($row = mysqli_fetch_array($SQL)){ */?>
							<? $row = ['price'=>10.1, 'item_id'=>2,'WMR'=>10.1,'item'=>'Название итем','type'=>'str','count'=>2]; { ?>
								<? $price['WMR'] = 10.1;	//json_decode($row['price'], true); ?>
								<div class="item-loop">
									<div class="poster">
										<img style="width:60px;height:60px;cursor:pointer;" src="<?=$row['image'];?>" />
										<a href="/item/<?=$row['item_id'];?>">
											<span class="macpay-snapprice price"><?=$price['WMR'];?> РУБЛЕЙ</span>
										</a>
									</div>
									<div style="padding-top: 8px;" class="title">
										<?=$row['item'];?>
										<center>
											<span style="color: #7e8d95; margin-left: 0px;font-size: 14px; float: left;margin-top: 4px;">В Наличии: <?=($row['type'] == 'file' ? 'Файл' : $row['count'].' шт.');?></span>
										</center>
									</div>
									<div class="block-title2">
										<center><a href="/item/<?=$row['item_id'];?>" style="color:#fff;">Kупить</a></center>
									</div>
								</div>
								<? } ?>
							<?/* } else { */?><!--
								<center>
									<font color="red">Товары отсутствуют.</font>
								</center>
							--><?/* } */?>
						</div>
					</div>
				</aside>