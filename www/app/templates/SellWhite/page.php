	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div class="other-goods" style="margin-bottom: 20px;">
		<h2><?=$PAGE['title'];?></h2>
	</div>
	<div class="goods3">
		<?=$PAGE['body'];?>
	</div>
	<? } else { ?>
		<center>
			<font color="red">Страницы не существует.</font>
		</center>
	<? } ?>
	<? } ?>