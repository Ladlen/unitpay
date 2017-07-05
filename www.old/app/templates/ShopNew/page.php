	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
		<article class="content-page">
			<div class="page-title"><h1><?=$PAGE['title'];?></h1></div>
			<div class="page-content idesc">
				<?=$PAGE['body'];?>
			</div>
		</article>
	<? } else { ?>
		<center>
			<font color="red">Страницы не существует.</font>
		</center>
	<? } ?>