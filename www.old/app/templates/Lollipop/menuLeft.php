				<aside id="side-left" style="position: relative; left: -4px; top: -14px;">
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="left-box">
						<div class="block-top">Категории</div>
						<ul class="b-nav">
							<? while($row = mysqli_fetch_array($SQL)){ ?>
							<li class="layer"><a href="/item/<?=$row['name']?>"><?=$row['category'];?></a></li>
							<? } ?>
						</ul>
					</div>
					<? } ?>
					<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<div class="left-box">
						<div class="block-top">Последние покупки</div>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
						<? if(mysqli_num_rows($SQL1) > 0){ ?>
						<? $ITEM = mysqli_fetch_array($SQL1); ?>
						<div class="item-poster">
							<div class="coast">Цена: <?=$row['price'].' '.$row['wallet'];?></div>
							<div class="name"><a href="/item/<?=$ITEM['item_id'];?>"><?=$row['item'];?></a></div>
							<div class="poster-shadw"></div>
							<img src="<?=$ITEM['image'];?>" />
						</div>
						<? } ?>
						<? } ?>
					</div>
					<? } ?>
				</aside>