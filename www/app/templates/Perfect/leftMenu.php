				<aside id="side-left">
					<div class="block">
						<div class="block-title">
							<center>Меню</center>
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
							<? $obj = json_decode(MENU, true); ?>
							<? foreach($obj as $name => $url){ ?>
							<div id="blocks-rt-1" class="normal" onclick="location.href='<?=$url;?>';">
								<a href="<?=$url;?>"><?=$name;?></a>
							</div>
							<? } ?>
							<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<div id="blocks-rt-1" class="normal" onclick="location.href='/page/<?=$row['pid'];?>';">
								<a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a>
							</div>
							<? } ?>
							<div id="blocks-rt-1" class="normal" onclick="location.href='/myorders/';">
								<a href="/myorders/">Мои покупки</a>
							</div>
							<div id="blocks-rt-1" class="normal"></div>		
						</div>
					</div>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="block">
						<div class="block-title">
							<center>Разделы</center>
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
								<? while($row = mysqli_fetch_array($SQL)){ ?>
									<div id="blocks-rt-5" class="normal" onclick="location.href='/item/<?=$row['name'];?>';">
										<a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
									</div>
								<? } ?>
							<ul id="blocks-ch-5"></ul>
						</div>
					</div>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="block">
						<div class="block-title">
							<center>Последние покупки</center>
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
							<? if(mysqli_num_rows($SQL1) > 0){ ?>
							<? $ITEM = mysqli_fetch_array($SQL1); ?>
							<div class="b-poster" style="padding: 0px; width: 211px; height: 120px;">  
								<div class="coast rpsn" style="height: 25px;">
									<div style="position:relative; bottom:12px;"><?=$row['price'];?> <?=$row['wallet'];?>.</div>
								</div>
								<div class="title" style="width: 212px;"><?=$row['item'];?></div>
								<a href="item/<?=$ITEM['item_id'];?>">
									<img style="height: 94px; width: 211px;" src="<?=$ITEM['image'];?>" />
								</a>
							</div>
							<? } ?>
							<? } ?>
						</div>
					</div>
					<? } ?>
					<div class="block">
						<div class="block-title">
							<center>Контакты</center>
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
							<?=CONTACTS;?>
						</div>
					</div>
					<div class="block">
						<div class="block-title">
							<center>Информация</center>
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
							<?=INFORMATION;?>
						</div>
					</div>
				</aside>