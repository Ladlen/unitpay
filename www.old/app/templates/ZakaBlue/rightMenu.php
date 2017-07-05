					<DIV class="right_div">
						<? if(PAGE == "item"){ ?>
						<div class="gameInfo gray_bg">
							<div class="price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
								<p itemprop="price" style="font-size: 17pt;"><?=$price['WMR'];?><span itemprop="priceCurrency" content="RUB">р.</span></p>
								<a href="#pay" class="header_bg button">Купить</a>
							</div>
						</div>
						<? } ?>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<div class="sale gray_bg">
							<h1 class="col_top">Покупки</h1>  
							<ul>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
								<? if(mysqli_num_rows($SQL1) > 0){ ?>
								<? $ITEM = mysqli_fetch_array($SQL1); ?>
								<li>
									<a href="/item/<?=$ITEM['item_id'];?>">
										<img src="<?=$ITEM['image'];?>" />
										<h2><?=$ITEM['item'];?></h2>
										<div>
											<p><?=$row['price'];?> <?=$row['wallet'];?></p>
										</div>
									</a>
								</li>
								<? } ?>
								<? } ?>
							</ul>
						</div>
						<? } ?>
					</DIV>