	<aside id="side-left">
		<div class="block">
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<div class="block">
				<div class="top">Разделы магазина</div>
				<div class="cont">
					<ul class="b-nav">
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<li class="layer"><a href="/item/<?=$row['name']?>"><?=$row['category'];?></a></li>
						<? } ?>
					</ul>
				</div>
			</div>
			<? } ?>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<div class="block">
				<div class="top">Последние покупки</div>
				<ul class="topsale">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
					<? if(mysqli_num_rows($SQL1) > 0){ ?>
					<? $ITEM = mysqli_fetch_array($SQL1); ?>
					<div class="b-poster" style="margin-left: -6px;">
						<div class="coast lpsn"><?=$row['price'];?> <i><?=$row['wallet'];?>.</i></div>
						<div class="title"><p><?=$row['item'];?></p></div>
						<a href="/item/<?=$ITEM['item_id'];?>"><img src="<?=$ITEM['image'];?>" height="108" width="188"></a>
					</div>
					<? } ?>
					<? } ?>
				</ul>
			</div>
			<? } ?>
		</div>
	</aside>