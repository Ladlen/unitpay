				</div>
			</div>
			<footer>
			
				<footer class="footer-bottom">
					<div class="wrapper">
						<div class="footer-desc idesc">
							<? if(COPYRIGHT == TRUE){ ?>
							<a href="https://shopsn.su" style="font-size: 12pt; color:white; position:relative; top:-3px;">Аренда онлайн магазинов - Shopsn.SU</a>
							<? } ?>
						</div>
					</div>
				</footer>
			</footer>
		</div>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>
<?=INFORMATION;?>