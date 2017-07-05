				<div class="left">
					<div class="ttttttteees">
						<ul class="menu">
							<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
							<? if(mysqli_num_rows($SQL) > 0){ ?>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<li><a href="/item/<?=$row['name']?>"><?=$row['category'];?></a></li>
								<? } ?>
							<? } ?>
							<div style="margin-top:20px;overflow: hidden;width: 160px;">
								<div style="text-transform: none;font-weight: normal;">
									Контакты
									<hr/>
									<?=CONTACTS;?>
								</div>
							</div>
							<div style="margin-top:20px;overflow: hidden;width: 160px;">
								<div style="text-transform: none;font-weight: normal;">
									Информация
									<hr/>
									<?=INFORMATION;?>
								</div>
							</div>
						</ul>
						<div class="clear"></div>
					</div>
				</div>