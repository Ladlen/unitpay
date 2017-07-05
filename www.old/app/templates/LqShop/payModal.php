<div class="modal fade" id="paymodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Оплата товара</h4>
            </div>
            <div class="modal-body">
                <table class="paytable">
                    <tr>
                        <td>Наименование продукта:</td>
                        <td class="payitem">...</td>
                    </tr>
                    <tr>
                        <td>Количество:</td>
                        <td class="paycount">...</td>
                    </tr>
                    <tr>
                        <td>К оплате:</td>
                        <td class="payprice">...</td>
                    </tr>
                    <tr>
                        <td>Кошелек для платежа:</td>
                        <td class="wallet">...</td>
                    </tr>
                    <tr>
                        <td>Примечание к платежу:</td>
                        <td class="paybill">...</td>
                    </tr>
<!--
                    <tr>
                        <td>Ваша скидка в %:</td>
                        <td id="copybill" class="discount">...</td>
                    </tr>
                    <tr>
                        <td>Ссылка для оплаты через WM:</td>
                        <td id="copybill" class="link">...</td>
                    </tr>
-->
                </table>
            </div>
            <div class="alert alert-danger">
                <span class="label label-important" style="background-color: rgb(204, 4, 0);">Внимание!</span>&nbsp;Очень важно чтобы вы переводили деньги с этим примечанием, иначе средства не будут зачислены автоматически.
            </div>
				<div class="payfoot modal-footer">
					<button type="button" onclick="" data-loading-text="Проверяем..." class="checkpaybtn btn btn-primary">Проверить</button>
				</div>
        </div>
    </div>
</div>

<div class="modal fade" id="setpaidway">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			  <h4 style="margin-left: 188px;" class="modal-title">Выберите способ оплаты</h4>
			</div>
			<div class="modal-body">
			<div style="margin-top:0px;margin-left:0px;width: 538px;">
            <? $wallets = json_decode(WALLETS, true); 
                  //  var_dump($wallets);
/*

array(10) { ["WMR"]=> bool(false) ["WMZ"]=> bool(false) ["WMU"]=> bool(false) ["WME"]=> bool(false) ["YAD"]=> string(15) "410012872268587" ["QIWI"]=> string(10) "7978888888" ["ROBOKASSA"]=> string(1) "0" ["FREEKASSA"]=> string(1) "0" ["PRIMEAREA"]=> string(1) "0" ["PAYEER"]=> string(1) "0" } 9999999 
 
 */ 


            ?>
            <? foreach($wallets as $name => $wallet){ ?>
		        <? if($wallet != false){ 
                ?>
			        <button onclick="wallet_name='<?=$name?>';setpaidway('<?=  $wallet ?>');setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" type="button" class="btn  btn-white btn-lg btn-block" style="padding: 5px;margin-top: 1px;">
                        <img src="./assets/img/pay/<?= strtolower($name == "YAD" ? "yandex" : $name);?>.png" style="height: 45px;margin-left: auto;margin-right: auto;">
                    </button>
                    <!--<button onclick="setpaidway(1);setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" type="button" class="btn  btn-white btn-lg btn-block" style="padding: 5px;margin-top: 1px;">
                        <img src="/assets/images/qiwi.png" style="height: 45px;margin-left: auto;margin-right: auto;">
                    </button>-->
                     <!-- было закоменчено    <button onclick='setpaidway(1);setEmail();'  id='setEmailButton' data-dismiss='modal' aria-hidden='true' data-toggle='modal'  type='button' class='btn  btn-white btn-lg btn-block' style='padding: 5px;margin-top: 1px;'><img src='/assets/images/sms.png' style='height: 45px;margin-left: auto;margin-right: auto;'></button> -->
                    <!--<button onclick="setpaidway(1);setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" type="button" class="btn  btn-white btn-lg btn-block" style="padding: 5px;margin-top: 1px;">
                        <img src="/assets/images/visamc.png" style="height: 45px;margin-left: auto;margin-right: auto;">
                    </button>
                    <button onclick="setpaidway(1);setEmail();" id="setEmailButton" data-dismiss="modal" aria-hidden="true" data-toggle="modal" type="button" class="btn  btn-white btn-lg btn-block" style="padding: 5px;margin-top: 1px;">
                        <img src="/assets/images/digiseller.png" style="height: 45px;margin-left: auto;margin-right: auto;">
                    </button>-->
                    <!--<button type="button" class="btn  btn-primary &nbsp;btn-block" aria-hidden="true" data-toggle="modal" data-target="#kupon" style="width: 538px;margin-top: 8px;color: rgb(255, 248, 220);font-size: 21px;font-weight: 100;padding: 0px;}">Ввод купона</button><p></p>-->
                <? } ?>
            <? } ?>
			<input name="emi" placeholder="E-mail поле обязательно для заполнения! Иначе не сможете купить!" class="form-control input-small" id="alert-box-email" style="text-align: center;width: 536px;margin-top: 5px;">
				<div id="cash"></div>
			</div>
			</div>
		  </div>
		</div>
	  </div>