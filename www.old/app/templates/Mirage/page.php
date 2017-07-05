	<? include('leftMenu.php'); ?>
	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
		<div class="middle_part">
			<div class="middle_part_in">
				<div class="info-tabs ui-tabs">
					<ul class="menu__products">
						<li><center><a><?=$PAGE['title'];?></a></li>
					</ul>
					<div class="detals" style="color:white; margin-left:20px;">
						<?=$PAGE['body'];?>
					</div>
				</div>
			</div>
		</div>	
	<? } ?>
	<? } ?>
	<? include('rightMenu.php'); ?>