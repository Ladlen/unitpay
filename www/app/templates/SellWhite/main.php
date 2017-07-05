			<div class="other-goods">
				<h2>ВСЕ ТОВАРЫ</h2>
			</div>
			<div class="left">
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<ul class="menu">
					<li style="color: #f50062;">Категории</li>
					<ul>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<li><a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a></li>
						<? } ?>
					</ul>
				</ul>
				<? } ?>
				<ul class="menu">
					<li style="color: #f50062;">Контакты</li>
					<ul>
						<?=CONTACTS;?>
					</ul>
				</ul>
				<ul class="menu">
					<li style="color: #f50062;">Информация</li>
					<ul>
						<?=INFORMATION;?>
					</ul>
				</ul>
			</div>
			<div class="right">
				<?
					# Сортировка по категориям
					if(Defined('CID')){
						$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
					# Обычный вывод без сортировки
					} else {
						$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
					}
				?>
				<div class="rows">
					<? if(mysqli_num_rows($SQL) > 0){ ?>
					<? while($row = mysqli_fetch_array($SQL)){ ?>
					<? $price = json_decode($row['price'], true); ?>
					<div class="row">
						<div class='img'><a href="/item/<?=$row['item_id'];?>">
							<span class="digiseller-vitrinaicon ">&nbsp;</span>
							<img class="lazy img" height="117px" width="250px" src="<?=$row['image'];?>">
							</a>
						</div>
						<div class="row-info">
							<div class="title"><a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a></div>
							<div class="price"><?=$price['WMR'];?> руб.</div>
						</div>
					</div>
					<? } ?>
					<? } else { ?>
					<center>
						<font color="red">Товаров нет.</font>
					</center>
					<? } ?>
				</div>
			</div>