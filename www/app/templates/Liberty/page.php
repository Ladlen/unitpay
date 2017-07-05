	<div class="side_right">
		<div class="sider_center">
       		<aside class="sblock">
				<? if(Defined('PID')){ ?>
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<? $PAGE = mysqli_fetch_array($SQL); ?>
				<div class="sb_title">
					<i class="ics ic_04"></i> <?=$PAGE['title'];?>
				</div>
				<div class="sb_cont">
					<div class="layer">
						<?=$PAGE['body'];?>
					</div>
				</div>
				<? } ?>
				<? } ?>
			</aside> 
		</div>	 
		<? include('rightMenu.php'); ?>
	</div>
	<? include('leftMenu.php'); ?>