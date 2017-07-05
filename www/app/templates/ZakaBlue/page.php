					<DIV class="center_div white_bg">
						<? if(Defined('PID')){ ?>
						<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
						<? if(mysqli_num_rows($SQL) > 0){ ?>
						<? $PAGE = mysqli_fetch_array($SQL); ?>
							<h2><?=$PAGE['title'];?></h2>
							<?=$PAGE['body'];?>
						<? } else { ?>
							<center>
								<font color="red">Страницы не существует.</font>
							</center>
						<? } ?>
						<? } ?>
					</DIV>
					<? include('rightMenu.php'); ?>
				</DIV>