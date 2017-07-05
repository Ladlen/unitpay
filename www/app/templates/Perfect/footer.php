			</section>
			<div id="hFoot"></div>
		</div>
		<center>
			<footer id="footer">
				<div id="f-bot">
					<div id="f-capt">
						<? if(COPYRIGHT == TRUE){ ?>
						<span><a href="https://shopsn.su">Аренда онлайн магазинов - Shopsn.SU</a></span>
						<? } ?>
					</div>
				</div>
			</footer>
		</center>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>