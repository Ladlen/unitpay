		</div>
		<footer class="main-footer" style="background: none; height: 50px;">
			<? if(COPYRIGHT == TRUE){ ?>
			<center>
				<a href="https://shopsn.su" style="color: white; position: relative; top: 5px;">Аренда онлайн магазинов - Shopsn.SU</a>
			</center>
			<? } ?>
		</footer>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
		<?=INFORMATION;?>
	</body>
</html>