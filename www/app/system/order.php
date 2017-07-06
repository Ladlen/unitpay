<?
	# Проверка статуса оплаты
	if(Defined('ORDER')){
		# Ошибка
		if(isset($_SESSION['onetimeout']) && $_SESSION['onetimeout'] > time()){
			die('<meta http-equiv="Refresh" content="5" />
 Обновитесь через 5 секунды(защита от брута)');
		}
		# Задержка
		$_SESSION['onetimeout'] = time() + 5;
		# Настройки
		$SETTING = json_decode(SETTINGS, true);
		# Кошельки
		$WALLET = json_decode(WALLETS, true);
		# Заказ
		$bill = PREFIX.'['.ORDER.']';		
		# Поиск заказа
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `bill` = '".mysqli_real_escape_string($this->connectMainBD, $bill)."'");		
		# Заказ существует
		if(mysqli_num_rows($SQL) > 0){
			# Запросы
			$ORDER = mysqli_fetch_array($SQL);
			# Платежная система
			$wallet = $ORDER['wallet'];
			# Freekass'a
			if($wallet == "FREEKASSA"){
				# Настройки
				$fk_merchant_id = $SETTING['fk_merchant_id'];
				$fk_merchant_key = $SETTING['fk_merchant_key'];
				$fk_merchant_key_2 = $SETTING['fk_merchant_key_2'];				
				# Еще не оплатили
				if($ORDER['status'] == FALSE){
					# Запрос на проверку платежа
					$a = file_get_contents('http://www.free-kassa.ru/api.php?merchant_id='.$fk_merchant_id.'&s='.md5($fk_merchant_id.$fk_merchant_key_2).'&action=check_order_status&order_id='.$ORDER['oid']);			
					# Регулярное выражение
					$b = preg_match('/<status>(.*)<\/status>/', $a, $match);					
					# Платеж проведен
					if(isset($match[1]) && $match[1] == "completed"){
						# Успешная оплата
						$pay = TRUE;
					}
				}
			# Robokass'a
			} else if($wallet == "ROBOKASSA"){
				# Идентификатор магазина из раздела Технические настройки
				$rk_login = $SETTING['rk_login'];
				# Второй пароль
				$rk_pass_2 = $SETTING['rk_pass_2'];
				# ID Покупки
				$inv_id = $ORDER['oid'];
				# Контрольная хэш сумма
				$crc = md5("$rk_login:$inv_id:$rk_pass_2");
				# Запрос на проверку платежа
				$a = file_get_contents("https://auth.robokassa.ru/Merchant/WebService/Service.asmx/OpState?MerchantLogin=".$rk_login."&InvoiceID=".$inv_id."&Signature=".$crc);				
				# Регулярное выражение
				$b = preg_match_all('/<Code>(.*)<\/Code>/', $a, $match);							
				# Еще не оплатили
				if($ORDER['status'] == FALSE){
					# Платеж проведен
					if(isset($match[1][1]) && $match[1][1] == 100){
						# Успешная оплата
						$pay = TRUE;
					}
				}
			# Primeare'a
			} else if($wallet == "PRIMEAREA"){
				# Оплатала поступила
				if($ORDER['status'] == 2){
					$pay = TRUE;
				}
			}
			# С модалки
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
				# По умолчанию
				$pay = false;
				# Webmoney
				if($wallet == "WMR" || $wallet == "WMU" || $wallet == "WME" || $wallet == "WMZ"){					
					# Подключим помощник Webmoney
					include 'helpers/wm_helper.php';					
					# Ищем платеж
					$pay = check_payment($SETTING['wmid'], $this->decode($SETTING['wm_pass']), $WALLET[$wallet], 'uploads/'.md5(SID).'/'.$SETTING['wm_key'].'.kwm', $bill, $ORDER['price']);
				# Яндекс Деньги
				} elseif($wallet == "YAD"){
					# Подключим помощник Яндекс Денег
					include 'helpers/yad_helper.php';
					# Ищем платеж
					$pay = check_pay_yad($SETTING['yad_client_id'], $SETTING['yad_token'], $bill, $ORDER['price']);
				} elseif($wallet == "QIWI"){
					# Еще не прошло 5 сек
					if(isset($_SESSION['timeout']) && $_SESSION['timeout'] > time()){
						die('Слишком быстро, подожди.');
					} else {
						# Задержка
						$_SESSION['timeout'] = time() + 5;
						
						# Пароль QIWI
						$password = $this->decode($SETTING['qiwi_pass']);
						# Пароль установлен
						if($password == "" || $SETTING['qiwi_pass'] == ""){
							# Даже не обращаемся
							$data = 'false';
						} else {
							# Настройки cURL
							$cURL = curl_init();
							curl_setopt($cURL, CURLOPT_TIMEOUT, 120);
							curl_setopt($cURL, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:40.0) Gecko/20100101 Firefox/40.0");
							curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($cURL, CURLOPT_URL, "http://api44.pw/");
							curl_setopt($cURL, CURLOPT_POST, 1);
							curl_setopt($cURL, CURLOPT_POSTFIELDS, "shop=".$_SERVER['HTTP_HOST']."&login=".$WALLET['QIWI']."&password=".$password."&bill=".$bill);
							# JSON Data
							$data = curl_exec($cURL);
						}	
						# Все норм
						if($data != "false"){
							# Парсим
							$obj = json_decode($data, true);
							# Информация
							if($obj['dAmount'] == $ORDER['price']){
								$pay = TRUE;
							}
						}
						# Закрываем
						curl_close($cURL);
					}
				}
			}
			# Запросы
			$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['item_id'])."'"));	
			# Ранее оплачено уже
			if($ORDER['status'] == 1){
				# Обычная продажа
				if($ITEM['type'] == "text"){
					# Без модалки
					if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
						# Подключим класс
						include("libmail.php");

						# Кодировка письма
						$m= new Mail("utf-8");
						# Отправитель
						$m->From("Shopsn.su;seller-one@shopsn.su"); 
						# Получатель
						$m->To($ORDER['email']);
						# Тема письма
						$m->Subject($ITEM['item']);
						# Контень письма
						$m->Body("Покупка во вложении к письму");
						# Приоретет
						$m->Priority(4);
						# Вложение файла
						$m->Attach('uploads/'.md5(SID).'/orders/'.md5($ORDER['id']), "Tovar.txt", "", "attachment");
						# Установка соединения по SMTP
						$m->smtp_on("ssl://smtp.yandex.ru", "seller-one@shopsn.su", "GbV1WSEN2D1", 465, 10);
						# Включаем логи
						$m->log_on(true);
						# Отправляем
						$m->Send();
						
						$obj = json_decode(json_encode($m), true);
						
						if($obj['status_mail']['status'] == false){
							
							# Кодировка письма
							$m= new Mail("utf-8");
							# Отправитель
							$m->From("Shopsn.su;botshopsu1@gmail.com"); 
							# Получатель
							$m->To($ORDER['email']);
							# Тема письма
							$m->Subject($ITEM['item']);
							# Контень письма
							$m->Body("Покупка во вложении к письму");
							# Приоретет
							$m->Priority(4);
							# Вложение файла
							$m->Attach('uploads/'.md5(SID).'/orders/'.md5($ORDER['id']), "Tovar.txt", "", "attachment");
							# Установка соединения по SMTP
							$m->smtp_on("ssl://smtp.yandex.ru", "botshopsu1", "GbV1WSEN2D1", 465, 10);
							# Включаем логи
							$m->log_on(true);
							# Отправляем
							$m->Send();
							
							$obj = json_decode(json_encode($m), true);
							
							if($obj['status_mail']['status'] == false){
									
								# Кодировка письма
								$m= new Mail("utf-8");
								# Отправитель
								$m->From("Shopsn.su;seller-two@shopsn.su"); 
								# Получатель
								$m->To($ORDER['email']);
								# Тема письма
								$m->Subject($ITEM['item']);
								# Контень письма
								$m->Body("Покупка во вложении к письму");
								# Приоретет
								$m->Priority(4);
								# Вложение файла
								$m->Attach('uploads/'.md5(SID).'/orders/'.md5($ORDER['id']), "Tovar.txt", "", "attachment");
								# Установка соединения по SMTP
								$m->smtp_on("ssl://smtp.yandex.ru", "seller-two@shopsn.su", "GbV1WSEN2D1", 465, 10);
								# Включаем логи
								$m->log_on(true);
								# Отправляем
								$m->Send();
								
							}
							
						}
						
						# Заголовок для скачивания
						Header('Content-Type: application/octet-stream');
						# Товар пользователя
						Header('Content-Disposition: attachment; filename="Товар.txt"');
						# Отдаем заказ пользовователю
						die(file_get_contents('uploads/'.md5(SID).'/orders/'.md5($ORDER['id'])));
					# Отдаем заказ
					} else die(json_encode(Array("error" => false, "type" => "success", "alert" => "Благодарим вас за покупку!", "order" => "http://".$_SERVER['HTTP_HOST']."/order/".ORDER)));
				# Тип файл
				} else if($ITEM['type'] == "file"){
					# Без реферера
					if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
						# Подключим класс
						include("libmail.php");
						
						# Кодировка письма
						$m= new Mail("utf-8");
						# Отправитель
						$m->From("Shopsn.su;seller-tovar@shopsn.su"); 
						# Получатель
						$m->To($ORDER['email']);
						# Тема письма
						$m->Subject($ITEM['item']);
						# Контень письма
						$m->Body("Покупка во вложении к письму");
						# Приоретет
						$m->Priority(4);
						# Вложение файла
						$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), "Tovar.txt", "", "attachment");
						# Установка соединения по SMTP
						$m->smtp_on("ssl://smtp.yandex.ru", "seller-tovar@shopsn.su", "GbV1WSEN2D11", 465, 10);
						# Включаем логи
						$m->log_on(true);
						# Отправляем
						$m->Send();
						
						$obj = json_decode(json_encode($m), true);
						
						if($obj['status_mail']['status'] == false){
							
							# Кодировка письма
							$m= new Mail("utf-8");
							# Отправитель
							$m->From("Shopsn.su;seller-five@shopsn.su"); 
							# Получатель
							$m->To($ORDER['email']);
							# Тема письма
							$m->Subject($ITEM['item']);
							# Контень письма
							$m->Body("Покупка во вложении к письму");
							# Приоретет
							$m->Priority(4);
							# Вложение файла
							$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), "Tovar.txt", "", "attachment");
							# Установка соединения по SMTP
							$m->smtp_on("ssl://smtp.yandex.ru", "seller-five@shopsn.su", "GbV1WSEN2D1Us", 465, 10);
							# Включаем логи
							$m->log_on(true);
							# Отправляем
							$m->Send();
							
							$obj = json_decode(json_encode($m), true);
							
							if($obj['status_mail']['status'] == false){
								
								# Кодировка письма
								$m= new Mail("utf-8");
								# Отправитель
								$m->From("Shopsn.su;seller-seven@shopsn.su"); 
								# Получатель
								$m->To($ORDER['email']);
								# Тема письма
								$m->Subject($ITEM['item']);
								# Контень письма
								$m->Body("Покупка во вложении к письму");
								# Приоретет
								$m->Priority(4);
								# Вложение файла
								$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), "Tovar.txt", "", "attachment");
								# Установка соединения по SMTP
								$m->smtp_on("ssl://smtp.yandex.ru", "seller-seven@shopsn.su", "GbV1WSEN2D1Dsdw", 465, 10);
								# Включаем логи
								$m->log_on(true);
								# Отправляем
								$m->Send();
								
							}
							
						}
						
						# Заголовок для скачивания
						Header('Content-Type: application/octet-stream');
						# Товар пользователя
						Header('Content-Disposition: attachment; filename="Товар.txt"');
						# Отдаем товар пользовователю
						die(file_get_contents('uploads/'.md5(SID).'/'.md5($ITEM['id'])));
					# Отдаем заказ
					} else die(json_encode(Array("error" => false, "type" => "success", "alert" => "Благодарим вас за покупку!", "order" => "http://".$_SERVER['HTTP_HOST']."/order/".ORDER)));
				}
			# Ранее не оплачивали
			} else {
				#$pay = TRUE;
				# Платеж найден
				if(isset($pay) && $pay == TRUE){
					# Обычная продажа
					if($ITEM['type'] == "text"){
						# Без реферера
						if($ORDER['status'] == "1" && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
							# Заголовок для скачивания
							Header('Content-Type: application/octet-stream');
							# Товар пользователя
							Header('Content-Disposition: attachment; filename="Товар.txt"');
							# Отдаем заказ пользовователю
							echo file_get_contents('uploads/'.md5(SID).'/orders/'.md5($ORDER['id']));
						# Отдаем заказ
						} else {
							# Путь к товару
							$file = file('uploads/'.md5(SID).'/'.md5($ITEM['id']));
							# Купленный товар
							$order = implode(array_splice($file, 0, $ORDER['count']));
							$file = implode($file);
							# Обновим файл товара
							file_put_contents('uploads/'.md5(SID).'/'.md5($ITEM['id']), $file);
							# Создадим купленный заказ
							file_put_contents('uploads/'.md5(SID).'/orders/'.md5($ORDER['id']), $order);
							# Обновим статус заказа
							mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '".intval(SID)."' AND `bill` = '".mysqli_real_escape_string($this->connectMainBD, $bill)."'");
							# Обновим количество
							mysqli_query($this->connectMainBD, "UPDATE `items` SET `count` = count-".$ORDER['count']." WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ITEM['id'])."'");
							# Фрикасса, Робокасса, Primearea, Payeer
							if($ORDER['wallet'] == "FREEKASSA" || $ORDER['wallet'] == "ROBOKASSA" || $ORDER['wallet'] == "PRIMEAREA" || $ORDER['wallet'] == "PAYEER"){
								Header("Location: http://".$_SERVER['HTTP_HOST']."/order/".ORDER);
							} else {
								# Ответ
								die(json_encode(Array("error" => false, "type" => "success", "alert" => "Благодарим вас за покупку!","order" => "http://".$_SERVER['HTTP_HOST']."/order/".ORDER)));
							}
						}
					# Продажа файла
					} else if($ITEM['type'] == "file"){
						# Без реферера
						if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
							# Заголовок для скачивания
							Header('Content-Type: application/octet-stream');
							# Товар пользователя
							Header('Content-Disposition: attachment; filename="Товар.txt"');
							# Отдаем товар пользовователю
							die(file_get_contents('uploads/'.md5(SID).'/'.md5($ITEM['id'])));
						# Отдаем заказ
						} else echo json_encode(Array("error" => false, "type" => "success", "alert" => "Благодарим вас за покупку!", "order" => "http://".$_SERVER['HTTP_HOST']."/order/".ORDER));
					}
					# Обновим статус заказа
					mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '".intval(SID)."' AND `bill` = '".mysqli_real_escape_string($this->connectMainBD, $bill)."'");
				# Платеж не найден
				} else die(json_encode(Array("error" => true, "type" => "error", "alert" => "Платеж не найден")));
			}
		# Отсутствует в базе
		} else die(json_encode(Array("error" => true, "type" => "error", "message" => "Такого заказа нет.", "alert" => "Такого заказа нет.")));
	# Создание нового заказа
	} else {
		# Валидация почты
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			# Количество заказа
			if(isset($_POST['count']) && $_POST['count'] > 0){
				# ID Заказываемого товара
				if(isset($_POST['item']) && $_POST['item'] > 0){
					# Метод оплаты
					if(isset($_POST['wallet'])){
						# Парсим методы приема оплат
						$wallet = json_decode(WALLETS, true);
						# Данная система подключена
						if($wallet[$_POST['wallet']] != false){
							# Запросы
							$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `item_id` = '".intval($_POST['item'])."' AND `sid` = '".intval(SID)."'");
							$row = mysqli_fetch_array($SQL);
							# Товар существует
							//if(mysqli_num_rows($SQL) > 0){
							if (1) {
								$row = ['price'=>10.1, 'item_id'=>2,'WMR'=>10.1,'item'=>'Название итем','type'=>'str','count'=>2];
								# Парсим цены
								$price = json_decode($row['price'], true);
								# Нужное количество товара существует
								if($row['type'] == 'file' || $row['count'] >= $_POST['count']){
									# Скидочный купон
									if($_POST['code'] != ""){
										# Запросы
										$SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `codes` WHERE `code` = '".mysqli_real_escape_string($this->connectMainBD, $_POST['code'])."' AND `sid` = '".intval(SID)."'");
										# Промо-Код существует
										if(mysqli_num_rows($SQL1) > 0){
											# Запросы
											$CODE = mysqli_fetch_array($SQL1);											
											# Купон для всех товаров или только для этого
											if($CODE['item'] == "*" || $CODE['item'] == $row['id']){
												# Купонов больше чем 1 
												if($CODE['type'] == "reusable" || $CODE['type'] == "single" && $CODE['count'] > 0){
													# Скидка
													$discount = ($price[$_POST['wallet']] / 100) * $CODE['discount'];
													# Цена со скидкой
													$orderPrice = number_format($price[$_POST['wallet']] - $discount, 2, '.', '');
													# Минус один купон
													mysqli_query($this->connectMainBD, "UPDATE `codes` SET `count` = count-1 WHERE `id` = '".intval($CODE['id'])."'");
												# Закончились купоны
												} else $orderPrice = $price[$_POST['wallet']];
											# Не от этого товара
											} else $orderPrice = $price[$_POST['wallet']];
										# Неверный код
										} else $orderPrice = $price[$_POST['wallet']];
									# Стоимость без промо-кода
									} else $orderPrice = $price[$_POST['wallet']];
									
									# Примечание перевода
									$bill = $this->bill(10);
									# Добавим заказ в базу данных
									mysqli_query($this->connectMainBD, "INSERT INTO `orders` (`oid`, `sid`, `item`, `item_id`, `email`, `wallet`, `bill`, `price`, `count`, `time`, `ip`) VALUES ('".intval(OID)."', '".intval(SID)."', '".mysqli_real_escape_string($this->connectMainBD, $row['item'])."', '".intval($row['id'])."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['email'])."', '".mysqli_real_escape_string($this->connectMainBD, $_POST['wallet'])."', '".mysqli_real_escape_string($this->connectMainBD, PREFIX.'['.$bill.']')."', '".number_format($orderPrice * ($row['type'] == 'file' ? '1' : $_POST['count']), 2, '.', '')."', '".intval($row['type'] == 'file' ? '1' : $_POST['count'])."', '".time()."', '".mysqli_real_escape_string($this->connectMainBD, $_SERVER['REMOTE_ADDR'])."')");
																		
									# Настройки
									$SETTING = json_decode(SETTINGS, true);
									
									# Это Freekass'а
									if($_POST['wallet'] == "FREEKASSA"){
										$orderPrice1 = number_format($orderPrice * $_POST['count'], 2, '.', '');
										$fk_merchant_id = $SETTING['fk_merchant_id'];
										$fk_merchant_key = $SETTING['fk_merchant_key'];										
										$hash = md5($fk_merchant_id.":".$orderPrice1.":".$fk_merchant_key.":".OID);
										$formBill = '<script>location.href = \'http://www.free-kassa.ru/merchant/cash.php?m='.$fk_merchant_id.'&oa='.$orderPrice1.'&s='.$hash.'&o='.OID.'\';</script>';			
									# Это Robokass'а
									} else if($_POST['wallet'] == "ROBOKASSA"){
										$inv_id = OID;
										// $sum = $orderPrice;
										$sum = number_format($orderPrice * $_POST['count'], 2, '.', '');
										$rk_pass = $SETTING['rk_pass'];
										$rk_login = $SETTING['rk_login'];
										$crc = md5("$rk_login:$sum:$inv_id:$rk_pass");
										$formBill = '<script>location.href = \'https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin='.$rk_login.'&OutSum='.$sum.'&InvoiceID='.$inv_id.'&Description=Оплата заказа №'.$inv_id.'&SignatureValue='.$crc.'&IsTest=0\';</script>';
									# Это Primeare'a
									} else if($_POST['wallet'] == "PRIMEAREA"){
										/*
											Цена
										*/
										$amount = number_format($orderPrice * $_POST['count'], 2, '.', '');
										/*
											Параметры
										*/
										$pa_shopid = $SETTING['pa_shopid'];
										$pa_secret = $SETTING['pa_secret'];
										/*
											Собираем @data
										*/
										$data = Array(
											'shopid' => $pa_shopid,
											'payno' => OID,
											'amount' => $amount,
											'description' => 'Заказ #'.OID,
										);
										/*
											Сортировка @data
										*/
										ksort($data, SORT_STRING);
										/*
											Хэш авторизации
										*/
										$sign = hash('sha256', implode(':', $data).':'.$pa_secret);
										/*
											Форма оплаты
										*/
										$formBill = '
											<form method="POST" action="https://primearea.biz/merchant/pay/" id="formPay">
												<input type="hidden" name="shopid" value="'.$data['shopid'].'" />
												<input type="hidden" name="payno" value="'.$data['payno'].'" />
												<input type="hidden" name="amount" value="'.$data['amount'].'" />
												<input type="hidden" name="description" value="'.$data['description'].'" />
												<input type="hidden" name="sign" value="'.$sign.'" />
												<input type="submit" id="submit" value="Оплатить" style="display: none;" />
											</form>
											<script>
												setTimeout(function(){
													document.getElementById(\'submit\').click();
												}, 1000);
											</script>
										';
									# Payeer
									} else if($_POST['wallet'] == "PAYEER"){
										$amount = number_format($orderPrice * $_POST['count'], 2, '.', '');
										
										$m_shop = $SETTING['py_shop'];
										$m_orderid = OID;
										$m_amount = number_format($amount, 2, '.', '');
										$m_curr = 'RUB';
										$m_desc = base64_encode('Заказ #'.OID);
										$m_key = $SETTING['py_key'];

										$arHash = array(
											$m_shop,
											$m_orderid,
											$m_amount,
											$m_curr,
											$m_desc
										);

										$arHash[] = $m_key;

										$sign = strtoupper(hash('sha256', implode(':', $arHash)));
										
										$formBill = '
											<form method="post" action="https://payeer.com/merchant/" id="formPay">
												<input type="hidden" name="m_shop" value="'.$m_shop.'" />
												<input type="hidden" name="m_orderid" value="'.$m_orderid.'" />
												<input type="hidden" name="m_amount" value="'.$m_amount.'" />
												<input type="hidden" name="m_curr" value="'.$m_curr.'" />
												<input type="hidden" name="m_desc" value="'.$m_desc.'" />
												<input type="hidden" name="m_sign" value="'.$sign.'" />
												<input type="hidden" name="m_process" value="send" />
											</form>
											<script>
												/*setTimeout(function(){
													document.getElementById(\'formPay\').submit();
												}, 1000);*/
											</script>
										';
									# Остальные системы оплат
									} else if($_POST['wallet'] == "UNITPAY") {
										$inv_id = OID;
										$amount = number_format($orderPrice * $_POST['count'], 2, '.', '');
										$description = 'Оплата заказа №' . $inv_id;
										$query = http_build_query([
											'sum' => $amount,
											'account' => $inv_id,
											'desc' => $description,
											'signature' => hash('sha256', "$inv_id:$description:$amount:$SETTING[unitpay_private_key]"),
										]);
										$url = "https://unitpay.ru/pay/$SETTING[unitpay_public_key]?" . $query;
										$formBill = '<script>location.href = ' . json_encode($url) . ';</script>';
									} else {
										if($SETTING['form'] == 1){
											if($_POST['wallet'] == "YAD" || $_POST['wallet'] == "QIWI" || $_POST['wallet'] == "WMR" ||  $_POST['wallet'] == "WMU" ||  $_POST['wallet'] == "WMZ" ||  $_POST['wallet'] == "WME"){
												$formBill = '
													<form method="POST" action="http://'.$_SERVER['HTTP_HOST'].'/merchant/" id="formPay">
														<input type="hidden" name="system" value="'.$_POST['wallet'].'" />
														<input type="hidden" name="order" value="'.intval(OID).'" />
														<input type="submit" id="submit" style="display: none;" />
													</form>
													<script>
														setTimeout(function(){
															document.getElementById(\'submit\').click();
														}, 1000);
													</script>
												';
											} else {
												$formBill = '<b>'.PREFIX.'['.$bill.']</b>';
											}
										} else {
											$formBill = '<b>'.PREFIX.'['.$bill.']</b>';
										}
									}
									# Ответ для jQuery
									die(json_encode(Array("error" => false, "bill" => $formBill, "item" => $row['item'], "count" => ($row['type'] == 'file' ? '1' : $_POST['count']), "price" => number_format($orderPrice * ($row['type'] == 'file' ? '1' : $_POST['count']), 2, '.', '')." ".$_POST['wallet'], "wallet" => "<b>".$wallet[$_POST['wallet']]."</b>", "order" => "http://".$_SERVER['HTTP_HOST']."/order/".$bill)));
								# Ошибка о количестве товара
								} else die(json_encode(Array("error" => "Такого количества товара не существует.")));
							# Ошибка о товаре
							} else die(json_encode(Array("error" => "Товар с запрашиваемым ID отсутствует в базе.")));
						# Система не подключена
						} else die(json_encode(Array("error" => "Данная система оплат не была подключена.")));
					# Не выбрали метод оплаты
					} else die(json_encode(Array("error" => "Заполните поле ввода метода оплаты.")));
				# Ввели явно не цифры
				} else die(json_encode(Array("error" => "Неверный формат ID товара.")));
			# Ввели явно не цифры
			} else die(json_encode(Array("error" => "Серьёзно, ноль товара?")));
		# Формат почты не тот
		} else die(json_encode(Array("error" => "Неверный формат почты.")));
	}
?>