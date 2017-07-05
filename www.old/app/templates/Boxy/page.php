	<? include('leftMenu.php'); ?>
	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div id="dle-content">
		<style>
			ul.tabNavigation {
				list-style: none;
				margin-left: 20px;
				padding: 0;
			}
			 
			ul.tabNavigation li {
				display: inline;
			}
			 
			ul.tabNavigation li a {
				padding: 24px 18px 6px 18px;
				color: #000;
				text-decoration: none;
			}
			 
			ul.tabNavigation li a.selected,
			ul.tabNavigation li a.selected:hover {
				background: rgba(177, 182, 184, 0.24);
				color: #000;
				border-radius: 4px;
			}
			 
			ul.tabNavigation li a:hover {
				background: rgba(177, 182, 184, 0.24);
				color: #000;
				border-radius: 4px;
				-webkit-transition: all ease .9s;
				-moz-transition: all ease .9s;
				-ms-transition: all ease .9s;
				-o-transition: all ease .9s;
				transition: all ease .9s;    
			}
			 
			ul.tabNavigation li a:focus {
				outline: 0;
			}
			 
			div.tabs div h2 {
				margin-top: 0;
			}
		</style>
		<div class="breadcrumb">
			<a href="/">Главная</a>
			<div class="crumb"></div>
			<a><?=$PAGE['title'];?></a>
		</div><br>
		<h1 itemprop="name"><?=$PAGE['title'];?></h1>
		<div class="big-info">
			<div class="inf-left">
				<div id="goods">
					<nav class="main-tabs" style="width: 787px;margin-top: 10px;">
						<div class="op">Описание</div>
						<div class="info"><p><?=$PAGE['body'];?></p></div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<? } else { ?>
		<center>
			<font color="red">Страницы не существует.</font>
		</center>
	<? } ?>
	<? } ?>