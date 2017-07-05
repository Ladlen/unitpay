						<? if(!Defined("GID")){ ?>
						<div class="sider_right">
							<aside class="sblock">
								<p class="sb_title"> Информация</p>
								<div class="sb_cont">
									<?=INFORMATION;?>
								</div>
							</aside>
							<aside class="sblock">
								<p class="sb_title"> Контакты</p>
								<div class="sb_cont">
									<?=CONTACTS;?>
								</div>
							</aside>
						</div>
						<? } ?>
					</div>
					<div class="side_left">
						<aside class="sblock">
							<p class="sb_title"> Категории</p>
							<div class="sb_cont">
								<ul class="b_nav">
									<li><a class="layer" style="color:#75afcc; color: rgb(255, 255, 255)" href="/">Список всех товаров</a></li>
									<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
									<? if(mysqli_num_rows($SQL) > 0){ ?>
										<? while($row = mysqli_fetch_array($SQL)){ ?>
										<li><a class="layer" style="color:#75afcc; color: rgb(255, 255, 255)" href="/item/<?=$row['name'];?>"><?=$row['category'];?></a></li>
										<? } ?>
									<? } ?>
								</ul>
							</div>
						</aside>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<aside class="sblock">
							<p class="sb_title">Последние покупки</p>
							<div class="sb_cont">
								<ul class="sb_items">
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
								<? if(mysqli_num_rows($SQL1) > 0){ ?>
								<? $ITEM = mysqli_fetch_array($SQL1); ?>
								<li>
									<a href="/item/<?=$ITEM['item_id'];?>">
										<span class="i_price"><?=$row['price'].' '.$row['wallet'];?>.</span>
										<span class="titles"><span><?=$row['item'];?></span></span>
										<span class="pict"><img src="<?=$ITEM['image'];?>" alt="" /></span>
									</a>
								</li>
								<? } ?>
								<? } ?>
								</ul>
							</div>
						</aside>
						<? } ?>
					</div>
					<div class="bg_layer"></div>
				</div>
				<footer class="f_bottom">
					<div class="f_desc">
						<? if(COPYRIGHT == TRUE){ ?>
						<center>
							<a href="https://shopsn.su" style="color: white; position: relative; top: 0px;">Аренда онлайн магазинов - Shopsn.SU</a>
						</center>
						<? } ?>
					</div>
				</footer>
			</div>
		</div>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>