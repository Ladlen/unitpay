	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div id="middle">
		<div>
			<h2 class="good-title">
				<span><?=$PAGE['title'];?></span>
			</h2>
			<div class="cnt">
				<div id="tabs">
					<div id="tabsHead">
						<a>Описание</a>
					</div>
					<div id="tabDescrC" class="tabsCnt">
						<?=$PAGE['body'];?>
					</div>
				</div>
			</div> 
		</div>
	</div> 
	<? } ?>
	<? } ?>