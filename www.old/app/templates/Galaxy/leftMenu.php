						<div class="side_left">
							<aside class="sblock">
								<div class="sb_title">
									<div class="sb_icon"></div>
									<span>Навигация</span>
								</div>
								<div class="sb_cont">
									<ul class="bnav">
										<? $obj = json_decode(MENU, true); ?>
										<? foreach($obj as $name => $url){ ?>
										<li class="layer"><a href="<?=$url;?>"><span><?=$name;?></span></a></li>
										<? } ?>
										<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
										<? while($row = mysqli_fetch_array($SQL)){ ?>
										<li class="layer"><a href="/page/<?=$row['pid'];?>"><span><?=$row['title'];?></span></a></li>
										<? } ?>
										<li class="layer"><a href="/myorders/"><span>Мои покупки</span></a></li>
									</ul>
								</div>
							</aside>
							<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
							<? if(mysqli_num_rows($SQL) > 0){ ?>
							<aside class="sblock">
								<div class="sb_title">
									<div class="sb_icon"></div>
									<span>Разделы магазина</span>
								</div>
								<div class="sb_cont">
									<ul class="bnav">
										<? while($row = mysqli_fetch_array($SQL)){ ?>
										<li class="layer"><a href="/item/<?=$row['name'];?>"><span><?=$row['category'];?></span></a></li>
										<? } ?>
									</ul>
								</div>
							</aside>
							<? } ?>
							<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
							<? if(mysqli_num_rows($SQL) > 0){ ?>
							<aside class="sblock">
								<div class="sb_title">
									<div class="sb_icon"></div>
									<span>ПОСЛЕДНИЕ ПОКУПКИ</span>
								</div>
								<div class="sb_cont">
									<? while($row = mysqli_fetch_array($SQL)){ ?>
									<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
									<? if(mysqli_num_rows($SQL1) > 0){ ?>
									<? $ITEM = mysqli_fetch_array($SQL1); ?>
									<div class="popular-item clr">
										<a href="/item/<?=$ITEM['item_id'];?>"><img src="<?=$ITEM['image'];?>" width="218" height="120" /></a>
										<center><p><a href="/item/<?=$ITEM['item_id'];?>"><?=$row['item'];?></a><br /><?=$row['price'];?> <?=$row['wallet'];?>.</p></center>
									</div>
									<? } ?>
									<? } ?>
								</div>
							</aside>
							<? } ?>
						</div>