	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Настройки</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['settings'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<ul class="breadcrumb" style="overflow: auto; height: 90%;">
		<center>
			<legend>Настройка методов оплаты</legend>
		</center>
		<?
			# Парсим методы оплаты
			$WALLET = json_decode(WALLETS, true);
			# Парсим настройки
			$obj = json_decode(SETTINGS, true);
		?>
		<?
			if(isset($_SESSION['err'])){
		?>
		<div class="alert alert-danger">
			<?=$_SESSION['err'];?>
		</div>
		<?
				unset($_SESSION['err']);
			}
		?>
		<form action="/admin/settings" method="post" accept-charset="utf-8" enctype="multipart/form-data">
			<table class="table table-bordered table-striped">
				<tbody>
					<tr>
						<td>Ключевые слова для поисковиков < meta name="keywords">:</td>
						<td><input name="settings[keywords]" value="<?=(isset($obj['keywords']) ? $obj['keywords'] : "Ключевые слова для поиска в интернете");?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Описание сайта для поисковиков < meta name="description">:</td>
						<td><input name="settings[description]" value="<?=(isset($obj['description']) ? $obj['description'] : "Описание для поисковика");?>" class="form-control" type="text"></td>
					</tr>

					<tr>
						<td>Префикс примечания (bill[]):</td>
						<td><input name="settings[prefix]" value="<?=(isset($obj['prefix']) ? $obj['prefix'] : "bill");?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Яндекс (Client ID):</td>
						<td><input name="settings[yad_client_id]" value="<?=$obj['yad_client_id'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Яндекс (Token):</td>
						<td><input name="settings[yad_token]" value="<?=$obj['yad_token'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Яндекс (Кошелёк):</td>
						<td><input name="wallets[YAD]" value="<?=$WALLET['YAD'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>QIWI (Номер без +):</td>
						<td><input name="wallets[QIWI]" value="<?=$WALLET['QIWI'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>QIWI (Пароль): <sub>обязательно для работы <b>QIWI</b> оплаты</sub></td>
						<td><input name="settings[qiwi_pass]" value="<?=($obj['qiwi_pass'] != "" ? "********" : "");?>" class="form-control" type="password"></td>
					</tr>
					<tr>
						<td>WMID:</td>
						<td><input name="settings[wmid]" value="<?=$obj['wmid'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>WMR:</td>
						<td><input name="wallets[WMR]" value="<?=$WALLET['WMR'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>WMZ:</td>
						<td><input name="wallets[WMZ]" value="<?=$WALLET['WMZ'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>WMU:</td>
						<td><input name="wallets[WMU]" value="<?=$WALLET['WMU'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>WME:</td>
						<td><input name="wallets[WME]" value="<?=$WALLET['WME'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Пароль от ключ-файла:</td>
						<td><input name="settings[wm_pass]" value="<?=($obj['wm_pass'] != "" ? "********" : "");?>" class="form-control" type="password"></td>
					</tr>
					<tr>
						<td>Ключ-файл:<sub>обязательно для работы <b>WEBMONEY</b> оплаты</sub></td>
						<td>
							<? if($obj['wm_key'] != false){ ?>
							<span class="label label-info" style="padding: 4px;"><?=Date("d.m.Y H:i:s", $obj['wm_key']);?></span>
							<input value="Удалить ключ" class="btn btn-mini btn-danger" type="button" onclick="location.href = '/admin/settings/key';" style="margin-top: -1.32px;">
							<? } else { ?>
							<input name="settings[wm_key]" size="20" class="form-control" type="file">
							<? } ?>
						</td>
					</tr>
					<tr>
						<td>
							Free-Kass'a включена? <br />
							<a href="http://shopsn.su/faq/" target="_blank">Как настроить? Жми 8 пункт.</a>
						</td>
						<td>
							<select name="wallets[FREEKASSA]">
								<option value="0" <?=($WALLET['FREEKASSA'] == FALSE ? 'selected' : '');?>>Выключена</option>
								<option value="1" <?=($WALLET['FREEKASSA'] == TRUE ? 'selected' : '');?>>Включена</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Merchant ID Free-Kassa:</td>
						<td><input name="settings[fk_merchant_id]" value="<?=$obj['fk_merchant_id'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Секретный код №1 Free-Kassa:</td>
						<td><input name="settings[fk_merchant_key]" value="<?=$obj['fk_merchant_key'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Секретный код №2 Free-Kassa:</td>
						<td><input name="settings[fk_merchant_key_2]" value="<?=$obj['fk_merchant_key_2'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>
							Robokass'а включена? <br />
							<a href="http://shopsn.su/faq/" target="_blank">Как настроить? Жми 9 пункт.</a>
						</td>
						<td>
							<select name="wallets[ROBOKASSA]">
								<option value="0" <?=($WALLET['ROBOKASSA'] == FALSE ? 'selected' : '');?>>Выключена</option>
								<option value="1" <?=($WALLET['ROBOKASSA'] == TRUE ? 'selected' : '');?>>Включена</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Merchant ID Robokassa:</td>
						<td><input name="settings[rk_login]" value="<?=$obj['rk_login'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Секретный код №1 Robokassa:</td>
						<td><input name="settings[rk_pass]" value="<?=$obj['rk_pass'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Секретный код №2 Robokassa:</td>
						<td><input name="settings[rk_pass_2]" value="<?=$obj['rk_pass_2'];?>" class="form-control" type="text"></td>
					</tr>
					
					<tr>
						<td>Primeare'а включена?<br>
						<a href="http://shopsn.su/faq/" target="_blank">Как настроить? Жми 11 пункт.</a>
						</td>
						<td>
							<select name="wallets[PRIMEAREA]">
								<option value="0" <?=($WALLET['PRIMEAREA'] == FALSE ? 'selected' : '');?>>Выключена</option>
								<option value="1" <?=($WALLET['PRIMEAREA'] == TRUE ? 'selected' : '');?>>Включена</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Shop ID Primearea:</td>
						<td><input name="settings[pa_shopid]" value="<?=$obj['pa_shopid'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Secret Primearea:</td>
						<td><input name="settings[pa_secret]" value="<?=$obj['pa_secret'];?>" class="form-control" type="text"></td>
					</tr>
					
					<tr>
						<td>Payeer включен?<br>
						<a href="http://shopsn.su/faq/" target="_blank">Как настроить? Жми 12 пункт.</a></td>
						<td>
							<select name="wallets[PAYEER]">
								<option value="0" <?=($WALLET['PAYEER'] == FALSE ? 'selected' : '');?>>Выключен</option>
								<option value="1" <?=($WALLET['PAYEER'] == TRUE ? 'selected' : '');?>>Включен</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Shop ID Payeer: <br />
							<a href="http://shopsn.su/faq/" target="_blank">Как настроить? Жми 12 пункт.</a>
						</td>
						<td><input name="settings[py_shop]" value="<?=$obj['py_shop'];?>" class="form-control" type="text"></td>
					</tr>
					<tr>
						<td>Секретный код Payeer:</td>
						<td><input name="settings[py_key]" value="<?=$obj['py_key'];?>" class="form-control" type="text"></td>
					</tr>
					
					<tr>
						<td>Тип авторизации:</td>
						<td>
							<select name="settings[authorization]">
								<option value="0" <?=($obj['authorization'] == FALSE ? 'selected' : '');?>>Обычная авторизация</option>
								<option value="1" <?=($obj['authorization'] == TRUE ? 'selected' : '');?>>Двухфакторная (VK, OK, MAIL, YANDEX)</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>Форма оплаты (Yandex, QIWI, Webmoney):</td>
						<td>
							<select name="settings[form]">
								<option value="0" <?=($obj['form'] == FALSE ? 'selected' : '');?>>Обычная</option>
								<option value="1" <?=($obj['form'] == TRUE ? 'selected' : '');?>>Мерчант</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td></td>
						<td><input value="Сохранить" class="btn btn-primary" type="submit"></td>
					</tr>
				</tbody>
			</table>
		</form>
	</ul>
	<?
		}
	?>