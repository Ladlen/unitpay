	<div id="middle" class="cnt clr">
		<div id="content">
			<? if(Defined('PID')){ ?>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<? $PAGE = mysqli_fetch_array($SQL); ?>
			<div id="new-items" class="white-cnt">
				<h2 class="title">Страница </h2>
				<div class="goods-list with-clear">
					<?=$PAGE['body'];?>
				</div>
			</div>
			<? } else { ?>
			<div id="new-items" class="white-cnt">
				<h2 class="title">Страница </h2>
				<div class="goods-list with-clear">
					<center>
						<font color="red">Страница не сушествует.</font>
					</center>
				</div>
			</div>
			<? } ?>
			<? } ?>
		</div>
		<? include('leftMenu.php'); ?>
	</div>