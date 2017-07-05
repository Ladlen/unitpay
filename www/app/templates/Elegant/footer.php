			<footer class="cnt">
				<div class="white-cnt">
					<div class="clr">
						<div class="f-block">
							<div class="f-block-title">Информация</div>
							<?=INFORMATION;?>
						</div>
						<div class="f-block">
							<div class="f-block-title">Контакты</div>
							<?=CONTACTS;?>
						</div>
					</div>
					<div class="copyrights" style="text-align:center;">
						<? if(COPYRIGHT == TRUE){ ?>
						<a href="https://shopsn.su">Аренда онлайн магазинов - Shopsn.SU</a>
						<? } ?>
					</div>
				</div>
			</footer>
		</div>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>