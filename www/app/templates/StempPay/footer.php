			</div>
			<aside id="sidebar-left">
				<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
				<? if(mysqli_num_rows($SQL) > 0){ ?>
				<div class="block">
					<div class="title">По категориям:</div>
					<ul class="list">
						<? while($row = mysqli_fetch_array($SQL)){ ?>
						<li><a href="/item/<?=$row['name'];?>"><?=$row['category'];?></a></li>
						<? } ?>
					</ul>
				</div>
				<? } ?>
				<div class="block" style="color: white;">
					<div class="title" style="width: auto;">Контакты:</div>
					<?=CONTACTS;?>
				</div>
				<div class="block" style="color: white;">
					<div class="title" style="width: auto;">Информация:</div>
					<?=INFORMATION;?>
				</div>
			</aside>
			<div class="clear"></div>
		</div>
	</div>
	<footer>
		<div style="float: left; margin-top: 10px; text-align: center; width: 755px;">
			<? if(COPYRIGHT == TRUE){ ?>
			<a href="https://shopsn.su" style="color:white; position:relative; top:2px;">Аренда онлайн магазинов - Shopsn.SU</a>
			<? } ?>
		</div>
	</footer>
	<?
		if(Defined("SCRIPTS")){
			echo SCRIPTS;
		}
	?>
</body>
</html>