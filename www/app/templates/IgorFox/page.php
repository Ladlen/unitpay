	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div class="page">
		<h1><?=$PAGE['title'];?></h1>
		<?=$PAGE['body'];?>
	</div>
	<? } ?>
	<? } ?>