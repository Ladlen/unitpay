	<div class="sider_center">
		<? if(Defined('PID')){ ?>
		<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $PAGE = mysqli_fetch_array($SQL); ?>
		<div class="cblock">
			<div class="cb_title"> 	
				<div class="cb_titl">
					<h1><?=$PAGE['title'];?></h1>
					<ul class="speedbar">
						<li><a href="/">Главная страница</a></li>
						<li><a href="page/<?=$PAGE['pid'];?>"><?=$PAGE['title'];?></a></li>
					</ul>
				</div>
			</div>
			<div class="vf_tab">
				<ul class="vf_tabs">
					<li class="current"><a href="#">ОПИСАНИЕ</a></li>
				</ul>
				<div style="display: block;" class="vf_desc current">
					<p><?=$PAGE['body'];?></p>
				</div>
			</div>
		</div>
		<? } ?>
		<? } ?>
	</div>
	</div>
	</div>
	</div>
	<? include('rightMenu.php'); ?>
	</div>
	<? include('leftMenu.php'); ?>