				<DIV class="footer" style="height: 55px;">
					<DIV class="copy" style="width: 950px; text-align: center;">
						<? if(COPYRIGHT == TRUE){ ?>
						<a href="https://shopsn.su" style="color:white; position:relative; top:2px;">Аренда онлайн магазинов - Shopsn.SU</a>
						<? } ?>
					</DIV>
				</DIV>
			</DIV>
		</DIV>
		<script>
			$("#slider").easySlider({auto: true});
		</script>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</BODY>
</HTML>