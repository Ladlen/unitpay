	<div class="item-full">
		<div id="brifly" class="clients two_column">
			<? if(Defined('PID')){ ?>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<? $PAGE = mysqli_fetch_array($SQL); ?>
				<div class="name_page"><?=$PAGE['title'];?></div>  
				<div class="description">
					<div class="rewiew">
						<?=$PAGE['body'];?>
					</div>  
				</div>
			<? } else { ?>
				<center>
					<font color="red">Страницы не существует.</font>
				</center>
			<? } ?>
			<? } ?>
			<? include('rightMenu.php'); ?>
		</div>
	</div>