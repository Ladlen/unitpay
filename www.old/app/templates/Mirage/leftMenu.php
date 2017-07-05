	<div class="left_part">
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<div class="block">
			<div class="h3">Категории</div>
			<div class="categories">
				<ul>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li><a href="/item/<?=$row['name']?>"><?=$row['category'];?></a></li>
					<? } ?>
				</ul>
			</div>
		</div>
		<? } ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<div class="block">
			<div class="h3">Последние покупки</div>
			<div class="categories">
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
				<? if(mysqli_num_rows($SQL1) > 0){ ?>
				<? $ITEM = mysqli_fetch_array($SQL1); ?>
				<center style="color:white;">
					Цена: <?=$row['price'].' '.$row['wallet'];?><br />
				</center>
				<div class="poster-shadw"></div>
				<a href="/item/<?=$ITEM['item_id'];?>">
					<img src="<?=$ITEM['image'];?>" width="218" height="120" />
				</a>
				<? } ?>
				<? } ?>
			</div>
		</div>
		<? } ?>
	</div>