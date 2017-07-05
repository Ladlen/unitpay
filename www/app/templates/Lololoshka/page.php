	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<div class="wrapper">	
		<section class="container">
			<h2 class="goods_title-wrap"><?=$PAGE['title'];?></h2>
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
				<aside class="aside">
				<? while($row = mysqli_fetch_array($SQL)){ ?>
				<a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
				<? } ?>
				</aside>
			<? } ?>
			<div class="catalog goods page">
				<div class="goods_left">
					<?=$PAGE['body'];?>
				</div>
			</div>
		</section>
	</div>
	<? } ?>
	<? } ?>