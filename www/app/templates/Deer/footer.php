	</div>
	<footer id="footer">
		<div class="container">
			<? if(COPYRIGHT == TRUE){ ?>
			<div class="text-muted"><a href="https://shopsn.su/">Аренда онлайн магазинов - Shopsn.SU</a></div>
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