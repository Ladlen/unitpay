			<? if(Defined('PID')){ ?>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<? $PAGE = mysqli_fetch_array($SQL); ?>
			<article class="page-full">
				<div class="block-title"><span><?=$PAGE['title'];?></span></div>
				<div class="block-wrap idesc">
					<div class="page-heads">
						<h1><?=$PAGE['title'];?></h1>
					</div>
					<center>
					<?=$PAGE['body'];?>
					</center>
				</div>
			</article>
			<? } ?>
			<? } ?>