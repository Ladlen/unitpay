			</div>
		</div>
		<footer>
			<div class="navbar-inverse text-center copyright">
				<? if(COPYRIGHT == TRUE){ ?>
				<a href="https://shopsn.su" style="font-size: 12pt; color:white; position:relative; top:-3px;">Аренда онлайн магазинов - Shopsn.SU</a>
				<? } ?>
			</div>
		</footer>
		<a href="#top" class="back-top text-center" onclick="$('body,html').animate({scrollTop:0},500); return false" style="display: block;">
			<i class="fa fa-angle-double-up"></i>
		</a>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>