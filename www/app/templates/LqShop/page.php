	<? if(Defined("CAT")){ ?>
	<style>
		.pubbody {
			z-index: 5;
			float: left;
			height:150px;
		}
		.pbbg {
			width:100%;
			height:150px;
			position: absolute;
			z-index: 100;
			overflow: hidden;
			background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.01) 1%, rgba(255,255,255,1) 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(1%,rgba(255,255,255,0.01)), color-stop(100%,rgba(255,255,255,1))); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* IE10+ */
			background: linear-gradient(to bottom,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */

		}
		.pubmain {
			position: relative;
		}
	</style>
	<? 
		# Все публикации
		if(CAT == "p"){
			# Количество публикаций
			$COUNT = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT COUNT(pid) FROM `pages` WHERE `sid` = '".intval(SID)."'"));
			# Запрос по страницам
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `sid` = '".intval(SID)."' ORDER BY pid DESC LIMIT ".((PID-1) * 5).", 5");
			# Публикации отсутствуют
			if(mysqli_num_rows($SQL) == 0){
	?>
	<div class="panel-heading" style="padding:15px; text-align:center;">
		<font color="red">Публикации отсутствуют.</font>
	</div><br />
	<?
			}
		}
	?>
	<div class="col-lg-12">
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? while($row = mysqli_fetch_array($SQL)){ ?>
		<article class="pubmain search-result row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h4><a href="/page/<?=$row['pid'];?>" title=""><?=$row['title'];?></a></h4>
				<div class="pubbody">
					<?=$row['body'];?>
				</div>
				<div class="pbbg"></div>
			</div>
			<span class="clearfix"></span>
			<div style="margin-bottom:10px;" class="pull-right">
				<a href="/page/<?=$row['pid'];?>" class="btn btn-primary">Подробнее</a>
			</div>
			<span class="clearfix border"></span>
		</article>
		<? } ?>
		<div class="text-center col-lg-12">
			<ul class="pagination">
				<?
					# Количество страниц
					$pages = ($COUNT[0] > 5 ? ($COUNT[0] / 5) : '1');
					$round = round($pages);
					$test = ($pages > $round ? $pages : $round) - ($pages < $round ? $pages : $round);
					$pages = ($test > 0 ? (round($pages) + 2) : round($pages) + 1);
					# Выведем Paginator
					for($i = 1; $i < $pages; $i++){
						# Назад
						if($i == 1) echo '<li '.($i == PID ? 'class="disabled"' : '').'><a '.($i == PID ? '' : 'href="/page/'.CAT.'/'.(PID - 1).'"').'>«</a></li>';
						# Страницы
						echo '<li '.($i == PID ? 'class="disabled"' : '').'><a '.($i == PID ? '' : 'href="/page/'.CAT.'/'.$i.'"').'>'.$i.'</a></li>';
						# Вперед
						if($i == ($pages - 1)) echo '<li '.($i == PID ? 'class="disabled"' : '').'><a '.($i == PID ? '' : 'href="/page/'.CAT.'/'.(PID + 1).'"').'>»</a></li>';
					}
				?>
			</ul>
		</div>
		<? } ?>
	</div>
	<? } else if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<div class="panel">
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? $row = mysqli_fetch_array($SQL); ?>
		<div class="panel-heading">
			<h3 class="panel-title"> <?=$row['title'];?></h3>
		</div>
		<div class="panel-body">
			<?=$row['body'];?>
		</div>
		<? } else { ?>
		<div class="panel-heading">
			<center>
				<font color="red">Новость отсутствует в базе данных.</font>
			</center>
		</div>
		<? } ?>
	</div>
	<? } ?>
    </div> <!-- close div.col-lg-8-->
 <style>
	body {
    	background-image: url(<?=BACKGROUND;?>);
	}
</style>
<? include('rightMenu.php'); ?>
</div> <!-- close div.maincont-->