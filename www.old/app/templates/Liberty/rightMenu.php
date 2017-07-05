	<div class="sider_right">
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<aside class="sblock">
			<div class="sb_title"><i class="ics ic_05"></i> Последние покупки</div>
			<div class="sb_cont">
				<ul class="sb_list">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
					<? if(mysqli_num_rows($SQL1) > 0){ ?>
					<? $ITEM = mysqli_fetch_array($SQL1); ?>
					<li><a href="/item/<?=$ITEM['item_id'];?>"><span class="stitles"><?=$row['item'];?></span> <span class="sprice">(<?=$row['price'];?> <?=$row['wallet'];?>.)</span></a></li>
					<? } ?>
					<? } ?>
				</ul>
			</div>
		</aside>
		<? } ?>	
		<aside class="sblock">
			<div class="sb_title"><i class="ics ic_06"></i> Контакты</div>
			<div class="sb_cont">
				<ul class="sb_contacts">
					<?=CONTACTS;?>
				</ul>
			</div>
		</aside>
		<aside class="sblock">
			<div class="sb_title"><i class="ics ic_06"></i> Информация</div>
			<div class="sb_cont">
				<ul class="sb_contacts">
					<?=INFORMATION;?>
				</ul>
			</div>
		</aside>
	</div>