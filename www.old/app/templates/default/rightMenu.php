	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Контакты</h3>
					</div>
					<ul class="rmenu nav nav-pills nav-stacked">
						<?=CONTACTS;?>
					</ul>
				</div>
			</div>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Информация</h3>
					</div>
					<ul class="rmenu nav nav-pills nav-stacked">
						<?=INFORMATION;?>
					</ul>
				</div>
			</div>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Категории</h3>
					</div>
					<ul class="rmenu nav nav-pills nav-stacked">
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY cid DESC"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<li><a href="/item/<?=$row['name'];?>"><span class="glyphicon glyphicon-chevron-right"></span> <?=$row['category'];?></a></li>
						<? } ?>
						<? } else { ?>
						<div style="padding:15px; text-align:center;">
							<font color="<?=COLORDEFAULTTEXT;?>">Категории отсутствуют.</font>
						</div>
						<? } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Последние покупки</h3>
		</div>
		<div class="list-group">
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `status` = '1' AND `sid` = '".intval(SID)."' ORDER BY oid DESC LIMIT 3"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<? while($row = mysqli_fetch_array($SQL)){ ?>
			<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
			<? if(mysqli_num_rows($SQL1) > 0){ ?>
			<? $ITEM = mysqli_fetch_array($SQL1); ?>
			<a href="/item/<?=$ITEM['item_id'];?>" class="list-group-item">
				<span class="badge"><?=Date('d-m в H:i', $row['time']);?></span>
				<?=$row['item'];?>
			</a>
			<? } ?>
			<? } ?>
			<? } else { ?>
			<div style="padding:15px; text-align:center;">
				<font color="<?=COLORDEFAULTTEXT;?>">Еще никто нечего не покупал.</font>
			</div>
			<? } ?>
		</div>
	</div>