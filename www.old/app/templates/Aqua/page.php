	<? include('leftMenu.php'); ?>
	<? include('rightMenu.php'); ?>
	<aside id="side-center">
		<? if(Defined('PID')){ ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $PAGE = mysqli_fetch_array($SQL); ?>
		<div class="full-content">
			<div class="lcol">
				<div class="b-top yellow"><?=$PAGE['title'];?></div>
				<div id="full-item-info">
					<div class="tab-box cur" style="display: block;">
						<?=$PAGE['body'];?>
					</div>
					<hr />
				</div>
			</div>
		</div>
		<? } ?>
		<? } ?>
	</aside>