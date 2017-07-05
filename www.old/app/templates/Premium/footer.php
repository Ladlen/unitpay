		<footer>
			<div id="footer_container">
				<div id="footer_top">
					<div id="footer_logo"></div>
					<ul>
						<li><a href="/">Главная</a></li>
						<li id="goTop" title="Вверх!"></li>
					</ul>
				</div>
				<div id="footer_bottom" style="text-align:center;">
					<div class="footer_block">
						<? if(COPYRIGHT == TRUE){ ?>
						<a href="https://shopsn.su">Аренда онлайн магазинов - Shopsn.SU</a>
						<? } ?>
					</div>
				</div>
		</footer>
		<script src="/assets/Premium/js/slider.js"></script>
		<script>
			$("#slider").easySlider({
				auto: true,
				continuous: true,
				numeric: true,
				pause: 4000
			});
		</script>
		<script src="/assets/Premium/js/ui.js"></script>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>