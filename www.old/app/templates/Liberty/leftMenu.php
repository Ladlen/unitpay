	<div class="side_left">
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<aside class="sblock">
			<div class="sb_title"><i class="ics ic_01"></i> Категории</div>
			<div class="sb_cont">
				<ul class="sb_list">
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<li class="layer"><a href="/item/<?=$row['name']?>"><?=$row['category'];?></a></li>
					<? } ?>
				</ul>
			</div>
		</aside>
		<? } ?>
	</div>