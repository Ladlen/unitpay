	<? include('leftMenu.php'); ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<aside id="side-center">
		<div class="block-title1">
			<center>Страница</center>
		</div>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $PAGE = mysqli_fetch_array($SQL); ?>
		<div style="margin-top: 5px;" class="product-info">
			<div class="fleft left spacing">
				<div class="extra-wrap">
					<div>
						<div class="tab-box cur" style="font-size: 20px; display: block;">
							<center>
								<h2><span><?=$PAGE['title'];?></span></h2>
							</center>
						</div>
						<div class="tab-box cur" style="display: block;">
							<center>
								<span><?=$PAGE['body'];?></span>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
		<? } else { ?>
			<center>
				<font color="red">Страницы не существует.</font>
			</center>
		<? } ?>
	</aside>