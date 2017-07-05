			<? if(Defined('PID')){ ?>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<? $PAGE = mysqli_fetch_array($SQL); ?>
			<center>
				<div class="layer" style="color: white; margin-top: 10px;">
					<div class="panel">
						<div class="panel-heading">
							<h1 class="panel-title"> <?=$PAGE['title'];?></h1>
						</div>
						<hr />
						<div class="panel-body">
							<p style="text-align: center;"><?=$PAGE['body'];?></p>
						</div>
					</div> 
				</div>
			</center>
			<? } ?>
			<? } ?>