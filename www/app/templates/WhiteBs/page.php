	<div class="col-lg-9 col-md-9 col-sm-12">
		<div class="layer">
			<div class="box padding">
				<? if(Defined('PID')){ ?>
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<? $PAGE = mysqli_fetch_array($SQL); ?>
					<h3><a href=""><?=$PAGE['title'];?></a></h3>
					<div class="text-blog"><?=$PAGE['body'];?></div>
				<? } else { ?>
					<center>
						<font color="red">Страницы не существует.</font>
					</center>
				<? } ?>
				<? } ?>
			</div>
		</div>  
	</div>