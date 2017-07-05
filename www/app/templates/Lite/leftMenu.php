	<aside class="side-left">
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<div class="block">
			<div class="block-top">Разделы магазина</div>
			<div class="block-cont">
				<ul class="b-nav">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li><a href="/item/<?=$row['name']?>"><?=$row['category'];?></a></li>
					<? } ?>
					<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."'"); ?>
					<? while($row = mysqli_fetch_array($SQL1)){ ?>
					<li><a href="/page/<?=$row['pid'];?>"><?=$row['title'];?></a></li>
					<? } ?>
				</ul>
			</div>
		</div> 
		<? } ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 4"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<div class="block">
			<div class="block-top">Последние покупки</div>
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
			<? if(mysqli_num_rows($SQL1) > 0){ ?>
			<? $ITEM = mysqli_fetch_array($SQL1); ?>
			<div class="block-cont">
				<a href="/item/<?=$ITEM['item_id'];?>" class="b-item">
					<span class="coast"><?=$row['price'].' '.$row['wallet'];?></span>
					<span class="title"><?=$row['item'];?></span>
					<img src="<?=$ITEM['image'];?>" />
				</a>
			</div>
			<? } ?>
			<? } ?>
		</div>
		<? } ?>
	</aside>