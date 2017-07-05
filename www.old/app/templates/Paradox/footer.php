				</section>
			<div id="hFoot"></div>
		</div>
		<script>
			$(document).ready(function(){
				$('#footer').show();
			});
		</script>
        <footer id="footer" style="text-align: center;">
			<? if(COPYRIGHT == TRUE){ ?>
			<a href="https://shopsn.su" style="color: white;">Аренда онлайн магазинов - Shopsn.SU</a>
			<? } ?>
        </footer>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>