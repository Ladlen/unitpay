						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<div id="list_special_offer">
							<h4>Недавно купили</h4>
							<ul id="NowBuy" style="position: relative; bottom: 30px;">
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
								<? if(mysqli_num_rows($SQL1) > 0){ ?>
								<? $ITEM = mysqli_fetch_array($SQL1); ?>
								<li>
									<a href="/item/<?=$row['item_id'];?>">
										<img width="158" height="74" src="<?=$ITEM['image'];?>">
										<span class="cost">
											<span class="new"><?=$row['price'];?> <?=$row['wallet'];?></span>
										</span>  
										<span class="name"><?=$ITEM['item'];?></span>
									</a>
								</li>
								<? } ?>
								<? } ?>
							</ul>
						</div>
						<? } ?>