			</div>
			<div class="footer">
				<div class="image_area">
					<img src="/assets/Mirage/img/img_footer.png" />
				</div>
				<div class="bottom" style="text-align:center;">
					<? if(COPYRIGHT == TRUE){ ?>
					<a href="https://shopsn.su" style="color:white; position:relative; top:10px;">Аренда онлайн магазинов - Shopsn.SU</a>
					<? } ?>
				</div>
			</div>
		</div>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>