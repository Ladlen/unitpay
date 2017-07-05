	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div class="container-r">
		<div class="topitem">
			<div class="pageloop">
				<div class="pagetitle"><?=$PAGE['title'];?></div>
				<div class="pagecontent">
					<?=$PAGE['body'];?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<? } ?>
	<? } ?>