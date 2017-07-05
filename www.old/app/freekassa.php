<?
	# Настройки
	$WALLET = json_decode(WALLETS, true);
	# Проверка
	if($WALLET['FREEKASSA'] == TRUE){
		# Заглушка для Free-кассы
		if(isset($_REQUEST['MERCHANT_ORDER_ID'])){
			# Запрос
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `oid` = '".intval($_REQUEST['MERCHANT_ORDER_ID'])."'");
			# Заказ существует
			if(mysqli_num_rows($SQL) > 0){
				# Запросы
				$ORDER = mysqli_fetch_array($SQL);
				# Определитель айпи
				function getIP(){
					if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
						return $_SERVER['REMOTE_ADDR'];
				}
				# Обработчик фрикассы
				if(in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))){					
					# Запросы
					$ITEM = mysqli_fetch_array(mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['item_id'])."'"));
					# Продажа по строкам
					if($ITEM['type'] == "text"){
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
						mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['id'])."'");
						# Обновим количество
						mysqli_query($this->connectMainBD, "UPDATE `items` SET `count` = count-".$ORDER['count']." WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ITEM['id'])."'");
						
						# Подключим класс
						include("/home/engine/app/system/libmail.php");
						
						# Кодировка письма
						$m= new Mail("utf-8");
						# Отправитель
						$m->From("Shopsn.su;botshopsu@gmail.com"); 
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
						$m->smtp_on("ssl://smtp.gmail.com", "botshopsu", "GbV1WSEN2D1", 465, 10);
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
								$m->From("Shopsn.su;botshopsu2@gmail.com"); 
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
								$m->smtp_on("ssl://smtp.gmail.com", "botshopsu2", "GbV1WSEN2D1", 465, 10);
								# Включаем логи
								$m->log_on(true);
								# Отправляем
								$m->Send();
								
							}
							
						}
						
						# YES
						die('YES');
					# Продажа файла
					} else {
						# Обновим статус заказа
						mysqli_query($this->connectMainBD, "UPDATE `orders` SET `status` = '1' WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($ORDER['id'])."'");
						
						# Подключим класс
						include("/home/engine/app/system/libmail.php");

						# Кодировка письма
						$m= new Mail("utf-8");
						# Отправитель
						$m->From("Shopsn.su;botshopsu@gmail.com"); 
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
						$m->smtp_on("ssl://smtp.gmail.com", "botshopsu", "GbV1WSEN2D1", 465, 10);
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
							$m->Attach('uploads/'.md5(SID).'/'.md5($ITEM['id']), "Tovar.txt", "", "attachment");
							# Установка соединения по SMTP
							$m->smtp_on("ssl://smtp.gmail.com", "botshopsu1", "GbV1WSEN2D1", 465, 10);
							# Включаем логи
							$m->log_on(true);
							# Отправляем
							$m->Send();
							
							$obj = json_decode(json_encode($m), true);
							
							if($obj['status_mail']['status'] == false){
								
								# Кодировка письма
								$m= new Mail("utf-8");
								# Отправитель
								$m->From("Shopsn.su;botshopsu2@gmail.com"); 
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
								$m->smtp_on("ssl://smtp.gmail.com", "botshopsu2", "GbV1WSEN2D1", 465, 10);
								# Включаем логи
								$m->log_on(true);
								# Отправляем
								$m->Send();
								
							}
							
						}
						
						# YES
						die('YES');
					}
				} else {
					# Bill
					$bill = str_replace(Array(PREFIX."[", "]"), Array("", ""), $ORDER['bill']);
					# Система оплаты
					$_SESSION['wallet'] = "FREEKASSA";
					# Редирект
					$this->redirect('/order/'.$bill);
				}
			}
		}
	}
?>