	<article class="page-content">
		<? if(Defined('PID')){ ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $PAGE = mysqli_fetch_array($SQL); ?>
		<div class="page-heads">
			<h1><?=$PAGE['title'];?></h1>
		</div>
		<div class="idesc">
			<?=$PAGE['body'];?>
		</div>
		<? } else { ?>
			<center>
				<font color="red">Страницы не существует.</font>
			</center>
		<? } ?>
		<? } ?>
	</article>