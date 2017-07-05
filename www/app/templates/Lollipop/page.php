	<? include('menuLeft.php'); ?>
	<div class="layer">
		<div id="content">
			<div id="content-c" style="width: 605px;">
				<? if(Defined('PID')){ ?>
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<? $PAGE = mysqli_fetch_array($SQL); ?>
				<div class="layer">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"> <?=$PAGE['title'];?></h3>
						</div>
						<div class="panel-body">
							<p style="text-align: center;"><?=$PAGE['body'];?></p>
						</div>
					</div> 
				</div>
				<? } ?>
				<? } ?>
			</div>
			<? include('menuRight.php'); ?>
		</div>
	</div>