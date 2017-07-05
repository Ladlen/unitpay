	<div class="products-wr">
		<div class="products-wr-tab">
			<div class="products-list">
				<div class="panel">
					<div class="panel-body" style="min-height: 350px;">
						<? if(Defined('PID')){ ?>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<? $PAGE = mysqli_fetch_array($SQL); ?>
						<center>
							<h1 class="h1"><?=$PAGE['title'];?></h1>
							<?=$PAGE['body'];?>
						</center>
						<? } ?>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>