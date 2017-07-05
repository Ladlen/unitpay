					<DIV class="center_div gray_bg">
						<UL class="games">
							<?
								# Сортировка по категориям
								if(Defined('CID')){
									$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
								# Обычный вывод без сортировки
								} else {
									$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, $this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
								}
							?>
							<? if(mysqli_num_rows($SQL) > 0){ ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $price = json_decode($row['price'], true); ?>
							<LI>
								<A href="/item/<?=$row['item_id'];?>">
									<IMG src="<?=$row['image'];?>" />
									<H1><SPAN><?=$row['item'];?></SPAN></H1>
									<P><?=$price['WMR'];?><SPAN>р.</SPAN></P>
								</A>
							</LI>
							<? } ?>
							<? } else { ?>
							<center>
								<font color="red">Товаров нет.</font>
							</center>
							<? } ?>
						</UL>
					</DIV>
					<? include('rightMenu.php'); ?>
				</DIV>