	<? include('leftMenu.php'); ?>
	<? include('rightMenu.php'); ?>
	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<aside id="side-center">
		<div id="dle-content">
			<div class="speedbar">		
				<a href="/" class="home"></a>
				<span><?=$PAGE['title'];?></span>
			</div>
			<div class="buy-item">
				<div style="padding-left:10px; padding-right:10px;" class="buy-view">
					<?=$PAGE['body'];?>
				</div>
			</div>
		</div>    
	</aside>
	<? } ?>
	<? } ?>