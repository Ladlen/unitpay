			<footer id="footer">
				<div class="lcol">
					<div class="caption">
						<span class="ft c-item" style="float:right; padding-top: 5px; height: 30px; width: auto;">
							<span class="title" style="float: right; margin-right: -99px; max-width: 200px;">
								<? if(COPYRIGHT == TRUE){ ?>
								<a href="https://shopsn.su/">Аренда онлайн магазинов - Shopsn.SU</a>
								<? } ?>
							</span>
						</span>
					</div>
				</div>
				<script>if(getCookie('fon')){$('body').removeClass().addClass('background'+getCookie('fon'));$('#header').removeClass().addClass('header'+getCookie('fon'));}</script>
				<script src="/assets/Lite/js/scripts.js"></script>
				<script src="/assets/Lite/js/ajax.js"></script>
			</footer>
		</div>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>