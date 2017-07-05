			</div>
			<div class="col-lg-4">
				<? include('rightMenu.php'); ?>
			</div>
		</div>
		<div class="row foot">
			<div class="col-lg-12">
				<? if(COPYRIGHT == TRUE){ ?>
				<span class="footcopy"><a href="https://shopsn.su">Аренда онлайн магазинов - Shopsn.SU</a></span>
				<? } ?>
			</div>
		</div>
	</div>
	<div id="loading"></div>
	<?
		if(Defined("SCRIPTS")){
			echo SCRIPTS;
		}
	?>
  </body>
</html>