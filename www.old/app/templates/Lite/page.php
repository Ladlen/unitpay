	<div id="container">
		<? include('leftMenu.php'); ?>
		<? if(Defined('PID')){ ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $PAGE = mysqli_fetch_array($SQL); ?>
		<aside class="side-middle">
			<div class="speedbar">
				<a href="/" class="home"></a>
				<span class="green"><?=$PAGE['title'];?></span>
			</div>
			<ul class="tab-nav">
				<li class="cur" style="float: left;"><span>Описание</span></li>
			</ul>
			<div class="tab-box cur" style="width: 100%;">
				<?=$PAGE['body'];?>
			</div>	
		</aside>
		<? } ?>
		<? } ?>
	</div>