	</div>
		<footer id="footer" role="contentinfo" class="clearfix">
			<div class="region region-footer">
				<section id="block-block-2" class="block block-block">
					<div class="content">
						<div class="footer_left"></div>
						<div class="footer_right"></div>  
					</div>
				</section>
			</div>
			<div id="footer_bootom" style="text-align:center;">
				<? if(COPYRIGHT == TRUE){ ?>
				<a href="https://shopsn.su/">Аренда онлайн магазинов - Shopsn.SU</a>
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