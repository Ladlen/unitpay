	<div class="modal fade" id="paymodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Оплата</h4>
				</div>
				<div class="modal-body">
					<table class="paytable">
						<tr>
							<td>Товар:</td>
							<td class="payitem">...</td>
						</tr>
						<tr>
							<td>Кол-во:</td>
							<td class="paycount">...</td>
						</tr>
						<tr>
							<td>К оплате:</td>
							<td class="payprice">...</td>
						</tr>
						<tr>
							<td>Кошелек для платежа:</td>
							<td id="copywallet" class="copyitem paywallet">...</td>
						</tr>
						<tr>
							<td>Примечание к платежу:</td>
							<td id="copybill" class="copyitem paybill">...</td>
						</tr>
					</table>
				</div>
				<div class="alert alert-danger">
					<strong>Обязательно</strong> переводите деньги именно с таким примечанием!
				</div>
				<div class="payfoot modal-footer">
					<button type="button" onclick="" data-loading-text="Проверяем..." class="checkpaybtn btn btn-primary">Проверить</button>
				</div>
			</div>
		</div>
	</div>