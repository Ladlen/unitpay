			</div>
		</main>
		<footer>
			<div class="copy">
				<? if(COPYRIGHT == TRUE){ ?>
				<center>
					<a href="https://shopsn.su" style="color: white; position: relative; top: 15px;">Аренда онлайн магазинов - Shopsn.SU</a>
				</center>
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