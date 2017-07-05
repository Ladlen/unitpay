	<? include('leftMenu.php'); ?>
	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div class="information">
		<div class="section">
			<div style="margin-right: 0px;" class="center2">
				<div class="cont">
					<div style="height: 270px;">
						<h1 style="margin-top: 8px; margin-left: 13px; color: #45b29d; font-size: 18px; line-height: 29px; font-weight: bold;"><?=$PAGE['title'];?></h1>
						<div style="background: rgba(69, 178, 157, 0.09); padding: 4px 7px; color: #59545E;">
							<?=$PAGE['body'];?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<? } ?>
	<? } ?>