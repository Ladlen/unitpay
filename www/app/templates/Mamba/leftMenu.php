				<div class="left">
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="block">
						<h3>
							<span class="fa fa-newspaper-o" style="background: url(/assets/Mamba/img/cat.png) no-repeat;width: 14px;height: 14px;"></span> Категории
						</h3>
						<ul class="leftnav">
							<li>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
								<? } ?>
							</li>
						</ul>
					</div>
					<? } ?>
					<div class="block">
						<h3>
							<span style="background: url(/assets/Mamba/img/rand.png) no-repeat;width: 16px;height: 16px;" class="fa fa-credit-card"></span> Последние покупки
						</h3>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
						<? if(mysqli_num_rows($SQL1) > 0){ ?>
						<? $ITEM = mysqli_fetch_array($SQL1); ?>
						<div class="discount">
							<a href="/item/<?=$ITEM['item_id'];?>">
								<img style="width:204px; height:96px;" src="<?=$ITEM['image'];?>">
							</a>
							<div class="title"><?=$row['item'];?></div>
							<div class="sale">
								<span><?=$row['price'];?> <?=$row['wallet'];?></span>
							</div>
						</div>
						<? } ?>
						<? } ?>
						<? } else { ?>
						Нет покупок
						<? } ?> 
					</div>
				</div>