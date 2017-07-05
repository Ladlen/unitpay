				<? include('leftMenu.php'); ?>
				<? include('rightMenu.php'); ?>
					<?
						# Сортировка по категориям
						if(Defined('CID')){
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC LIMIT 3");
						# Обычный вывод без сортировки
						} else {
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC LIMIT 3");
						}
					?>
					<div class="center">
						<div class="flexslider">
							<div class="flex-viewport" style="overflow: hidden; position: relative;"></div>
							<ul class="flex-direction-nav">
								<li><a class="flex-prev" href="#">Previous</a></li>
								<li><a class="flex-next" href="#">Next</a></li>
							</ul>
							<div class="flex-viewport" style="overflow: hidden; position: relative;">
								<? if(mysqli_num_rows($SQL) > 0){ ?>
								<ul class="slides" style="width: 2400%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
									<? while($row = mysqli_fetch_array($SQL)){ ?>
									<? $price = json_decode($row['price'], true); ?>
									<li class="clone" aria-hidden="true" style="width: 476px; float: left; display: block;">
										<div class="text">
											<span><a><?=$row['desc'];?></a></span>
										</div>
										<div class="discount">
											<span><?=$price['WMR'];?> р</span>
										</div>
										<a href="/item/<?=$row['item_id'];?>">
											<img style="height: 267px; width: 476px;" src="<?=$row['image'];?>">
										</a>
									</li>
									<? } ?>								
								</ul>
								<? } ?>	
							</div>
						</div>
						<script>
							(function($){
								$(function(){
									$('ul.tabs').on('click', 'li:not(.current)', function (){
										$(this).addClass('current').siblings().removeClass('current').parents('div.section').find('div.list_box').eq($(this).index()).fadeIn(0).siblings('div.list_box').hide();
									})
								})
							})(jQuery)
						</script>
						<div class="section">
							<ul class="tabs">
								<li class="current">Все товары</li>
							</ul>
							<div class="list_box visible">
								<?
									# Сортировка по категориям
									if(Defined('CID')){
										$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
									# Обычный вывод без сортировки
									} else {
										$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
									}
								?>
								<? if(mysqli_num_rows($SQL) > 0){ ?>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $price = json_decode($row['price'], true); ?>
								<a href="/item/<?=$row['item_id'];?>">
									<div class="item">
										<div class="img">
											<img width="151" height="72" src="<?=$row['image'];?>" />
										</div>
										<div style="margin-top:36px;" class="price"> <?=$price['WMR'];?>
											<i class="fa fa-rub" style="background: url(/assets/Mamba/img/rur.png) no-repeat;  width: 14px;  height: 16px;"></i>
										</div>
										<div class="cont">
											<h4> <?=$row['item'];?></h4>
										</div>
									</div>
								</a>
								<? } ?>
								<? } ?>								
							</div>
						</div>