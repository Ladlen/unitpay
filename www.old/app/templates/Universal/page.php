		<? if(Defined('PID')){ ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $PAGE = mysqli_fetch_array($SQL); ?>
			<div class="h_content">
				<div class="h_title"><?=$PAGE['title'];?></div>
				<div class="over_cnt">
					<div class="cnt_in">
						<div class="goods-list with-clear">
							<?=$PAGE['body'];?>
						</div>
					</div>
				</div>
			</div>
		<? } ?>
		<? } ?>