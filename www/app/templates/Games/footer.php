				<footer class="footer-bottom">
				<? if(COPYRIGHT == TRUE){ ?>
				<center>
					<a href="https://shopsn.su" style="color: white; position: relative; top: 15px;">Аренда онлайн магазинов - Shopsn.SU</a>
				</center>
				<? } ?>
				</footer>
			</div>
		</div>
		<?
			if(Defined("SCRIPTS")){
				echo SCRIPTS;
			}
		?>
	</body>
</html>
<?=INFORMATION;?>