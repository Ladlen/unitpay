				<aside id="sidebar">
					<div class="block">
						<div class="block-title">
							<i class="fa fa-bars"></i>
							Контакты
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
							<?=CONTACTS;?>
							<ul id="blocks-ch-5"></ul>					
						</div>
					</div>
					<div class="block">
						<div class="block-title">
							<i class="fa fa-bars"></i>
							Информация
						</div>
						<div class="cat-blocks with-clear" style="width:100%!important">
							<?=INFORMATION;?>
							<ul id="blocks-ch-5"></ul>					
						</div>
					</div>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="block">
						<div class="block-title">
							<i class="fa fa-bars"></i>
							Категории
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
							<i class="fa fa-star-o"></i>
							Последние покупки
						</div>
						<div class="block-body clr">
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
						<? if(mysqli_num_rows($SQL1) > 0){ ?>
						<? $ITEM = mysqli_fetch_array($SQL1); ?>
						<div class="popular-item clr">
							<img src="<?=$ITEM['image'];?>" />
							<p><a href="/item/<?=$ITEM['item_id'];?>"><?=$row['item'];?></a><br /><span><span><?=$row['price'];?> <?=$row['wallet'];?>.</span></span></p>
						</div>
						<? } ?>
						<? } ?>
						</div>
					</div>
					<? } ?>
					<div class="block">
						<a href="javascript:void(0)"></a>
					</div>
				</aside>